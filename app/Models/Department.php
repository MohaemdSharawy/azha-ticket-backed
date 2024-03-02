<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';
    protected $appends = [
        'department_name'
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
    ];

    protected $fillable = [
        'dep_name',
        'dep_code',
        'guest',
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
        'deleted',
        'notify'
    ];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_department', 'dep_id', 'user_id');
    }

    public function workers()
    {
        return $this->belongsToMany(User::class, 'user_department', 'dep_id', 'user_id')->where('is_worker', 1);
    }

    public function getDepartmentNameAttribute()
    {
        if (isset($GLOBALS['lang'])) {
            switch ($GLOBALS['lang']) {
                case "en":
                    return $this->getDepartmentLang('en');
                    break;
                case "ar":
                    return $this->getDepartmentLang('ar');
                    break;
                case "cz":
                    return $this->getDepartmentLang('cz');
                    break;
                case "de":
                    return $this->getDepartmentLang('de');
                    break;
                case "du":
                    return $this->getDepartmentLang('du');
                    break;
                case "fr":
                    return $this->getDepartmentLang('fr');
                    break;
                case "it":
                    return $this->getDepartmentLang('it');
                    break;
                case "pl":
                    return $this->getDepartmentLang('pl');
                    break;
                case "ro":
                    return $this->getDepartmentLang('ro');
                    break;
                case "ru":
                    return $this->getDepartmentLang('ru');
                    break;
                case "ua":
                    return $this->getDepartmentLang('ua');
                    break;
                default:
                    return $this->getDepartmentLang('en');
            }
        }
    }

    private function getDepartmentLang($lang)
    {
        $property = 'name_' . $lang;
        if ($this->{$property} != null  && $this->{$property} != '') {
            return $this->{$property};
        } else {
            return $this->name_en;
        }
    }
}
