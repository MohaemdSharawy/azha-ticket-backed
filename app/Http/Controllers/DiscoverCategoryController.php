<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscoverCategoryController extends Controller
{

    public function index(){
        return view('discover_category.index');
    }

}
