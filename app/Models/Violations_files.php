<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violations_files extends Model
{
    use HasFactory;

    protected $table =  'violations_files';

    protected $fillable = [
        'violation_id',
        'file',
        'deleted'
    ];


}
