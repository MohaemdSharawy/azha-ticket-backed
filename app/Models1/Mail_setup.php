<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mail_setup extends Model
{
    use HasFactory;
    protected $table = 'mail_setup';
    protected $fillable = [
        'h_id', 'dep_id', 'name', 'type', 'deleted'
    ];
    public $timestamps = false;

    public static function get_mail_setup($hid, $dep_id)
    {
        return DB::table('mail_setup')->select('mail_setup.*', 'hotels.hotel_name', 'department.dep_name')
            ->where(['h_id' => $hid, 'dep_id' => $dep_id])->leftJoin('hotels', 'hotels.id', '=', 'mail_setup.h_id')
            ->leftJoin('department', 'department.id', '=', 'mail_setup.dep_id')->get();
    }
}
