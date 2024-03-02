<?php

namespace App\Livewire\Posts;

use App\Models\Posts;
use App\Traits\General;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination, General;

    public $limit = 10;

    public $search;


    public function delete($id)
    {
        $post = Posts::find($id);
        $post->deleted = 1;
        $post->save();
    }

    public function render()
    {
        $data['posts'] = Posts::search($this->search)->where(['deleted' => 0])->whereIn('hotel_id',  $this->getUserHotels())
            ->orderBy('id', 'DESC')->paginate($this->limit);
        return view('livewire.posts.index', $data);
    }
}
