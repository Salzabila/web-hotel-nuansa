<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('room_number')->get();
        
        // Count active transactions
        $activeTransactions = Transaction::where('status', 'active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        // Get daily revenue
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'finished')
            ->sum('total_price');

        return view('dashboard', compact(
            'rooms',
            'activeTransactions',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'todayRevenue'
        ));
    }
}

