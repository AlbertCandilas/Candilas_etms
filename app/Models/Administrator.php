<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'role'];

    /**
     * Relationship with Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Relationship with AttendanceRecords (as a verifier)
     */
    public function verifiedRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'verified_by');
    }
}