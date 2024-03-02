<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscoverCategory extends Model
{
    use HasFactory;
    protected $table =  'discover_category';

    protected $fillable = [
        'title_ar',
        'description_ar',
        'title_en',
        'description_en',
        'rank',
        'active',
        'deleted',
    ];


    protected $appends = [
        'tittle',
        'description'
    ];

    public function getTittleAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->title_en;
                    break;
                case "ar":
                    return (!is_null($this->title_ar) && $this->title_ar) ? $this->title_ar :  $this->title_en;
                    break;
                default:
                    return $this->title_en;
            }
        }
        return $this->title_en;
    }


    public function getDescriptionAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->description_en;
                    break;
                case "ar":
                    return (!is_null($this->description_ar) && $this->description_ar) ? $this->name_ar :  $this->description_en;
                    break;
                default:
                    return $this->description_en;
            }
        }
        return $this->description_en;
    }


    public function scopeSearch($query, $value)
    {
        $query->where('title_ar', 'like', '%' . $value . '%')
        ->orWhere('title_en', 'like', '%' . $value . '%')
        ->orWhere('created_at', 'like', '%' . $value . '%');
    }
}
