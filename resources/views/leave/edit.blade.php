@extends('layouts.app')

@section('header_title', 'Update Leave Request')

@section('content')
<div class="max-w-2xl">
    {{-- Consistent Back Button --}}
    <div class="mb-6">
        <a href="{{ route('leave-management.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Back to Leave List
        </a>
    </div>

    {{-- Info Header --}}
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-sm text-gray-700">Requester: <span class="font-bold ml-1">{{ $leave->employee->name }}</span></p>
        <p class="text-xs text-gray-500">Type: {{ $leave->leave_type }}</p>
    </div>

    {{-- Updated Form with parameter fix --}}
    <form action="{{ route('leave-management.update', ['leave' => $leave->id]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Update Request Status</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Pending --}}
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Pending" {{ $leave->status == 'Pending' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:text-yellow-700 hover:bg-gray-50">
                        <i class="bi bi-clock-history mb-1 block"></i>
                        <span class="text-sm font-semibold">Pending</span>
                    </div>
                </label>

                {{-- Approved --}}
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Approved" {{ $leave->status == 'Approved' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700 hover:bg-gray-50">
                        <i class="bi bi-check-circle mb-1 block"></i>
                        <span class="text-sm font-semibold">Approve</span>
                    </div>
                </label>

                {{-- Rejected --}}
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Rejected" {{ $leave->status == 'Rejected' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 hover:bg-gray-50">
                        <i class="bi bi-x-circle mb-1 block"></i>
                        <span class="text-sm font-semibold">Reject</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="bi bi-arrow-repeat"></i> Update Request Status
            </button>
        </div>
    </form>
</div>
@endsection