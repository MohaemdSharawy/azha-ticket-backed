@extends('layouts.admin')
@section('content')

    @include('layouts.datatable_css')
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">


    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.css') }}">


    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="custom-control custom-switch mb-1">
                    <input type="checkbox" class="custom-control-input my_task" id="example-switch-custom1" name="can_login"
                        value="1" onchange="fillter()" checked>
                    <label class="custom-control-label" for="example-switch-custom1">
                        My Tasks
                    </label>
                </div>
                <br>
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">

                    <div class="row">
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label for="hotels">Hotels</label>
                                <select class="js-select2 form-control" id="hotels" name="hid" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Hotel" multiple onchange="fillter()">
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <label for="from_time">From Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="from_time" name="from_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>

                        <div class="col-lg-4 ">
                            <label for="to_time">To Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="to_time" name="to_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label for="hotels">Status</label>
                                <select class="js-select2 form-control" id="status" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Status" multiple onchange="fillter()">
                                    @foreach ($status as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                <label for="types">Type</label>
                                <select class="js-select2 form-control" id="types" name="types" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Types" multiple onchange="fillter()">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="form-group">
                                {{-- <label for="types">priority</label>
                                <select class="js-select2 form-control" id="priority" name="priority" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select priority" multiple
                                    onchange="fillter()">
                                    @foreach ($priority as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                        </div>
                    </div>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Task</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="block block-rounded">
                <div class="block-header">
                    <button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#createTask">Create
                        New Task <i class="fa fa-edit"></i></button>
                </div>
                <div class="block-content">


                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter " id="ticket"
                            style="width:100%">
                            <thead class="bg-flat-light">
                                <tr>
                                    <th>ID</th>
                                    <th> Name</th>
                                    <th>Hotel Name</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->



        <div class="modal fade confirmation viewTask" id="viewTask" data-backdrop="static" data-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-xl ">
                <div class="modal-content">
                    <div class="modal-header block-header bg-flat-light">
                        <h5 class="modal-title" id="TicketTittle" style="color: black;">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: black;">
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
        {{-- Create Model --}}
        <div class="modal fade" id="createTask" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content">
                    <div class="modal-header bg-flat-light">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: black;">Add New Hotel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('hotel.save') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="uid" value="{{ Auth::id() }}">
                            <input type="hidden" name="uid" value="1">
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label for="hotels">Hotels*</label>
                                    <select class="js-select2 form-control" style="width: 100%;" data-live-search="true"
                                        data-placeholder="Select Status" required>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label for="hotels">Department*</label>
                                    <select class="js-select2 form-control" style="width: 100%;" data-live-search="true"
                                        data-placeholder="Select Status" required>
                                        @foreach ($departments as $dep)
                                            <option value="{{ $dep->id }}">{{ $dep->dep_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 ">
                                <div class="form-group">
                                    <label for="hotels">Describtion*</label>
                                    <textarea id="js-ckeditor5-classic" name="description"></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </main>



    @push('scripts')
        @include('layouts.datatable')
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/jquery-ui.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>

        <script>
            jQuery(function() {

                One.helpers(['flatpickr', 'select2', 'datepicker', 'ckeditor5']);
            });
        </script>
        @include('tasks.scripts')
        <script>
            getData();
        </script>
    @endpush


@stop
