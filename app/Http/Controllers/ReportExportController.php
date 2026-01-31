<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Expense;
use App\Models\OperationalExpense;
use App\Exports\TransactionsExport;
use App\Exports\FinancialExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportExportController extends Controller
{
    /**
     * Export Laporan Transaksi ke PDF
     */
    public function exportTransactionsPDF(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $transactions = Transaction::with(['room', 'user'])
            ->whereBetween('check_in', [$startDate, $endDate])
            ->orderBy('check_in', 'desc')
            ->get();

        $totalRevenue = $transactions->where('status', 'finished')->sum('total_price');
        $totalTransactions = $transactions->count();

        $data = [
            'title' => 'Laporan Transaksi Hotel Nuansa',
            'period' => $startDate->format('d F Y') . ' - ' . $endDate->format('d F Y'),
            'transactions' => $transactions,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'generatedDate' => Carbon::now()->format('d F Y H:i'),
            'generatedBy' => auth()->user()->name
        ];

        $pdf = Pdf::loadView('exports.transactions-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->download('Laporan-Transaksi-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Laporan Keuangan ke PDF
     */
    public function exportFinancialPDF(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Pendapatan
        $revenue = Transaction::where('status', 'finished')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->sum('total_price');

        // Pengeluaran Operasional
        $expenses = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])
            ->get();
        
        $totalExpenses = $expenses->sum('amount');

        // Komisi TC
        $tcCommission = Transaction::where('status', 'finished')
            ->where('payment_method', 'travel_company')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->sum('tc_commission');

        // Laba Bersih
        $netProfit = $revenue - $totalExpenses - $tcCommission;

        // Transaksi
        $transactions = Transaction::with(['room', 'user'])
            ->whereBetween('check_in', [$startDate, $endDate])
            ->orderBy('check_in', 'desc')
            ->get();

        $data = [
            'title' => 'Laporan Keuangan Hotel Nuansa',
            'period' => $startDate->format('d F Y') . ' - ' . $endDate->format('d F Y'),
            'revenue' => $revenue,
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'tcCommission' => $tcCommission,
            'netProfit' => $netProfit,
            'transactions' => $transactions,
            'generatedDate' => Carbon::now()->format('d F Y H:i'),
            'generatedBy' => auth()->user()->name
        ];

        $pdf = Pdf::loadView('exports.financial-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->download('Laporan-Keuangan-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export Transaksi ke Excel
     */
    public function exportTransactionsExcel(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $transactions = Transaction::with(['room', 'user'])
            ->whereBetween('check_in', [$startDate, $endDate])
            ->orderBy('check_in', 'desc')
            ->get();

        return Excel::download(
            new TransactionsExport($transactions), 
            'Laporan-Transaksi-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export Keuangan ke Excel
     */
    public function exportFinancialExcel(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Data Ringkasan
        $revenue = Transaction::where('status', 'finished')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->sum('total_price');

        $expenses = OperationalExpense::whereBetween('expense_date', [$startDate, $endDate])->get();
        $totalExpenses = $expenses->sum('amount');

        $tcCommission = Transaction::where('status', 'finished')
            ->where('payment_method', 'travel_company')
            ->whereBetween('check_in', [$startDate, $endDate])
            ->sum('tc_commission');

        $netProfit = $revenue - $totalExpenses - $tcCommission;

        return Excel::download(
            new FinancialExport($revenue, $totalExpenses, $tcCommission, $netProfit, $expenses, $startDate, $endDate),
            'Laporan-Keuangan-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }
}
