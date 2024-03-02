<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CustomDropzone extends Component
{
    public $folder;

    public function mount($folder){
        $this->folder =  $folder;
    }

    public function render()
    {
        $folder = $this->folder;
        return view('livewire.admin.custom-dropzone' , compact('folder'));
    }
}
