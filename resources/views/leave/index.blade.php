@extends('layouts.app')

@section('header_title', 'Leave Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Leave Requests</h3>
        <a href="{{ route('leave-management.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i class="bi bi-calendar-plus"></i>
            New Request
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-400 uppercase text-xs">
                    <th class="px-4 py-3 font-medium">Employee</th>
                    <th class="px-4 py-3 font-medium">Type</th>
                    <th class="px-4 py-3 font-medium">Duration</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($leaves as $leave)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-gray-800">{{ $leave->employee->name }}</div>
                            <div class="text-[10px] text-gray-400 uppercase">{{ $leave->employee->position }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-gray-700 font-medium">{{ $leave->leave_type }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-gray-800 font-medium">
                                {{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - 
                                {{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}
                            </div>
                            <div class="text-[10px] text-blue-500 font-bold">
                                {{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} Day(s)
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            @php
                                $statusClass = match(strtolower($leave->status)) {
                                    'approved' => 'bg-green-100 text-green-700',
                                    'pending'  => 'bg-yellow-100 text-yellow-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    default    => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClass }}">
                                {{ $leave->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('leave-management.update', $leave->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="p-1 text-green-600 hover:bg-green-50 rounded" title="Approve">
                                        <i class="bi bi-check-circle-fill text-lg"></i>
                                    </button>
                                </form>

                                <form action="{{ route('leave-management.update', $leave->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="p-1 text-red-600 hover:bg-red-50 rounded" title="Reject">
                                        <i class="bi bi-x-circle-fill text-lg"></i>
                                    </button>
                                </form>

                                <div class="h-4 border-r border-gray-200 mx-1"></div>

                                <a href="{{ route('leave-management.edit', $leave->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <form action="{{ route('leave-management.destroy', $leave->id) }}" method="POST" onsubmit="return confirm('Delete this request?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600">
                                        <i class="bi bi-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 italic">
                            No leave requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection