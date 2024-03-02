@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">


    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    {{-- <style>
        .select2-dropdown {
            background-color: #2d3436;
            color: white;
        }

        .select2-results__options {
            background-color: black;
        }
    </style> --}}



    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">PDF <small>Export</small></h3>
                        </div>
                        <div class="block-content">
                            <form class="js-validation" method="POST" action="{{ route('report.ticket.generate') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="example-ltf-email2">Hotels*</label>
                                    <select class=" form-control" name="hid" required>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" name="{{ $hotel->hotel_name }}">
                                                {{ $hotel->hotel_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="example-ltf-email2">Type*</label>
                                    <select class=" form-control" id="type_id" name="type_id" required>
                                        <option value="Daily Report">Daily Report</option>
                                        {{-- <option value="Top 10">Top 10</option> --}}
                                    </select>
                                </div>

                                {{-- <div class="form-group" id="month-container">
                                    <label for="example-ltf-email2">Month*</label>
                                    <select class=" form-control" id="month" name="month" required>
                                        @for ($i = 1; $i < 13; $i++)
                                            <option value="{{ $i }}">{{ get_month_name($i) }}</option>
                                        @endfor
                                    </select>
                                </div> --}}
                                <div id="from-to-container">
                                    <div class="form-group">
                                        <label for="from_date">From Date</label>
                                        <input type="date" class=" form-control bg-white" id="from_date" name="from_date"
                                            placeholder="Y-m-d" required>
                                        {{-- <input type="text" class="js-flatpickr form-control bg-white" id="from_date"
                                            name="from_date" placeholder="Y-m-d" required> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="to_date">To Date</label>
                                        <input type="date" class=" form-control bg-white" id="to_date" name="to_date"
                                            placeholder="Y-m-d" required>
                                        {{-- <input type="text" class="js-flatpickr form-control bg-white" id="to_date"
                                            name="to_date" placeholder="Y-m-d" required> --}}
                                    </div>
                                </div>

                                <button class="btn btn-info">Generate</button>
                                <br><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
        </div>
    </main>

    @push('scripts')
        <script src="{{ URL::asset('admin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
        {{-- <script src="{{ URL::asset('admin/assets/js/pages/be_forms_validation.js') }}"></script>
        <script src="{{ URL::asset('admin/assets/js/plugins/jquery-validation/jquery.validate.min.js ') }}"></script> --}}

        <script>
            jQuery(function() {

                One.helpers(['flatpickr', 'select2', 'datepicker', 'ckeditor5']);
            });
        </script>
        {{-- @include('tickets.scripts') --}}
        {{-- <script>
            function typechange() {
                if ($('#type_id').val() == 'Daily Report') {
                    $('#month-container').hide();
                    $('#from-to-container').show();

                } else if ($('#type_id').val() == 'Top 10') {
                    $('#month-container').show();
                    $('#from-to-container').hide();
                }
            }
            typechange()
        </script> --}}
    @endpush

@stop
