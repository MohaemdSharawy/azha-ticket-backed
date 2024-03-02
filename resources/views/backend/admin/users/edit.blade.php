@extends('layouts.admin')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">


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
                            {{-- <li class="breadcrumb-item" aria-current="page">

                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">User Create</li> --}}
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('users') }}">Users</a>
                            </li>
                            {{-- <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" >{{ $hotel->hotel_name }}</a>
                            </li> --}}
                            <li class="breadcrumb-item">{{ $user->name }}</li>
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

                    <!-- Block Tabs Animated Slide Up -->
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#btabs-animated-slideup-home">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-profile">Permission</a>
                            </li>
                            <li class="nav-item ml-auto">
                                <a class="nav-link" href="#btabs-animated-slideup-settings">
                                    <i class="si si-settings"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="block-content tab-content overflow-hidden">
                            <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel">
                                @include('backend.admin.users.componant.eidt')
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel">
                                @include('backend.admin.users.componant.permission')

                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-settings" role="tabpanel">
                                @include('backend.admin.users.componant.userlog')
                            </div>
                        </div>
                        <!-- END Block Tabs Animated Slide Up -->

                        <!-- Block Tabs Animated Slide Right -->


                    </div>
                </div>

                <!-- END Dynamic Table with Export Buttons -->
            </div>
            <!-- END Page Content -->
    </main>
    @push('scripts')
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
        {{--
        <script>
            $('.my-select').selectpicker();
        </script> --}}

        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/pages/be_tables_datatables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/es6-promise/es6-promise.auto.min.js') }}"></script>

        <script src="{{ URL::asset('admin/assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

        <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/jquery-ui.js') }}"></script>

        <script>
            jQuery(function() {

                One.helpers(['select2', 'datepicker', ]);
            });
        </script>
        @include('backend.admin.log.log_script')
    @endpush

@stop
