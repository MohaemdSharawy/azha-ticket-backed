@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Users <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">User Create</li>
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
                    <h3 class="block-title">User</small></h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <div class="block block-rounded">
                        <div class="block-header">
                            {{-- <h3 class="block-title">{{ $user->nam }}</h3> --}}
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
                                    {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="example-ltf-email2">User Name</label>
                                            <input type="text" class="form-control form-control-alt"
                                                id="example-ltf-email2" name="name" placeholder="User Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">User Email</label>
                                            <input type="email" class="form-control form-control-alt"
                                                id="example-ltf-email2" name="email" placeholder="User Email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Password</label>
                                            <input type="password" class="form-control form-control-alt"
                                                id="example-ltf-email2" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Hotels</label>
                                            <select class="selectpicker form-control" name="hotels[]"
                                                data-live-search="true" data-style="btn-info" multiple required>
                                                @foreach ($hotels as $hotel)
                                                    <option value="{{ $hotel->id }}">{{ $hotel->code }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-ltf-email2">Departments</label>
                                            <select class="selectpicker form-control" name="departments[]"
                                                data-live-search="true" data-style="btn-info" multiple required>
                                                @foreach ($departments as $dep)
                                                    <option value="{{ $dep->id }}">{{ $dep->dep_code }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            {{-- <label>Switches</label> --}}
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="example-switch-custom1" name="can_login" value="1">
                                                <label class="custom-control-label" for="example-switch-custom1">
                                                    Can Login
                                                </label>
                                            </div>
                                            <div class="custom-control custom-switch mb-1">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="example-switch-custom2" name="worker" value="1">
                                                <label class="custom-control-label" for="example-switch-custom2">
                                                    Worker
                                                </label>
                                            </div>

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
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script>
            $('.my-select').selectpicker();
        </script>
    @endpush

@stop
