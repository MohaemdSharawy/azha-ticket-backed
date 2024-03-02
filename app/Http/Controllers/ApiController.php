<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hotels;
use App\Models\MetaData;
use App\Models\RoomData;
use App\Models\Service;
use App\Models\Task;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Events\RealTimePush;


class ApiController extends Controller
{
    public function getDepartmentService($lang = 'en')
    {

        $this->setLang($lang);
        // $category_service = MetaData::where(['key_word' => 'service_category'])->get();
        $category_service = Department::where(['deleted' => 0, 'guest' => 1])->get();
        return response()->json([
            'department_service' => $category_service,
        ], 200);
    }

    public function guestService($lang = 'en', $department_id = false)
    {

        $this->setLang($lang);
        $services = Service::where(['guest' => 1, 'deleted' => 0, 'disable' => 0,]);
        if ($department_id) {
            $services = Service::where(['guest' => 1, 'deleted' => 0, 'disable' => 0, 'type' => $department_id]);
        }
        $result = $services->get();
        return response()->json([
            'services' => $result,
        ], 200);
    }




    public function create_ticket(Request $request)
    {
        $services  = Service::find($request->service_id);
        // return response()->json([
        //     'result' =>  $request->all()
        // ], 500);
        try {

            $find_room =  RoomData::where(['room_num' => $request->room_num, 'conf_num' => $request->conf_num,  'hid' => $request->hid])->first();
            if ($find_room) {
                $room  = $find_room->id;
            } else {
                $create_room =  RoomData::create([
                    'guest_name' => $request->guest_name,
                    'conf_num' => $request->conf_num,
                    'room_num' => $request->room_num,
                    'hid' => $request->hid
                ]);
                $room = $create_room->id;
            }
            $inputs = [
                'hid' => $request->hid,
                'room_id' => $room,
                'to_dep' => $services->dep_id,
                'service_id' => $request->service_id,
                'type_id' => 1,
                'description' => $request->description,
                'status_id' => 1,
                'priority_level' => 1
            ];
            $add  = Ticket::create($inputs);
            Task::create([
                'uid' => 0,
                'dep_id' => $services->dep_id,
                'hid'  => $request->hid,
                'name' =>  $services->name,
                'description' => $request->description,
                'ticket_id' => $add->id,
                'time' => '00:00',
                'status_id' => 1,
                'type_id' => 7
            ]);
            try {
                RealTimePush::dispatch('New Task Added');
                $hotel  = Hotels::find($request->hid);
                if ($hotel->phone) {
                    $message  = 'New Ticket Create : https://tickets.sunrise-resorts.com/ticket/show-model/' . $add->id;
                    whatsapp($hotel->phone, $message);
                }
            } catch (\Exception $exception) {
                //
            }
            return response()->json([
                'result' =>  $add
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'result' => $request->all()
            ], 500);
        }
    }

    public function upgrade_priority($ticket_id, Request $request)
    {
        $ticket = Ticket::find($ticket_id);
        $ticket_id->priority_level =  $request->priority_level;
        $ticket->save();
        return response()->json([
            'ticket' => $ticket
        ], 200);
    }

    public function confirm_ticket($ticket_id)
    {
        $ticket  = $this->update_status($ticket_id, 4);
        try {
            RealTimePush::dispatch('Guest COnfirm Ticket #' . $ticket_id);
        } catch (\Exception $exception) {
            //
        }
        return response()->json([
            'ticket' => $ticket
        ]);
    }

    public function reopen_ticket($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if ($ticket->status_id == 4) {
            return response()->json([
                'message' => 'Sorry You Cant Reopen Confirmed Ticket Please Create New One'
            ], 500);
        }
        $this->update_status($ticket_id, 2);
        $ticket->reopen = $ticket->reopen + 1;
        $ticket->save();
        $tasks_ids =  Task::pluck('id')->where(['ticket_id' => $ticket_id])->toArray();
        foreach ($tasks_ids as $task_id) {
            $task = Task::find($task_id);
            $task->status_id  = 2;
            $task->save();
        }

        try {
            RealTimePush::dispatch('Guest Reopen Ticket #' . $ticket_id);
        } catch (\Exception $exception) {
            //
        }
        return response()->json('Updated Successfully');
    }

    private function update_status($ticket_id, $status)
    {
        $ticket = Ticket::find($ticket_id);
        $ticket->status_id =  $status;
        $ticket->save();
        return response()->json([
            'ticket' => $ticket
        ], 200);
    }

    public function update_ticket($ticket_id, Request $request)
    {
        $row = Ticket::find($ticket_id);
        $row->update($request->all());
        return response()->json([
            'ticket' => $row
        ], 200);
    }

    private function setLang($lang)
    {
        $GLOBALS['lang'] = $lang;
    }

    public function GuestTickets($hid, $room_num,  $conf_num,  $lang = 'en')
    {
        $this->setLang($lang);
        $room =   RoomData::where(['room_num' => $room_num, 'conf_num' => $conf_num, 'hid' => $hid])->first();
        if ($room) {
            $tickets = Ticket::with('services', 'to_department', 'status')->where(['room_id' => $room->id, 'deleted' => 0])->orderBy('id', 'DESC')->get();
        } else {
            $tickets = [];
        }


        return response()->json([
            'tickets' => $tickets
        ]);
    }
}
