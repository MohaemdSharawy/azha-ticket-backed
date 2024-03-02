<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merge extends Model
{
    use HasFactory;
    protected $table = 'tblstaff';
    protected $fillable = [
        'staffid',
        'email',
        'firstname',
        'lastname',
        'is_not_staff'
    ];
}
