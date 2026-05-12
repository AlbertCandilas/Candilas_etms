<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'time_in',
        'time_out',
        'status_id',
        'verified_by'
    ];

    /**
     * Relationship with Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /**
     * Relationship with AttendanceStatus
     * Fixes: Call to undefined relationship [status]
     */
    public function status()
    {
        // Links status_id on this table to id on the attendance_statuses table
        return $this->belongsTo(AttendanceStatus::class, 'status_id', 'id');
    }

    /**
     * Relationship with Administrator
     * Fixes: Call to undefined relationship [admin]
     */
    public function admin()
    {
        // Links verified_by on this table to id on the administrators table
        return $this->belongsTo(Administrator::class, 'verified_by', 'id');
    }
}