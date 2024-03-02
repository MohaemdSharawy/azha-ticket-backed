@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/js/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


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
                                Mail Setup
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
            <div class="col-md-12 col-xl-12">
                <div class="block block-rounded block-themed">
                    <div class="block-header bg-dark">
                        <h3 class="block-title">Mail Setup</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form onsubmit="getMails()" id="mailSearch">
                            <div class="form-group">
                                <label for="example-ltf-email2">Hotels</label>
                                <select class="selectpicker form-control" name="hotels[]" data-live-search="true"
                                    data-style="btn-info" required id="hotels">
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->code }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-ltf-email2">Departments</label>
                                <select class="selectpicker form-control" name="dep[]" data-live-search="true"
                                    data-style="btn-info" required id="department">
                                    @foreach ($departments as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->dep_code }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-dark" style="margin-top: 30px; ">Seach <i
                                        class="fa fa-arrow-alt-circle-right"></i></button>
                            </div>
                        </form>
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
            $('#mailSearch').submit(function(event) {
                event.preventDefault();
            });
            $('.my-select').selectpicker();
        </script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/pages/be_tables_datatables.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script>
            function depStatus(dep_id, status) {
                console.log(dep_id)
                url = "{{ route('department.disable') }}"
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "dep_id": dep_id,
                        "status": status
                    },
                    success: function(data) {
                        $('#dep_stats-' + dep_id + '').empty()
                        if (data.user_status == 0) {
                            $('#dep_stats-' + dep_id + '').append(
                                '<a onclick="depStatus(' + data.dep_id +
                                ',  1)"><button class="btn btn-success js-swal-info"><i class="fa fa-check-circle"></i></button></a>'
                            );
                            One.helpers('notify', {
                                type: 'success',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        } else {
                            $('#dep_stats-' + dep_id + '').append(
                                '<a onclick="depStatus(' + data.dep_id +
                                ',  0)"><button class="btn btn-danger js-swal-info"><i class="fa fa-window-close"></i></button></a>'
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


            function getMails() {
                var hotel = $('#hotels').val();
                var dep = $('#department').val();
                // console.log(hotel);
                // console.log(dep);
                window.location.href = '/admin/mail_setup/' + hotel + '/' + dep;
            }
        </script>
        {{-- @include('layouts.alerts') --}}
    @endpush

@stop
