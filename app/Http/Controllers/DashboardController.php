<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = DB::table('view_employee_details')->count();
        
        $todayAttendance = DB::table('view_attendance_details')
            ->where('date', now()->toDateString())
            ->count();

        $pendingLeaves = DB::table('leave_requests')
            ->where('status', 'Pending')
            ->count();

        $recentAttendance = DB::table('view_attendance_details')
            ->latest('id')
            ->limit(5)
            ->get();

        $latestPayroll = DB::table('view_payroll_reports')
            ->latest('payroll_date')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalEmployees', 
            'todayAttendance', 
            'pendingLeaves', 
            'recentAttendance',
            'latestPayroll'
        ));
    }
}