<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 
        'total_hours', 
        'overtime_hours', 
        'deductions', 
        'net_salary', 
        'payroll_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
