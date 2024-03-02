<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $fillable = [
        'uid',
        'hid',
        'dep_id',
        'name',
        'disable',
        'deleted'
    ];


    public function hotels()
    {
        return $this->belongsTo(Hotels::class, 'hid');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }
}
