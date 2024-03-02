<?php

namespace App\Livewire\Clients;

use Livewire\WithPagination;
use App\Models\Payment_request;
use App\Models\Units;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class FinancalPayment extends Component
{

    use WithPagination ,WithoutUrlPagination;

    public $id;

    public $type;

    public $unite;



    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {
        $data['unites'] = Units::all();
        $data['units_ids'] =  Units::where('owner_id' , $this->id)->pluck('id')->toArray();
        $data['payment_requests']  = Payment_request::with(['Unite' ])->whereIn('unite_id', $data['units_ids'])->when($this->type ,  function($query){
            $query->where('module_name' , $this->type);
        })->when($this->unite , function($que){
            $que->where('unite_id' , $this->unite);
        })->paginate(3);
        return view('livewire.clients.financal-payment', $data);
    }
}
