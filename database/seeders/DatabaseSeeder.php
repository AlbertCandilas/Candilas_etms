<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear existing data to avoid "Duplicate Entry" errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('departments')->truncate();
        DB::table('positions')->truncate();
        DB::table('employees')->truncate();
        DB::table('administrators')->truncate();
        DB::table('attendance_statuses')->truncate();
        DB::table('leave_types')->truncate();
        DB::table('attendance_records')->truncate();
        DB::table('leave_requests')->truncate();
        DB::table('payrolls')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create the Admin User for Login
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@companyx.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Departments
        $departments = ['Human Resources', 'Information Technology', 'Finance', 'Marketing', 'Operations'];
        foreach ($departments as $dept) {
            DB::table('departments')->insert([
                'department_name' => $dept,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Seed Positions
        $positions = ['Manager', 'Developer', 'Analyst', 'Coordinator', 'Specialist'];
        foreach ($positions as $pos) {
            DB::table('positions')->insert([
                'position_name' => $pos,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Seed Employees
        $employees = [
            ['first_name' => 'Alice', 'last_name' => 'Smith', 'email' => 'alice@example.com'],
            ['first_name' => 'Bob', 'last_name' => 'Jones', 'email' => 'bob@example.com'],
            ['first_name' => 'Charlie', 'last_name' => 'Brown', 'email' => 'charlie@example.com'],
            ['first_name' => 'Diana', 'last_name' => 'Prince', 'email' => 'diana@example.com'],
            ['first_name' => 'Edward', 'last_name' => 'Norton', 'email' => 'edward@example.com'],
        ];

        foreach ($employees as $index => $emp) {
            DB::table('employees')->insert([
                'first_name' => $emp['first_name'],
                'middle_name' => 'Sample',
                'last_name' => $emp['last_name'],
                'email' => $emp['email'],
                'password' => Hash::make('password123'),
                'position_id' => $index + 1,
                'department_id' => $index + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. Seed Administrators
        for ($i = 1; $i <= 5; $i++) {
            DB::table('administrators')->insert([
                'employee_id' => $i,
                'role' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. Seed Attendance Statuses
        $statuses = ['Present', 'Absent', 'Late', 'Excused', 'Half-day'];
        foreach ($statuses as $status) {
            DB::table('attendance_statuses')->insert([
                'status_name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 8. Seed Leave Types
        $leaves = ['Sick Leave', 'Vacation Leave', 'Emergency Leave', 'Maternity', 'Paternity'];
        foreach ($leaves as $leave) {
            DB::table('leave_types')->insert([
                'leave_name' => $leave,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 9. Seed Attendance Records
        for ($i = 1; $i <= 5; $i++) {
            DB::table('attendance_records')->insert([
                'employee_id' => $i,
                'date' => Carbon::today()->toDateString(),
                'time_in' => '08:00:00',
                'time_out' => '17:00:00',
                'status_id' => 1,
                'verified_by' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 10. Seed Leave Requests
        for ($i = 1; $i <= 5; $i++) {
            DB::table('leave_requests')->insert([
                'employee_id' => $i,
                'leave_type_id' => $i,
                'start_date' => Carbon::now()->addDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 11. Seed Payrolls
        for ($i = 1; $i <= 5; $i++) {
            $hours = 160.00;
            $ot = 10.00;
            $deductions = 500.00;
            DB::table('payrolls')->insert([
                'employee_id' => $i,
                'total_hours' => $hours,
                'overtime_hours' => $ot,
                'deductions' => $deductions,
                'net_salary' => ($hours * 50) - $deductions,
                'payroll_date' => Carbon::now()->startOfMonth()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}