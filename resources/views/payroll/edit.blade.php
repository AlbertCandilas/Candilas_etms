@extends('layouts.app')

@section('header_title', 'Adjust Payroll Record')

@section('content')
<div class="max-w-2xl">
    {{-- Consistent Back Button --}}
    <div class="mb-6">
        <a href="{{ route('payroll.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Back to Payroll List
        </a>
    </div>

    <form action="{{ route('payroll.update', $payroll->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Employee Info Header --}}
        <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-sm font-semibold text-gray-700">Editing Payroll for: {{ $payroll->employee->name }}</p>
            <p class="text-xs text-gray-500">Current Net Salary: ₱{{ number_format($payroll->net_salary, 2) }}</p>
        </div>

        <input type="hidden" name="employee_id" value="{{ $payroll->employee_id }}">

        {{-- Hour Inputs Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Regular Hours</label>
                <input type="number" step="0.01" name="total_hours" value="{{ $payroll->total_hours }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Overtime Hours</label>
                <input type="number" step="0.01" name="overtime_hours" value="{{ $payroll->overtime_hours }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>

        {{-- Deductions and Date Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deductions (₱)</label>
                <input type="number" step="0.01" name="deductions" value="{{ $payroll->deductions }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payroll Date</label>
                <input type="date" name="payroll_date" value="{{ $payroll->payroll_date }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-600 flex items-center gap-2">
                <i class="bi bi-info-circle"></i>
                Saving this will automatically recalculate Net Salary: (Total Hours × 50) - Deductions.
            </p>
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg flex items-center gap-2 transition-colors">
                <i class="bi bi-save"></i> Save Adjustments
            </button>
        </div>
    </form>
</div>
@endsection