<?php

namespace App\Livewire\PaymentRequest;

use App\Models\Payment_request;
use App\Traits\General;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PaymentList extends Component
{

    use  WithPagination, WithoutUrlPagination, General;


    public $search;

    public $limit = 10;

    public function render()
    {
        $data['payments'] = Payment_request::search($this->search)->whereIn('unite_id' , $this->get_units_in_user_properties())
            ->orderBy('id', 'DESC')->paginate($this->limit);
        return view('livewire.payment-request.payment-list', $data);
    }
}
