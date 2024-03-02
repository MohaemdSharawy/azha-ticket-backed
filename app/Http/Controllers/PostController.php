<?php

namespace App\Http\Controllers;

use App\Models\Hotels;
use App\Models\Posts;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use General;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['hotels'] = Hotels::whereIn('id', $this->getUserHotel())->get();
        return view('posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs =  $request->all();
        $inputs['user_id'] = Auth::id();
        $inputs['image']  =  $this->uploadImage('posts', $request->image);
        Posts::create($inputs);
        return redirect()->back()->with(['success_notify' => 'New Post Add Successfully !!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['hotels'] = Hotels::whereIn('id', $this->getUserHotel())->get();
        $data['post'] =  Posts::find($id);
        return view('posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs =  $request->all();
        $post =  Posts::find($id);
        if ($request->image) {
            $inputs['image']  =  $this->uploadImage('posts', $request->image);
        }
        $post->update($inputs);
        return redirect()->back()->with(['success_notify' => 'Post Updated Successfully !!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
