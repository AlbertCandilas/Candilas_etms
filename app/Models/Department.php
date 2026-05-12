<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = ['department_name'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }
}
