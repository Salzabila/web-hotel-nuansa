<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Feedback;
use App\Models\Room;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactions()
    {
        $transactions = Transaction::with('room','user','feedback')
            ->orderByDesc('check_in')
            ->paginate(20);
        
        $totalRevenue = Transaction::where('status','finished')->sum('total_price');
        $occupancyRate = $this->calculateOccupancyRate();
        
        return view('reports.transactions', compact('transactions','totalRevenue','occupancyRate'));
    }

    public function feedback()
    {
        $feedbacks = Feedback::with('transaction.guest_name','transaction.room')
            ->orderByDesc('created_at')
            ->paginate(20);
        
        $avgRating = Feedback::avg('rating');
        $totalReviews = Feedback::count();
        
        return view('reports.feedback', compact('feedbacks','avgRating','totalReviews'));
    }

    private function calculateOccupancyRate()
    {
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status','occupied')->count();
        
        return $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 2) : 0;
    }

    public function exportTransactions(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        [$year,$m] = explode('-', $month);
        
        $transactions = Transaction::whereYear('check_in',$year)
            ->whereMonth('check_in',$m)
            ->with('room','user')
            ->get();
        
        $csv = "No,Pelanggan,NIK,Kamar,Check-in,Check-out,Harga,Status\n";
        foreach($transactions as $idx=>$tx) {
            $csv .= ($idx+1)."," . $tx->guest_name . "," . $tx->nik . "," . $tx->room->room_number 
                . "," . $tx->check_in->format('Y-m-d') . "," . $tx->check_out->format('Y-m-d')
                . "," . $tx->total_price . "," . $tx->status . "\n";
        }
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=transactions_$month.csv"
        ]);
    }
}
