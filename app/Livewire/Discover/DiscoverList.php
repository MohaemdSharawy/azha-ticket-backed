<?php

namespace App\Livewire\Discover;

use App\Models\Discover;
use App\Traits\General;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class DiscoverList extends Component
{
    use WithPagination, WithoutUrlPagination, General;
    public $search;
    public $limit;

    public function render()
    {
        $data['discovers'] = Discover::search($this->search)->where(['deleted' =>0])->paginate($this->limit);
        return view('livewire.discover.discover-list');
    }
}
