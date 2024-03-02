<?php

namespace App\Livewire\Clients;

use App\Models\Orders;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
class Transaction extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id;

    public $serial;

    public function mount($id)
    {
        $this->id = $id;
    }


    public function render()
    {
        $data['transactions']  = Orders::with(['Tickets'])->where(['client_id' =>$this->id])->when($this->serial, function($query){
            $query->where('serial','LIKE','%'.$this->serial.'%');
        })->get();
        return view('livewire.clients.transaction', $data);
    }
}
