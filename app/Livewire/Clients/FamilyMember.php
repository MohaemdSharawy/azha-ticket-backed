<?php

namespace App\Livewire\Clients;

use App\Models\Clients;
use Livewire\Component;

class FamilyMember extends Component
{

    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }


    public function change_status(){
    }

    public function render()
    {
        $data['family_members'] =  Clients::where(['master_id' => $this->id])->get();
        return view('livewire.clients.family-member', $data);
    }
}
