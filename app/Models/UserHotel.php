<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserHotel extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'user_hotels';
    protected $fillable = [
        'uid', 'hid'
    ];
    public $timestamps = false;
    public static function get_user_hotels($uid)
    {
        $data = DB::table('user_hotels')->select('user_hotels.*', 'hotels.hotel_name')
            ->join('hotels', 'hotels.id', '=', 'user_hotels.hid')
            ->where('user_hotels.uid', $uid)->get();
        $array = json_decode(json_encode($data), true);
        return $array;
    }
    public static function del_hotel($uid, $hid)
    {
        // $data  = DB::table('user_hotels')->where('uid', $uid)->where('hid', $hid)->get();
        // dd($data);
        DB::table('user_hotels')->where('uid', $uid)->where('hid', $hid)->delete();
    }

    public function User()
    {
        return $this->belongsTo(User::class)->distinct();
    }
}
