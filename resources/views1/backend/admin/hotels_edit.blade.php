@extends('layouts.admin')
@section('content')
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
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('hotels') }}">Hotels</a>
                            </li>
                            {{-- <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" >{{ $hotel->hotel_name }}</a>
                            </li> --}}
                            <li class="breadcrumb-item">{{ $hotel->hotel_name }}</li>
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
                    <h3 class="block-title">Edit Hotel</small></h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <div class="block block-rounded">
                        <div class="block-header">
                            <h3 class="block-title">{{ $hotel->hotel_name }}</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="row">
                                {{-- <div class="col-lg-4">
                                    <p class="font-size-sm text-muted">
                                        An often used layout which is very easy to create with minimal markup
                                    </p>
                                </div> --}}
                                <div class="col-lg-12">
                                    <!-- Form Labels on top - Default Style -->
                                    {{-- <form class="mb-5" action="be_forms_layouts.html" method="POST"
                                        onsubmit="return false;">
                                        <div class="form-group">
                                            <label for="example-ltf-email">Email</label>
                                            <input type="email" class="form-control" id="example-ltf-email"
                                                name="example-ltf-email" placeholder="Your Email..">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-password">Password</label>
                                            <input type="password" class="form-control" id="example-ltf-password"
                                                name="example-ltf-password" placeholder="Your Password..">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form> --}}
                                    <!-- END Form Labels on top - Default Style -->

                                    <!-- Form Labels on top - Alternative Style -->
                                    <form action="{{ route('hotel.update', $hotel->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Hotel Name</label>
                                            <input type="text" class="form-control form-control-alt"
                                                id="example-ltf-email2" name="hotel_name"
                                                placeholder="{{ $hotel->hotel_name }}" value="{{ $hotel->hotel_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Hotel Name</label>
                                            <input type="test" class="form-control form-control-alt"
                                                id="example-ltf-email2" name="code" placeholder="{{ $hotel->code }}"
                                                value="{{ $hotel->code }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Index Template</label>
                                            <select class="form-control form-control-alt" name="template">
                                                @foreach ($index_design as $index)
                                                    <option value="{{ $index->name }}">{{ $index->nick_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Create Template</label>
                                            <select class="form-control form-control-alt" name="create">
                                                @foreach ($create_design as $index)
                                                    <option value="{{ $index->name }}">{{ $index->nick_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Thank u Template</label>
                                            <select class="form-control form-control-alt" name="thanku">
                                                @foreach ($thanku_design as $index)
                                                    <option value="{{ $index->name }}">{{ $index->nick_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>Hotel Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                                id="example-file-input-custom" name="logo">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose
                                                file</label>
                                        </div>

                                        <label>Image</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" data-toggle="custom-file-input"
                                                id="example-file-input-custom" name="image">
                                            <label class="custom-file-label" for="example-file-input-custom">Choose
                                                file</label>
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
@stop
