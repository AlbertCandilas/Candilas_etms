@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">Edit Employee</h1>

    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="employee_no" value="{{ $employee->employee_no }}" class="border p-2 w-full mb-2">

        <input type="text" name="name" value="{{ $employee->name }}" class="border p-2 w-full mb-2">

        <input type="text" name="department" value="{{ $employee->department }}" class="border p-2 w-full mb-2">

        <input type="text" name="position" value="{{ $employee->position }}" class="border p-2 w-full mb-2">

        <input type="number" name="basic_salary" value="{{ $employee->basic_salary }}" class="border p-2 w-full mb-2">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>

</div>
@endsection