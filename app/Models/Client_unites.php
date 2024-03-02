<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_unites extends Model
{
    use HasFactory;

    protected $table =  'client_unites';

    protected $fillable  = [
        'unit_id',
        'client_id'
    ];

}
