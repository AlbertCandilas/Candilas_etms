<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::prefix('admin')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendance', AttendanceRecordController::class);
    Route::resource('payroll', PayrollController::class);
    Route::resource('leave-management', LeaveRequestController::class)->parameters([
    'leave-management' => 'leave'
]);
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');