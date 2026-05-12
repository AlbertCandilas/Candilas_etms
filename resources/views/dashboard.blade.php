@extends('layouts.app')

@section('header_title', 'System Overview')

@section('content')
<div class="space-y-8">
    {{-- Top Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5 transition-hover hover:shadow-md">
            <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-2xl">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[11px] font-semibold uppercase tracking-wider mb-1">Total Staff</p>
                <h4 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $totalEmployees }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5 transition-hover hover:shadow-md">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center text-2xl">
                <i class="bi bi-calendar2-check"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[11px] font-semibold uppercase tracking-wider mb-1">Today's Logs</p>
                <h4 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $todayAttendance }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5 transition-hover hover:shadow-md">
            <div class="w-14 h-14 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center text-2xl">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[11px] font-semibold uppercase tracking-wider mb-1">Pending Requests</p>
                <h4 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $pendingLeaves }}</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Attendance --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-800">Recent Attendance</h3>
                <a href="{{ route('attendance.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">View All</a>
            </div>
            <div class="px-2">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentAttendance as $log)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-4">
                                <p class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">{{ $log->first_name }} {{ $log->last_name }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $log->position_name }}</p>
                            </td>
                            <td class="px-4 py-4 text-right">
                                @php
                                    $statusClasses = match(strtolower($log->status_name ?? '')) {
                                        'present' => 'bg-emerald-50 text-emerald-600',
                                        'late'    => 'bg-amber-50 text-amber-600',
                                        'absent'  => 'bg-rose-50 text-rose-600',
                                        default   => 'bg-gray-50 text-gray-600'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide {{ $statusClasses }}">
                                    {{ $log->status_name ?? 'Unknown' }}
                                </span>
                                <p class="text-[10px] text-gray-400 mt-1.5 font-mono">{{ $log->time_in }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Payroll --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-800">Recent Payroll</h3>
                <a href="{{ route('payroll.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Manage</a>
            </div>
            <div class="px-2">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($latestPayroll as $pay)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-4">
                                <p class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">{{ $pay->employee_name }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Paid {{ \Carbon\Carbon::parse($pay->payroll_date)->format('M d, Y') }}</p>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <p class="text-sm font-bold text-emerald-600">₱{{ number_format($pay->net_salary, 2) }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-tighter font-semibold">Net Salary</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection