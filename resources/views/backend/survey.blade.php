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
                        Guest Survey <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Survey</a>
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
                    <h3 class="block-title">Survey Data</small></h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">ID</th>
                                <th>Name</th>
                                <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Statu</th>
                                <th style="width: 15%;">CReated AT </th>
                                <th style="width: 15%;">More Details </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                @foreach ($surveys as $survey)
                                    {{-- {{ $i++ }} --}}
                                    <td class="text-center font-size-sm">{{ $survey->id }}</td>
                                    <td class="font-w600 font-size-sm">{{ $survey->name }}</td>
                                    <td class="d-none d-sm-table-cell font-size-sm">
                                        <em class="text-muted">{{ $survey->email }}</em>
                                    </td>
                                    @if ($survey->priority_id == 1)
                                        <td class="d-none d-sm-table-cell">
                                            <span class="badge badge-success">Happy</span>
                                        </td>
                                    @elseif ($survey->priority_id == 2)
                                        <td class="d-none d-sm-table-cell">
                                            <span class="badge badge-danger">Sad</span>
                                        </td>
                                    @else
                                        <td class="d-none d-sm-table-cell">
                                            <span class="badge badge-warning">Idea</span>
                                        </td>
                                    @endif
                                    <td>
                                        <em class="text-muted font-size-sm">{{ $survey->timestamps }}</em>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary js-swal-info" id="{{ $survey->id }}"
                                            onclick="setvalue('{{ $survey->id }}')">Show More
                                            Details</button>
                                    </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        {{-- 
        <div class="modal fade" id="response_massage" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 9999999999999999;">
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
                            <textarea class="form-control"></textarea>
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
        </div> --}}
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
        @include('backend.survey_script')
        <script>
            function add_meesage(survey_id) {
                console.log(survey_id);
                var massage;
                $('.response_massage').empty();
                $('.response_massage').append(
                    '<br><form method="POST" action="{{ route('add_response') }}">  <input type="hidden" name="_token" value="{{ csrf_token() }}"> <input type="hidden" value="' +
                    survey_id +
                    '" name="survey_id" > <textarea required name="message" id="summernote" class="form-control"></textarea> <br><button type="submit" class="btn btn-dark">Sned Response</button>  </form> '
                )
            }
        </script>
    @endpush


@stop
