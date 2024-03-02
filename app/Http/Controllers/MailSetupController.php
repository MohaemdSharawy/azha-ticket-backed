<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\Mail_setup;
use App\Models\MailQueue;
use App\Models\tickets;
use App\Models\User;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailSetupController extends Controller
{

    use General;

    private $module_id = 6;

    public function index()
    {
        $user_hotels = $this->getUserHotel();
        $hotels = Hotels::where(['deleted' => 0])->whereIn('id', $user_hotels)->get();
        $departments = Department::where(['deleted' => 0])->get();
        return view('backend.admin.mailSetup.index', compact('hotels', 'departments'));
    }

    public function show_mails($hotel_id,  $dep_id)
    {
        $data  = Mail_setup::get_mail_setup($hotel_id, $dep_id);
        // dd($data);
        return view('backend.admin.mailSetup.show', compact('data', 'hotel_id', 'dep_id'));
    }

    public function store(Request $request)
    {


        if ($request->type  == 13) {
            $add = Mail_setup::create([
                'h_id' => $request->h_id,
                'dep_id' => $request->dep_id,
                'name' => $request->mail,
                'type' => $request->type
            ]);
            $message = 'New Mail Add Successfully!!';
        } elseif ($request->type  == 14) {
            $add = Mail_setup::create([
                'h_id' => $request->h_id,
                'dep_id' => $request->dep_id,
                'name' => $request->phone,
                'type' => $request->type
            ]);
            $message = 'New Phone Add Successfully!!';
        }

        if ($add) {
            $this->loger('Create',  $this->module_id,  $add->id, json_encode($add), $request->ip());

            // $this->loger()
            return redirect()->back()->with(['success_notify' => $message]);
        }
    }

    public function mail_disable(Request $request)
    {
        // dd($request->mail_id);
        $old_data =  Mail_setup::find($request->mail_id);
        $mail = Mail_setup::find($request->mail_id);

        $mail->deleted =  $request->status;
        $mail->save();
        //Notifcation Message
        if ($mail->type == 13) {
            ($request->status == 0) ? $message = 'Mail Enable Successfully!! ' :  $message = 'Mail Disable Successfully!! ';
        } elseif ($mail->type == 14) {
            ($request->status == 0) ? $message = 'Phone Enable Successfully!! ' :  $message = 'Phone Disable Successfully!! ';
        }

        //Log Massage
        if ($mail->type == 13) {
            ($request->status == 0) ? $action = 'Mail Enable  ' :  $action = 'Mail Disable ';
        } elseif ($mail->type == 14) {
            ($request->status == 0) ? $action = 'Phone Enable  ' :  $action = 'Phone Disable ';
        }
        if ($mail) {
            $this->loger($action,  $this->module_id,  $request->mail_id, json_encode($mail), $request->ip(), json_encode($old_data));
            return response()->json([
                'status' => 200,
                'message' => $message,
                'mail_status'  =>  $request->status,
                'mail_id' => $request->mail_id
            ]);
        }
    }

    public function disable_dep_mail($hotel_id, $dep_id, Request $request)
    {
        $assigners = Mail_setup::where(['h_id' => $hotel_id,  'dep_id' => $dep_id])->get();
        foreach ($assigners  as $assigner) {
            $assigner->deleted = 1;
            $assigner->save();
        }
        $fdata = [
            'hotel_name' => Hotels::find($hotel_id)->hotel_name,
            'dep_name' => Department::find($dep_id)->dep_code
        ];

        $this->loger('Reset Department',  $this->module_id,  $dep_id, json_encode($fdata), $request->ip());
        return redirect()->back()->with(['success_notify' => 'Department Rest Successfully!!']);
    }

    public function update(Request $request)
    {
        // dd($request);
        $old_data = Mail_setup::find($request->mail_id);
        $update = Mail_setup::find($request->mail_id);
        if ($update->type == 14) {
            $name = $request->mail;
            $message = 'Phone Updated Successfully!!';
        } else {
            $name =  $request->mail;
            $message = 'Mail Updated Successfully!!';
        }
        $update->name = $name;
        $update->save();
        if ($update) {
            $this->loger('Update',  $this->module_id,  $request->mail_id, json_encode($update), $request->ip(), json_encode($old_data));
            return redirect()->back()->with(['success_notify' => $message]);
        }
    }

    public function inbox()
    {
        // $test = MailQueue::where('from', Auth::user()->email)->ORwhereHas('cc', function ($q) {
        //     $q->where('uid', Auth::id());
        // })->get();
        // dd($test);
        $active_users = User::where(['login' => 1])->get();
        $query = MailQueue::mail_inbox();
        $mails = $query->get();
        $inbox_count =  $query->count();
        $star_count =  MailQueue::mail_star()->count();
        $send_count  =  MailQueue::send_mail()->count();
        $deleted_count  = MailQueue::deleted_mail()->count();
        return view('backend.inbox', compact('mails',  'inbox_count', 'star_count', 'send_count',  'deleted_count', 'active_users'));
    }

    public function set_star(Request $request)
    {
        $old_data  = MailQueue::find($request->id);
        $update  = MailQueue::find($request->id);
        $update->starred = $request->status;
        $update->save();
        ($request->status == 1) ? $message = 'Mail Set As Starred Mail' : $message =  'Mail Set As UnStarred Mail';
        return response()->json([
            'status' => 200,
            'message' => $message,
            'star_status'  =>  $request->status,
            'id' => $request->id,
            'count' => MailQueue::mail_star()->count()
        ]);
    }

    public function get_star()
    {
        $result = MailQueue::mail_star()->get();
        return response()->json([
            'status' => 200,
            'result' => $result,
        ]);
    }


    public function get_inbox()
    {
        $result = MailQueue::mail_inbox()->get();
        return response()->json([
            'status' => 200,
            'result' => $result,
        ]);
    }

    public function get_send_mail()
    {
        $result = MailQueue::send_mail()->get();
        return response()->json([
            'status' => 200,
            'result' => $result,
        ]);
    }
    public function get_deleted_mail()
    {
        $result = MailQueue::deleted_mail()->get();
        return response()->json([
            'status' => 200,
            'result' => $result,
        ]);
    }

    public function onlineUsers()
    {
        return response()->json([
            'users' => $this->onlineUserHotels()
        ], 200);
    }
}
