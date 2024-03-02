<?php

namespace App\Http\Controllers;

use App\Jobs\SendMails;
use App\Models\User;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function notify(Request $request)
    {
        // $data = $request->all();
        $data = User::whereIn($request->users_id)->get();
        dispatch(new SendMails($data));
    }
}
