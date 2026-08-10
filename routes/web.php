<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseTransactionController;
use App\Http\Controllers\IncomeTransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MealScheduleController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Master Data & Operations
    Route::resource('people', PersonController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('meal-schedules', MealScheduleController::class);
    Route::resource('attendances', AttendanceController::class);

    // Invoices (Termasuk tambahan route markAsPaid)
    Route::patch('invoices/{invoice}/pay', [InvoiceController::class, 'markAsPaid'])->name('invoices.pay');
    Route::resource('invoices', InvoiceController::class)->except(['edit', 'update']);

    // Transactions & Cash Book
    Route::resource('income', IncomeTransactionController::class)->parameters(['income' => 'income']);
    Route::get('income/{income}/download', [IncomeTransactionController::class, 'download'])->name('income.download');

    Route::resource('expense', ExpenseTransactionController::class)->parameters(['expense' => 'expense']);
    Route::get('expense/{expense}/download', [ExpenseTransactionController::class, 'download'])->name('expense.download');

    Route::get('receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::get('cash', CashBookController::class)->name('cash.index');

    // Salaries (Penggajian)
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::get('/salaries/create', [SalaryController::class, 'create'])->name('salaries.create');
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');
    Route::delete('/salaries/{salary}', [SalaryController::class, 'destroy'])->name('salaries.destroy');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('reports/excel', [ReportController::class, 'excel'])->name('reports.excel');

    // Settings
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';