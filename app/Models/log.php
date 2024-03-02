<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class log extends Model
{
    use HasFactory;

    protected $table = 'log';

    protected $fillable = [
        'uid', 'form_id', 'module_id',  'action', 'old_data', 'new_data', 'ip'
    ];
    public $timestamps = false;

    public static function get_user_log($uid)
    {
        return DB::table('log')->select('log.*', 'module.name as model_name', 'users.name as user_name')->where(['uid' => $uid])
            ->leftJoin('module', 'module.id', '=', 'log.module_id')
            ->leftJoin('users', 'users.id', '=', 'log.uid')->get();
    }

    public static function get_all_log()
    {
        return DB::table('log')->select('log.*', 'module.name as model_name', 'users.name as user_name')
            ->leftJoin('module', 'module.id', '=', 'log.module_id')
            ->leftJoin('users', 'users.id', '=', 'log.uid')->get();
    }
}
