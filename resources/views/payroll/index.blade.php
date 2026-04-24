@extends('layouts.app')

@section('header_title', 'Payroll Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Payroll Records</h3>
        <a href="{{ route('payroll.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i class="bi bi-cash-stack"></i>
            Generate Payroll
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-400 uppercase text-xs">
                    <th class="px-4 py-3 font-medium">Employee</th>
                    <th class="px-4 py-3 font-medium">Date</th>
                    <th class="px-4 py-3 font-medium text-center">Hours (OT)</th>
                    <th class="px-4 py-3 font-medium text-right">Deductions</th>
                    <th class="px-4 py-3 font-medium text-right">Net Salary</th>
                    <th class="px-4 py-3 font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($payrolls as $payroll)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800">{{ $payroll->employee->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $payroll->employee->position }}</div>
                        </td>
                        <td class="px-4 py-4 text-gray-500 italic">
                            {{ \Carbon\Carbon::parse($payroll->payroll_date)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="font-bold text-gray-700">{{ number_format($payroll->total_hours, 1) }}h</span>
                            <span class="text-[10px] text-orange-500 font-bold ml-1">(+{{ number_format($payroll->overtime_hours, 1) }})</span>
                        </td>
                        <td class="px-4 py-4 text-right text-red-500 font-medium">
                            -₱{{ number_format($payroll->deductions, 2) }}
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="text-green-600 font-bold text-base">
                                ₱{{ number_format($payroll->net_salary, 2) }}
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('payroll.edit', $payroll->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <form action="{{ route('payroll.destroy', $payroll->id) }}" method="POST" onsubmit="return confirm('Remove this payroll record?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Delete">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-400">
                            <p class="italic">No payroll records generated yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection