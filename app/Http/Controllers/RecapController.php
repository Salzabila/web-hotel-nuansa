<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecapController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $carbon = Carbon::parse($date);

        $transactions = Transaction::whereDate('check_in', $date)
            ->where('status', 'finished')
            ->with('room', 'user')
            ->get();

        $expenses = Expense::whereDate('date', $date)->get();

        $income = $transactions->sum('total_price');
        $expense = $expenses->sum('amount');
        $profit = $income - $expense;

        return view('recaps.daily', compact('date', 'carbon', 'transactions', 'expenses', 'income', 'expense', 'profit'));
    }

    public function weekly(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $carbon = Carbon::parse($date);
        $startOfWeek = $carbon->startOfWeek();
        $endOfWeek = $carbon->endOfWeek();

        $dailyData = [];
        $totalIncome = 0;
        $totalExpense = 0;

        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $income = Transaction::whereDate('check_in', $day)->where('status', 'finished')->sum('total_price');
            $expense = Expense::whereDate('date', $day)->sum('amount');

            $dailyData[] = [
                'date' => $day,
                'day' => $day->format('D'),
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense
            ];

            $totalIncome += $income;
            $totalExpense += $expense;
        }

        return view('recaps.weekly', compact('date', 'startOfWeek', 'endOfWeek', 'dailyData', 'totalIncome', 'totalExpense'));
    }

    public function monthly(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m'));
        [$year, $month] = explode('-', $date);

        $monthName = Carbon::parse($date . '-01')->format('F Y');
        $daysInMonth = Carbon::parse($date . '-01')->daysInMonth;

        $dailyData = [];
        $totalIncome = 0;
        $totalExpense = 0;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date_obj = Carbon::parse("$year-$month-$day");
            $income = Transaction::whereDate('check_in', $date_obj)->where('status', 'finished')->sum('total_price');
            $expense = Expense::whereDate('date', $date_obj)->sum('amount');

            $dailyData[] = [
                'date' => $date_obj,
                'day' => $day,
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense
            ];

            $totalIncome += $income;
            $totalExpense += $expense;
        }

        return view('recaps.monthly', compact('date', 'monthName', 'dailyData', 'totalIncome', 'totalExpense'));
    }

    public function yearly(Request $request)
    {
        $year = $request->query('year', now()->format('Y'));

        $monthlyData = [];
        $totalIncome = 0;
        $totalExpense = 0;

        for ($m = 1; $m <= 12; $m++) {
            $startDate = Carbon::parse("$year-$m-01");
            $endDate = $startDate->copy()->endOfMonth();

            $income = Transaction::whereBetween('check_in', [$startDate, $endDate])
                ->where('status', 'finished')
                ->sum('total_price');
            $expense = Expense::whereBetween('date', [$startDate, $endDate])->sum('amount');

            $monthlyData[] = [
                'month' => $startDate->format('M'),
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense
            ];

            $totalIncome += $income;
            $totalExpense += $expense;
        }

        return view('recaps.yearly', compact('year', 'monthlyData', 'totalIncome', 'totalExpense'));
    }

    public function exportDaily(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));

        $transactions = Transaction::whereDate('check_in', $date)
            ->where('status', 'finished')
            ->with('room', 'user')
            ->get();

        $expenses = Expense::whereDate('date', $date)->get();

        $csv = "REKAPITULASI HARIAN - $date\n\n";
        $csv .= "TRANSAKSI:\n";
        $csv .= "No,Pelanggan,NIK,Kamar,Total\n";
        
        $incomeTotal = 0;
        foreach ($transactions as $idx => $tx) {
            $csv .= ($idx + 1) . "," . $tx->guest_name . "," . $tx->nik . "," . $tx->room->room_number . "," . $tx->total_price . "\n";
            $incomeTotal += $tx->total_price;
        }

        $csv .= "\nPENGELUARAN:\n";
        $csv .= "Kategori,Deskripsi,Jumlah\n";
        $expenseTotal = 0;
        foreach ($expenses as $exp) {
            $csv .= $exp->category . "," . ($exp->description ?? '-') . "," . $exp->amount . "\n";
            $expenseTotal += $exp->amount;
        }

        $csv .= "\nRINGKASAN:\n";
        $csv .= "Total Pemasukan,$incomeTotal\n";
        $csv .= "Total Pengeluaran,$expenseTotal\n";
        $csv .= "Profit,$incomeTotal - $expenseTotal\n";

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=recap_daily_$date.csv"
        ]);
    }

    /**
     * Personal Shift Recap - Accessible by Kasir and Admin
     * Shows transactions handled by the currently authenticated user today
     */
    public function personal()
    {
        $today = Carbon::today();
        $userId = auth()->id();
        $userName = auth()->user()->name;

        // Get all transactions created by this user today
        $transactions = Transaction::with(['room'])
            ->where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate total cash in
        $totalCashIn = $transactions->where('status', 'finished')->sum('total_price');
        $totalTransactions = $transactions->count();
        $finishedTransactions = $transactions->where('status', 'finished')->count();
        $activeTransactions = $transactions->where('status', 'active')->count();

        return view('recaps.personal', compact(
            'today',
            'userName',
            'transactions',
            'totalCashIn',
            'totalTransactions',
            'finishedTransactions',
            'activeTransactions'
        ));
    }
}
