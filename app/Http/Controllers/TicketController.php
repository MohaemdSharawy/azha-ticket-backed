<?php

namespace App\Http\Controllers;

use App\Events\RealTimePush;
use App\Http\Requests\TicketRequest;
use App\Mail\DesignRequestEmail;
use App\Mail\GscDaily;
use App\Mail\NotifyMail;
use App\Models\Attachment;
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
use App\Models\TicketComment;
use App\Models\User;
use App\Models\UserDepartment;
use App\Notifications\TicketNotification;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $Departments  = Department::all();
        $user_department = $this->getUserDepartment();
        return view('tickets.index', compact('hotels', 'status', 'types', 'priority', 'Departments', 'user_department'));
    }


    public function index_data(Request $request)
    {
        if ($request->ajax()) {
            $from = date('Y-m-d', strtotime($request->from_time . ' - 1 days'));
            $to = date('Y-m-d', strtotime($request->to_time . ' + 1 days'));
            $tickets = Ticket::with(['hotels' => function ($q) {
                $q->select('hotel_name', 'id');
            }, 'status', 'level', 'room', 'facility', 'to_department', 'services', 'task'])->whereIn('hid', $this->getUserHotel())->where(['deleted' => 0, 'master_id' => null])
                ->whereBetween('created_at', [$from, $to]);
            if (isset($request->hotels)) {
                $tickets->whereIn('hid', $request->hotels);
            }
            if (isset($request->status_ids)) {
                $tickets->whereIn('status_id', $request->status_ids);
            }

            if (isset($request->types)) {
                $tickets->whereIn('type_id', $request->types);
            }
            if (isset($request->department)) {
                $tickets->whereIn('to_dep', $request->department);
            }
            if (isset($request->creator)) {
                if ($request->creator == 'guest') {
                    $tickets->whereNull('uid');
                } elseif ($request->creator == 'staff') {
                    $tickets->whereNotNull('uid');
                }
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
        if ($request->dep == "15" || $request->dep == "16") {
            $inputs['design_task'] = $request->design_task;
            $inputs['design_size'] = $request->design_size;
        }
        if ($request->type_id == "1") {
            $find_room =  RoomData::where(['room_num' => $request->room, 'conf_num' => $request->reservation_no, 'hid' => $request->hid])->first();
            // dd($find_room->id);
            if ($find_room) {
                $room = $find_room->id;
            } else {
                $new_room = RoomData::create([
                    'room_num' => $request->room,
                    'guest_name' => $request->guest_name,
                    'conf_num' => $request->reservation_no,
                    'hid' => $request->hid
                ]);
                $room =  $new_room->id;
            }
            // $room = RoomData::create([
            //     'room_num' => $request->room,
            //     'guest_name' => $request->guest_name,
            //     'conf_num' => $request->reservation_no,
            //     'hid' => $request->hid
            // ]);
            $inputs['room_id'] = $room;
        } else {
            $inputs['facility_id'] = $request->facility_id;
        }
        // dd($inputs);

        $add =  Ticket::create($inputs);
        if ($add) {
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Attachment::create([
                        'form_id' => $add->id,
                        'module_id' => 10,
                        'file' => $image,
                    ]);
                }
            }
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

        if ($request->dep == "15" || $request->dep == "16") {
            $data['attach'] = [];
            $data['subject'] =  'New Design Request Created';
            $data['url'] = $_SERVER["HTTP_HOST"] . '/ticket/show-model/' . $add->id;
            $data['to'] = $this->get_user_emails($request->dep);
            $data['message']  = 'New Design Request  ';
            if (count($data['to']) > 0) {
                Mail::send(new GscDaily($data));
            }
        }

        if (in_array($request->hid, $this->getUserHotel())) {
            RealTimePush::dispatch('New Task Added');
        }
        $this->notifyTicket($add->id, $add->hid, $add->to_dep);
        return redirect()->route('ticket')->with(['success_notify' => 'New Ticket Add Successfully!!']);
    }




    public function show($id)
    {
        $show_queue =  false;
        $queue_count = 0;
        $this->readFromNotification('App\Notifications\TicketNotification', $id);
        $ticket = Ticket::withCount('TicketComments')->with(['Attachment', 'hotels', 'to_department', 'services', 'status', 'level', 'facility', 'room', 'users'])->where(['id' => $id])->first();
        if (!$ticket) {
            return response()->json([
                'message' => 'Sorry Ticket #' . $id .  ' Is Not Existed'
            ], 500);
        }
        if (!is_null($ticket->master_id)) {
            $ticket = Ticket::withCount('TicketComments')->with(['Attachment', 'hotels', 'to_department', 'services', 'status', 'level', 'facility', 'room', 'users'])->where(['id' => $ticket->master_id])->first();
        }
        $subTickets = Ticket::withCount('TicketComments')->with(['hotels', 'to_department', 'services', 'status', 'level', 'facility', 'room',  'users'])->where(['master_id' => $ticket->id, 'deleted' => 0])->get();
        $ticket->tasks  = Task::with(['user', 'status', 'department'])->where('ticket_id', $ticket->id)->get();
        foreach ($subTickets as $sub_ticket) {
            $sub_ticket['tasks']  = Task::with(['user', 'status', 'department'])->where('ticket_id', $sub_ticket->id)->get();
        }
        $priority = Periority::all();
        if ($ticket->to_dep == "15") {
            $show_queue = true;
            $queue_count  =  Ticket::where(['deleted' => 0, 'to_dep' => 15, 'master_id' => null])->where('id', '<', $ticket->id)->whereIn('status_id', [1, 2, 5])->count();
        }

        return response()->json([
            'ticket' => $ticket,
            'subTickets' =>  $subTickets,
            'priority' => $priority,
            'user_dep' => $this->getUserDepartment(),
            'show_queue' => $show_queue,
            'queue_count' => $queue_count
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
        if ($request->type == 4 || $request->type == 8 || $request->type == 9 || $request->type == 10) {
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
        return response()->json([
            'message' => 'Status Change Successfully!!',
        ]);
        // return redirect()->back()->with(['success_notify' => 'Status Change Successfully!!']);
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

    //////////////////////////
    /// Comment On Ticket ///
    ///////////////////////


    public function ticketComments($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if ($ticket->status_id == 1) {
            return redirect()->route('ticket.show.model', $ticket_id)->with(['failed_notify' => 'Must Assign Worker Before Open Comment']);
        }
        $comments =  TicketComment::where(['ticket_id' => $ticket_id, 'deleted' => 0])->orderBy('id', 'DESC')->get();
        $all_tasks = Task::where(['ticket_id' => $ticket_id, 'deleted' => 0])->count();
        $in_dep = in_array($ticket->to_dep, $this->getUserDepartment());
        return view('tickets.comments', compact('ticket_id', 'comments', 'all_tasks', 'in_dep', 'ticket'));
    }

    public function createComment(Request $request)
    {
        $add =  TicketComment::create($request->all());
        if ($request->has('document') && count($request->document) > 0) {
            foreach ($request->document as $image) {
                Attachment::create([
                    'form_id' => $add->id,
                    'module_id' => 9,
                    'file' => $image,
                ]);
            }
        }
        return redirect()->back()->with(['success_notify' => 'Comment Create Successfully !!']);
    }

    /*
    #
    #
    #
    #      Send Comment Mails
    #
    #
    */
    private function CommentHandelToMail($comment_id): array
    {
        $comment = TicketComment::with('CommentAttachment')->where('id', $comment_id)->first();
        $mail_attachment = [];
        foreach ($comment->CommentAttachment as $attach) {
            array_push($mail_attachment,   public_path('/uploads/attach/' . $attach->file));
        }
        return [
            'mail_to' => $comment->Ticket->users,
            'mail_attach' => $mail_attachment,
            'message' => $comment->comment,
            'ticket_id' => $comment->ticket_id
        ];
    }


    private function SendMail($to,  $data)
    {
        Mail::to($to)->send(new DesignRequestEmail($data));
        try {
            return redirect()->back()->with(['success_notify' => 'Mail Send Successfully !!']);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed_notify' => 'Something Wrong Happened While Sending Mail !!']);
        }
    }

    public function notify_comment($comment_id)
    {

        $comment = $this->CommentHandelToMail($comment_id);
        $data =  [
            'subject' => 'Mail Comment For Ticket # ' . $comment['ticket_id'],
            'message' => $comment['message'],
            'attach' => $comment['mail_attach'],
            'url'  => $_SERVER["HTTP_HOST"] . '/ticket/show-model/' . $comment['ticket_id']
        ];
        return $this->SendMail($comment['mail_to'], $data);
    }

    private function ConfirmAllTicketTasks($ticket_id)
    {
        $tasks =  Task::where(['ticket_id' => $ticket_id, 'deleted' => 0])->get();
        $ticket = Ticket::find($ticket_id);
        $updates = [
            'end_at' => Carbon::now(),
            'end_by' => Auth::id(),
            'status_id' => 3,
        ];
        $ticket->update($updates);

        foreach ($tasks  as $task) {
            $row = Task::find($task->id);
            $row->end_at = Carbon::now();
            $row->end_by = Auth::id();
        }
    }


    public function notify_comment_with_confirm($comment_id)
    {
        $comment = $this->CommentHandelToMail($comment_id);
        $data = [
            'subject' => 'Mail Confirmed For Ticket # ' . $comment['ticket_id'],
            'message' => $comment['message'],
            'attach' => $comment['mail_attach'],
            'url'  => $_SERVER["HTTP_HOST"] . '/ticket/show-model/' . $comment['ticket_id']
        ];
        $this->ConfirmAllTicketTasks($comment['ticket_id']);
        return  $this->SendMail($comment['mail_to'], $data);
    }


    private function get_user_department_ids(int $department_id)
    {
        $users = UserDepartment::where(['dep_id' => $department_id])->pluck('user_id')->toArray();
        return $users;
    }

    private function get_user_emails($department_id)
    {
        return User::whereIn('id', $this->get_user_department_ids($department_id))->get()->whereNotNull('email')->pluck('email')->toArray();
    }
}
