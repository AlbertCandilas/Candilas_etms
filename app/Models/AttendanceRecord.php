<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = ['employee_id', 'date', 'time_in', 'time_out', 'status', 'verified_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class, 'verified_by');
    }
}
