<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'ticket';
    protected $fillable = [
        'uid',
        'hid',
        'facility_id',
        'to_dep',
        'room_id',
        'service_id',
        'type_id',
        'description',
        'reopen',
        'master_id',
        'status_id',
        'priority_level',
        'end_at',
        'confirmed_type',
        'confirmed_at',
        'confirmed_by',
        'deleted'
    ];


    public function hotels()
    {
        return $this->belongsTo(Hotels::class, 'hid');
    }

    public function to_department()
    {
        return $this->belongsTo(Department::class, 'to_dep');
    }

    public function level()
    {
        return $this->belongsTo(Periority::class, 'priority_level');
    }

    public function status()
    {
        return $this->belongsTo(status::class, 'status_id');
    }

    public function room()
    {
        return $this->belongsTo(RoomData::class, 'room_id');
    }

    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function facility()
    {
        return $this->belongsTo(Facilities::class, 'facility_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}
