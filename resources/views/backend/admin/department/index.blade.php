@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/js/plugins/sweetalert2/sweetalert2.min.css">

    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Hotels List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Departments</a>
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
                    <a><button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#staticBackdrop">Create
                            New Departments <i class="fa fa-edit"></i></button></a>
                    {{-- <h3 class="block-title">Hotel List</small></h3> --}}
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">ID</th>
                                <th>Name</th>
                                <th class="d-none d-sm-table-cell" style="width: 30%;">CODE</th>
                                <th style="width: 15%;">More Details </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                @if (isset($departments))

                                    @foreach ($departments as $dep)
                                        {{-- {{ $i++ }} --}}
                                        <td class="text-center font-size-sm">{{ $dep->id }}</td>
                                        <td class="font-w600 font-size-sm">{{ $dep->dep_name }}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{ $dep->dep_code }}</em>
                                        </td>
                                        <td>
                                            <button
                                                onclick="edit_dep('{{ $dep->dep_name }}', '{{ $dep->dep_code }}' , '{{ $dep->id }}')"{{-- data-target="#edit_model" data-toggle="modal" --}}
                                                class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>
                                            <i id="dep_stats-{{ $dep->id }}">

                                                @if ($dep->deleted == 0)
                                                    <a onclick="depStatus({{ $dep->id }},  1)"><button
                                                            class="btn btn-success js-swal-info"><i
                                                                class="fa fa-check-circle"></i></button></a>
                                                @else
                                                    <a onclick="depStatus({{ $dep->id }},  0)"><button
                                                            class="btn btn-danger js-swal-info"><i
                                                                class="fa fa-window-close"></i></button></a>
                                                @endif
                                            </i>
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
    </main>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                    <form method="POST" action="{{ route('department.store') }}" enctype="multipart/form-data">
                        @csrf
                        <label>Department Name</label>
                        <input type="text" class="form-control" name="name">
                        <br>
                        <label>Department Code</label>
                        <input type="text" class="form-control" name="code">
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Model --}}

    <div class="modal fade" id="edit_model" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                    <form method="POST" action="{{ route('department.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="id" id="dep_id">
                        <label>Department Name</label>
                        <input type="text" class="form-control" name="name" id="dep_name">
                        <br>
                        <label>Department Code</label>
                        <input type="text" class="form-control" name="code" id="dep_code">
                        <br>
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
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/pages/be_tables_datatables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script>
            function depStatus(dep_id, status) {
                console.log(dep_id)
                url = "{{ route('department.disable') }}"
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "dep_id": dep_id,
                        "status": status
                    },
                    success: function(data) {
                        $('#dep_stats-' + dep_id + '').empty()
                        if (data.user_status == 0) {
                            $('#dep_stats-' + dep_id + '').append(
                                '<a onclick="depStatus(' + data.dep_id +
                                ',  1)"><button class="btn btn-success js-swal-info"><i class="fa fa-check-circle"></i></button></a>'
                            );
                            One.helpers('notify', {
                                type: 'success',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        } else {
                            $('#dep_stats-' + dep_id + '').append(
                                '<a onclick="depStatus(' + data.dep_id +
                                ',  0)"><button class="btn btn-danger js-swal-info"><i class="fa fa-window-close"></i></button></a>'
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


            function edit_dep(dep_name, dep_code, dep_id) {
                // console.log('here');
                $('#dep_name').val(dep_name);
                $('#dep_code').val(dep_code);
                $('#dep_id').val(dep_id);

                $("#edit_model").modal("show");

            }
        </script>
        {{-- @include('layouts.alerts') --}}
    @endpush

@stop
