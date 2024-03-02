<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violations_actions extends Model
{
    use HasFactory;

    protected $table = 'violations_actions';

    protected $fillable = [
        'name',
        'cost',
        'deleted'
    ];

}
