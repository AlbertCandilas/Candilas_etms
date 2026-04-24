<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index() {
        $employees = Employee::with('department')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create() {
        $departments = Department::all(); // For the dropdown
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created employee in the database.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);
        Employee::create($data);
        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee) {
        $departments = Department::all();
        return view('employees.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified employee in the database.
     */
    public function update(Request $request, Employee $employee) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,id',
        ]);

        $employee->update($data);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from the database.
     */
    public function destroy(Employee $employee) {
        // Because of onDelete('cascade') in your migration, 
        // related payrolls/attendance will be handled by the DB.
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}