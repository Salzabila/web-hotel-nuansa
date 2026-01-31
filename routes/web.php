<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ReportExportController;
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
    Route::get('transactions/{id}', [TransactionController::class,'show'])->name('transactions.show');
    Route::get('transactions/checkin/{room}', [TransactionController::class,'create'])->name('transactions.create');
    Route::post('transactions/checkin/{room}', [TransactionController::class,'store'])->name('transactions.store');
    
    // Express Check-in Routes
    Route::get('transactions/{id}/receipt', [TransactionController::class,'showReceipt'])->name('transactions.receipt');
    Route::get('transactions/{id}/guest-book', [TransactionController::class,'showGuestBook'])->name('transactions.guestBook');
    Route::put('transactions/{id}/update-guest-data', [TransactionController::class,'updateGuestData'])->name('transactions.updateGuestData');
    
    Route::post('transactions/{id}/extend', [TransactionController::class,'extend'])->name('transactions.extend');
    Route::get('transactions/checkout/{id}', [TransactionController::class,'showCheckout'])->name('transactions.checkout');
    Route::post('transactions/checkout/{id}', [TransactionController::class,'processCheckout'])->name('transactions.processCheckout');
    Route::get('transactions/struk/{id}', [TransactionController::class,'struk'])->name('transactions.struk');

    // Room Management - accessible by all users (grid view) and admin (CRUD)

    // Mark room as clean - accessible by Admin & Kasir
    Route::post('rooms/{id}/mark-clean', [RoomController::class,'markAsClean'])->name('rooms.markClean');

    // Personal Recap - accessible by Admin & Kasir
    Route::get('my-recap', [\App\Http\Controllers\RecapController::class, 'personal'])->name('recaps.personal');

    // Unified Room Management - accessible by all users
    Route::get('rooms', [RoomController::class,'index'])->name('rooms.index');
    
    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Room CRUD operations
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
        Route::get('feedbacks', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedbacks.index');
        Route::get('feedbacks/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'show'])->name('feedbacks.show');
        Route::put('feedbacks/{feedback}/status', [\App\Http\Controllers\FeedbackController::class, 'updateStatus'])->name('feedbacks.updateStatus');
        
        // User Management (admin)
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
        
        // Cashier Management (admin)
        Route::get('cashiers', [CashierController::class, 'index'])->name('cashiers.index');
        Route::post('cashiers', [CashierController::class, 'store'])->name('cashiers.store');
        Route::delete('cashiers/{cashier}', [CashierController::class, 'destroy'])->name('cashiers.destroy');
    });
});

