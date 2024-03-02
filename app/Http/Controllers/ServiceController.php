<?php

namespace App\Http\Controllers;

use App\Models\Category_services;
use App\Models\Department;
use App\Models\MetaData;
use App\Models\Service;
use App\Traits\General;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use General;
    private $model;

    public function __construct()
    {
        $this->model = $this->get_model_by_name('Services');
    }

    public function  index()
    {
        $data = Service::with(['Service_category'])->where(['deleted' => 0])->get();
        $types = MetaData::where(['key_word' => 'ticket_type', 'deleted' =>  0])->get();
        $deps  = Department::where(['deleted' => 0])->get();
        $service_categories =  Category_services::where(['deleted' => 0])->get();
        return view('services.index', compact('data', 'types', 'deps', 'service_categories'));
    }

    public function store(Request $request)
    {
        $inputs =  $request->all();
        $inputs['name'] =  $inputs['name_en'];
        // dd($inputs);
        $add = Service::create($inputs);
        // dd($request);
        // $add = Service::create([
        //     'dep_id' => $request->dep_id,
        //     'name' => $request->name,
        //     'guest' => $request->guest,
        //     'name_en' =>$request->name
        //     // 'type_id' => $request->type_id,
        // ]);
        if ($add) {
            $this->loger('Create Services', $this->model->id, $add->id, json_encode($add),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'New Service Add Successfully!!']);
        }
    }

    public function update(Request $request)
    {
        // dd($request);
        $old_data = Service::find($request->service_id);
        $service = Service::find($request->service_id);
        $service->dep_id =  $request->dep_id;
        $service->name = $request->name;
        // $service->type_id =  $request->type_id;
        $service->guest =  ($request->guest == 1) ? 1  : 0;
        $service->save();
        if ($service) {
            $this->loger('Update Service', $this->model->id, $service->id, json_encode($service),  $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' => 'Service Update Successfully!!']);
        }
        return redirect()->back()->with(['failed_notify' => 'SomeThing Wrong Process Not Complete']);
    }

    public function del($id, Request $request)
    {
        $service = Service::find($id);
        if ($service->disable == 0) {
            $service->disable =  1;
            $service->save();
            $this->loger('Disable service', $this->model->id, $service->id, json_encode($service),  $request->ip());
            return redirect()->back()->with(['failed_notify' => 'service Disable Successfully']);
        } else {
            $service->disable =  0;
            $service->save();
            $this->loger('Enable service', $this->model->id, $service->id, json_encode($service),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'service Enable Successfully']);
        }
    }
}
