<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\OperationalExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now());

        if (is_string($startDate)) {
            $startDate = Carbon::parse($startDate);
        }
        if (is_string($endDate)) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        // Get transactions (revenue)
        $transactions = Transaction::with('room')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get operational expenses
        $expenses = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])
            ->orderBy('expense_date', 'desc')
            ->paginate(20, ['*'], 'expenses_page');

        // Calculate summary
        $totalRevenue = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'finished')
            ->sum('total_price');

        $totalExpenses = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');

        $netProfit = $totalRevenue - $totalExpenses;

        return view('reports.financial', compact(
            'transactions',
            'expenses',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalExpenses',
            'netProfit'
        ));
    }
}
