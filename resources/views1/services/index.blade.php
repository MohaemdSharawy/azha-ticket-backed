@extends('layouts.admin')
@section('content')

    @include('layouts.datatable_css')

    <main id="main-container">
        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Services List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Services</a>
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
                            New Services <i class="fa fa-edit"></i></button></a>
                </div>

                <div class="block-content block-content-full">
                    <table class="table  table-striped table-vcenter js-dataTable-full-pagination " id="ticket"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->type->name }}</td>
                                    <td>{{ $row->department->dep_name }}</td>
                                    <td>
                                        <button
                                            onclick="edit_facility(`{{ $row->dep_id }}` , `{{ $row->type_id }}` ,`{{ $row->name }}` ,`{{ $row->id }}`)"
                                            class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>
                                        <i id="dep_stats-{{ $row->id }}">

                                            @if ($row->disable == 0)
                                                <a href="{{ route('services.disable', $row->id) }}"><button
                                                        class="btn btn-success js-swal-info"><i
                                                            class="fa fa-check-circle"></i></button></a>
                                            @else
                                                <a href="{{ route('services.disable', $row->id) }}"><button
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
                        <label>Type</label>
                        <select class="form-control form-control-alt" name="type_id" required>
                            <option>-----</option>
                            @foreach ($types as $type)
                                @if ($type->id != 1)
                                    <option value=" {{ $type->id }}">{{ $type->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                        <label>Department</label>
                        <select class="form-control form-control-alt" name="dep_id" required>
                            <option>-----</option>
                            @foreach ($deps as $dep)
                                <option value=" {{ $dep->id }}">{{ $dep->dep_name }}</option>
                            @endforeach
                        </select>
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
                    <form method="POST" action="{{ route('services.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="service_id" name="service_id">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required id="service_name">
                        <br>
                        <label>Type</label>
                        <select class="form-control form-control-alt" name="type_id" required id="type_id">
                            <option>-----</option>
                            @foreach ($types as $type)
                                @if ($type->id != 1)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <br>
                        <label>Department</label>
                        <select class="form-control form-control-alt" name="dep_id" id="dep_id" required>
                            <option>-----</option>
                            @foreach ($deps as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->dep_name }}</option>
                            @endforeach
                        </select>
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
            function edit_facility(dep_id, type_id, name, id) {
                $("#edit_model").modal("show");
                $('#dep_id option').removeAttr('selected').filter('[value=' + dep_id + ']').attr('selected', true)
                $('#type_id option').removeAttr('selected').filter('[value=' + type_id + ']').attr('selected', true)
                $('#service_name').val(name)
                $('#service_id').val(id)
            }
        </script>
    @endpush


@stop
