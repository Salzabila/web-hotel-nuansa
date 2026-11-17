<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use App\Models\Expense;
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
        $rooms = Room::with(['transactions' => function($q) {
            $q->where('status', 'active');
        }])->orderBy('room_number')->get();
        
        // Count active transactions
        $activeTransactions = Transaction::where('status', 'active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $dirtyRooms = Room::where('status', 'dirty')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        // Get daily revenue
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'finished')
            ->sum('total_price');

        // Active transactions list for "Tamu Menginap Aktif"
        $activeTransactionsList = Transaction::with(['room', 'user'])
            ->where('status', 'active')
            ->orderBy('check_in', 'desc')
            ->get();

        // Incomplete guest data count & list
        $incompleteGuests = Transaction::with(['room'])
            ->where('status', 'active')
            ->where('is_guest_data_complete', false)
            ->get();
        $incompleteGuestsCount = $incompleteGuests->count();

        // Approaching / overdue checkout guests
        $approachingCheckoutGuests = $activeTransactionsList->filter(function ($tx) {
            return in_array($tx->checkout_urgency, ['overdue', 'imminent', 'today']);
        });
        $approachingCheckoutCount = $approachingCheckoutGuests->count();

        // Data untuk chart: 7 hari terakhir
        $chartData = [];
        $chartLabels = [];
        $chartTransactions = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->isoFormat('ddd'); // Sen, Sel, Rab, Kam, Jum, Sab, Min
            
            $dailyRevenue = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->sum('total_price');
            $chartData[] = $dailyRevenue;
            
            $dailyTransactions = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->count();
            $chartTransactions[] = $dailyTransactions;
        }

        // Data untuk Rekap Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->sum('total_price');
            
        $monthlyExpenses = Expense::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $monthlyTCCommission = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->where('is_tc', true)
            ->sum('tc_nominal');
            
        $monthlyProfit = $monthlyRevenue - ($monthlyExpenses + $monthlyTCCommission);

        return view('dashboard', compact(
            'rooms',
            'activeTransactions',
            'activeTransactionsList',
            'incompleteGuests',
            'incompleteGuestsCount',
            'approachingCheckoutGuests',
            'approachingCheckoutCount',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'dirtyRooms',
            'occupancyRate',
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
        $rooms = Room::with(['transactions' => function($q) {
            $q->where('status', 'active');
        }])->orderBy('room_number')->get();
        
        // Count active transactions
        $activeTransactions = Transaction::where('status', 'active')->count();
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();
        $dirtyRooms = Room::where('status', 'dirty')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        // Get daily revenue
        $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'finished')
            ->sum('total_price');

        // Get active transactions for cashier
        $activeTransactionsList = Transaction::with(['room', 'user'])
            ->where('status', 'active')
            ->orderBy('check_in', 'desc')
            ->get();

        // Incomplete guest data count & list
        $incompleteGuests = Transaction::with(['room'])
            ->where('status', 'active')
            ->where('is_guest_data_complete', false)
            ->get();
        $incompleteGuestsCount = $incompleteGuests->count();

        // Approaching / overdue checkout guests
        $approachingCheckoutGuests = $activeTransactionsList->filter(function ($tx) {
            return in_array($tx->checkout_urgency, ['overdue', 'imminent', 'today']);
        });
        $approachingCheckoutCount = $approachingCheckoutGuests->count();

        // Data untuk chart: 7 hari terakhir
        $chartData = [];
        $chartLabels = [];
        $chartTransactions = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->isoFormat('ddd');
            
            $dailyRevenue = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->sum('total_price');
            $chartData[] = $dailyRevenue;
            
            $dailyTransactions = Transaction::whereDate('created_at', $date)
                ->where('status', 'finished')
                ->count();
            $chartTransactions[] = $dailyTransactions;
        }

        // Data untuk Rekap Bulan Ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $monthlyRevenue = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->sum('total_price');
            
        $monthlyExpenses = Expense::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
            
        $monthlyTCCommission = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'finished')
            ->where('is_tc', true)
            ->sum('tc_nominal');
            
        $monthlyProfit = $monthlyRevenue - ($monthlyExpenses + $monthlyTCCommission);

        return view('dashboard-kasir', compact(
            'rooms',
            'activeTransactions',
            'activeTransactionsList',
            'incompleteGuests',
            'incompleteGuestsCount',
            'approachingCheckoutGuests',
            'approachingCheckoutCount',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'dirtyRooms',
            'occupancyRate',
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

    /**
     * API Endpoint untuk real-time room status updates
     * Digunakan untuk polling dari frontend tanpa perlu refresh halaman
     */
    public function getRoomStatusAPI(Request $request)
    {
        try {
            // Get rooms dengan limit (untuk performance)
            $limit = $request->query('limit', 8);
            $rooms = Room::orderBy('room_number')
                ->take($limit)
                ->get(['id', 'room_number', 'type', 'status', 'price_per_night']);

            // Count stats
            $stats = [
                'total' => Room::count(),
                'available' => Room::where('status', 'available')->count(),
                'occupied' => Room::where('status', 'occupied')->count(),
                'dirty' => Room::where('status', 'dirty')->count(),
                'maintenance' => Room::where('status', 'maintenance')->count(),
            ];

            // Get today's revenue
            $todayRevenue = Transaction::whereDate('created_at', Carbon::today())
                ->where('status', 'finished')
                ->sum('total_price');

            // Get active transactions count
            $activeTransactions = Transaction::where('status', 'active')->count();

            return response()->json([
                'success' => true,
                'rooms' => $rooms,
                'stats' => $stats,
                'todayRevenue' => $todayRevenue,
                'activeTransactions' => $activeTransactions,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

