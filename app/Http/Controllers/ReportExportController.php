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
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'chroot' => public_path(),
                'isRemoteEnabled' => true,
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

        // Pengeluaran Operasional (Unified Expense Model)
        $expenses = Expense::with('user')
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
        
        $totalExpenses = $expenses->sum('amount');

        // Komisi TC
        $tcCommission = Transaction::where('status', 'finished')
            ->where('is_tc', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('tc_nominal');

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
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif',
                'dpi' => 150,
                'chroot' => public_path(),
                'isRemoteEnabled' => true,
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

        $expenses = Expense::with('user')
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();
        $totalExpenses = $expenses->sum('amount');

        $tcCommission = Transaction::where('status', 'finished')
            ->where('is_tc', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('tc_nominal');

        $netProfit = $revenue - $totalExpenses - $tcCommission;

        return Excel::download(
            new FinancialExport($revenue, $totalExpenses, $tcCommission, $netProfit, $expenses, $startDate, $endDate),
            'Laporan-Keuangan-' . Carbon::now()->format('Y-m-d') . '.xlsx'
        );
    }
}
