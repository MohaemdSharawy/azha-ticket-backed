@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('admin/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">

    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Mail List <small
                            class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('mailSetup') }}">Mail Setup</a>
                            </li>
                            {{-- <li class="breadcrumb-item">{{ $data->hotel_name }} / {{ $data->dep_name }}</li> --}}

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
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-home">Mail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-profile">Phone</a>
                    </li>
                    @if (Auth::user()->is_admin == 1)
                        <li class="nav-item ml-auto">
                            <a class="nav-link" href="#btabs-animated-slideup-settings">
                                <i class="si si-settings"></i>
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel">
                        @include('backend.admin.mailSetup.companent.mail')
                    </div>
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel">
                        @include('backend.admin.mailSetup.companent.phone')

                    </div>
                    @if (Auth::user()->is_admin == 1)
                        <div class="tab-pane fade fade-up" id="btabs-animated-slideup-settings" role="tabpanel">
                            <a href="{{ url('admin/disable_all/' . $hotel_id . '/' . $dep_id) }}"><button
                                    class="btn btn-dark" onclick="rest()">
                                    Disable All Department(Rest)
                                </button></a><br><br>
                        </div>
                    @endif
                </div>
                <!-- END Block Tabs Animated Slide Up -->

                <!-- Block Tabs Animated Slide Right -->


            </div>

            <!-- END Dynamic Table with Export Buttons -->
        </div>
        <!-- END Page Content -->




        <div class="modal fade confirmation" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('mailSetup.store') }}" enctype="multipart/form-data">
                            @csrf
                            <label>Mail</label>
                            <input type="hidden"name="h_id" value="{{ $hotel_id }}">
                            <input type="hidden"name="dep_id" value="{{ $dep_id }}">
                            <input type="hidden"name="type" value="13">
                            <input type="email" class="form-control" name="mail" required placeholder="E-Mail">
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


        <div class="modal fade confirmation" id="editMail" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Edit New Mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('mailSetup.update') }}" enctype="multipart/form-data">
                            @csrf
                            <label>Mail</label>
                            <input type="hidden"name="mail_id" id="mail_id">
                            <input type="text" class="form-control" name="mail" required placeholder="E-Mail"
                                id="mail">
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





        {{-- Phone Model --}}



        <div class="modal fade confirmation" id="phone" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Add New Phone</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('mailSetup.store') }}" enctype="multipart/form-data">
                            @csrf
                            <label>Phone Number</label>
                            <input type="hidden"name="h_id" value="{{ $hotel_id }}">
                            <input type="hidden"name="dep_id" value="{{ $dep_id }}">
                            <input type="hidden"name="type" value="14">
                            <input type="text" class="form-control" name="phone" required
                                placeholder="Phone Number">
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


        <div class="modal fade confirmation" id="editphone" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Edit New Mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('mailSetup.update') }}" enctype="multipart/form-data">
                            @csrf
                            <label>Phone</label>
                            <input type="hidden"name="mail_id" id="phone_id">
                            {{-- <input type="text" class="form-control" name="mail" required placeholder="phone"
                                id="phone"> --}}
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


        {{-- End Phone MOdel --}}















    </main>




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
        {{-- @include('layouts.alerts') --}}
        <script>
            function mailStatus(mail_id, status) {
                url = "{{ route('mailSetup.disable') }}"
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "mail_id": mail_id,
                        "status": status
                    },
                    success: function(data) {
                        $('#mail_stats-' + mail_id + '').empty()
                        if (data.mail_status == 0) {
                            $('#mail_stats-' + mail_id + '').append(
                                '<a onclick="mailStatus(' + data.mail_id +
                                ',  1)"><button class="btn btn-success js-swal-info"><i class="fa fa-user"></i></button></a>'
                            );
                            One.helpers('notify', {
                                type: 'success',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        } else {
                            $('#mail_stats-' + mail_id + '').append(
                                '<a onclick="mailStatus(' + data.mail_id +
                                ',  0)"><button class="btn btn-danger js-swal-info"><i class="fa fa-user-slash"></i></button></a>'
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



            function edit(mail, id) {
                $('#mail').val(mail);
                $('#mail_id').val(id);
                $("#editMail").modal("show");
            }

            // function editphone(mail, id) {
            //     $('#phone_id').val(id);
            //     $('#phone').val(mail);
            //     $("#editphone").modal("show");
            // }


            // function rest() {
            //     var userselection = confirm("Are you sure you want to Disabale All Users?");
            // }
        </script>
        @include('backend.survey_script')
    @endpush
@stop
