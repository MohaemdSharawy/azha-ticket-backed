<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    protected $fillable = [
        'name',
        'hid',
        'type_id',
        'disable',
        'deleted',
    ];
    public $timestamps = false;




    public function hotels()
    {
        return $this->belongsTo(Hotels::class, 'hid');
    }

    public function type()
    {
        return $this->belongsTo(MetaData::class, 'type_id');
    }
}
