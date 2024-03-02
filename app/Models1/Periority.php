<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periority extends Model
{
    use HasFactory;
    protected $table = 'priority';
    protected $fillable = [
        'name',
        'color',
        'icon',
    ];
    public $timestamps = false;
}
