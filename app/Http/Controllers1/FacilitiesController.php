<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use App\Models\Hotels;
use App\Models\MetaData;
use App\Traits\General;
use Illuminate\Http\Request;

class FacilitiesController extends Controller
{
    private $model;

    use General;
    public function __construct()
    {
        $this->model = $this->get_model_by_name('Facilities');
    }


    public function index()
    {
        $data  =  Facilities::with(['hotels', 'type'])->whereIn('hid', $this->getUserHotel())->get();
        $types  = MetaData::where(['key_word' => 'ticket_type'])->get();
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->get();
        return view('facility.index', compact('data', 'types', 'hotels'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $add =  Facilities::create([
            'name' => $request->name,
            'hid' => $request->hid,
            'type_id' => $request->type_id,
        ]);

        if ($add) {
            $this->loger('Create Facility', $this->model->id, $add->id, json_encode($add),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'New Facility Add Successfully!!']);
        }
    }

    public function update(Request $request)
    {
        $old_data =  Facilities::find($request->facility_id);
        $facility = Facilities::find($request->facility_id);
        $facility->name =  $request->name;
        $facility->hid  = $request->hid;
        $facility->type_id  = $request->type_id;
        $facility->save();
        if ($facility) {
            $this->loger('Create facility', $this->model->id, $facility->id, json_encode($facility),  $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' => 'Facility Update Successfully!!']);
        }
        return redirect()->back()->with(['failed_notify' => 'SomeThing Wrong Process Not Complete']);
    }



    public function del($id, Request $request)
    {
        $facility = Facilities::find($id);
        if ($facility->disable == 0) {
            $facility->disable =  1;
            $facility->save();
            $this->loger('Disable facility', $this->model->id, $facility->id, json_encode($facility),  $request->ip());
            return redirect()->back()->with(['failed_notify' => 'Facility Disable Successfully']);
        } else {
            $facility->disable =  0;
            $facility->save();
            $this->loger('Enable facility', $this->model->id, $facility->id, json_encode($facility),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'Facility Enable Successfully']);
        }
    }
}
