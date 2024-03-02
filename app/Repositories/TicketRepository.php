<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository extends  MainRepository
{

    public function __construct()
    {
        parent::__construct();
        $this->model =  Ticket::class;
    }
    public function get(int $id)
    {
        return $this->model::find($id);
    }
}
