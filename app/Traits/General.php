<?php

namespace App\Traits;

use App\Models\Clients_property;
use App\Models\log;
use App\Models\Modules;
use App\Models\Units;
use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserHotel;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;


trait General
{

    public function img_upload($image)
    {
        $file_extension =  $image->getClientOriginalExtension();
        $file_name = time() .  '.' . $file_extension;
        $path  = 'uploads/logo';
        $image->move($path,  $file_name);
        return $file_name;
    }

    public function loger($action, $module_id, $form_id,  $new_data, $ip, $old_data = '')
    {
        log::create([
            'uid' =>  Auth::id(),
            'module_id' => $module_id,
            'form_id' => $form_id,
            'action' => $action,
            'new_data' => $new_data,
            'module_id' =>  $module_id,
            'old_data' => $old_data,
            'ip' => $ip
        ]);
    }


    function uploadImage($folder, $image)
    {
        $image->store('/', $folder);
        $filename = $image->hashName();
        return  $filename;
    }

    function resize($image)
    {
        // $filename    =  $image->getClientOriginalName();

        // $image_resize = Image::make($image->getRealPath());
        // $image_resize->resize(250, 250);
        // $image_resize->save(public_path('gallary/' . $filename));

        // return $filename;
    }

    public function get_model_by_name($name)
    {
        return  Modules::where('name', $name)->first();
    }


    public function getUserHotels()
    {
        $user_id = Auth::id();
        $u_hotels = UserHotel::where(['uid' => $user_id])->get();
        $hotels = [];
        foreach ($u_hotels as $hotel) {
            array_push($hotels, $hotel->hid);
        }
        return $hotels;
    }

    public function getUsersByHotels()
    {
        $user_hotels =  UserHotel::whereIn('hid', $this->getUserHotels())->get();
        $u_ids = [];
        foreach ($user_hotels as $user_hotel) {

            if (!in_array($user_hotel->uid, $u_ids)) {
                array_push($u_ids, $user_hotel->uid);
            }
        }

        return User::whereIn('id', $u_ids)->get();
    }

    public function onlineUserHotels()
    {
        $user_hotels =  UserHotel::whereIn('hid', $this->getUserHotels())->get();
        $u_ids = [];
        foreach ($user_hotels as $user_hotel) {

            if (!in_array($user_hotel->uid, $u_ids)) {
                array_push($u_ids, $user_hotel->uid);
            }
        }

        return User::where('login', 1)->whereIn('id', $u_ids)->get();
    }



    private function usersInHotelDepartment($hid, $dep_id)
    {
        $users_hotel =  UserHotel::where('hid', $hid)->get();
        $users_department = UserDepartment::where('dep_id', $dep_id)->get();
        $u_ids_hotel = [];
        $u_ids_department = [];
        foreach ($users_hotel as $user_hotel) {
            array_push($u_ids_hotel, $user_hotel->uid);
        }
        foreach ($users_department as $user_department) {
            array_push($u_ids_department, $user_department->user_id);
        }
        $u_ids = array_intersect($u_ids_hotel, $u_ids_department);
        return $u_ids;
    }

    public function UserNotifyHotelDepartment($hid,  $dep_id)
    {
        return User::whereIn('id', $this->usersInHotelDepartment($hid, $dep_id))->where([
            'notify' => 1,
            'can_login' => 1
        ])->get();
    }

    public function workerInHotelDepartment($hid,  $dep_id)
    {
        return User::where(['is_worker' => 1])->whereIn('id', $this->usersInHotelDepartment($hid, $dep_id))->get();
    }


    public function get_client_property($client_id): array
    {
        return Clients_property::where(['client_id' => $client_id])->pluck('hotel_id')->toArray();
    }

    public function get_units_in_user_properties(array $h_ids = []) :array{
        (!empty($h_ids)) ? $hotel_ids =$h_ids  : $hotel_ids =$this->getUserHotels();
        return Units::whereIn('hotel_id' ,$hotel_ids)->pluck('id')->toArray();
    }

}
