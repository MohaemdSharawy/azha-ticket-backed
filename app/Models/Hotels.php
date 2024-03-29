<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [
        'hotel_name', 'code', 'template',  'create_temp', 'thanks_temp', 'logo',  'image', 'phone', 'deleted'
    ];

    public $timestamps = false;
}
