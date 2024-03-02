<?php

namespace App\Http\Controllers;

use App\Events\RealTimePush;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\MetaData;
use App\Models\Periority;
use App\Models\status;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TaskNotification;
use App\Notifications\TicketNotification;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{

    private $model;
    use General;

    public function __construct()
    {
        $this->model = $this->get_model_by_name('Tasks');
    }

    public function index()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->where(['deleted' => 0])->get();
        $status =  status::all();
        $types = MetaData::where(['key_word' => 'ticket_type'])->get();
        $priority = Periority::all();
        $departments = Department::whereIn('id', $this->getUserDepartment())->where(['deleted' => 0])->get();

        return view('tasks.index', compact('hotels', 'status', 'types', 'priority', 'departments'));
    }

    public function index_data(Request $request)
    {
        if ($request->ajax()) {
            $from = date('Y-m-d', strtotime($request->from_time . ' - 1 days'));
            $to = date('Y-m-d', strtotime($request->to_time . ' + 1 days'));
            $tickets = Task::with(['hotels' => function ($q) {
                $q->select('hotel_name', 'id');
            }, 'status',])->whereIn('hid', $this->getUserHotel())->whereIn('dep_id', $this->getUserDepartment())->where(['deleted' => 0,])
                ->whereBetween('created_at', [$from, $to]);
            if (isset($request->hotels)) {
                $tickets->whereIn('hid', $request->hotels);
            }
            if (isset($request->my_task) && $request->my_task == "true") {
                $tickets->where('worker_id', Auth::id());
            }
            if (isset($request->status)) {
                $tickets->where('status_id', $request->status);
            }
            if (isset($request->priority)) {
                $tickets->whereIn('priority_level', $request->priority);
            }
            if (isset($request->types)) {
                $tickets->whereIn('type_id', $request->types);
            }
            return response()->json([
                'ticket' => $tickets->get(),
            ]);
        } else {
            abort(403);
        }
    }





    public function show($id)
    {
        $this->readFromNotification('App\Notifications\TaskNotification', $id);
        $task = Task::with(['user', 'status', 'department', 'hotels'])->find($id);
        return response()->json([
            'task' => $task,
            'user_dep' => $this->getUserDepartment()
        ], 200);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['status_id'] = 1;
        $inputs['type_id'] = 6;
        $add = Task::create($inputs);
        if ($add) {
            RealTimePush::dispatch('New Task Added');
            $this->notifyTask($add->id, $add->hid, $add->dep_id);
            $this->loger('Created Task To Ticket ' . $request->ticket_id . '', $this->model->id, $add->id, json_encode($add), $request->ip());
            return redirect()->back()->with(['success_notify' => 'Task Add Successfully!!']);
        }
    }

    public function assignTaskToWorker(Request $request)
    {
        $task =  Task::find($request->task_id);
        // get_time_diff($task->created_at);
        $task->worker_id  = $request->worker_id;
        $task->status_id = 2;
        $task->assigned_at = Carbon::now();
        $task->save();
        $user = User::find($request->worker_id);
        if ($user->notify == "1") {
            $user->notify((new  TaskNotification('You have been Assigned To New Task # ' . $task->id, $task->id)));
        }
        if (!is_null($task->ticket_id)) {
            $this->StartTicket($task->ticket_id);
        }
        $this->incUserTask($request->worker_id);
        return redirect()->back()->with(['success_notify' => 'Worker Assigned SuccessFully!! ']);
    }

    public function changeTaskStatus(int $task_id, int $status)
    {

        $task =  Task::find($task_id);
        $task->status_id =  $status;
        if ($status == 3) {
            $task->end_at = Carbon::now();
            $task->end_by = Auth::id();
            $this->decUserTask($task->worker_id);
        }
        $task->save();
        if ($task->ticket_id) {
            $this->allTasksConfirmed($task->ticket_id);
        }

        return redirect()->back()->with(['success_notify' => 'Status Change SuccessFully!! ']);
    }

    private function allTasksConfirmed(int $ticket_id): void
    {
        $tasks_ticket   = Task::where(['ticket_id' => $ticket_id, ['status_id', '!=', '3']])->count();
        if ($tasks_ticket == 0) {
            $ticket = Ticket::find($ticket_id);
            $ticket->status_id = 3;
            $ticket->end_at = Carbon::now();
            $ticket->save();
            $user = User::find($ticket->uid);
            if ($user->notify == "1") {
                $user->notify((new  TicketNotification('Ticket Completed # ' . $ticket_id, $ticket_id)));
            }
        }
    }


    private function StartTicket($ticket_id)
    {
        $ticket  =  Ticket::find($ticket_id);
        $ticket->status_id = 2;
        $ticket->save();
    }
    private function incUserTask($uid)
    {
        $user = User::find($uid);
        $user->in_task = $user->in_task + 1;
        $user->save();
    }
    private function decUserTask($uid)
    {
        $user = User::find($uid);
        if ($user->in_task  > 0) {
            $user->in_task = $user->in_task - 1;
        }
        $user->save();
    }



    public function notifyTask($task_id, $dep_id, $hotel_id)
    {
        $users = $this->UserNotifyHotelDepartment($hotel_id, $dep_id);
        foreach ($users  as $user) {
            $user->notify((new  TaskNotification('New Task Created # ' . $task_id, $task_id)));
        }
    }
}
