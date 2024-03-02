@extends('layouts.admin')
<link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet"
    href="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">


<link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.css') }}">
<style>
    .show {
        max-width: 450px;
    }

    .select2-dropdown {
        background-color: #2d3436;
        color: white;
    }

    .select2-results__options {
        background-color: black;
    }
</style>
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Create Ticket <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('ticket') }}">Ticket</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Create
                            </li>

                            {{-- <li class="breadcrumb-item">{{ $hotel->hotel_name }}</li> --}}
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
                    {{-- <a><button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#staticBackdrop">Create
                            New Hotel <i class="fa fa-edit"></i></button></a> --}}
                    <h3 class="block-title">Create Ticket</small></h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="block block-rounded">
                        <div class="block-header">
                            {{-- <h3 class="block-title">{{ $hotel->hotel_name }}</h3> --}}
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">

                                <div class="col-lg-12">

                                    <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        @csrf
                                        <div class="hide-input">

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label for="example-ltf-email2">Hotel Name*</label>
                                                    <select class="boot-select form-control " name="hid" required
                                                        data-live-search="true" id="h_id">
                                                        @foreach ($hotels as $hotel)
                                                            <option value="{{ $hotel->id }}">{{ $hotel->hotel_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label for="example-ltf-email2">Type*</label>
                                                    <select class="boot-select form-control" id="type_id" name="type_id"
                                                        data-live-search="true" onchange="typeChange()" required>
                                                        <option></option>
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->id }}" name="{{ $type->name }}">
                                                                {{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label for="example-ltf-email2"> Department*</label>
                                                    <select class="boot-select form-control" name="dep" id="dep"
                                                        onchange="getServices()" required>
                                                        <option></option>
                                                        @foreach ($deps as $dep)
                                                            <option value="{{ $dep->id }}">{{ $dep->dep_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label for="example-ltf-email2"> Priority*</label>
                                                    <select class="boot-select form-control" name="priority_level" required>
                                                        <option></option>
                                                        @foreach ($priority as $prio)
                                                            <option value="{{ $prio->id }}">{{ $prio->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 ">
                                                <div class="form-group" id="rooms">
                                                    <label for="facility_id" id="lab_name">Facility</label>
                                                    <select class="form-control boot-select " data-live-search="true"
                                                        id="facility_id" name="facility_id" required
                                                        onchange="saveFacility()">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 ">
                                                <div class="form-group">
                                                    <label for="example-ltf-email2" id="lab_name">Service</label>
                                                    <select class="boot-select form-control " data-live-search="true"
                                                        id="services" name="service_id" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row designer-tab">
                                            <div class="col-6">
                                                <label>Task Name</label>
                                                <input type="text" class="form-control" placeholder="Task Name"
                                                    name="design_task">
                                            </div>
                                            <div class="col-6">
                                                <label>Size</label>
                                                <input type="text" class="form-control" placeholder="Size"
                                                    name="design_size">
                                            </div>
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="js-ckeditor5-classic" name="description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Attach</label>
                                            @include('layouts.dropzone')
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-dark"
                                                style="margin-top: 30px; ">Save</button>
                                        </div>
                                    </form>

                                    <!-- END Form Labels on top - Alternative Style -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->
    </main>
    <div class="modal fade" id="MymodalPreventHTML">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop


@push('scripts')
    <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>



    <script>
        jQuery(function() {

            One.helpers(['flatpickr', 'select2', 'datepicker', 'ckeditor5']);
        });
    </script>
    @include('tickets.scripts')
    <script>
        $('.designer-tab').hide()
        // let department = $('#dep').val();
        // console.log('sss');
    </script>
@endpush


{{--




    <button type="button" id="MybtnPreventHTML" class="btn btn-primary" data-target="#MymodalPreventHTML" data-toggle="modal" data-backdrop="static" data-keyboard="false">Open Modal</button>
	<!-- .modal -->
	<div class="modal fade" id="MymodalPreventHTML">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Notification</h4>
				</div>
				<div class="modal-body">
					Are you sure you want to continue?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    --}}
