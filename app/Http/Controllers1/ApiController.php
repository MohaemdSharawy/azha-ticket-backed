<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\MetaData;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getDepartmentService($lang = 'en')
    {
        $GLOBALS['lang'] = $lang;
        // $category_service = MetaData::where(['key_word' => 'service_category'])->get();
        $category_service = Department::where(['deleted' => 0, 'guest' => 1])->get();
        return response()->json([
            'department_service' => $category_service,
        ], 200);
    }

    public function guestService($lang = 'en', $department_id = false)
    {

        $GLOBALS['lang'] = $lang;
        $services = Service::where(['guest' => 1, 'deleted' => 0, 'disable' => 0,]);
        if ($department_id) {
            $services->where(['dep_id' => $department_id]);
        }
        $result = $services->get();
        return response()->json([
            'services' => $result,
        ], 200);
    }




    public function create_ticket(Request $request)
    {
        $services  = Service::find($request->service_id);
        $inputs = [
            'hid' => $request->hid,
            'to_dep' => $services->dep_id,
            'service_id' => $request->service_id,
            'type_id' => 1,
            'description' => $request->description,
            'status_id' => 1,
            'priority_level' => $request->priority_level
        ];
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
        return response()->json([
            'ticket' => $ticket
        ]);
    }

    public function reopen_ticket($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if ($ticket->status == 4) {
            return response()->json([
                'message' => 'Sorry You Cant Reopen Confirmed Ticket Please Create New One'
            ], 500);
        }
        return $this->update_status($ticket_id, 5);
    }

    private function update_status($ticket_id, $status)
    {
        $ticket = Ticket::find($ticket_id);
        $ticket->status =  4;
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
}
