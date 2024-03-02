<?php

namespace App\Http\Controllers;

use App\Mail\NotifyMail;
use App\Models\Department;
use App\Models\MailQueue;
use App\Models\tickets;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DepartmnetController extends Controller
{
    use General;
    private $model_id = 4;
    public function index()
    {
        $departments  =  Department::all();
        return view('backend.admin.department.index', compact('departments'));
    }


    public function store(Request $request)
    {
        $add = Department::create([
            'dep_name' => $request->name,
            'dep_code' => $request->code
        ]);

        if ($add) {
            $this->loger('Create',  $this->model_id,  $add->id, json_encode($add), $request->ip());
            return redirect()->back()->with(['success_notify' => 'New Department Add Successfully !!']);
        }
    }

    public function disable(Request $request)
    {
        $old_data =  Department::find($request->dep_id);
        $dep = Department::find($request->dep_id);
        $dep->deleted =  $request->status;
        $dep->save();
        ($request->status == 0) ? $message = 'Department Enable Successfully!! ' :  $message = 'Department Disable Successfully!! ';
        ($request->status == 0) ? $action = 'Department Enable  ' :  $action = 'Department Disable ';
        if ($dep) {
            $this->loger($action, $this->model_id,  $request->dep_id, json_encode($dep), $request->ip(), json_encode($old_data));
            return response()->json([
                'status' => 200,
                'message' => $message,
                'user_status'  =>  $request->status,
                'dep_id' => $request->dep_id
            ]);
        }
    }


    public function update(Request $request)
    {
        $old_data =  Department::find($request->id);
        $update = Department::find($request->id);
        $update->dep_name = $request->name;
        $update->dep_code =  $request->code;
        $update->save();
        if ($update) {
            $this->loger('Update',  $this->model_id,  $request->id, json_encode($update), $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' => 'Data Updated SuccessFully!! ']);
        }
    }




    public function DepartmentUser(int $hotel_id, int $dep_id)
    {

        $workers =  $this->workerInHotelDepartment($hotel_id, $dep_id);
        // $department = Department::where('id', $dep_id)->with('workers', 'users')->first();
        return response()->json([
            // 'department' => $department
            'workers' => $workers
        ], 200);
    }


    public function test()
    {

        // $survey =  tickets::survey_view(9);
        // Mail::to('mohamed.sharawy@sunrise-resorts.com')->send(new NotifyMail($survey->name, $survey->room_num, $survey->email, $survey->dep_name, $survey->survey_status, $survey->phone, $survey->hotel_name, $survey->logo));
        // $survey =  tickets::survey_view(3);
        // Mail::to('mohamed.sharawy@sunrise-resorts.com')->send(new NotifyMail($survey->name, $survey->room_num, $survey->email, $survey->dep_name, $survey->survey_status, $survey->phone, $survey->hotel_name, $survey->logo));
        // // $e = MailQueue::find(2);
        // send_to_sendmail_service($e->to, 'test', 'test', '');
        // whatsapp($e->to, "5", $e->survey_id);

        // Mail::to('mohamed.sharawy@sunrise-resorts.com')->send(new NotifyMail());
    }
}
