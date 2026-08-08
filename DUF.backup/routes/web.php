<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseTransactionController;
use App\Http\Controllers\IncomeTransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('people', PersonController::class);
    Route::resource('income', IncomeTransactionController::class)->parameters(['income' => 'income']);
    Route::get('income/{income}/download', [IncomeTransactionController::class, 'download'])->name('income.download');
    Route::resource('expense', ExpenseTransactionController::class)->parameters(['expense' => 'expense']);
    Route::get('expense/{expense}/download', [ExpenseTransactionController::class, 'download'])->name('expense.download');
    Route::get('receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::resource('inventories', InventoryController::class);
    Route::get('cash', CashBookController::class)->name('cash.index');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('reports/excel', [ReportController::class, 'excel'])->name('reports.excel');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::put('users/{user}/password', [UserManagementController::class, 'resetPassword'])->name('users.password');
        Route::patch('users/{user}/enable', [UserManagementController::class, 'enable'])->name('users.enable');
        Route::delete('users/{user}/permanent', [UserManagementController::class, 'permanentDestroy'])->name('users.permanent-destroy');
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
