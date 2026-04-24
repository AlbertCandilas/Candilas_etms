<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['position_name'];

    // Note: If you link Position to Employee via FK later, add hasMany here.
}
