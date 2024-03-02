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
                    <div class="col-6"></div>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Worker</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">

            <div class="block block-rounded">
                <div class="block-header">
                    <a><button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#staticBackdrop">Create
                            New Worker <i class="fa fa-edit"></i></button></a>
                </div>

                <div class="block-content block-content-full">
                    <table class="table  table-striped table-vcenter  " id="ticket" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>

                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->
    </main>


    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                        <br>
                        <label>Hotels</label>
                        <select class="custom-select " name="h_id" required data-live-search="true" id="h_id">
                            <option></option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <br>
                        <label>Department</label>
                        <select class="custom-select" name="dep_id" required data-live-search="true">
                            <option>-----</option>
                            @foreach ($deps as $dep)
                                <option value=" {{ $dep->id }}">{{ $dep->dep_name }}</option>
                            @endforeach
                        </select>
                        <br><br>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="" id="have_user"
                                    name="have_user" onchange="haveUser()">
                                <label class="form-check-label" for="have_user">Have User</label>
                            </div>
                        </div>
                        <div class="form-group" id="user_select">

                            <label>Users</label>
                            <select class="custom-select" name="uid" required data-live-search="true" id="uid">

                            </select>
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




    @push('scripts')
        @include('layouts.datatable')
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

        <script>
            jQuery(function() {

                One.helpers(['flatpickr', 'select2', 'datepicker']);
            });
        </script>
        <script>
            function getData() {
                $("#user_select").hide();
                hotels = $('#hotels').val();
                $.ajax({
                    url: "{{ route('workers.data') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        hotels,
                    },
                    success: function(data) {
                        $('#ticket').DataTable({
                            "data": data.ticket,
                            "responsive": true,
                            "columns": [{
                                    "data": "id",
                                },

                            ]
                        })
                    }
                })
            }


            function haveUser() {
                let hid = $("#h_id").val();
                if (hid != '') {
                    getUsers(hid);
                } else {
                    $('#have_user').prop('checked', false);
                    alert('Please Select Hotel First')
                }

                // var hotel = $('#hid').val();


            }

            function getUsers(hid) {
                $('#user_select').show();
                $.ajax({
                    url: "{{ route('workers.users') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        hid,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);
                    }
                })
            }

            getData()
        </script>
    @endpush


@stop
