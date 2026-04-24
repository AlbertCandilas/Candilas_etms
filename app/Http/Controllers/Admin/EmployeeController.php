<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Show all employees
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    // Show create form
    public function create()
    {
        return view('admin.employees.create');
    }

    // Store employee
    public function store(Request $request)
    {
        $request->validate([
            'employee_no' => 'required|unique:employees',
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'basic_salary' => 'required|numeric',
        ]);

        Employee::create($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee added successfully!');
    }

    // Show edit form
    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    // Update employee
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_no' => 'required',
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'basic_salary' => 'required|numeric',
        ]);

        $employee->update($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    // Delete employee
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return back()->with('success', 'Employee deleted successfully!');
    }
}