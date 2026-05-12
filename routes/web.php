<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AttendanceStatusController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DashboardController;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('employees.index');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendance', AttendanceRecordController::class);
    Route::resource('payroll', PayrollController::class);
    
    Route::resource('leave-management', LeaveRequestController::class)->parameters([
        'leave-management' => 'leave'
    ]);

    Route::resource('administrators', AdministratorController::class);
    Route::resource('attendance-statuses', AttendanceStatusController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('leave-types', LeaveTypeController::class);
    Route::resource('positions', PositionController::class);

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});