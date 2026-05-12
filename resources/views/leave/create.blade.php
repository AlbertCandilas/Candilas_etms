@extends('layouts.app')

@section('header_title', 'New Leave Request')

@section('content')
<style>
    /* Absolute fix for white-on-white text issues */
    select, option, input {
        color: #000000 !important;
        background-color: #ffffff !important;
    }
</style>

<div class="max-w-2xl">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('leave-management.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm transition-colors">
            <i class="bi bi-arrow-left"></i> Back to Leave List
        </a>
    </div>

    <form action="{{ route('leave-management.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Employee Selection --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Select Employee</label>
            <select name="employee_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white">
                <option value="" disabled selected>Select an employee</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->first_name }} {{ $emp->last_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Leave Type Selection --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
            <select name="leave_type_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none bg-white">
                <option value="" disabled selected>Select Leave Type</option>
                @foreach($leaveTypes as $type)
                    <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->leave_name }} 
                    </option>
                @endforeach
            </select>
            @error('leave_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Date Range --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Initial Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Initial Status</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Pending" {{ old('status', 'Pending') == 'Pending' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:text-yellow-700 hover:bg-gray-50 text-black">
                        <i class="bi bi-clock-history mb-1 block"></i>
                        <span class="text-sm font-semibold">Pending</span>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Approved" {{ old('status') == 'Approved' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:text-green-700 hover:bg-gray-50 text-black">
                        <i class="bi bi-check-circle mb-1 block"></i>
                        <span class="text-sm font-semibold">Approve</span>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Rejected" {{ old('status') == 'Rejected' ? 'checked' : '' }} class="peer hidden">
                    <div class="text-center p-3 border rounded-lg transition-all peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 hover:bg-gray-50 text-black">
                        <i class="bi bi-x-circle mb-1 block"></i>
                        <span class="text-sm font-semibold">Reject</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center gap-2 transition-all active:scale-95">
                <i class="bi bi-calendar-check"></i> Submit Leave Request
            </button>
        </div>
    </form>
</div>
@endsection