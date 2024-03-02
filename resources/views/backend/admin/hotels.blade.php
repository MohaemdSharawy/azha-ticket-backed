@extends('layouts.admin')
@section('content')

    @include('layouts.datatable_css')

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
                                <a class="link-fx" href="">Hotels</a>
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
                            New Hotel <i class="fa fa-edit"></i></button></a>
                    {{-- <h3 class="block-title">Hotel List</small></h3> --}}
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
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
                                @if (isset($hotels))

                                    @foreach ($hotels as $hotel)
                                        {{-- {{ $i++ }} --}}
                                        <td class="text-center font-size-sm">{{ $hotel->id }}</td>
                                        <td class="font-w600 font-size-sm">{{ $hotel->hotel_name }}</td>
                                        <td class="d-none d-sm-table-cell font-size-sm">
                                            <em class="text-muted">{{ $hotel->code }}</em>
                                        </td>
                                        <td>
                                            <a href="{{ route('hotel.view', $hotel->id) }}"><button
                                                    class="btn btn-primary js-swal-info"><i
                                                        class="fa fa-eye"></i></button></a>
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
                        <select class="form-control" name="template">
                            <option>-------- </option>
                            @foreach ($index_design as $index)
                                <option value="{{ $index->name }}">{{ $index->nick_name }}</option>
                            @endforeach
                        </select>
                        <br>

                        <label>Create Template </label>
                        {{-- <small>Select Template For This Hotel</small> --}}
                        <select class="form-control" name="create">
                            <option>-------- </option>
                            @foreach ($create_design as $create)
                                <option value="{{ $create->name }}">{{ $create->nick_name }}</option>
                            @endforeach
                        </select>
                        <br>

                        <label>Thank u Template </label>
                        {{-- <small>Select Template For This Hotel</small> --}}
                        <select class="form-control" name="thanku">
                            <option>-------- </option>
                            @foreach ($thanku_design as $thanku)
                                <option value="{{ $thanku->name }}">{{ $thanku->nick_name }}</option>
                            @endforeach
                        </select>

                        <br>
                        <label>Hotel Logo</label>
                        <div class="custom-file">
                            <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                id="example-file-input-custom" name="logo">
                            <label class="custom-file-label" for="example-file-input-custom">Choose file</label>
                        </div>
                        <label>Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                id="example-file-input-custom" name="image">
                            <label class="custom-file-label" for="example-file-input-custom">Choose
                                file</label>
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





        {{-- <script src="assets/js/plugins/es6-promise/es6-promise.auto.min.js"></script>
        <script src="assets/js/plugins/sweetalert2/sweetalert2.min.js"></script> --}}

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
        {{-- @include('backend.survey_script') --}}
    @endpush


@stop
