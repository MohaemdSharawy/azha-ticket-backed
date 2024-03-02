<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violations extends Model
{
    use HasFactory;

    protected $table = 'violations';

    protected $fillable = [
        'action_id',
        'unite_id',
        'cost',
        'status_id',
        'deleted'
    ];

    public function V_Action()
    {
        return $this->belongsTo(Violations_actions::class,  'action_id');
    }

    public function Status()
    {
        return $this->belongsTo(MetaData::class, 'status_id');
    }

    public function Unite()
    {
        return $this->belongsTo(Units::class, 'unite_id');
    }

    public function scopeSearch($query, $value)
    {
        $query->whereHas('V_Action', function ($q) use ($value) {
            $q->where('name', 'like', '%' . $value . '%');
        })->orWhereHas('Unite', function ($qu) use ($value) {
            $qu->where('unite_name', 'like', '%' . $value . '%');
        })->orWhereHas('Unite.Owner', function ($que) use ($value) {
            $que->where('first_name', 'like', '%' . $value . '%')->orWhere('last_name', 'like', '%' . $value . '%');
        })->orWhere('cost', 'like', '%' . $value . '%');
    }
}
