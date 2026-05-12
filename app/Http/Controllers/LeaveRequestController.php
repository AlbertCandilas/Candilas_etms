<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveRequestController extends Controller
{
    public function index() {
        $leaves = DB::table('view_leave_details')->get();
        return view('leave.index', compact('leaves'));
    }

    public function create() {
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        return view('leave.create', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|max:20'
        ]);

        LeaveRequest::create($request->all());
        return redirect()->route('leave-management.index')->with('success', 'Leave request created.');
    }

    public function edit($id) {
        $leave = LeaveRequest::findOrFail($id);
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        return view('leave.edit', compact('leave', 'employees', 'leaveTypes'));
    }

    public function update(Request $request, $id) {
        $leave = LeaveRequest::findOrFail($id);
        $leave->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated.');
    }

    public function destroy($id) {
        $leave = LeaveRequest::findOrFail($id);
        $leave->delete();
        return redirect()->route('leave-management.index')->with('success', 'Leave request deleted.');
    }
}