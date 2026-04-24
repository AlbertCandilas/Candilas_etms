<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    protected $fillable = ['name', 'role'];

    public function verifiedAttendances()
    {
        return $this->hasMany(AttendanceRecord::class, 'verified_by');
    }
}
