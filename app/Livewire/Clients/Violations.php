<?php

namespace App\Livewire\Clients;

use App\Models\Units;
use App\Models\Violations as ModelsViolations;
use Livewire\Component;

class Violations extends Component
{


    public $id;


    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $data['units_ids'] =  Units::where('owner_id' , $this->id)->pluck('id')->toArray();
        $data['violations'] = ModelsViolations::with(['Unite' , 'V_Action' ,'Status'])->whereIn('unite_id', $data['units_ids'])->get();
        return view('livewire.clients.violations' ,$data);
    }
}
