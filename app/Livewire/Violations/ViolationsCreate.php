<?php

namespace App\Livewire\Violations;

use App\Models\Units;
use App\Models\Violations;
use App\Models\Violations_actions;
use App\Models\Violations_files;
use App\Traits\General;
use Livewire\Attributes\On;
use Livewire\Component;

class ViolationsCreate extends Component
{

    use General;

    public $action_id;

    public $cost;

    public $unite_id;
    public array $photos = [];

    #[On('add_doc')]
    public function add_doc($name){
        array_push($this->photos,  $name);
    }

    #[On('del_doc')]
    public function del_doc($name){
        $key = array_search($name ,$this->photos);
        unset($this->photos[$key]);
    }


    public function select_action($value)
    {
        $action = Violations_actions::find($value);
        $this->cost  = ($action) ? $action->cost : 0;
    }


    public function save(){
        $violation = Violations::create([
            'action_id' => $this->action_id,
            'unite_id' => $this->unite_id,
            'cost' => $this->cost,
            'status_id' => 11,
        ]);
        foreach($this->photos  as $file){
            Violations_files::create([
                'violation_id'=>$violation->id,
                'file' => $file
            ]);
        }
        return redirect()->route('violations.create')->with(['success_notify' => 'Violation Added Successfully!!']);
    }


    public function render()
    {
        $data['actions'] =  Violations_actions::where(['deleted' => 0])->get();
        $data['unites']  = Units::whereIn('hotel_id', $this->getUserHotels())->where('deleted', 0)->get();
        return view('livewire.violations.violations-create', $data);
    }
}
