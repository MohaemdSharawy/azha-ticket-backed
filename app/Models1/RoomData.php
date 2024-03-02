<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomData extends Model
{
    use HasFactory;
    protected $table = 'room_data';
    protected $fillable = [
        'room_num',
        'conf_num',
        'guest_name'
    ];
    public $timestamps = false;
}
