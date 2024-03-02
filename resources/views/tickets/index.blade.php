@extends('layouts.admin')
@section('content')
    <style>
        .dropdown-toggle {
            width: 350px;
            max-width: 350px;
        }
    </style>
    @include('layouts.datatable_css')
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">


    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.css') }}">


    <main id="main-container">

        <!-- Hero -->

        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="hotels">Hotels</label>
                                <select class="boot-select form-control" id="hotels" name="hid" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Hotel" multiple onchange="fillter()">
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <label for="from_time">From Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="from_time" name="from_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>

                        <div class="col-lg-3 ">
                            <label for="to_time">To Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="to_time" name="to_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="statues">Status</label>
                                <select class="boot-select form-control" id="stat" style="width: 100%;" name="statues"
                                    data-live-search="true" data-placeholder="Select Status" multiple onchange="fillter()">
                                    @foreach ($status as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Type</label>
                                <select class="boot-select form-control" id="types" name="types" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Types" multiple onchange="fillter()">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">priority</label>
                                <select class="boot-select form-control" id="priority" name="priority" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select priority" multiple
                                    onchange="fillter()">
                                    @foreach ($priority as $pro)
                                        <option value="{{ $pro->id }}">{{ $pro->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Departments</label>
                                <select class="boot-select form-control" id="department" name="department"
                                    style="width: 100%;" data-live-search="true" data-placeholder="Select department"
                                    multiple onchange="fillter()">
                                    @foreach ($Departments as $dep)
                                        <option value="{{ $dep->id }}"
                                            @if (in_array($dep->id, $user_department)) {{ 'selected' }} @endif>
                                            {{ $dep->dep_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="form-group">
                                <label for="types">Creator Type</label>
                                <select class="boot-select form-control" id="creator" name="creator" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select creator" onchange="fillter()">
                                    <option> All </option>
                                    <option value="staff"> Staff </option>
                                    <option value="guest"> Guest From App </option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            <div class="block block-rounded">
                <div class="block-header">
                    <a href="{{ route('ticket.create') }}"><button class="btn btn-primary js-swal-info" data-toggle="modal"
                            data-target="#staticBackdrop">Create
                            New Ticket <i class="fa fa-edit"></i></button></a>
                </div>
                <div class="block-content">


                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter" id="ticket"
                            style="width:100%">
                            <thead class="bg-flat-light">
                                <tr>
                                    <th>ID</th>
                                    <th> Name</th>
                                    <th>Hotel Name</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th width="19%"> At</th>
                                    <th>EndTime</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="ticket-table-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->




        {{-- @include('layouts.ticket_model.blade') --}}





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



        <script>
            getData();
        </script>
    @endpush


@stop
