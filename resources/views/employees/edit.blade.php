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
        
        {{-- Name Input --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input type="text" name="name" value="{{ $employee->name }}" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Position Input --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Position / Title</label>
            <input type="text" name="position" value="{{ $employee->position }}" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all">
            @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Department Dropdown --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Assigned Department</label>
            <select name="department_id" required 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 outline-none transition-all">
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
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