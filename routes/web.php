<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard - untuk semua user
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    // Transactions - untuk semua user
    Route::get('transactions', [TransactionController::class,'index'])->name('transactions.index');
    Route::get('transactions/checkin/{room}', [TransactionController::class,'create'])->name('transactions.create');
    Route::post('transactions/checkin/{room}', [TransactionController::class,'store'])->name('transactions.store');
    Route::get('transactions/checkout/{id}', [TransactionController::class,'showCheckout'])->name('transactions.checkout');
    Route::post('transactions/checkout/{id}', [TransactionController::class,'processCheckout'])->name('transactions.processCheckout');
    Route::get('transactions/struk/{id}', [TransactionController::class,'struk'])->name('transactions.struk');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Manajemen Kamar
        Route::get('rooms', [RoomController::class,'index'])->name('rooms.index');
        Route::get('rooms/create', [RoomController::class,'create'])->name('rooms.create');
        Route::post('rooms', [RoomController::class,'store'])->name('rooms.store');
        Route::get('rooms/{room}/edit', [RoomController::class,'edit'])->name('rooms.edit');
        Route::put('rooms/{room}', [RoomController::class,'update'])->name('rooms.update');
        Route::delete('rooms/{room}', [RoomController::class,'destroy'])->name('rooms.destroy');
        
        // Pengeluaran Operasional
        Route::get('expenses', [ExpenseController::class,'index'])->name('expenses.index');
        Route::get('expenses/create', [ExpenseController::class,'create'])->name('expenses.create');
        Route::post('expenses', [ExpenseController::class,'store'])->name('expenses.store');

        // Reports (admin)
        Route::get('reports/finance', [\App\Http\Controllers\FinancialReportController::class, 'index'])->name('reports.finance');
        Route::get('reports/transactions', [\App\Http\Controllers\ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('reports/feedback', [\App\Http\Controllers\ReportController::class, 'feedback'])->name('reports.feedback');
        Route::get('reports/export-transactions', [\App\Http\Controllers\ReportController::class, 'exportTransactions'])->name('reports.exportTransactions');
        
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
        Route::get('feedbacks', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::get('feedbacks/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'show'])->name('feedbacks.show');
        Route::put('feedbacks/{feedback}/status', [\App\Http\Controllers\FeedbackController::class, 'updateStatus'])->name('feedbacks.updateStatus');
    });
});

