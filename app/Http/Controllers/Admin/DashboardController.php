<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class DashboardController extends Controller
{
    /**
     * Ipakita ang Dashboard Overview
     */
    public function index()
    {
        // Total employees
        $totalEmployees = Employee::count();

        // Temporary stats (no attendance system yet)
        $presentToday = 0;
        $pendingLeaves = 0;

        // Payroll total
        $monthlyPayroll = Employee::sum('basic_salary');

        return view('admin.dashboard', compact(
            'totalEmployees',
            'presentToday',
            'pendingLeaves',
            'monthlyPayroll'
        ));
    }
}