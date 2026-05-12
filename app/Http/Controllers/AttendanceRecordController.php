<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\Administrator;
use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceRecordController extends Controller
{
    public function index() {
        $attendance = DB::table('view_attendance_details')->latest('date')->get();
        return view('attendance.index', compact('attendance'));
    }

    public function create() {
        $employees = Employee::all();
        $admins = Administrator::all();
        $statuses = AttendanceStatus::all();
        return view('attendance.create', compact('employees', 'admins', 'statuses'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status_id' => 'nullable|exists:attendance_statuses,id',
            'verified_by' => 'nullable|exists:administrators,id'
        ]);

        AttendanceRecord::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance logged.');
    }

    public function edit($id) {
        $attendance = AttendanceRecord::findOrFail($id);
        $employees = Employee::all();
        $admins = Administrator::all();
        $statuses = AttendanceStatus::all();
        return view('attendance.edit', compact('attendance', 'employees', 'admins', 'statuses'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'nullable|date',
            'time_in' => 'nullable',
            'time_out' => 'nullable',
            'status_id' => 'nullable|exists:attendance_statuses,id',
            'verified_by' => 'nullable|exists:administrators,id'
        ]);

        $attendance = AttendanceRecord::findOrFail($id);
        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated.');
    }

    public function destroy($id) {
        $attendance = AttendanceRecord::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted.');
    }
}