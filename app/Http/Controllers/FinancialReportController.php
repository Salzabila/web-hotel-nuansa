<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\OperationalExpense;
use App\Models\Expense;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'harian');
        $today = Carbon::today();

        // Calculate date range based on period or manual inputs
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
        } else {
            if ($period === 'harian') {
                $startDate = $today->copy()->startOfDay();
                $endDate = $today->copy()->endOfDay();
            } elseif ($period === 'mingguan') {
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
            } elseif ($period === 'bulanan') {
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
            } elseif ($period === 'tahunan') {
                $startDate = $today->copy()->startOfYear();
                $endDate = $today->copy()->endOfYear();
            } else {
                $startDate = $today->copy()->startOfDay();
                $endDate = $today->copy()->endOfDay();
            }
        }

        // Get transactions (revenue)
        $transactions = Transaction::with('room')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->orderBy('check_out', 'desc')
            ->paginate(20);

        // Operational expenses query with category filter
        $selectedCategory = $request->get('category', 'all');
        $expenseQuery = Expense::query();
        if ($selectedCategory && $selectedCategory !== 'all') {
            $expenseQuery->where('category', $selectedCategory);
        }
        $expenseQuery->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        $expensesList = $expenseQuery->orderBy('date', 'desc')->get();

        // If Expense is empty, check OperationalExpense as fallback
        if ($expensesList->isEmpty()) {
            $opQuery = OperationalExpense::query();
            if ($selectedCategory && $selectedCategory !== 'all') {
                $opQuery->where('category', $selectedCategory);
            }
            $opQuery->whereBetween('expense_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            $expensesList = $opQuery->orderBy('expense_date', 'desc')->get();
        }

        // Operational expenses paginated (for backward compatibility if needed)
        $expenses = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])
            ->orderBy('expense_date', 'desc')
            ->paginate(20, ['*'], 'expenses_page');

        // Calculate summary
        $totalRevenue = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->sum('total_price');

        $totalExpensesFromOps = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');
        $totalExpensesFromExp = Expense::whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->sum('amount');
        $rawExpenseTotal = max($totalExpensesFromOps, $totalExpensesFromExp);

        // Tambahkan komisi TC sebagai expense
        $totalTCCommission = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->where('is_tc', true)
            ->sum('tc_nominal');
        
        $totalExpenses = $rawExpenseTotal + $totalTCCommission;
        
        // Input untuk biaya operasional tambahan dan gaji
        $operationalCost = (float) $request->get('operational_cost', 0);
        $employeeSalary = (float) $request->get('employee_salary', 0);
        
        // Total customer count
        $totalCustomers = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->count();

        // Laba Bersih = Total Pendapatan - (Total Expenses + Biaya Ops + Gaji)
        $netProfit = $totalRevenue - ($totalExpenses + $operationalCost + $employeeSalary);

        // Feedback stats
        $avgRating = Feedback::avg('rating');
        $avgRatingFormatted = $avgRating ? number_format($avgRating, 1) : '4.8';
        $latestFeedback = Feedback::latest()->first();

        return view('reports.financial', compact(
            'transactions',
            'expenses',
            'expensesList',
            'startDate',
            'endDate',
            'period',
            'selectedCategory',
            'totalRevenue',
            'rawExpenseTotal',
            'totalExpenses',
            'totalTCCommission',
            'netProfit',
            'operationalCost',
            'employeeSalary',
            'totalCustomers',
            'avgRatingFormatted',
            'latestFeedback'
        ));
    }
}
