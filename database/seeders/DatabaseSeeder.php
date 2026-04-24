<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SEED DEPARTMENTS
        $departments = ['Human Resources', 'Information Technology', 'Finance', 'Marketing', 'Operations'];
        foreach ($departments as $dept) {
            DB::table('departments')->insert([
                'department_name' => $dept,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. SEED POSITIONS
        $positions = ['Manager', 'Developer', 'Analyst', 'Coordinator', 'Specialist'];
        foreach ($positions as $pos) {
            DB::table('positions')->insert([
                'position_name' => $pos,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. SEED ADMINISTRATORS
        $admins = ['Alice Smith', 'Bob Jones', 'Charlie Brown', 'Diana Prince', 'Edward Norton'];
        foreach ($admins as $admin) {
            DB::table('administrators')->insert([
                'name' => $admin,
                'role' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. SEED ATTENDANCE STATUSES
        $statuses = ['Present', 'Absent', 'Late', 'Excused', 'Half-day'];
        foreach ($statuses as $status) {
            DB::table('attendance_statuses')->insert([
                'status_name' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. SEED LEAVE TYPES
        $leaves = ['Sick Leave', 'Vacation Leave', 'Emergency Leave', 'Maternity', 'Paternity'];
        foreach ($leaves as $leave) {
            DB::table('leave_types')->insert([
                'leave_name' => $leave,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. SEED EMPLOYEES
        // Linking to IDs 1-5 created above
        for ($i = 1; $i <= 5; $i++) {
            DB::table('employees')->insert([
                'name' => "Employee " . $i,
                'position' => $positions[$i-1],
                'department_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. SEED ATTENDANCE RECORDS
        for ($i = 1; $i <= 5; $i++) {
            DB::table('attendance_records')->insert([
                'employee_id' => $i,
                'date' => Carbon::today()->toDateString(),
                'time_in' => '08:00:00',
                'time_out' => '17:00:00',
                'status' => 'Present',
                'verified_by' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 8. SEED LEAVE REQUESTS
        for ($i = 1; $i <= 5; $i++) {
            DB::table('leave_requests')->insert([
                'employee_id' => $i,
                'leave_type' => $leaves[$i-1],
                'start_date' => Carbon::now()->addDays(5)->toDateString(),
                'end_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 9. SEED PAYROLLS
        for ($i = 1; $i <= 5; $i++) {
            $hours = 160;
            $ot = 10;
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