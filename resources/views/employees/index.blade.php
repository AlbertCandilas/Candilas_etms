@extends('layouts.app')

@section('header_title', 'Employee Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-700">Staff List</h3>
        <a href="{{ route('employees.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
            <i class="bi bi-plus-lg"></i>
            Add Employee
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-400 uppercase text-xs">
                    <th class="px-4 py-3 font-medium">ID</th>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Position</th>
                    <th class="px-4 py-3 font-medium">Department</th>
                    <th class="px-4 py-3 font-medium text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($employees as $employee)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 font-mono text-xs">#{{ $employee->id }}</td>
                        <td class="px-4 py-4 font-semibold text-gray-800">{{ $employee->name }}</td>
                        <td class="px-4 py-4">
                            <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-[11px] font-bold uppercase">
                                {{ $employee->position }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-gray-500">
                            {{ $employee->department->department_name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>

                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');" class="inline">
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
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 italic">
                            No employees found in the system.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection