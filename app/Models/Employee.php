<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name', 
        'middle_name', 
        'last_name', 
        'email', 
        'password', 
        'position_id', 
        'department_id'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id', 'employee_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'employee_id', 'employee_id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'employee_id', 'employee_id');
    }
}