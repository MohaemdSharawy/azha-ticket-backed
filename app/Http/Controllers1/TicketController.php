<?php

namespace App\Http\Controllers;

use App\Events\RealTimePush;
use App\Http\Requests\TicketRequest;
use App\Models\Department;
use App\Models\Facilities;
use App\Models\Hotels;
use App\Models\Merge;
use App\Models\MetaData;
use App\Models\Periority;
use App\Models\RoomData;
use App\Models\Service;
use App\Models\status;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{

    private $model;
    use General;




    public function __construct()
    {
        $this->model = $this->get_model_by_name('tickets');
    }

    public function index()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->where(['deleted' => 0])->get();
        $status =  status::all();
        $types = MetaData::where(['key_word' => 'ticket_type'])->get();
        $priority = Periority::all();
        $user_department = $this->getUserDepartment();
        return view('tickets.index', compact('hotels', 'status', 'types', 'priority', 'user_department'));
    }


    public function index_data(Request $request)
    {
        if ($request->ajax()) {
            $from = date('Y-m-d', strtotime($request->from_time . ' - 1 days'));
            $to = date('Y-m-d', strtotime($request->to_time . ' + 1 days'));
            $tickets = Ticket::with(['hotels' => function ($q) {
                $q->select('hotel_name', 'id');
            }, 'status', 'level', 'room', 'facility'])->whereIn('hid', $this->getUserHotel())->where(['deleted' => 0, 'master_id' => null])
                ->whereBetween('created_at', [$from, $to]);
            if (isset($request->hotels)) {
                $tickets->whereIn('hid', $request->hotels);
            }
            if (isset($request->status)) {
                $tickets->where('status_id', $request->status);
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

    public function create($id = null)
    {
        $hotels  = Hotels::WhereIn('id', $this->getUserHotel())->get();
        $deps  = Department::all();
        $priority = Periority::all();
        $types =  MetaData::where('key_word', 'ticket_type')->get();
        return view('tickets.create', compact('hotels', 'deps', 'types', 'id', 'priority'));
    }

    public function store(TicketRequest $request)
    {

        // dd($request->all());
        $inputs = [
            'uid' => Auth::id(),
            'hid' => $request->hid,
            'to_dep' => $request->dep,
            'service_id' => $request->service_id,
            'type_id' => $request->type_id,
            'description' => $request->description,
            'master_id' =>  $request->id,
            'status_id' => 1,
            'priority_level' => $request->priority_level
        ];
        if ($request->type_id == "1") {
            $room = RoomData::create([
                'room_num' => $request->room,
                'guest_name' => $request->guest_name,
                'conf_num' => $request->reservation_no
            ]);
            $inputs['room_id'] = $room->id;
        } else {
            $inputs['facility_id'] = $request->facility_id;
        }
        // dd($inputs);

        $add =  Ticket::create($inputs);
        if ($add) {
            // $this->loger('Create Ticket', $this->model->id, $add->id, json_encode($add),  $request->ip());
            Task::create([
                'uid' => Auth::id(),
                'dep_id' => $request->dep,
                'hid'  => $request->hid,
                'name' =>  Service::find($request->service_id)->name,
                'description' => $request->description,
                'ticket_id' => $add->id,
                'time' => '00:00',
                'status_id' => 1,
                'type_id' => 6
            ]);
        }

        RealTimePush::dispatch('New Task Added');
        $this->notifyTicket($add->id, $add->hid, $add->to_dep);
        return redirect()->route('ticket')->with(['success_notify' => 'New Ticket Add Successfully!!']);
    }



    public function show($id)
    {
        $this->readFromNotification('App\Notifications\TicketNotification', $id);
        $ticket = Ticket::with(['hotels', 'to_department', 'services', 'status', 'level', 'facility', 'room', 'users'])->where(['id' => $id])->first();
        $subTickets = Ticket::with(['hotels', 'to_department', 'services', 'status', 'level', 'facility', 'room',  'users'])->where(['master_id' => $ticket->id, 'deleted' => 0])->get();
        $ticket->tasks  = Task::with(['user', 'status', 'department'])->where('ticket_id', $ticket->id)->get();
        foreach ($subTickets as $sub_ticket) {
            $sub_ticket['tasks']  = Task::with(['user', 'status', 'department'])->where('ticket_id', $sub_ticket->id)->get();
        }
        $priority = Periority::all();
        return response()->json([
            'ticket' => $ticket,
            'subTickets' =>  $subTickets,
            'priority' => $priority,
            'user_dep' => $this->getUserDepartment()
        ], 200);
    }


    public function get_service_by_dep(Request $request)
    {
        $services =  Service::where(['dep_id' => $request->dep_id, 'disable' => 0, 'deleted' => 0])->get();
        return response()->json([
            'services' => $services,
        ]);
    }

    public function get_facilities_by_type(Request $request)
    {
        if ($request->type == 4 || $request->type == 8 || $request->type == 9) {
            $facility =  Facilities::where(['type_id' =>  $request->type, 'disable' => 0, 'deleted' => 0])->get();
        } else {
            $facility =  Facilities::where(['type_id' =>  $request->type,  'hid' => $request->hid, 'disable' => 0, 'deleted' => 0])->get();
        }
        return response()->json([
            'facility' => $facility,
        ]);
    }

    public function update_ticket_status(int $ticket_id, int $status)
    {
        $ticket = Ticket::find($ticket_id);
        // when Status try TO update (2 Inprogress) it mean task Will Reopen
        $task = Task::where('ticket_id', $ticket->id)->orderBy('id', 'ASC')->first();
        if ($status == 2) {
            $ticket->status_id = 2;
            $ticket->reopen = $ticket->reopen + 1;
            $ticket->Save();
            $this->RecreateTask($task);
        } else { // Confirm Task (Stats 4)
            $ticket->status_id = $status;
            $ticket->confirmed_by =  Auth::id();
            $ticket->confirmed_type = 'user';
            $ticket->confirmed_at = Carbon::now();
            $ticket->Save();
        }
        return redirect()->back()->with(['success_notify' => 'Status Change Successfully!!']);
    }
    private function RecreateTask(Task $task)
    {
        $inputs = [
            'uid' => Auth::id(),
            'hid' => $task->hid,
            'dep_id' => $task->dep_id,
            'name' => $task->name,
            'description' => $task->description,
            'ticket_id' => $task->ticket_id,
            'status_id' => 2,
            'type_id' => 6
        ];
        $task  = Task::create($inputs);
        //Add Loge
    }

    public function merge()
    {
        $merged =  Merge::all();
        foreach ($merged as $mer) {
            $name = $mer->firstname . ' ' .  $mer->lastname;
            $find  = User::where('name',  $name)->first();
            if (!$find) {
                $user = [
                    'id' => $mer->staffid,
                    'name' => $mer->firstname . ' ' .  $mer->lastname,
                    'email' => null,
                    'password' => '$2y$10$AQ5KlMge5yvNSs2PXYpLd.VfpFLucq0PLWjkXxGwp4ysPcMlqg/4q',
                    'is_admin' => 0,
                    'is_worker' => $mer->is_not_staff,
                    'can_login' => 1,
                    'in_task' => 0,
                    'disable' => 0
                ];
                User::create($user);
            }
        }
    }

    private function switchHotelS($old_h_id)
    {
        switch ($old_h_id) {
            case "5":
                return 1;
                break;
            case "7":
                return 2;
                break;
            case "3":
                return 3;
                break;
            case "2":
                return 4;
                break;
            case "6":
                return 5;
                break;
            case "4":
                return 6;
                break;
            case "1":
                return 7;
                break;
            case "9":
                return 8;
                break;
            case "10":
                return 9;
                break;
            case "9":
                return 10;
                break;
            case "20":
                return 11;
                break;
            case "22":
                return 12;
                break;
            case "23":
                return 13;
                break;
            case "24":
                return 14;
                break;
            case "25":
                return 15;
                break;
            case "26":
                return 16;
                break;
            case "21":
                return 17;
                break;
            case "27":
                return 19;
                break;
            default:
                return 0;
        }
    }



    public function notifyTicket($ticket_id, $dep_id, $hotel_id)
    {
        $users = $this->UserNotifyHotelDepartment($hotel_id, $dep_id);
        foreach ($users  as $user) {
            $user->notify((new  TicketNotification('New Ticket Created # ' . $ticket_id, $ticket_id)));
        }
    }
}
