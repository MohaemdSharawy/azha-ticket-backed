<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\log;
use App\Models\Modules;
use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserHotel;
use App\Models\UserPermission;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use General;

    private $module_id  =  1;

    public function index()
    {
        $users_data =         $this->getUsersByHotels();
        $permission = UserPermission::where(['module_id' => $this->module_id, 'u_id' => Auth::id()])->first();
        return view('backend.admin.users.index', compact('users_data', 'permission'));
    }

    public function create()
    {
        $hotels  = Hotels::all();
        $departments =  Department::all();
        return view('backend.admin.users.create', compact('hotels', 'departments'));
    }



    public function store(Request $request)
    {


        $email = User::where('email', $request->email)->first();
        if ($email) {
            return redirect()->back()->with(['failed_notify' => 'Email Already Existed']);
        }

        $add = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'disable' => 0,
            'is_admin' => 0,
            'is_worker' => ($request->worker == null) ? 0 : 1,
            'can_login' => ($request->can_login == null) ? 0 : 1,
            'notify' => ($request->notify == null) ? 0 : 1
        ]);

        if ($add) {
            if ($request->departments) {
                foreach ($request->departments as $dep) {
                    UserDepartment::create([
                        'user_id' => $add->id,
                        'dep_id' => $dep
                    ]);
                }
            }
            foreach ($request->hotels as $hotel) {
                UserHotel::create([
                    'uid' => $add->id,
                    'hid' => $hotel
                ]);
            }
            $this->loger('Create',  $this->module_id,  $add->id, json_encode($add), $request->ip());
            return redirect()->back()->with(['success_notify' =>  'user Created Successfully!!']);
        }
    }

    public function edit($id)
    {
        $user  =  User::find($id);
        $hotels  = Hotels::where(['deleted' => 0])->get();
        $departments =  Department::where(['deleted' => 0])->get();
        $users_hotels = UserHotel::where(['uid' => $id])->get();
        $user_departments =  UserDepartment::where(['user_id' => $id])->get();
        $modules = Modules::all_modules();
        $user_log = log::get_user_log($id);
        foreach ($modules as $key => $module) {
            $modules[$key]['permission'] =  UserPermission::get_acces_model($id, $module['id']);
        }

        $user_log =  log::get_user_log($id);
        return view('backend.admin.users.edit', compact('user', 'hotels', 'departments', 'users_hotels', 'modules', 'user_log', 'user_departments'));
    }

    public function change_status(Request $request)
    {
        $old_data =  User::find($request->user_id);
        $user = User::find($request->user_id);
        $user->disable =  $request->status;
        $user->save();
        ($request->status == 0) ? $message = 'User Enable Successfully!! ' :  $message = 'User Disable Successfully!! ';
        ($request->status == 0) ? $action = 'User Enable  ' :  $action = 'User Disable ';
        if ($user) {
            $this->loger($action,  $this->module_id,  $request->user_id, json_encode($user), $request->ip(), json_encode($old_data));
            return response()->json([
                'status' => 200,
                'message' => $message,
                'user_status'  =>  $request->status,
                'user_id' =>  $request->user_id
            ]);
        }
    }


    public function update(Request $request,  $id)
    {
        $old_data  = User::find($id);
        $update  =  User::find($id);
        $update->name  = $request->name;
        $update->email =  $request->email;
        $update->is_worker = ($request->worker == null) ? 0 : 1;
        $update->can_login = ($request->can_login == null) ? 0 : 1;
        $update->notify = ($request->notify == null) ? 0 : 1;
        // $update->department = $request->dep;
        if ($request->password) {
            $update->password = Hash::make($request->password);
        }
        $update->save();

        $user_hotels = UserHotel::get_user_hotels($id);
        $new_hotels = $request->hotels;
        $user_hotels_ids = array();


        foreach ($user_hotels as $user_hotel) {
            $user_hotels_ids[] = $user_hotel['hid'];
        }


        if (count($new_hotels) > count($user_hotels_ids)) {
            $extra_hotels = array_diff($new_hotels, $user_hotels_ids);
            foreach ($extra_hotels as $extra) {
                $add_hotel = new   UserHotel();
                $add_hotel->uid = $id;
                $add_hotel->hid = $extra;
                $add_hotel->save();
            }
        } elseif (count($new_hotels) < count($user_hotels_ids)) {
            $del_hotels = array_diff($user_hotels_ids, $new_hotels);
            foreach ($del_hotels as $hotels) {
                UserHotel::del_hotel($id, $hotels);
            }
        } elseif (count($new_hotels) == count($user_hotels_ids)) {
            $del_h = array_diff($user_hotels_ids, $new_hotels);
            foreach ($del_h as $hotels) {
                UserHotel::del_hotel($id, $hotels);
            }
            $extra_property = array_diff($new_hotels, $user_hotels_ids);
            // dd($del_h);

            foreach ($extra_property as $extra) {
                $add_hotel = new   UserHotel();
                $add_hotel->uid = $id;
                $add_hotel->hid = $extra;
                $add_hotel->save();
            }
        }
        $updated_hotel = UserHotel::get_user_hotels($id);

        $this->updateDepartment($request->dep, $id);


        if ($update) {
            $this->loger('update user Hotel',  $this->module_id,  $id, json_encode($updated_hotel), $request->ip(), json_encode($user_hotels));
            $this->loger('update',  $this->module_id,  $request->user_id, json_encode($update), $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' =>  'user Updated Successfully']);
        }
    }

    public function update_permission(Request $request, $u_id)
    {
        $data = $request->accs;
        foreach ($data as $accs) {
            unset($accs['id']);
            if (UserPermission::check_permission($u_id, $accs['module_id'])) {
                $old_data  = UserPermission::where(['module_id' => $accs['module_id'],  'u_id' => $u_id])->first();
                $update =  UserPermission::updated_permission($accs['module_id'], $u_id, $accs);
                $accs['ui_d'] = $u_id;
                $this->loger('update Permission',  $this->module_id,  $request->user_id, json_encode($accs), $request->ip(), json_encode($old_data));
            } else {
                $accs['u_id'] =  $u_id;
                $insert = UserPermission::create($accs);
                $this->loger('Add Permission',  $this->module_id,  $request->user_id, json_encode($accs), $request->ip());
            }
        }


        return redirect()->back()->with(['success' => "Permission Changed Successfully!!"]);
    }


    public function changePassword(Request $request)
    {
        $user_id  = Auth::id();
        $old_data = Auth::user();
        $user  = User::find($user_id);
        if ($request->password ==  $request->password_confirm) {
            $user->password =  Hash::make($request->password);
            $user->save();
            $this->loger('Change Password',  $this->module_id,  $user_id, json_encode($user), $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' =>  'Password Change Successfully!!!']);
        } else {
            return redirect()->back()->with(['failed_notify' => 'Password Not Match']);
        }
    }

    private function updateDepartment($departments, $id)
    {
        $user_departments =  UserDepartment::where('user_id', $id)->get();
        $new_departments = $departments;
        $user_departments_ids =  array();

        foreach ($user_departments as $user_dep) {
            $user_departments_ids[] = $user_dep['dep_id'];
        }
        if (count($new_departments) > count($user_departments_ids)) {
            $extra_department = array_diff($new_departments, $user_departments_ids);
            foreach ($extra_department as $extra) {
                $add_dep = new   UserDepartment();
                $add_dep->user_id = $id;
                $add_dep->dep_id = $extra;
                $add_dep->save();
            }
        } elseif (count($new_departments) < count($user_departments_ids)) {
            $del_dep = array_diff($user_departments_ids, $new_departments);
            foreach ($del_dep as $dep) {
                UserDepartment::where(['user_id' => $id, 'dep_id' => $dep])->delete();
            }
        } elseif (count($new_departments) == count($user_departments_ids)) {
            $del_dep = array_diff($user_departments_ids, $new_departments);
            foreach ($del_dep as $dep) {
                // UserHotel::del_hotel($id, $hotels);
                UserDepartment::where(['user_id' => $id, 'dep_id' => $dep])->delete();
            }
            $extra_dep = array_diff($new_departments, $user_departments_ids);

            foreach ($extra_dep as $extra) {
                $add_dep = new   UserDepartment();
                $add_dep->user_id = $id;
                $add_dep->dep_id = $extra;
                $add_dep->save();
            }
        }
    }




    public function change_notification()
    {
        $user = Auth::user();
        ($user->notify == 1) ? $user->notify = 0 : $user->notify = 1;
        $user->save();
        return redirect()->back()->with(['success_notify' =>  'Notification Status Change Successfully!!!']);
    }
}
