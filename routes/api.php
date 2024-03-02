<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GscApi\AuthApiController;
use App\Http\Controllers\GscApi\PostsApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => 'api_access'], function () {
Route::get('service_category/{lang?}', [ApiController::class,  'getDepartmentService']);
Route::get('guests_service/{lang?}/{dep_id?}', [ApiController::class,  'guestService']);
Route::post('ticket/create', [ApiController::class,  'create_ticket']);
Route::get('guest_ticket/{hid}/{room_num}/{conf_num}/{lang?}', [ApiController::class,  'GuestTickets']);
Route::post('ticket/update/{ticket_id}', [ApiController::class,  'update_ticket']);
Route::get('ticket_reopen/{ticket_id}', [ApiController::class,  'reopen_ticket']);
Route::get('ticket_confirm/{ticket_id}', [ApiController::class,  'confirm_ticket']);
//});

Route::group(['prefix' => 'gsc'], function () {
    Route::post('login/client', [AuthApiController::class, 'login']);
    Route::post('register/client', [AuthApiController::class, 'register_client']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthApiController::class, 'logout']);

        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', [PostsApiController::class, 'posts']);
        });

        Route::group(['prefix' =>  'service_category'], function () {
            // Route::get('/' ,  );
        });
    });
});
