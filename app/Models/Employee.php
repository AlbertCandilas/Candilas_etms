<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Nililista rito ang mga columns na pwede nating sulatan/i-save
    protected $fillable = [
        'employee_no',
        'name',
        'department',
        'position',
        'salary'
    ];
}