<div>

    <div class="row">
        <div class="col-md-6">
            <label for="example-ltf-email2">Order Serial</label>
            <select class="boot-select form-control" data-live-search="true" name="hid" required wire:model.live="type">
                <option></option>
                <option value="order">ORDERS</option>
                <option value="other">other</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Serial</label>
            <select class="boot-select form-control" data-live-search="true" name="hid" required wire:model.live="unite">
                <option></option>
                @foreach ($unites as $unite  )
                <option value="{{$unite->id}}">{{$unite->unite_name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <br>
    <br>

    <div>
        <ul class="timeline timeline-alt py-0">
            @foreach ($payment_requests as $payment )
                <li class="timeline-event">
                    <div class="timeline-event-icon bg-dark">
                        <i class="fa fa-cog"></i>
                    </div>
                    <div class="timeline-event-block block js-appear-enabled animated fadeIn" data-toggle="appear">
                        <div class="block-header">
                            <h3 class="block-title">Payment</h3>
                            <div class="block-options">
                                <div class="timeline-event-time block-options-item font-size-sm">
                                    {{ $payment->created_at->diffForHumans(Carbon\Carbon::now()) }}
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <p class="font-w600 mb-2">
                                Unite: {{$payment->Unite->unite_name}}
                             </p>
                            <p class="font-w600 mb-2">
                                Amount: {{$payment->paid_amount}}  /  Pay: {{$payment->module_name}}
                            </p>
                            <p class="font-w600 mb-2">
                                @if ($payment->module_name  == 'order')
                                Serial : {{($payment->details) ? $payment->details->serial : ''}}
                               @endif
                            </p>
                            <p>
                                @if ($payment->comment)
                                    Comment  : {{$payment->comment}}
                                @endif
                            </p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    {{$payment_requests->links('vendor.livewire.bootstrap')}}
</div>
