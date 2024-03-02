<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'hotel_id',
        'title',
        'description',
        'image',
        'deleted'
    ];

    public function  User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function Hotels()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('title', 'like',  '%' . $value . '%')
            ->orWhereHas('User', function ($q) use ($value) {
                $q->where('name', 'like', '%' . $value . '%');
            });
    }
}
