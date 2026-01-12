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
            'guest_address' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'is_ktp_held' => 'nullable|boolean',
        ]);

        $checkInDate = Carbon::now();
        $checkOutDate = $checkInDate->copy()->addDays($data['duration']);

        // Auto-calculate Total = Room Price * Duration
        $total = $room->price_per_night * $data['duration'];

        $transaction = Transaction::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'invoice_code' => $this->generateInvoiceCode(),
            'guest_name' => $data['guest_name'],
            'guest_nik' => $data['guest_nik'],
            'guest_address' => $data['guest_address'] ?? null,
            'check_in' => $checkInDate,
            'check_out_plan' => $checkOutDate,
            'check_out_actual' => null,
            'total_price' => $total,
            'status' => 'active',
            'is_ktp_held' => ($request->has('is_ktp_held') && $request->boolean('is_ktp_held')),
        ]);

        // Update room status to occupied
        $room->status = 'occupied';
        $room->save();

        return redirect()->route('transactions.struk', $transaction->id);
    }

    public function checkout($id)
    {
        $tx = Transaction::findOrFail($id);
        if ($tx->status !== 'active') {
            return back()->with('error','Transaksi sudah selesai.');
        }

        // Record actual checkout time
        $tx->check_out_actual = Carbon::now();
        $tx->status = 'finished';
        $tx->save();

        // Swap room status back to available
        $room = $tx->room;
        $room->status = 'available';
        $room->save();

        return redirect()->route('transactions.struk', $tx->id)->with('success', 'Check-out berhasil');
    }

    public function struk($id)
    {
        $tx = Transaction::with('room','user')->findOrFail($id);
        return view('transactions.struk', compact('tx'));
    }

    public function index()
    {
        $transactions = Transaction::with('room', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('transactions.index', compact('transactions'));
    }
}

