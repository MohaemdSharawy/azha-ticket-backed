<div>
<section>
    <h3>Ordering </h3>
    <div class="form-group">
        <label for="example-ltf-email2">Order Serial</label>
        <input type="text" class="form-control " wire:model.live="serial"
            id="example-ltf-email2" name="name" placeholder="Search Serial" required><div id="faq1" class="mb-5" role="tablist" aria-multiselectable="true">
    </div>
    @foreach ($transactions as $transaction )

    <div class="block block-rounded block-bordered mb-1 ">
        <div class="block-header block-header-default bg-primary-darker" role="tab" id="faq1_h3" data-toggle="collapse" href="#faq1_q3-{{$transaction->id}}">
            <a style="color:white ! important;" class="text-muted collapsed"   data-parent="#faq1"  aria-expanded="false" aria-controls="faq1_q3">Order  {{$transaction->serial}} </a>
        </div>
        <div id="faq1_q3-{{$transaction->id}}" class="collapse" role="tabpanel" aria-labelledby="faq1_h3" data-parent="#faq1">
            <div class="block-content">
                @php
                    $count = 1;
                @endphp
                @foreach ($transaction->tickets as $ticket )
                <p>
                    <spna>{{$count}}- </span>
                    Ticket Serial #{{$ticket->id}}

                    <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit Client" onclick="ViewTicket(`{{$ticket->id}}`)">
                        <i class="fa fa-eye"></i>
                    </button>
                </p>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>

</section>



</div>
