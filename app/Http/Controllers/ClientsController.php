<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Clients_property;
use App\Models\Hotels;
use App\Models\Orders;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotels::whereIn('id', $this->getUserHotel())->where(['deleted' => 0])->get();
        return view('clients.index', compact('hotels'));
    }


    public function index_data(Request $request)
    {
        // TODO Filter By Property
        if ($request->ajax()) {
            $from = date('Y-m-d', strtotime($request->from_time . ' - 1 days'));
            $to = date('Y-m-d', strtotime($request->to_time . ' + 1 days'));
            // $clients = Clients::whereBetween('created_at', [$from, $to])->get();
            $clients = Clients::all();
            // if (isset($request->status_ids)) {
            //     $tickets->whereIn('status_id', $request->status_ids);
            // }
            return response()->json([
                'clients' => $clients,
            ]);
        } else {
            abort(403);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {


        $data['client_property']  = Clients_property::where(['client_id' => $id])->pluck('hotel_id')->toArray();
        $data['hotels'] =  Hotels::whereIn('id' ,  $data['client_property']  )->get();
        $data['client'] =  Clients::find($id);

        // $data['payment_cost'] =

        // $data['tickets'] = Ti
        // dd($data);

        // $data['orders'] = Orders::with(['Tickets'])->where(['client_id'=>  $id  , 'deleted'=> 0])->get();
        // $data['tickets']  = $data['orders']->Tickets->paginate(5);
        return view('clients.edit' , $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
