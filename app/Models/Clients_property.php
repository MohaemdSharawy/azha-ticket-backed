<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients_property extends Model
{
    use HasFactory;

    protected $table  = 'clients_property';

    protected $fillable =  [
        'client_id',
        'hotel_id'
    ];

    public $timestamps = false;
}
