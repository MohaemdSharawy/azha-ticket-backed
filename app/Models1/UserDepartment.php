<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    use HasFactory;

    protected $table  = 'user_department';
    protected $fillable = [
        'user_id',
        'dep_id'
    ];

    public $timestamps = false;
}
