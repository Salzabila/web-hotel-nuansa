<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
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
        $room = Room::findOrFail($roomId);

        $data = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_nik' => 'required|string|max:50',
            'guest_phone' => 'required|string|max:20',
            'guest_address' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'is_ktp_held' => 'nullable|boolean',
            'ktp_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $checkInDate = Carbon::now();
        $checkOutDate = $checkInDate->copy()->addDays($data['duration']);

        // Auto-calculate Total = Room Price * Duration
        $total = $room->price_per_night * $data['duration'];

        // Handle KTP photo upload
        $ktpPhotoPath = null;
        if ($request->hasFile('ktp_photo')) {
            $ktpPhotoPath = $request->file('ktp_photo')->store('ktp_photos', 'public');
        }

        $transaction = Transaction::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'invoice_code' => $this->generateInvoiceCode(),
            'guest_name' => strtoupper($data['guest_name']),
            'guest_nik' => $data['guest_nik'],
            'guest_phone' => $data['guest_phone'],
            'guest_address' => $data['guest_address'] ?? null,
            'ktp_photo_path' => $ktpPhotoPath,
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'total_price' => $total,
            'status' => 'active',
            'is_ktp_held' => ($request->has('is_ktp_held') && $request->boolean('is_ktp_held')),
        ]);

        // Update room status to occupied
        $room->status = 'occupied';
        $room->save();

        return redirect()->route('dashboard')->with('success', 'Check-in Berhasil: Tamu ' . $transaction->guest_name . ' di Kamar ' . $room->room_number);
    }

    public function showCheckout($id)
    {
        $tx = Transaction::with('room', 'user')->findOrFail($id);
        
        if ($tx->status !== 'active') {
            return redirect()->route('dashboard')->with('error','Transaksi sudah selesai.');
        }

        return view('transactions.checkout', compact('tx'));
    }

    public function processCheckout(Request $request, $id)
    {
        $tx = Transaction::findOrFail($id);
        
        if ($tx->status !== 'active') {
            return back()->with('error','Transaksi sudah selesai.');
        }

        // Validate penalty input
        $data = $request->validate([
            'penalty' => 'nullable|numeric|min:0',
        ]);

        // Add penalty to total if provided
        if (isset($data['penalty']) && $data['penalty'] > 0) {
            $tx->total_price += $data['penalty'];
        }

        // Record actual checkout time
        $tx->check_out = Carbon::now();
        $tx->status = 'finished';
        $tx->save();

        // Change room status back to available
        $room = $tx->room;
        $room->status = 'available';
        $room->save();

        return redirect()->route('transactions.struk', $tx->id)->with('success', 'Check-out berhasil! Terima kasih.');
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
    }}

