<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = 'user_permission';
    protected $fillable = [
        'u_id', 'view',  'p_view', 'create', 'edit', 'remove', 'module_id'
    ];
    public $timestamps = false;
    public static function get_acces_model($u_id, $module_id)
    {
        $data = DB::table('user_permission')->where(['u_id' => $u_id, 'module_id' => $module_id])->first();
        $array = json_decode(json_encode($data), true);
        return $array;
    }
    public static function check_permission($uid, $model_id)
    {
        $data =    DB::table('user_permission')->where('u_id', $uid)->where('module_id', $model_id)->get()->toArray();
        return $data;
    }


    public static function updated_permission($module_id, $uid, $data)
    {
        DB::table('user_permission')->where(['module_id' => $module_id, 'u_id' => $uid])
            ->update($data);
    }
}
