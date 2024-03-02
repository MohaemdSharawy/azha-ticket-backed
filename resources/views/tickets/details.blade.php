<div class="row">

    <div class="col-xl-8 order-xl-0">
        <div class="comments">

        </div>
        <br>

        <div class="block block-rounded">
            <div class="block-content">
                <div class="tab-pane pull-x active" id="ecom-product-info" role="tabpanel">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th colspan="2">Details</th>
                            </tr>
                        </thead>
                        <tbody class="ticket-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="attachment-data">

        </div>
        <div class="block block-rounded">
            <div class="block-content">
                <div class="tab-pane pull-x active" id="ecom-product-info" role="tabpanel">
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th colspan="2">Task</th>
                            </tr>
                        </thead>
                        <tbody class="task-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 order-xl-1">
        <!-- Categories -->
        <div class="block block-rounded js-ecom-div-nav  d-xl-block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-boxes text-muted mr-1"></i> Taks
                </h3>
            </div>
            <div class="block-content">
                <ul class="nav nav-pills flex-column push" id="tasks_tab">
                    {{-- <li class="nav-item mb-1 ">
                        <a class="nav-link active d-flex justify-content-between align-items-center nav-ticket-list"
                            href="javascript:void(0)" onclick="ToggleTicket()" id="master">
                            Master
                        </a>
                    </li> --}}
                    <div class="ticket-list"></div>
                </ul>
                <br>
                <hr>
                <div>
                    <div class="actions"></div>

                    <h4>Ticket Action</h4>
                    <div class='row'>
                        <div class="btn-group col-12">
                            <button type="button" class="btn bg-flat-light dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                Action
                            </button>
                            <div class="row">
                                <div class="dropdown-menu col-12 ">
                                    <div class="main-actions">

                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="secoud-actions">
                                        <a class="dropdown-item" href="#"> <i class="fa fa-plus-circle"> </i>
                                            Create SubTicket
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <hr>
                <div class="task-action">

                    <h4>Task Action</h4>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="create-task"></div>

<div class="sendResonse" style=" display:none;">
    <button type="button" class="close colse-reminder" onclick="closeReminder()" style="color: black;">
        <span aria-hidden="true">&times;</span>
    </button>
    <form>
        <label>Send To</label>
        <select class="js-select2 form-control" id="remder_user" style="width: 100%;" data-live-search="true"
            data-placeholder="Select Users" multiple>

        </select>
        <br>
        <br>
        <div id="js-ckeditor5-classic"></div>


    </form>
    <br>
    <br><br>

</div>
