<?php

namespace App\Http\Controllers;

use App\Models\Category_services;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =  Category_services::where(['deleted' => 0])->get();
        return view('category_service.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category_services::create($request->all());
        return redirect()->back()->with(['success_notify' => 'New Category Service Add Successfully!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.x
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $row = Category_services::find($request->category_id);
        $row->update($request->all());
        return redirect()->back()->with(['success_notify' => 'Category Service updated Successfully!!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Category_services::find($id);
        if ($service->active == 0) {
            $service->active =  1;
            $service->save();
            // $this->loger('Disable service', $this->model->id, $service->id, json_encode($service),  $request->ip());
            return redirect()->back()->with(['failed_notify' => 'Category service Disable Successfully']);
        } else {
            $service->active =  0;
            $service->save();
            // $this->loger('Enable service', $this->model->id, $service->id, json_encode($service),  $request->ip());
            return redirect()->back()->with(['success_notify' => 'Category service Enable Successfully']);
        }
    }
}
