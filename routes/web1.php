<?php

use App\Events\RealTimePush;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\logController;
use App\Http\Controllers\DepartmnetController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('notify', function () {
    return RealTimePush::dispatch("hello");
});


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//DropzoneController@fileStore
Route::post('drop/upload', [DropzoneController::class, 'fileStore'])->name('save_img');
Route::get('del/attach/{id}', [DropzoneController::class, 'delete']);


Route::group(['middleware' => 'auth'], function () {

    //Hotel Module
    Route::group(['prefix' => '/hotels', 'middleware' => 'admin_check'], function () {
        Route::GET('/', [HotelController::class, 'index'])->name('hotels')->middleware('view_permission');
        Route::GET('/view/{hotel_id}', [HotelController::class, 'view'])->name('hotel.view');
        Route::POST('/store', [HotelController::class, 'store'])->name('hotel.save');
        Route::POST('/update/{id}', [HotelController::class, 'update'])->name('hotel.update');
    });

    //Users Model
    Route::group(['prefix' => '/users',],  function () {
        Route::GET('/', [UserController::class, 'index'])->name('users')->middleware('view_permission');
        Route::GET('/create', [UserController::class, 'create'])->name('users.create');
        Route::POST('/store', [UserController::class, 'store'])->name('users.store');
        Route::GET('/view/{user_id}', [UserController::class, 'edit'])->name('users.view');
        Route::POST('/user_status', [UserController::class, 'change_status'])->name('users.disable');
        Route::POST('/update/{user_id}', [UserController::class, 'update'])->name('users.update');
        Route::POST('/update_permission/{user_id}', [UserController::class, 'update_permission'])->name('update.user.permission');
        Route::POST('/change_password', [UserController::class, 'changePassword'])->name('update.user.password');
    });

    //Department Model
    Route::group(['prefix' => '/department',  'middleware' => 'admin_check'], function () {
        Route::GET('/', [DepartmnetController::class,  'index'])->name('department');
        Route::POST('/store', [DepartmnetController::class,  'store'])->name('department.store');
        Route::POST('/disable', [DepartmnetController::class,  'disable'])->name('department.disable');
        Route::POST('/update', [DepartmnetController::class,  'update'])->name('department.update');
        Route::GET('/department_user/{department_id}', [DepartmnetController::class,  'DepartmentUser'])->name('department.users');
    });

    Route::group(['prefix' => 'log', 'middleware' => 'admin_check'], function () {
        Route::get('/', [logController::class, 'index'])->name('log');
        Route::post('/view', [logController::class, 'view'])->name('view_log');
    });


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    //Ticket Model
    Route::group(['prefix' => '/ticket',], function () {
        Route::GET('/', [TicketController::class,  'index'])->name('ticket');
        Route::GET('/data', [TicketController::class,  'index_data'])->name('ticket.data');
        Route::GET('/create/{id?}', [TicketController::class,  'create'])->name('ticket.create');
        Route::POST('/store', [TicketController::class,  'store'])->name('ticket.store');
        Route::GET('/show/{id}', [TicketController::class,  'show'])->name('ticket.show');
        Route::POST('/disable', [TicketController::class,  'disable'])->name('ticket.disable');
        Route::POST('/update', [TicketController::class,  'update'])->name('ticket.update');
        Route::POST('/service_by_dep', [TicketController::class,  'get_service_by_dep'])->name('ticket.dep_service');
        Route::POST('/facilities_by_type', [TicketController::class,  'get_facilities_by_type'])->name('ticket.facility');
    });




    //Task Model
    Route::group(['prefix' => '/task',], function () {
        Route::GET('/', [TasksController::class,  'index'])->name('task');
        Route::GET('/data', [TasksController::class,  'index_data'])->name('task.data');
        Route::GET('/show/{id}', [TasksController::class,  'show'])->name('ticket.show');
        Route::POST('/store', [TasksController::class,  'store'])->name('task.create');
        Route::GET('/change_status/{ticket_id}/{status}', [TasksController::class,  'changeTaskStatus'])->name('task.change.status');
        Route::POST('/data', [TasksController::class,  'assignTaskToWorker'])->name('task.assign.worker');
        Route::POST('/task_time_diff', [TasksController::class,  'task_time_diff'])->name('task.task_time_diff');
    });



    //facilities Model
    Route::group(['prefix' => '/facility'], function () {
        Route::GET('/', [FacilitiesController::class,  'index'])->name('facility');
        Route::POST('/store', [FacilitiesController::class,  'store'])->name('facility.store');
        Route::GET('/disable/{id}', [FacilitiesController::class,  'del'])->name('facility.disable');
        Route::POST('/update', [FacilitiesController::class,  'update'])->name('facility.update');
    });


    //Services Model
    Route::group(['prefix' => '/services'], function () {
        Route::GET('/', [ServiceController::class,  'index'])->name('services');
        Route::POST('/store', [ServiceController::class,  'store'])->name('services.store');
        Route::GET('/disable/{id}', [ServiceController::class,  'del'])->name('services.disable');
        Route::POST('/update', [ServiceController::class,  'update'])->name('services.update');
    });

    //Workers Model
    Route::group(['prefix' => '/workers'], function () {
        Route::GET('/', [WorkerController::class,  'index'])->name('workers');
        Route::POST('/store', [WorkerController::class,  'store'])->name('workers.store');
        Route::GET('/disable/{id}', [WorkerController::class,  'del'])->name('workers.disable');
        Route::POST('/update', [WorkerController::class,  'update'])->name('workers.update');
        Route::GET('/data', [WorkerController::class,  'index_data'])->name('workers.data');
        Route::POST('/users', [WorkerController::class,  'get_users_by_hotel'])->name('workers.users');
    });
});

require __DIR__ . '/auth.php';
