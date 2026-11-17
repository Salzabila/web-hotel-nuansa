<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    // Room CRUD operations
    Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Pengeluaran Operasional
    Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // Reports (admin)
    Route::get('reports/finance', [\App\Http\Controllers\FinancialReportController::class, 'index'])->name('reports.finance');
    Route::get('reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('reports/feedback', [ReportController::class, 'feedback'])->name('reports.feedback');
    Route::get('reports/export-transactions', [ReportController::class, 'exportTransactions'])->name('reports.exportTransactions');

    // Export Routes (PDF & Excel)
    Route::get('export/transactions-pdf', [ReportExportController::class, 'exportTransactionsPDF'])->name('export.transactions.pdf');
    Route::get('export/transactions-excel', [ReportExportController::class, 'exportTransactionsExcel'])->name('export.transactions.excel');
    Route::get('export/financial-pdf', [ReportExportController::class, 'exportFinancialPDF'])->name('export.financial.pdf');
    Route::get('export/financial-excel', [ReportExportController::class, 'exportFinancialExcel'])->name('export.financial.excel');

    // Recapitulation (admin)
    Route::get('recaps/daily', [\App\Http\Controllers\RecapController::class, 'daily'])->name('recaps.daily');
    Route::get('recaps/weekly', [\App\Http\Controllers\RecapController::class, 'weekly'])->name('recaps.weekly');
    Route::get('recaps/monthly', [\App\Http\Controllers\RecapController::class, 'monthly'])->name('recaps.monthly');
    Route::get('recaps/yearly', [\App\Http\Controllers\RecapController::class, 'yearly'])->name('recaps.yearly');
    Route::get('recaps/export', [\App\Http\Controllers\RecapController::class, 'export'])->name('recaps.export');
    Route::get('recaps/export-daily', [\App\Http\Controllers\RecapController::class, 'exportDaily'])->name('recaps.exportDaily');
    Route::get('recaps/export-weekly', [\App\Http\Controllers\RecapController::class, 'exportWeekly'])->name('recaps.exportWeekly');
    Route::get('recaps/export-monthly', [\App\Http\Controllers\RecapController::class, 'exportMonthly'])->name('recaps.exportMonthly');

    // Feedbacks (admin)
    Route::get('feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('feedbacks/{feedback}', [FeedbackController::class, 'show'])->name('feedbacks.show');
    Route::put('feedbacks/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('feedbacks.updateStatus');

    // User Management (admin)
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

});
