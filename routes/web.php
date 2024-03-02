<?php

use App\Events\RealTimePush;
use App\Http\Controllers\Admin\DashBoard;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\logController;
use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DepartmnetController;
use App\Http\Controllers\DiscoverCategoryController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\MailSetupController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentRequestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViolationsController;
use App\Http\Controllers\WorkerController;
use App\Models\Category_services;
use App\Models\User;
use App\Notifications\TicketNotification;

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

Route::GET('/merge', [TicketController::class,  'merge']);


Route::get('notify', function () {
    return RealTimePush::dispatch(1, 2, 3, 4, 5, 6);
});


Route::get('/', [DashBoard::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashBoard::class, 'index'])->middleware('auth')->name('dashboard');




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//DropzoneController@fileStore
Route::post('drop/upload', [DropzoneController::class, 'fileStore'])->name('save_img');
Route::post('drop/upload/custom', [DropzoneController::class, 'custom_file_store'])->name('save_img.custom');
Route::get('del/attach/{id}', [DropzoneController::class, 'delete']);


Route::group(['middleware' => 'auth'], function () {
    Route::GET('ticket/show-model/{ticket_id}', [DashBoard::class, 'show_ticket_model']);


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
        Route::GET('/change_notification', [UserController::class, 'change_notification']);
    });

    //Department Model
    Route::group(['prefix' => '/department',  'middleware' => 'admin_check'], function () {
        Route::GET('/', [DepartmnetController::class,  'index'])->name('department');
        Route::POST('/store', [DepartmnetController::class,  'store'])->name('department.store');
        Route::POST('/disable', [DepartmnetController::class,  'disable'])->name('department.disable');
        Route::POST('/update', [DepartmnetController::class,  'update'])->name('department.update');
    });
    Route::GET('department/department_user/{hotel_id}/{department_id}', [DepartmnetController::class,  'DepartmentUser'])->name('department.users');

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
        Route::GET('/update_status/{ticket_id}/{status}', [TicketController::class,  'update_ticket_status'])->name('ticket.update.status');
        Route::POST('/service_by_dep', [TicketController::class,  'get_service_by_dep'])->name('ticket.dep_service');
        Route::POST('/facilities_by_type', [TicketController::class,  'get_facilities_by_type'])->name('ticket.facility');
    });

    Route::group(['prefix' => '/ticket_comments'], function () {
        Route::GET('/show/{ticket_id}', [TicketController::class,  'ticketComments'])->name('ticket.comments');
        Route::POST('/create/{ticket_id}', [TicketController::class,  'createComment'])->name('ticket.comments.create');
        Route::GET('/comment_notify/{comment_id}', [TicketController::class,  'notify_comment'])->name('ticket.comments.mail');
        Route::GET('/comment_notify/{comment_id}/confirm', [TicketController::class,  'notify_comment_with_confirm'])->name('ticket.comments.mail.with.confirm');
    });


    //Task Model
    Route::group(['prefix' => '/task',], function () {
        Route::GET('/', [TasksController::class,  'index'])->name('task');
        Route::GET('/data', [TasksController::class,  'index_data'])->name('task.data');
        Route::GET('/show/{id}', [TasksController::class,  'show']);
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


    Route::group(['prefix' => '/category_service'], function () {
        Route::GET('/', [CategoryServiceController::class, 'index'])->name('category_service');
        Route::POST('/store', [CategoryServiceController::class, 'store'])->name('category_service.store');
        Route::GET('/disable/{id}', [CategoryServiceController::class, 'destroy'])->name('category_service.disable');
        Route::POST('/update', [CategoryServiceController::class, 'update'])->name('category_service.update');
    });


    Route::group(['prefix' => 'clients'], function () {
        Route::GET('/',  [ClientsController::class, 'index'])->name('clients');
        Route::GET('/get',  [ClientsController::class, 'index_data'])->name('clients.data');
        Route::GET('/edit/{id}',  [ClientsController::class, 'edit'])->name('clients.edit');
        Route::GET('/update/{id}',  [ClientsController::class, 'update'])->name('clients.update');
    });

    Route::group(['prefix' => 'posts'],  function () {
        Route::GET('/', [PostController::class, 'index'])->name('posts');
        Route::GET('/create', [PostController::class, 'create'])->name('posts.create');
        Route::POST('/store', [PostController::class, 'store'])->name('posts.store');
        Route::GET('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
        Route::POST('/update/{id}', [PostController::class, 'update'])->name('posts.update');
    });


    Route::group(['prefix' => 'violations'],  function () {
        Route::GET('/', [ViolationsController::class, 'index'])->name('violations');
        Route::GET('/create', [ViolationsController::class, 'create'])->name('violations.create');
        Route::POST('/store', [ViolationsController::class, 'store'])->name('violations.store');
        Route::GET('/edit/{id}', [ViolationsController::class, 'edit'])->name('violations.edit');
        Route::POST('/update/{id}', [ViolationsController::class, 'update'])->name('violations.update');
    });


    Route::group(['prefix' => 'discover'],  function () {
        Route::GET('/', [DiscoverController::class, 'index'])->name('discover');
        Route::GET('/create', [DiscoverController::class, 'create'])->name('discover.create');
        Route::POST('/store', [DiscoverController::class, 'store'])->name('discover.store');
        Route::GET('/edit/{id}', [DiscoverController::class, 'edit'])->name('discover.edit');
        Route::POST('/update/{id}', [DiscoverController::class, 'update'])->name('discover.update');
    });

    Route::group(['prefix' => 'discover-category'],  function () {
        Route::GET('/', [DiscoverCategoryController::class, 'index'])->name('discover-category');
        Route::GET('/create', [DiscoverCategoryController::class, 'create'])->name('discover-category.create');
        Route::POST('/store', [DiscoverCategoryController::class, 'store'])->name('discover-category.store');
        Route::GET('/edit/{id}', [DiscoverCategoryController::class, 'edit'])->name('discover-category.edit');
        Route::POST('/update/{id}', [DiscoverCategoryController::class, 'update'])->name('discover-category.update');
    });


    Route::group(['prefix' => 'payment_request'],  function () {
        Route::GET('/', [PaymentRequestController::class, 'index'])->name('payment');
        Route::GET('/create', [PaymentRequestController::class, 'create'])->name('payment.create');
        Route::POST('/store', [PaymentRequestController::class, 'store'])->name('payment.store');
        Route::GET('/edit/{id}', [PaymentRequestController::class, 'edit'])->name('payment.edit');
        Route::POST('/update/{id}', [PaymentRequestController::class, 'update'])->name('payment.update');
    });


    Route::group(['prefix' => 'orders'],  function () {
        Route::GET('/', [OrdersController::class, 'index'])->name('order');
        Route::GET('/view/{id}', [OrdersController::class, 'edit'])->name('order.view');
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

    Route::group(['prefix' => '/reports'], function () {
        Route::GET('/', [ReportController::class, 'index'])->name('report');
        Route::GET('/worker', [ReportController::class, 'index_worker'])->name('report.worker');
        Route::GET('/department', [ReportController::class, 'index_department'])->name('report.department');


        Route::POST('excel', [ReportController::class,  'excel_department'])->name('excel.department.report');
        Route::POST('/daily', [ReportController::class, 'TicketReports'])->name('report.ticket.generate');
        Route::GET('/top_ten', [ReportController::class, 'top_ten_index'])->name('report.top_ten');
    });



    //Inbox Routes
    Route::GET('/inbox', [MailSetupController::class, 'inbox'])->name('inbox');
    Route::post('/set_star', [MailSetupController::class, 'set_star'])->name('star');
    Route::post('/get_star', [MailSetupController::class, 'get_star'])->name('get_star');
    Route::post('/get_inbox', [MailSetupController::class, 'get_inbox'])->name('get_inbox_ajax');
    Route::post('/get_send', [MailSetupController::class, 'get_send_mail'])->name('get_send_ajax');
    Route::post('/get_deleted', [MailSetupController::class, 'get_deleted_mail'])->name('get_deleted_ajax');
    Route::get('/user/online', [MailSetupController::class, 'onlineUsers'])->name('user.online');
});


Route::post('annul', [ReportController::class,  'annual_service'])->name('report.annual');
Route::get('report/annul', [ReportController::class,  'index_annul_report'])->name('report.annual.index');


// Route::get('send-message', function () {
//     $user =  User::find(1352);
//     $user->notify((new  TicketNotification('Welcome Sharawy')));
//     return $user->unreadNotifications;
// });

require __DIR__ . '/auth.php';
