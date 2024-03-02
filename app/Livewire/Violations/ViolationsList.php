<?php

namespace App\Livewire\Violations;

use App\Models\MetaData;
use App\Models\Violations;
use App\Models\Violations_actions;
use App\Traits\General;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ViolationsList extends Component
{

    use WithPagination, WithoutUrlPagination, General;

    public $search;

    public $selected_actions;

    public $limit = 10;


    public function update_status($violation_id , $status_id ){
        $violation =  Violations::find($violation_id);
        $violation->status_id = $status_id;
        $violation->save();
        session()->flash('success_notify', 'Statues Updated Successfully');
        $this->redirect('/violations');
    }


    public function render()
    {
        $data['violations'] = Violations::search($this->search)->with('Status')->where(['deleted' => 0])
            ->orderBy('id', 'DESC')->paginate($this->limit);

        $data['actions'] =  Violations_actions::where(['deleted' => 0])->get();
        $data['status'] =  MetaData::where(['key_word' => 'violation_status'])->get();
        return view('livewire.violations.violations-list', $data);
    }
}
