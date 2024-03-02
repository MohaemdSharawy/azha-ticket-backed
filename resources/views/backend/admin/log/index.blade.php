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
                        System Log <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item"> <a class="link-fx" href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">
                                Log
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
                    <h3 class="block-title">Log Data</small></h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">ID</th>
                                <th>Name</th>
                                <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Access</th>
                                <th style="width: 15%;">CReated AT </th>
                                <th style="width: 15%;">More Details </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                @if (isset($data))

                                    @foreach ($data as $log)
                                        {{-- {{ $i++ }} --}}
                                        <td class="text-center font-size-sm">{{ $log->id }}</td>
                                        <td class="font-w600 font-size-sm">{{ $log->model_name }}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{ $log->user_name }}</em>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            {{ $log->action }}
                                        </td>
                                        <td>
                                            <em class="text-muted font-size-sm">{{ $log->time_stamps }}</em>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary js-swal-info" id="{{ $log->id }}"
                                                onclick="setvalue('{{ $log->id }}')">Show More
                                                Details</button>
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


    @push('scripts')
        <script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="assets/js/plugins/datatables/buttons/dataTables.buttons.min.js"></script>
        <script src="assets/js/plugins/datatables/buttons/buttons.print.min.js"></script>
        <script src="assets/js/plugins/datatables/buttons/buttons.html5.min.js"></script>
        <script src="assets/js/plugins/datatables/buttons/buttons.flash.min.js"></script>
        <script src="assets/js/plugins/datatables/buttons/buttons.colVis.min.js"></script>
        <script src="assets/js/pages/be_tables_datatables.min.js"></script>
        <script src="assets/js/plugins/es6-promise/es6-promise.auto.min.js"></script>
        <script src="assets/js/plugins/sweetalert2/sweetalert2.min.js"></script>

        <!-- Page JS Code -->
        {{-- <script src="assets/js/pages/be_comp_dialogs.min.js"></script> --}}
        {{-- <script>
            // var survey_id;

            function setvalue(id) {
                $('.js-swal-info').val(id)
                var survey_id = $('.js-swal-info').val()
                // return survey_id
                // console.log(survey_id)
                var n = Swal.mixin({
                    buttonsStyling: !1,
                    customClass: {
                        confirmButton: "btn btn-success m-1",
                        cancelButton: "btn btn-danger m-1",
                        input: "form-control"
                    }
                });
                jQuery(".js-swal-info").on("click", function(e, survey_id) {

                    var s = $(this).attr('id');
                    // console.log(s);

                    n.fire("info", s, "info");
                });

                function n(n, e) {
                    for (var t = 0; t < e.length; t++) {
                        var i = e[t];
                        (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0),
                            Object.defineProperty(n, i.key, i);
                    }
                }
            }
        </script> --}}
        @include('backend.admin.log.log_script')
    @endpush


@stop
