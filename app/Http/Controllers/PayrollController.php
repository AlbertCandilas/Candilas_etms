<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    public function index() {
        $payrolls = DB::table('view_payroll_reports')->get();
        return view('payroll.index', compact('payrolls'));
    }

    public function create() {
        $employees = Employee::all();
        return view('payroll.create', compact('employees'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'total_hours' => 'required|numeric|between:0,999999.99',
            'overtime_hours' => 'required|numeric|between:0,999999.99',
            'deductions' => 'required|numeric|between:0,99999999.99',
            'payroll_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['net_salary'] = ($request->total_hours * 50) + ($request->overtime_hours * 75) - $request->deductions;
        
        Payroll::create($data);
        return redirect()->route('payroll.index')->with('success', 'Payroll record created.');
    }

    public function edit($id) {
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::all();
        return view('payroll.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'total_hours' => 'required|numeric|between:0,999999.99',
            'overtime_hours' => 'required|numeric|between:0,999999.99',
            'deductions' => 'required|numeric|between:0,99999999.99',
            'payroll_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['net_salary'] = ($request->total_hours * 50) + ($request->overtime_hours * 75) - $request->deductions;

        $payroll->update($data);
        return redirect()->route('payroll.index')->with('success', 'Payroll updated successfully.');
    }

    public function destroy($id) {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();
        return redirect()->route('payroll.index')->with('success', 'Payroll record deleted.');
    }
}