@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('admin/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">


    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Users List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Users</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Dynamic Table Full -->

            <!-- END Dynamic Table Full -->

            <!-- Dynamic Table Full Pagination -->
            <div class="block block-rounded">
                <div class="block-header">
                    @if ($permission->create == 1)
                        <a href="{{ route('users.create') }}"><button class="btn btn-primary js-swal-info">Create
                                New User <i class="fa fa-edit"></i></button></a>
                    @endif
                    {{-- <h3 class="block-title">Hotel List</small></h3> --}}
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">ID</th>
                                <th>Name</th>
                                <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                                @if ($permission->edit == 1)
                                    <th style="width: 15%;">Action </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                @if (isset($users_data))

                                    @foreach ($users_data as $user)
                                        {{-- {{ $i++ }} --}}
                                        <td class="text-center font-size-sm">{{ $user->id }}</td>
                                        <td class="font-w600 font-size-sm">{{ $user->name }}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{ $user->email }}</em>
                                        </td>
                                        @if ($permission->edit == 1)
                                            <td>
                                                {{-- <div class="col-5"> --}}
                                                <a href="{{ route('users.view', $user->id) }}"><button
                                                        class="btn btn-primary js-swal-info"><i
                                                            class="fa fa-eye"></i></button></a>
                                                {{-- </div> --}}
                                                @if (Auth::user()->is_admin == 1)
                                                    <i id="user_stats-{{ $user->id }}">
                                                        @if ($user->disable == 0)
                                                            <a onclick="userStatus({{ $user->id }},  1)"><button
                                                                    class="btn btn-success js-swal-info"><i
                                                                        class="fa fa-user"></i></button></a>
                                                        @else
                                                            <a onclick="userStatus({{ $user->id }},  0)"><button
                                                                    class="btn btn-danger js-swal-info"><i
                                                                        class="fa fa-user-slash"></i></button></a>
                                                        @endif
                                                    </i>
                                                @endif

                                            </td>
                                        @endif
                </div>

                </td>

                </tr>
                @endforeach
                @endif


                </tbody>
                </table>
            </div>
        </div>

        <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->




        <div class="modal fade confirmation" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Hotel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('hotel.save') }}" enctype="multipart/form-data">
                            @csrf
                            <label>Hotel Name</label>
                            <input type="text" class="form-control" name="hotel_name">
                            <br>
                            <label>Hotel Code</label>
                            <input type="text" class="form-control" name="code">
                            <br>
                            <label>Guest Template </label>
                            {{-- <small>Select Template For This Hotel</small> --}}

                            <br>
                            <label>Hotel Logo</label>
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                    id="example-file-input-custom" name="logo">
                                <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
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
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/pages/be_tables_datatables.min.js') }}"></script>

        <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/jquery-ui.js') }}"></script>

        <script>
            jQuery(function() {

                One.helpers(['select2', 'datepicker', ]);
            });
        </script>
        <script>
            function userStatus(user_id, status) {
                url = "{{ route('users.disable') }}"
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user_id": user_id,
                        "status": status
                    },
                    success: function(data) {
                        $('#user_stats-' + user_id + '').empty()
                        if (data.user_status == 0) {
                            $('#user_stats-' + user_id + '').append(
                                '<a onclick="userStatus(' + data.user_id +
                                ',  1)"><button class="btn btn-success js-swal-info"><i class="fa fa-user"></i></button></a>'
                            );
                            One.helpers('notify', {
                                type: 'success',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        } else {
                            $('#user_stats-' + user_id + '').append(
                                '<a onclick="userStatus(' + data.user_id +
                                ',  0)"><button class="btn btn-danger js-swal-info"><i class="fa fa-user-slash"></i></button></a>'
                            );
                            One.helpers('notify', {
                                type: 'danger',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        }

                    }
                });


            }
        </script>
    @endpush
@stop
