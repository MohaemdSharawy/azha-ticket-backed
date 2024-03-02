<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clients extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table  =  'clients';

    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'email',
        'phone',
        'birth_day',
        'password',
        'gender',
        'master_id',
        'unit',
        'role',
        'active',
    ];

    protected $appends =  [
        'family_member'
    ];


    public function getFamilyMemberAttribute()
    {
        if ($this->master_id) {
            return Clients::where('master_id', $this->master_id);
        }
    }
}
