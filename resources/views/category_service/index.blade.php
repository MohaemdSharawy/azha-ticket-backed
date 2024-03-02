@extends('layouts.admin')
@section('content')

    @include('layouts.datatable_css')

    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Category Services List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Category Services</a>
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
                            New Category Services <i class="fa fa-edit"></i></button></a>
                </div>

                <div class="block-content block-content-full">
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination " id="ticket"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Name AR</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name_en }}</td>
                                    <td>{{ $row->name_ar }}</td>


                                    <td>
                                        <button
                                            onclick="edit_category(`{{ $row->name_ar }}` , `{{ $row->name_en }}` , `{{ $row->id }}` )"
                                            class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>
                                        <i id="dep_stats-{{ $row->id }}">

                                            @if ($row->active == 1)
                                                <a href="{{ route('category_service.disable', $row->id) }}"><button
                                                        class="btn btn-success js-swal-info"><i
                                                            class="fa fa-check-circle"></i></button></a>
                                            @else
                                                <a href="{{ route('category_service.disable', $row->id) }}"><button
                                                        class="btn btn-danger js-swal-info"><i
                                                            class="fa fa-window-close"></i></button></a>
                                            @endif
                                        </i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->
    </main>

    {{-- Create Model --}}
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('category_service.store') }}">
                        @csrf
                        <label>English Name</label>
                        <input type="text" class="form-control" name="name_en" required>
                        <br>
                        <label>Arabic Name</label>
                        <input type="text" class="form-control" name="name_ar" required>
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
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Hotel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('category_service.update') }}">
                        @csrf
                        <input type="hidden" id='category_id' name="category_id">
                        <label>English Name</label>
                        <input type="text" class="form-control" name="name_en" required id="name_en_edit">
                        <br>
                        <label>Arabic Name</label>
                        <input type="text" class="form-control" name="name_ar" required id="name_ar_edit">
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
        @include('layouts.datatable')
        <script>
            function edit_category(name_en, name_ar, id) {
                $("#edit_model").modal("show");
                $('#name_en_edit').val(name_en);
                $('#name_ar_edit').val(name_ar);
                $('#category_id').val(id);
                // $('#dep_id option').removeAttr('selected').filter('[value=' + dep_id + ']').attr('selected', true)
                // $('#service_name').val(name)
                // $('#service_id').val(id)
                // if (guest == 1) {
                //     $('#guest').attr('checked', true)
                // } else {
                //     $('#guest').attr('checked', false)
                // }
            }
        </script>
    @endpush


@stop
