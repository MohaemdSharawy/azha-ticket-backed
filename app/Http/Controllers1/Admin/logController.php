<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\log;
use Illuminate\Http\Request;

class logController extends Controller
{
    public function index()
    {

        $data = log::get_all_log();
        return view('backend.admin.log.index', compact('data'));
    }

    public function view(Request $request)
    {
        $result =  log::find($request->log_id);
        return response()->json([
            'status' => 200,
            'result' => $result
        ]);
    }


    public function mail_queue()
    {
    }
}
