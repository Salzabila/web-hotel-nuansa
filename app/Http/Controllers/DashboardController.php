<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use App\Models\OperationalExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek role user
        if (auth()->user()->role === 'kasir') {
            return $this->kasirDashboard();
        }
        
        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $rooms = Room::orderBy('room_number')->get();
        
        // Count active transactions
        $activeTransactions = Transaction::where('status', 'active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $dirtyRooms = Room::where('status', 'dirty')->count();

        // Get daily revenue
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'finished')
            ->sum('total_price');

        // Data untuk chart: 7 hari terakhir
        $chartData = [];
        $chartLabels = [];
        $chartTransactions = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            
            $dailyRevenue = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->sum('total_price');
            $chartData[] = $dailyRevenue;
            
            $dailyTransactions = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->count();
            $chartTransactions[] = $dailyTransactions;
        }

        // Data untuk Pie Chart - Rekap Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->sum('total_price');
            
        $monthlyExpenses = OperationalExpense::whereBetween('expense_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $monthlyTCCommission = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->where('is_tc', true)
            ->sum('tc_nominal');
            
        $monthlyProfit = $monthlyRevenue - ($monthlyExpenses + $monthlyTCCommission);

        return view('dashboard', compact(
            'rooms',
            'activeTransactions',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'dirtyRooms',
            'todayRevenue',
            'chartLabels',
            'chartData',
            'chartTransactions',
            'monthlyRevenue',
            'monthlyExpenses',
            'monthlyTCCommission',
            'monthlyProfit'
        ));
    }

    private function kasirDashboard()
    {
        $rooms = Room::orderBy('room_number')->get();
        
        // Count active transactions
        $activeTransactions = Transaction::where('status', 'active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        // Get daily revenue
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'finished')
            ->sum('total_price');

        // Get active transactions for cashier
        $activeTransactionsList = Transaction::with('room')
            ->where('status', 'active')
            ->orderBy('check_in', 'desc')
            ->get();

        return view('dashboard-kasir', compact(
            'rooms',
            'activeTransactions',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'todayRevenue',
            'activeTransactionsList'
        ));
    }
}

