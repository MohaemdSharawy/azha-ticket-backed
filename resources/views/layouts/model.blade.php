<div class="modal fade confirmation viewTicket" id="viewTicketz" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl ">
        <div class="modal-content">
            <div class="modal-header block-header bg-flat-light">
                <h5 class="modal-title" id="TicketTittle" style="color: black;">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: black;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="" style="padding-left : 20px; padding-top :20px; ">
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ticket-taps" href="#btabs-animated-fade-home" id="master-ticket"
                                onclick="ToggleTicket()">Master
                                Ticket</a>
                        </li>

                        <ul class="sub-tabs nav nav-tabs nav-tabs-block">
                        </ul>
                        <li class="nav-item ml-auto">
                            <div class="block-options pl-3 pr-2">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="fullscreen_toggle"></button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="content_toggle"></button>

                            </div>
                        </li>
                    </ul>
                    <div class="block-content tab-content overflow-hidden" id="tab-master-content">
                        <div class="tab-pane fade show active " id="btabs-animated-fade-home" role="tabpanel">
                            @include('tickets.details')

                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </div>
        </div>
    </div>
</div>



<div class="modal fade confirmation viewTask" id="viewTask" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl ">
        <div class="modal-content">
            <div class="modal-header block-header bg-flat-light">
                <h5 class="modal-title" id="TicketTittle" style="color: black;">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: black;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="TaskBody">

            </div>

            {{-- <div class="" style="padding-left : 20px; padding-top :20px; ">
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active ticket-taps" href="#btabs-animated-fade-home"
                            id="master-ticket" onclick="ToggleTicket()">Master
                            Ticket</a>
                    </li>

                    <ul class="sub-tabs nav nav-tabs nav-tabs-block">
                    </ul>
                    <li class="nav-item ml-auto">
                        <div class="block-options pl-3 pr-2">
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="content_toggle"></button>

                        </div>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden" id="tab-master-content">
                    <div class="tab-pane fade show active " id="btabs-animated-fade-home" role="tabpanel">
                        @include('tickets.details')

                    </div>


                </div>
            </div>
        </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
            </div>
        </div>
    </div>
</div>
