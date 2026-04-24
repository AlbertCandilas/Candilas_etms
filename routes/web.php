<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;

/*
|-------------------------
| ADMIN ROUTES
|-------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Employees CRUD
    Route::resource('/employees', EmployeeController::class);

    // Placeholder routes (avoid errors for now)
    Route::get('/attendance', fn () => view('admin.attendance'))->name('attendance');
    Route::get('/payroll', fn () => view('admin.payroll'))->name('payroll');
    Route::get('/leave', fn () => view('admin.leave'))->name('leave');

});