<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Models\Attachment;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;

class DropzoneController extends Controller
{


    public function fileStore(Request $request)
    {

        $file = $request->file('dzfile');
        $filename = uploadImage('attach', $file);
        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    public function custom_file_store(Request $request){
        $file = $request->file('dzfile');
        $filename = uploadImage($request->file_name, $file);
        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function fileCreate()
    {
        return view('layouts.dropzone');
    }




    public function delete($id)
    {
        $item = Attachment::find($id);
        $item->update(['deleted' => 1]);
        return redirect()->back();
    }
}
