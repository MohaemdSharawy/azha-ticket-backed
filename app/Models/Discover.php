<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discover extends Model
{
    use HasFactory;
    protected $table  = 'discover';
    protected $fillable = [
        'category_id',
        'name_en',
        'name_ar',
        'description_ar',
        'description_en',
        'logo',
        'phone',
        'address',
        'location',
        'active',
        'deleted',
    ];
    protected $appends = [
        'name',
        'description'
    ];

    public function Category(){
        return $this->belongsTo(DiscoverCategory::class ,  'category_id');
     }

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

    public function getDescriptionAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->description_en;
                    break;
                case "ar":
                    return (!is_null($this->description_ar) && $this->description_ar) ? $this->description_ar :  $this->description_en;
                    break;
                default:
                    return $this->description_en;
            }
        }
        return $this->description_en;
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name_ar', 'like', '%' . $value . '%')
        ->orWhere('name_en', 'like', '%' . $value . '%')
        ->orWhere('created_at', 'like', '%' . $value . '%');
    }

}
