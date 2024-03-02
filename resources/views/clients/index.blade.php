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
                <br>
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">

                    <div class="row">
                        <div class="col-lg-5 ">
                            <div class="form-group">
                                <label for="hotels">Property</label>
                                <select class="js-select2 form-control" id="hotels" name="hid" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Hotel" multiple onchange="fillter()">
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 ">
                            <label for="from_time">From Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="from_time" name="from_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>

                        <div class="col-lg-5 ">
                            <label for="to_time">To Date</label>
                            <input type="text" class="js-flatpickr form-control bg-white" id="to_time" name="to_time"
                                placeholder="Y-m-d" onchange="fillter()">
                        </div>
                        <div class="col-lg-5 ">
                            <div class="form-group">
                                <label for="types">Role</label>
                                <select class="js-select2 form-control" id="types" name="types" style="width: 100%;"
                                    data-live-search="true" data-placeholder="Select Types" multiple {{-- onchange="fillter()" --}}>
                                    <option value="owner">Owner</option>
                                    <option value="family_member">Family Member</option>
                                    <option value="tenant">Tenant</option>
                                </select>
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
                    <h3>Clients</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-borderless table-striped table-vcenter " id="clients"
                            style="width:100%">
                            <thead class="bg-flat-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                        </table>
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
        @include('clients.scripts')
    @endpush


@stop
