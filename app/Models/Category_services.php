<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_services extends Model
{
    use HasFactory;

    protected $table  = 'service_category';

    protected $fillable = [
        'name_en',
        'name_ar',
        'active	',
        'deleted'
    ];

    protected $appends = [
        'name'
    ];


    public function getNameAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->name_en;
                    break;
                case "ar":
                    return (!is_null($this->name_ar) && $this->name_ar) ? $this->name_ar :  $this->name_en;
                    break;
                default:
                    return $this->name_en;
            }
        }
        return $this->name_en;
    }

    public function Services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
