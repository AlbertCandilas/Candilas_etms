<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index() {
        $leaves = LeaveRequest::with('employee')->get();
        return view('leave.index', compact('leaves'));
    }

    public function create() {
        $employees = Employee::all();
        return view('leave.create', compact('employees'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string'
        ]);

        LeaveRequest::create($request->all());
        return redirect()->route('leave-management.index')->with('success', 'Leave request created.');
    }

    public function edit(LeaveRequest $leave) {
        $employees = Employee::all();
        // Passing the record as $leave to match your update method parameter
        return view('leave.edit', compact('leave', 'employees'));
    }

    public function update(Request $request, LeaveRequest $leave) {
        // Used for Admin to Approve or Reject
        $leave->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated.');
    }

    public function destroy(LeaveRequest $leave) {
        $leave->delete();
        return redirect()->route('leave-management.index')->with('success', 'Leave request deleted.');
    }
}