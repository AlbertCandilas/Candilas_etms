@extends('layouts.app')

@section('header_title', 'Generate Payroll')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('payroll.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Back to Payroll List
        </a>
    </div>

    <form action="{{ route('payroll.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Employee</label>
            <select name="employee_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                <option value="" disabled selected>Choose an employee...</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->position }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Regular Hours</label>
                <input type="number" step="0.01" name="total_hours" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="0.00">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Overtime Hours</label>
                <input type="number" step="0.01" name="overtime_hours" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="0.00">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deductions (₱)</label>
                <input type="number" step="0.01" name="deductions" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="0.00">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payroll Date</label>
                <input type="date" name="payroll_date" value="{{ date('Y-m-d') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-600 flex items-center gap-2">
                <i class="bi bi-info-circle"></i>
                Net Salary is calculated as: (Total Hours × 50) - Deductions.
            </p>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg flex items-center gap-2">
                <i class="bi bi-cash-coin"></i> Process Payroll
            </button>
        </div>
    </form>
</div>
@endsection