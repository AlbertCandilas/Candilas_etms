<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ==========================================
        // 1. SQL VIEWS (For Read-Only Reporting)
        // ==========================================

        // View for Employee Full Details
        DB::statement("
            CREATE OR REPLACE VIEW view_employee_details AS
            SELECT 
                e.id AS employee_id,
                CONCAT(e.first_name, ' ', COALESCE(e.middle_name, ''), ' ', e.last_name) AS full_name,
                e.email,
                d.department_name,
                p.position_name,
                e.created_at AS date_hired
            FROM employees e
            LEFT JOIN departments d ON e.department_id = d.id
            LEFT JOIN positions p ON e.position_id = p.id
        ");

        // View for Attendance Records (Combines Employee, Position, and Status)
        DB::statement("
            CREATE OR REPLACE VIEW view_attendance_details AS
            SELECT 
                ar.id,
                ar.date,
                ar.time_in,
                ar.time_out,
                e.first_name,
                e.last_name,
                p.position_name,
                ast.status_name,
                COALESCE(admin_emp.first_name, 'System') as verified_by_name
            FROM attendance_records ar
            JOIN employees e ON ar.employee_id = e.id
            LEFT JOIN positions p ON e.position_id = p.id
            LEFT JOIN attendance_statuses ast ON ar.status_id = ast.id
            LEFT JOIN administrators adm ON ar.verified_by = adm.id
            LEFT JOIN employees admin_emp ON adm.employee_id = admin_emp.id
        ");

        // View for Leave Requests (Includes automatic day calculation)
        DB::statement("
            CREATE OR REPLACE VIEW view_leave_details AS
            SELECT 
                lr.id,
                lr.start_date,
                lr.end_date,
                lr.status,
                e.first_name,
                e.last_name,
                p.position_name,
                lt.leave_name as leave_type_name,
                DATEDIFF(lr.end_date, lr.start_date) + 1 as total_days
            FROM leave_requests lr
            JOIN employees e ON lr.employee_id = e.id
            LEFT JOIN positions p ON e.position_id = p.id
            LEFT JOIN leave_types lt ON lr.leave_type_id = lt.id
        ");

        // View for Payroll Reports
        DB::statement("
            CREATE OR REPLACE VIEW view_payroll_reports AS
            SELECT 
                pr.id AS payroll_id,
                CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                pr.total_hours,
                pr.overtime_hours,
                pr.deductions,
                pr.net_salary,
                pr.payroll_date
            FROM payrolls pr
            JOIN employees e ON pr.employee_id = e.id
        ");

        // ==========================================
        // 2. SQL TRIGGERS (For Automated Logic)
        // ==========================================

        // TRIGGER: Calculate Net Salary on INSERT
        DB::statement("
            CREATE TRIGGER tr_calculate_net_salary_insert
            BEFORE INSERT ON payrolls
            FOR EACH ROW
            BEGIN
                SET NEW.net_salary = (NEW.total_hours * 50) + (NEW.overtime_hours * 75) - NEW.deductions;
            END
        ");

        // TRIGGER: Calculate Net Salary on UPDATE
        DB::statement("
            CREATE TRIGGER tr_calculate_net_salary_update
            BEFORE UPDATE ON payrolls
            FOR EACH ROW
            BEGIN
                SET NEW.net_salary = (NEW.total_hours * 50) + (NEW.overtime_hours * 75) - NEW.deductions;
            END
        ");

        // TRIGGER: Auto-mark as 'Late' if time_in is after 09:00:00
        DB::statement("
            CREATE TRIGGER tr_check_attendance_lateness
            BEFORE INSERT ON attendance_records
            FOR EACH ROW
            BEGIN
                IF NEW.time_in > '09:00:00' AND NEW.status_id IS NULL THEN
                    SET NEW.status_id = 3; 
                END IF;
            END
        ");

        // TRIGGER: Prevent Overlapping Leave Requests
        DB::statement("
            CREATE TRIGGER tr_prevent_overlapping_leaves
            BEFORE INSERT ON leave_requests
            FOR EACH ROW
            BEGIN
                IF EXISTS (
                    SELECT 1 FROM leave_requests 
                    WHERE employee_id = NEW.employee_id 
                    AND status = 'Approved'
                    AND (
                        (NEW.start_date BETWEEN start_date AND end_date) OR 
                        (NEW.end_date BETWEEN start_date AND end_date) OR
                        (start_date BETWEEN NEW.start_date AND NEW.end_date)
                    )
                ) THEN
                    SIGNAL SQLSTATE '45000' 
                    SET MESSAGE_TEXT = 'Error: Employee already has an approved leave during this period.';
                END IF;
            END
        ");

        // TRIGGER: Auto-Clock Out (Safety logic for attendance updates)
        DB::statement("
            CREATE TRIGGER tr_auto_clock_out
            BEFORE UPDATE ON attendance_records
            FOR EACH ROW
            BEGIN
                IF NEW.time_out IS NULL AND NEW.status_id = 1 THEN
                    SET NEW.time_out = '18:00:00';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all Views
        DB::statement("DROP VIEW IF EXISTS view_employee_details");
        DB::statement("DROP VIEW IF EXISTS view_attendance_details");
        DB::statement("DROP VIEW IF EXISTS view_leave_details");
        DB::statement("DROP VIEW IF EXISTS view_payroll_reports");

        // Drop all Triggers
        DB::statement("DROP TRIGGER IF EXISTS tr_calculate_net_salary_insert");
        DB::statement("DROP TRIGGER IF EXISTS tr_calculate_net_salary_update");
        DB::statement("DROP TRIGGER IF EXISTS tr_check_attendance_lateness");
        DB::statement("DROP TRIGGER IF EXISTS tr_prevent_overlapping_leaves");
        DB::statement("DROP TRIGGER IF EXISTS tr_auto_clock_out");
    }
};