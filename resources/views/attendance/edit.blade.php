@extends('layouts.app')

@section('header_title', 'Edit Attendance Log')

@section('content')
<div class="max-w-2xl">
    {{-- Consistent Back Button --}}
    <div class="mb-6">
        <a href="{{ route('attendance.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Back to Logs
        </a>
    </div>

    {{-- Info Header --}}
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <p class="text-sm text-gray-700">Editing entry for: <strong>{{ $attendance->employee->name }}</strong></p>
    </div>

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date" value="{{ $attendance->date }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Attendance Status</label>
                <select name="status" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="Present" {{ $attendance->status == 'Present' ? 'selected' : '' }}>Present</option>
                    <option value="Late" {{ $attendance->status == 'Late' ? 'selected' : '' }}>Late</option>
                    <option value="Absent" {{ $attendance->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Time In</label>
                <input type="time" name="time_in" value="{{ $attendance->time_in }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Time Out</label>
                <input type="time" name="time_out" value="{{ $attendance->time_out }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Verified By (Admin)</label>
            <select name="verified_by" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none">
                <option value="">System Auto</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $attendance->verified_by == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg flex items-center gap-2 transition-colors">
                <i class="bi bi-save"></i> Update Entry
            </button>
        </div>
    </form>
</div>
@endsection