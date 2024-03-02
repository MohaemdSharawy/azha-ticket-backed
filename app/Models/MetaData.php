<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    use HasFactory;
    protected $table = 'meta_data';
    protected $fillable = [
        'name', 'nick_name', 'key_word',  'rank', 'deleted'
    ];
    public $timestamps = false;
}
