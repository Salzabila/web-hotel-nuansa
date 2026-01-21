<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Get current shift based on time (Semi-Automatic - Default by Time)
     * Pagi: 07:00 - 19:00 (Jam Tutup Buku)
     * Malam: 19:00 - 07:00
     * Note: User dapat override pilihan ini di form checkout
     */
    private function getCurrentShift()
    {
        $now = Carbon::now();
        $hour = $now->hour;
        $minute = $now->minute;
        $time = $hour * 60 + $minute; // Convert to minutes

        // Morning shift: 07:00 (420 min) - 19:00 (1140 min)
        if ($time >= 420 && $time < 1140) {
            return 'Pagi';
        }
        
        // Night shift: 19:00 onwards or before 07:00
        return 'Malam';
    }

    public function create($roomId)
    {
        $room = Room::findOrFail($roomId);
        if ($room->status !== 'available') {
            return redirect()->route('dashboard')->with('error','Kamar tidak tersedia.');
        }
        return view('transactions.create', compact('room'));
    }

    /**
     * Generate unique invoice code format: INV-YYYYMMDD-XXX
     */
    private function generateInvoiceCode()
    {
        $date = Carbon::now()->format('Ymd');
        $count = Transaction::whereDate('created_at', Carbon::today())->count() + 1;
        $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);
        return "INV-{$date}-{$sequence}";
    }

    public function store(Request $request, $roomId)
    {
        try {
            $room = Room::findOrFail($roomId);

            $data = $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_nik' => 'required|string|max:50',
                'guest_phone' => 'required|string|max:20',
                'guest_address' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'is_ktp_held' => 'nullable',
            ]);

            // Convert duration to integer to ensure Carbon compatibility
            $duration = (int) $data['duration'];

            $checkInDate = Carbon::now();
            $checkOutDate = $checkInDate->copy()->addDays($duration);

            // Auto-calculate Total = Room Price * Duration
            $total = $room->price_per_night * $duration;

            // Use DB transaction for data integrity
            DB::beginTransaction();
            
            $transaction = Transaction::create([
                'room_id' => $room->id,
                'user_id' => Auth::id(),
                'invoice_code' => $this->generateInvoiceCode(),
                'guest_name' => strtoupper($data['guest_name']),
                'guest_nik' => $data['guest_nik'],
                'guest_phone' => $data['guest_phone'],
                'guest_address' => $data['guest_address'] ?? null,
                'check_in' => $checkInDate,
                'check_out' => $checkOutDate,
                'duration' => $duration,
                'total_price' => $total,
                'additional_charges' => 0,
                'payment_status' => 'unpaid',
                'paid_amount' => 0,
                'status' => 'active',
                'is_ktp_held' => $request->has('is_ktp_held') ? true : false,
            ]);

            // Update room status to occupied
            $room->update(['status' => 'occupied']);
            
            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', '✓ Check-in Berhasil! Pelanggan ' . $transaction->guest_name . ' telah check-in di Kamar ' . $room->room_number . ' | Invoice: ' . $transaction->invoice_code);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Data tidak valid. Periksa kembali formulir.');
                
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            
            Log::error('Check-in error: ' . $e->getMessage() . ' | Line: ' . $e->getLine() . ' | File: ' . $e->getFile());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function showCheckout($id)
    {
        $tx = Transaction::with('room', 'user')->findOrFail($id);
        
        if ($tx->status !== 'active') {
            return redirect()->route('dashboard')->with('error','Transaksi sudah selesai.');
        }

        $currentShift = $this->getCurrentShift();
        $cashiers = \App\Models\User::orderBy('name')->get(['id', 'name']);

        return view('transactions.checkout', compact('tx', 'currentShift', 'cashiers'));
    }

    public function processCheckout(Request $request, $id)
    {
        $tx = Transaction::findOrFail($id);
        
        if ($tx->status !== 'active') {
            return back()->with('error','Transaksi sudah selesai.');
        }

        // Validate additional charges, payment, cashier, and shift
        $data = $request->validate([
            'additional_charges' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'cashier_name' => 'required|string|max:100',
            'shift' => 'required|in:Pagi,Malam',
        ]);

        // Update additional charges
        $tx->additional_charges = $data['additional_charges'] ?? 0;
        
        // Calculate final total
        $basePrice = $tx->room->price_per_night * $tx->duration;
        $finalTotal = $basePrice + $tx->additional_charges;
        $tx->total_price = $finalTotal;
        
        // Update payment info
        $tx->paid_amount = $data['paid_amount'];
        
        // Determine payment status
        if ($tx->paid_amount >= $finalTotal) {
            $tx->payment_status = 'paid';
        } elseif ($tx->paid_amount > 0) {
            $tx->payment_status = 'partial';
        } else {
            $tx->payment_status = 'unpaid';
        }

        // Record actual checkout time and shift info (from user selection)
        $tx->check_out = Carbon::now();
        $tx->shift = $data['shift']; // Simpan shift sesuai pilihan user
        $tx->cashier_name = $data['cashier_name'];
        $tx->status = 'finished';
        $tx->save();

        // Change room status to 'dirty' (needs cleaning)
        $room = $tx->room;
        $room->status = 'dirty';
        $room->save();

        // Redirect directly to struk page for printing
        return redirect()->route('transactions.struk', $tx->id);
    }

    public function struk($id)
    {
        $tx = Transaction::with('room','user')->findOrFail($id);
        return view('transactions.struk', compact('tx'));
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['room', 'user']);

        // Search by guest name or invoice code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('invoice_code', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('check_in', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('check_in', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('check_in', 'desc')->paginate(15);
        
        return view('transactions.index', compact('transactions'));
    }
    public function show($id)
    {
        $tx = Transaction::with(['room', 'user'])->findOrFail($id);
        return view('transactions.show', compact('tx'));
    }
    
    /**
     * Extend stay duration (Perpanjang masa menginap)
     */
    public function extend(Request $request, $id)
    {
        $tx = Transaction::findOrFail($id);
        
        if ($tx->status !== 'active') {
            return back()->with('error', 'Hanya transaksi aktif yang bisa diperpanjang.');
        }
        
        $data = $request->validate([
            'additional_nights' => 'required|integer|min:1|max:30',
        ]);
        
        $additionalNights = $data['additional_nights'];
        
        // Update duration and checkout date
        $tx->duration += $additionalNights;
        $tx->check_out = $tx->check_out->addDays($additionalNights);
        
        // Recalculate total price (base price only, not including additional charges)
        $basePrice = $tx->room->price_per_night * $tx->duration;
        $tx->total_price = $basePrice + $tx->additional_charges;
        
        $tx->save();
        
        return back()->with('success', "✓ Masa menginap berhasil diperpanjang {$additionalNights} malam. Total: Rp " . number_format($tx->total_price, 0, ',', '.'));
    }
}

