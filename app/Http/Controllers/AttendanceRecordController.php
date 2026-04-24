<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\Administrator;
use Illuminate\Http\Request;

class AttendanceRecordController extends Controller
{
    public function index() {
        $attendance = AttendanceRecord::with(['employee', 'admin'])->latest()->get();
        return view('attendance.index', compact('attendance'));
    }

    public function create() {
        $employees = Employee::all();
        $admins = Administrator::all(); // For the 'verified_by' field
        return view('attendance.create', compact('employees', 'admins'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'required',
            'time_out' => 'nullable',
            'status' => 'required',
            'verified_by' => 'nullable|exists:administrators,id'
        ]);

        AttendanceRecord::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance logged.');
    }

    public function edit(AttendanceRecord $attendance) {
        $employees = Employee::all();
        $admins = Administrator::all();
        // The variable $attendance represents the single record being edited
        return view('attendance.edit', compact('attendance', 'employees', 'admins'));
    }

    public function update(Request $request, AttendanceRecord $attendance) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'time_in' => 'required',
            'time_out' => 'nullable',
            'status' => 'required',
            'verified_by' => 'nullable|exists:administrators,id'
        ]);

        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated.');
    }

    public function destroy(AttendanceRecord $attendance) {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted.');
    }
}