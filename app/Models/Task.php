<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'uid',
        'worker_id',
        'dep_id',
        'hid',
        'name',
        'description',
        'ticket_id',
        'type_id',
        'status_id',
        'assigned_at',
        'end_at',
        'end_by',
        'deleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id');
    }

    public function status()
    {
        return $this->belongsTo(status::class, 'status_id');
    }

    public function Hotels()
    {
        return $this->belongsTo(Hotels::class, 'hid');
    }
}
