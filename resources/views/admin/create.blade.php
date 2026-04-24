@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-4">Add Employee</h1>

    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        <input type="text" name="employee_no" placeholder="Employee No" class="border p-2 w-full mb-2">

        <input type="text" name="name" placeholder="Name" class="border p-2 w-full mb-2">

        <input type="text" name="department" placeholder="Department" class="border p-2 w-full mb-2">

        <input type="text" name="position" placeholder="Position" class="border p-2 w-full mb-2">

        <input type="number" name="basic_salary" placeholder="Salary" class="border p-2 w-full mb-2">

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>

</div>
@endsection