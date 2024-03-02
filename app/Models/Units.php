<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;

    protected $table = 'unites';

    protected $fillable = [
        'unite_name',
        'hotel_id',
        'owner_id',
        'deleted',
    ];

    public function Owner()
    {
        return  $this->belongsTo(Clients::class, 'owner_id');
    }

    public function Hotel()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }
}
