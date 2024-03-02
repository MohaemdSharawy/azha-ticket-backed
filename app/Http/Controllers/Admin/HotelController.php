<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotels;
use App\Models\MetaData;
use App\Traits\General;
use Illuminate\Http\Request;

class HotelController extends Controller
{

    use General;

    private $module_id = 2;


    public function index()
    {
        $hotels = Hotels::where(['deleted' => 0])->get();
        // dd($hotels);
        $index_design  = MetaData::where(['key_word' => 'index_design'])->get();
        $create_design = MetaData::where(['key_word' => 'create_design'])->get();
        $thanku_design = MetaData::where(['key_word' => 'thanku_design'])->get();
        return view('backend.admin.hotels', compact('hotels', 'index_design', 'thanku_design', 'create_design'));
    }

    public function view($id)
    {
        $hotel = Hotels::find($id);
        $index_design  = MetaData::where(['key_word' => 'index_design'])->get();
        $create_design = MetaData::where(['key_word' => 'create_design'])->get();
        $thanku_design = MetaData::where(['key_word' => 'thanku_design'])->get();
        return view('backend.admin.hotels_edit', compact('hotel', 'index_design', 'create_design', 'thanku_design'));
    }


    public function store(Request $request)
    {
        // dd($request->logo);
        $add = Hotels::create([
            'hotel_name' => $request->hotel_name,
            'code' => $request->code,
            'template' => $request->template,
            'logo' => $this->img_upload($request->logo),
            'create_temp' => $request->create,
            'thanks_temp' => $request->thanku,
            'image' =>  $this->resize($request->image)
        ]);
        if ($add) {
            // $this->loger('Create Hotel', json_encode($add), $add->id, $request->ip());
            return redirect()->back()->with(['success' => 'New Hotel Add Successfully!!']);
        }
    }

    public function update(Request $request, $id)
    {

        // dd($this->resize($request->image));
        $old_data  = Hotels::find($id);
        $update = Hotels::find($id);
        $update->hotel_name = $request->hotel_name;
        $update->code = $request->code;
        $update->template = $request->template;
        $update->create_temp =  $request->create;
        $update->thanks_temp = $request->thanku;

        if ($request->image) {

            $update->image = $this->resize($request->image);
        }

        if ($request->logo) {
            $update->logo =  $this->img_upload($request->logo);
        }
        $update->save();

        if ($update) {
            $this->loger('updated',  $this->module_id,  $id, json_encode($update), $request->ip(), json_encode($old_data));

            return redirect()->back()->with(['success' => 'Data Updated Successfully !!']);
        }
    }
}
