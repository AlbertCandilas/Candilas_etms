@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">Employees List</h1>

    <a href="{{ route('admin.employees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Add Employee
    </a>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">No</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($employees as $employee)
            <tr class="border-t">
                <td class="p-2">{{ $employee->employee_no }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->position }}</td>
                <td>₱{{ $employee->basic_salary }}</td>

                <td class="space-x-2">
                    <a href="{{ route('admin.employees.edit', $employee->id) }}"
                       class="text-blue-600">Edit</a>

                    <form action="{{ route('admin.employees.destroy', $employee->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection