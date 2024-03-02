<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\User;
use App\Models\UserHotel;
use App\Models\Worker;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    use General;
    private $model;

    public function __construct()
    {
        $this->model = $this->get_model_by_name('Workers');
    }

    public function index()
    {
        $u_hotels =  $this->getUserHotel();
        $hotels   =  Hotels::whereIn('id', $u_hotels)->get();
        $deps     =  Department::all();
        return view('backend.admin.workers.index', compact('deps', 'hotels'));
    }

    public function index_data(Request $request)
    {
        if ($request->ajax()) {

            $workers = Worker::with(['hotels' => function ($q) {
                $q->select('hotel_name', 'id');
            }, 'status' => function ($q) {
                $q->select('dep_name', 'id');
            }])->whereIn('h_id', $this->getUserHotel())->where(['deleted' => 0]);
            if (isset($request->hotels)) {
                $workers->whereIn('hid', $request->hotels);
            }
            return response()->json([
                'ticket' => $workers->get(),
            ]);
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $add = Worker::create([
            'h_id' => $request->h_id,
            'u_id' => $request->uid,
            'dep_id' => $request->dep_id,
            'name' => $request->name
        ]);
        if ($add) {
            $this->loger('Create Worker', $this->model->id, $add->id, json_encode($add),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'New Worker Add Successfully!!']);
        }
    }

    public function update($id, Request $request)
    {
        $old_data =  Worker::find($id);
        $worker =  Worker::find($id);
        $worker->h_id  = $request->hid;
        $worker->dep_id = $request->dep_id;
        $worker->name = $request->name;
        $worker->save();
        if ($worker) {
            $this->loger('Update Worker', $this->model->id, $worker->id, json_encode($worker),  $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' => 'New Worker Update Successfully!!']);
        }
        return redirect()->back()->with(['failed_notify' => 'SomeThing Wrong Process Not Complete']);
    }


    public function del($id, Request $request)
    {
        $worker = Worker::find($id);
        if ($worker->deleted == 0) {
            $worker->deleted =  1;
            $worker->save();
            $this->loger('Disable Worker', $this->model->id, $worker->id, json_encode($worker),  $request->ip());
            return redirect()->back()->with(['failed_notify' => 'Worker Disable Successfully']);
        } else {
            $worker->deleted =  0;
            $worker->save();
            $this->loger('Enable Worker', $this->model->id, $worker->id, json_encode($worker),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'Worker Enable Successfully']);
        }
    }



    public function get_users_by_hotel(Request $request)
    {
        $users_hotel = UserHotel::Where(['hid' => $request->hid])->get();
        $users_id =  [];
        foreach ($users_hotel as $u_h) {
            array_push($users_id, $u_h->uid);
        }
        $users = User::whereIn('id', $users_id)->get();
        return response()->json([
            'users' => $users,
        ]);
    }
}
