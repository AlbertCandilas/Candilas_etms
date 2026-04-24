<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index() {
        $payrolls = Payroll::with('employee')->get();
        return view('payroll.index', compact('payrolls'));
    }

    public function create() {
        $employees = Employee::all();
        return view('payroll.create', compact('employees'));
    }

    public function store(Request $request) {
        // You can calculate net_salary here before saving
        $data = $request->all();
        $data['net_salary'] = ($request->total_hours * 50) - $request->deductions;
        
        Payroll::create($data);
        return redirect()->route('payroll.index');
    }

    public function edit(Payroll $payroll) {
        $employees = Employee::all();
        return view('payroll.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll) {
        $data = $request->all();
        
        // Recalculate net salary based on updated hours/deductions
        $data['net_salary'] = ($request->total_hours * 50) - $request->deductions;

        $payroll->update($data);
        return redirect()->route('payroll.index')->with('success', 'Payroll updated successfully.');
    }

    public function destroy(Payroll $payroll) {
        $payroll->delete();
        return redirect()->route('payroll.index')->with('success', 'Payroll record deleted.');
    }
}