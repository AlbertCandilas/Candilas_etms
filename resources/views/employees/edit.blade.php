@extends('layouts.app')

@section('header_title', 'Edit Employee')

@section('content')
<div class="max-w-2xl">
    {{-- Consistent Back Button --}}
    <div class="mb-6">
        <a href="{{ route('employees.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Name Fields --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name', $employee->middle_name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @error('middle_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Email Field --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password Field (Optional on edit) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">New Password (Leave blank to keep current)</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all"
                placeholder="********">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Position Dropdown --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Position / Title</label>
            <select name="position_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @foreach($positions as $pos)
                    <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id) == $pos->id ? 'selected' : '' }}>
                        {{ $pos->position_name }}
                    </option>
                @endforeach
            </select>
            @error('position_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Department Dropdown --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Department</label>
            <select name="department_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                        {{ $dept->department_name }}
                    </option>
                @endforeach
            </select>
            @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Submit Button --}}
        <div class="pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                <i class="bi bi-check2-circle"></i> Update Employee Info
            </button>
        </div>
    </form>
</div>
@endsection