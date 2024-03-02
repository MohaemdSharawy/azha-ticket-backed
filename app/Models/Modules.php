<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Modules extends Model
{
    use HasFactory;
    protected $table = 'module';
    protected $fillable = [
        'view', 'p_view',  'edit', 'remove'
    ];
    public $timestamps = false;


    public static function all_modules()
    {
        $data = DB::table('module')->get();
        $array = json_decode(json_encode($data), true);
        return $array;
    }
}
