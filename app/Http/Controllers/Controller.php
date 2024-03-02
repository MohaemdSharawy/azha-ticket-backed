<?php

namespace App\Http\Controllers;

use App\Models\UserDepartment;
use App\Models\UserHotel;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function getUserHotel()
    {
        $user_id = Auth::id();
        $u_hotels = UserHotel::where(['uid' => $user_id])->get();
        $hotels = [];
        foreach ($u_hotels as $hotel) {
            array_push($hotels, $hotel->hid);
        }
        return $hotels;
    }


    public function getUserDepartment()
    {
        $user_id = Auth::id();
        $user_department = UserDepartment::where('user_id', $user_id)->get();
        $departments = [];
        foreach ($user_department as $department) {
            array_push($departments, $department->dep_id);
        }
        return $departments;
    }


    public function readFromNotification(String $type, int $form_id)
    {
        $notifications = DB::table('notifications')->whereJsonContains('data->id', $form_id)
            ->where(['notifiable_id' => Auth::id(),  'type' => $type])->whereNull('read_at')->update(["read_at" => Carbon::now()]);
        // foreach ($notifications as $notification) {
        //     $notification->update(["read_at" => Carbon::now()]);
        // }
    }
}
