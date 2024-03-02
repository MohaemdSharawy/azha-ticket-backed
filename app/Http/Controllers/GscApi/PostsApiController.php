<?php

namespace App\Http\Controllers\GscApi;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Posts;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsApiController extends Controller
{
    use General;

    public function posts()
    {
        $posts  =  Posts::where('hotel_id', $this->get_client_property(Auth::id()))->get();
        return response()->json([
            'posts' => $posts,
        ], 200);
    }
}
