<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'service';
    protected $appends = [
        'Service_name'
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'name_ru',
        'name_de',
        'name_du',
        'name_fr',
        'name_it',
        'name_cz',
        'name_pl',
        'name_ro',
        'name_ua',
        'type_id',
    ];
    protected $fillable = [
        'dep_id',
        'category_id',
        'cost',
        'name',
        'name_en',
        'name_ar',
        'name_ru',
        'name_de',
        'name_du',
        'name_fr',
        'name_it',
        'name_cz',
        'name_pl',
        'name_ro',
        'name_ua',
        'type_id',
        'disable',
        'guest',
        'deleted'
    ];
    public $timestamps = false;


    public function type()
    {
        return $this->belongsTo(MetaData::class, 'type_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,  'dep_id');
    }

    public function getServiceNameAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->getServiceLang('en');
                    break;
                case "ar":
                    return $this->getServiceLang('ar');
                    break;
                case "cz":
                    return $this->getServiceLang('cz');
                    break;
                case "de":
                    return $this->getServiceLang('de');
                    break;
                case "du":
                    return $this->getServiceLang('du');
                    break;
                case "fr":
                    return $this->getServiceLang('fr');
                    break;
                case "it":
                    return $this->getServiceLang('it');
                    break;
                case "pl":
                    return $this->getServiceLang('pl');
                    break;
                case "ro":
                    return $this->getServiceLang('ro');
                    break;
                case "ru":
                    return $this->getServiceLang('ru');
                    break;
                case "ua":
                    return $this->getServiceLang('ua');
                    break;
                default:
                    return $this->getServiceLang('en');
            }
        }
    }

    private function getServiceLang($lang)
    {
        $property = 'name_' . $lang;
        if ($this->{$property} != null  && $this->{$property} != '') {
            return $this->{$property};
        } else {
            return $this->name_en;
        }
    }

    public function Service_category()
    {
        return $this->belongsTo(Category_services::class, 'category_id');
    }
}
