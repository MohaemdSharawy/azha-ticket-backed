<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotels;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\tickets;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoard extends Controller
{
    use General;

    public function index()
    {
        $status = [1, 2, 5];
        $my_current_task =  Task::where(['worker_id' => Auth::id(), 'status_id' => 2, "ticket_id" => null])->count();
        $my_finish_task =  Task::whereMonth('created_at', date('m'))->where(['worker_id' => Auth::id(), 'status_id' => 3])->count();
        $finish_ticket = Ticket::whereMonth('created_at', date('m'))->whereIn('status_id', [3, 4])->whereIn('to_dep', $this->getUserDepartment())
            ->whereIn('hid', $this->getUserHotel())->count();
        $created_ticket = Ticket::whereMonth('created_at', date('m'))->whereIn('to_dep', $this->getUserDepartment())
            ->whereIn('hid', $this->getUserHotel())->count();
        $last_tasks = Task::orderBy("id", "DESC")->where(["ticket_id" => null])->whereIn('status_id', $status)
            ->whereIn('hid', $this->getUserHotel())->whereIn('dep_id', $this->getUserDepartment())->limit(10)->get();
        $last_tickets = Ticket::orderBy("id", "DESC")->where(['master_id' => null])->whereIn('status_id', $status)
            ->whereIn('hid', $this->getUserHotel())->whereIn('to_dep', $this->getUserDepartment())->limit(10)->get();

        // Chart data
        $h_code =  [];
        $admin_request = [];
        $guest_request = [];
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->get();
        foreach ($hotels as $hotel) {
            array_push($h_code, $hotel->code);
            array_push($admin_request, Ticket::whereYear('created_at', date('Y'))->whereIn('type_id', [2, 3, 4])->where(['master_id' => null,  'hid' => $hotel->id])->count());
            array_push($guest_request, Ticket::whereYear('created_at', date('Y'))->where(['master_id' => null,  'hid' => $hotel->id,  'type_id' => 1])->count());
        }
        $h_code =  json_encode($h_code);
        $admin_request = json_encode($admin_request);
        $guest_request = json_encode($guest_request);
        return view(
            'dashboard',
            compact(
                'my_current_task',
                'my_finish_task',
                'finish_ticket',
                'created_ticket',
                'last_tasks',
                'last_tickets',
                'h_code',
                'admin_request',
                'guest_request'
            )
        );
    }
}
