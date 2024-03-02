@extends('layouts.admin')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/select2/css/select2.min.css') }}">


    <main id="main-container">
        <div class="bg-image" style="background-image: url('{{URL::asset('admin/assets/media/photos/photo8@2x.jpg')}}">
            <div class="bg-black-50">
                <div class="content content-full text-center">
                    <div class="my-3">
                        <img class="img-avatar img-avatar-thumb" src="{{URL::asset('admin/assets/media/avatars/avatar13.jpg')}}" alt="">
                    </div>
                    <h1 class="h2 text-white mb-0">{{$client->first_name  . ' ' .  $client->last_name}}</h1>
                    <span class="text-white-75" style="font-size:25px;"> {{strtoupper($client->role)}}</span>
                    @if ($client->role != 'owner')
                        <a href="{{route('clients.edit' , $client->master_id)}}">
                           <button class="btn btn-primary"> Go  To Master</button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <!-- Hero -->
        {{-- <div class="bg-body-light">
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
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="{{ route('users') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item">{{ $client->first_name  .  ' ' . $client->last_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div> --}}
        <div class="content">
            <div class="block block-rounded">
                {{-- <div class="block-header">
                    <h3 class="block-title">User</small></h3>
                </div> --}}
                <div class="block-content block-content-full">
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#btabs-animated-slideup-home">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-profile">Transaction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-financal">Financal Status</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-rating">Rating</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-invoice">Invoices</a>
                            </li>
                            @if ($client->role == 'owner')
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-family">Family Member</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#btabs-animated-slideup-violations">Violations</a>
                            </li>

                            <li class="nav-item ml-auto">
                                <a class="nav-link" href="#btabs-animated-slideup-settings">
                                    <i class="si si-settings"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="block-content tab-content overflow-hidden">
                            <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-home" role="tabpanel">
                                @include('clients.componant.edit')
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-profile" role="tabpanel">
                                <livewire:clients.transaction :id="$client->id" />
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-financal" role="tabpanel">
                                <div class="">
                                    <livewire:clients.financal-payment :id="$client->id" />
                                </div>
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-rating" role="tabpanel">
                                <div class="">
                                    ratings
                                </div>
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-invoice" role="tabpanel">
                                <div class="">
                                    invoice
                                </div>
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-family" role="tabpanel">
                                <div class="">
                                    <livewire:clients.family-member :id="$client->id" />

                                </div>
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-violations" role="tabpanel">
                                <div class="">
                                    <livewire:clients.violations :id="$client->id" />

                                </div>
                            </div>
                            <div class="tab-pane fade fade-up" id="btabs-animated-slideup-settings" role="tabpanel">
                                {{-- @include('backend.admin.users.componant.userlog') --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
