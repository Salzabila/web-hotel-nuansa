<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Front Office (Check-in & Checkout terpadu)
    Route::get('front-office', [TransactionController::class, 'frontOffice'])->name('front-office');
    Route::get('checkin', [TransactionController::class, 'frontOffice'])->name('checkin');

    // Transactions - untuk semua user
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('transactions/checkin/{room}', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions/checkin/{room}', [TransactionController::class, 'store'])->name('transactions.store');

    // Check-in Routes
    Route::get('transactions/{id}/receipt', [TransactionController::class, 'showReceipt'])->name('transactions.receipt');
    Route::put('transactions/{id}/update-checkin-data', [TransactionController::class, 'updateCheckInData'])->name('transactions.updateCheckInData');
    Route::get('transactions/{id}/guest-book', [TransactionController::class, 'showGuestBook'])->name('transactions.guestBook');
    Route::put('transactions/{id}/update-guest-data', [TransactionController::class, 'updateGuestData'])->name('transactions.updateGuestData');

    // API for modal checkout
    Route::get('transactions/{id}/checkout-data', [TransactionController::class, 'getCheckoutData']);
    Route::get('api/cashiers', function () {
        return response()->json(\App\Models\User::where('role', 'kasir')->orderBy('name')->get(['id', 'name']));
    });

    Route::post('transactions/{id}/extend', [TransactionController::class, 'extend'])->name('transactions.extend');
    Route::get('transactions/checkout/{id}', [TransactionController::class, 'showCheckout'])->name('transactions.checkout');
    Route::post('transactions/checkout/{id}', [TransactionController::class, 'processCheckout'])->name('transactions.processCheckout');
    Route::get('transactions/struk/{id}', [TransactionController::class, 'struk'])->name('transactions.struk');

    // Pengeluaran Operasional - accessible by all users (Kasir & Admin)
    Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // Laporan Keuangan - accessible by all users (Kasir & Admin)
    Route::get('reports/finance', [FinancialReportController::class, 'index'])->name('reports.finance');
    Route::get('export/financial-pdf', [ReportExportController::class, 'exportFinancialPDF'])->name('export.financial.pdf');
    Route::get('export/financial-excel', [ReportExportController::class, 'exportFinancialExcel'])->name('export.financial.excel');
    Route::get('export/transactions-pdf', [ReportExportController::class, 'exportTransactionsPDF'])->name('export.transactions.pdf');
    Route::get('export/transactions-excel', [ReportExportController::class, 'exportTransactionsExcel'])->name('export.transactions.excel');

    // Room Management - accessible by all users
    Route::post('rooms/{id}/mark-clean', [RoomController::class, 'markAsClean'])->name('rooms.markClean');
    Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');

    // Personal Recap - accessible by Admin & Kasir
    Route::get('my-recap', [\App\Http\Controllers\RecapController::class, 'personal'])->name('recaps.personal');
});
