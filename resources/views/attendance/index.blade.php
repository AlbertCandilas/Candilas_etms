@extends('layouts.app')

@section('header_title', 'Attendance Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Daily Attendance Logs</h3>
        <a href="{{ route('attendance.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i class="bi bi-clock-history"></i>
            Log Attendance
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-400 uppercase text-xs">
                    <th class="px-4 py-3 font-medium">Date</th>
                    <th class="px-4 py-3 font-medium">Employee</th>
                    <th class="px-4 py-3 font-medium">In / Out</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Verified By</th>
                    <th class="px-4 py-3 font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($attendance as $record)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800">{{ $record->employee->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase">{{ $record->employee->position }}</div>
                        </td>
                        <td class="px-4 py-4 font-mono text-xs">
                            <span class="text-green-600">{{ $record->time_in }}</span>
                            <span class="mx-1 text-gray-300">|</span>
                            <span class="text-orange-600">{{ $record->time_out ?? '--:--' }}</span>
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $statusColor = match(strtolower($record->status)) {
                                    'present' => 'bg-green-100 text-green-700',
                                    'late' => 'bg-yellow-100 text-yellow-700',
                                    'absent' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusColor }}">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-gray-500">
                            {{ $record->admin->name ?? 'System Auto' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('attendance.edit', $record->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <form action="{{ route('attendance.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Delete this attendance record?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-400 italic">
                            No attendance logs found for today.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection