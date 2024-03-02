@extends('layouts.admin')
@section('content')
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <div class="row">
                <div class="col-md-5 col-xl-3">
                    <!-- Toggle Inbox Side Navigation -->
                    <div class="d-md-none push">
                        <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                        <button type="button" class="btn btn-block btn-primary" data-toggle="class-toggle"
                            data-target="#one-inbox-side-nav" data-class="d-none">
                            Inbox Menu
                        </button>
                    </div>
                    <!-- END Toggle Inbox Side Navigation -->

                    <!-- Inbox Side Navigation -->
                    <div id="one-inbox-side-nav" class="d-none d-md-block push">
                        <!-- Inbox Menu -->
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title" id="side_title">Inbox</h3>
                                <div class="block-options">
                                    {{-- <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal"
                                        data-target="#one-inbox-new-message">
                                        <i class="fa fa-pencil-alt mr-1"></i> New Message
                                    </button> --}}
                                </div>
                            </div>
                            <div class="block-content">
                                <ul class="nav nav-pills flex-column font-size-sm push">
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center active"
                                            id="inbox" onclick="activeTap('inbox')">
                                            <span>
                                                <i class="fa fa-fw fa-inbox mr-1"></i> Inbox
                                            </span>
                                            <span class="badge badge-pill badge-secondary">{{ $inbox_count }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center" id="starred"
                                            onclick="activeTap('starred')">
                                            <span>
                                                <i class="fa fa-fw fa-star mr-1"></i> Starred
                                            </span>
                                            <span class="badge badge-pill badge-secondary"
                                                id="star_count">{{ $star_count }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center"
                                            href="javascript:void(0)" id="sent" onclick="activeTap('sent')">
                                            <span>
                                                <i class="fa fa-fw fa-paper-plane mr-1"></i> Sent
                                            </span>
                                            <span class="badge badge-pill badge-secondary">{{ $send_count }}</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center"
                                            href="javascript:void(0)" id="starred"
                                            onclick="activeTap('starred')">
                                            <span>
                                                <i class="fa fa-fw fa-pencil-alt mr-1"></i> Draft
                                            </span>
                                            <span class="badge badge-pill badge-secondary">2</span>
                                        </a>
                                    </li> --}}
                                    {{-- <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center"
                                            href="javascript:void(0)">
                                            <span>
                                                <i class="fa fa-fw fa-folder mr-1"></i> Archive
                                            </span>
                                            <span class="badge badge-pill badge-secondary">1987</span>
                                        </a>
                                    </li> --}}
                                    <li class="nav-item my-1">
                                        <a class="nav-link d-flex justify-content-between align-items-center"
                                            href="javascript:void(0)" id="deleted" onclick="activeTap('deleted')">
                                            <span>
                                                <i class="fa fa-fw fa-trash-alt mr-1"></i> Trash
                                            </span>
                                            <span class="badge badge-pill badge-secondary">{{ $deleted_count }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END Inbox Menu -->



                    </div>
                    <!-- END Inbox Side Navigation -->
                </div>
                <div class="col-md-7 col-xl-9">
                    <!-- Message List -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                15-30 <span class="font-w400 text-lowercase">from</span> 700
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left"
                                    title="Previous 15 Messages">
                                    <i class="si si-arrow-left"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left"
                                    title="Next 15 Messages">
                                    <i class="si si-arrow-right"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="fullscreen_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <!-- Messages Options -->
                            <div class="d-flex justify-content-between push">
                                <div class="btn-group">
                                    {{-- <button class="btn btn-sm btn-light" type="button">
                                        <i class="fa fa-archive text-primary"></i>
                                        <span class="d-none d-sm-inline ml-1">Archive</span>
                                    </button> --}}
                                    <button class="btn btn-sm btn-light" type="button">
                                        <i class="fa fa-star text-warning"></i>
                                        <span class="d-none d-sm-inline ml-1">Star</span>
                                    </button>
                                </div>
                                <button class="btn btn-sm btn-light" type="button">
                                    <i class="fa fa-times text-danger"></i>
                                    <span class="d-none d-sm-inline ml-1">Delete</span>
                                </button>
                            </div>
                            <!-- END Messages Options -->

                            <!-- Messages and Checkable Table (.js-table-checkable class is initialized in Helpers.tableToolsCheckable()) -->
                            <div class="pull-x">
                                <table class="js-table-checkable table table-hover table-vcenter font-size-sm">
                                    <tbody class="main_mails">
                                        @foreach ($mails as $mail)
                                            <tr>
                                                <td class="text-center" style="width: 60px;">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="check-{{ $mail->id }}" name="check-{{ $mail->id }}">
                                                        <label class="custom-control-label font-w400"
                                                            for="check-{{ $mail->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">
                                                    @if ($mail->from == Auth::user()->email)
                                                        {{ $mail->to }}
                                                    @else
                                                        {{ $mail->from }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="font-w600" data-toggle="modal"
                                                        data-target="#one-inbox-message"
                                                        href="#">{{ $mail->description }}</a>

                                                </td>

                                                {{-- <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                                <i class="fa fa-paperclip mr-1"></i> (3)
                                            </td> --}}
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                                    <em>{{ $mail->sent_at }}</em>
                                                </td>
                                                <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"
                                                    id="star-{{ $mail->id }}">
                                                    @if ($mail->starred == 1)
                                                        <i onclick="setStar({{ $mail->starred }}  , {{ $mail->id }})"
                                                            class="fa fa-star text-warning"></i>
                                                    @else
                                                        <i
                                                            onclick="setStar({{ $mail->starred }}  , {{ $mail->id }})"class="fa fa-star text-defult"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- END Messages and Checkable Table -->
                        </div>
                    </div>
                    <!-- END Message List -->
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>

    @push('scripts')
        <script>
            var auth_mail = "{{ Auth::user()->email }}"

            function activeTap(TapId) {
                var activeId = $(".active");
                activeId.removeClass("active");
                $('#side_title').empty();

                $('#side_title').append(TapId);
                $('#' + TapId + '').addClass("active");

                if (TapId == 'starred') {
                    StarLoad()
                }
                if (TapId == 'inbox') {
                    inboxLoad()
                }
                if (TapId == 'sent') {
                    sendLoad()
                }
                if (TapId == 'deleted') {
                    deletedLoad()
                }


            }

            function setStar(status, Id) {
                var mail_status;
                if (status == 0) {
                    mail_status = 1
                } else {
                    mail_status = 0
                }
                url = "{{ route('star') }}"
                $.ajax({
                    url: url,
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": Id,
                        "status": mail_status
                    },
                    success: function(data) {
                        $('#star-' + data.id + '').empty()
                        if (data.star_status == 0) {
                            $('#star-' + data.id + '').append(
                                '<i  onclick="setStar(' + data.star_status + '  , ' + data.id +
                                ')"class="fa fa-star text-defult"></i>'
                            );
                            $('#star_count').empty();
                            $('#star_count').append(data.count);

                            One.helpers('notify', {
                                type: 'danger',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });

                        } else {
                            $('#star-' + data.id + '').append(
                                '<i  onclick="setStar(' + data.star_status + '  , ' + data.id +
                                ')"class="fa fa-star text-warning"></i>'
                            );
                            $('#star_count').empty();
                            $('#star_count').append(data.count);
                            One.helpers('notify', {
                                type: 'success',
                                icon: 'fa fa-check mr-1',
                                message: data.message
                            });
                        }
                    }
                });

            }




            function StarLoad() {
                $.ajax({
                    url: "{{ route('get_star') }}",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('.main_mails').empty()
                        console.log(data.result);
                        for (let i = 0; i < data.result.length; i++) {
                            if (data.result[i]['from'] == auth_mail) {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].to +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    '</a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '}}"> <i onclick="setStar(1  , ' + data.result[i].id +
                                    ')"class="fa fa-star text-warning"></i> </td>'
                                );

                            } else {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].from +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '}}"><i onclick="setStar(1  , ' + data.result[i].id +
                                    ')"class="fa fa-star text-warning"></i> </td>'
                                )
                            }

                        }
                    }
                });
            }


            function inboxLoad() {
                $.ajax({
                    url: "{{ route('get_inbox_ajax') }}",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('.main_mails').empty()
                        for (let i = 0; i < data.result.length; i++) {
                            if (data.result[i]['from'] == auth_mail) {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].to +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '">  </td>'
                                );

                                $('#star-' + data.result[i].id + '').empty()

                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    console.log(data.result[i].id);

                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }

                            } else {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].from +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '"></td>'
                                )
                                $('#star-' + data.result[i].id + '').empty()
                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }
                            }

                        }
                    }
                });
            }

            function sendLoad() {
                $.ajax({
                    url: "{{ route('get_send_ajax') }}",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('.main_mails').empty()
                        for (let i = 0; i < data.result.length; i++) {
                            if (data.result[i]['from'] == auth_mail) {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].to +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '">  </td>'
                                );

                                $('#star-' + data.result[i].id + '').empty()

                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    console.log(data.result[i].id);

                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }

                            } else {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].from +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '"></td>'
                                )
                                $('#star-' + data.result[i].id + '').empty()
                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }
                            }

                        }
                    }
                });
            }


            function deletedLoad() {
                $.ajax({
                    url: "{{ route('get_deleted_ajax') }}",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('.main_mails').empty()
                        for (let i = 0; i < data.result.length; i++) {
                            if (data.result[i]['from'] == auth_mail) {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].to +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '">  </td>'
                                );

                                $('#star-' + data.result[i].id + '').empty()

                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    console.log(data.result[i].id);

                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }

                            } else {
                                $('.main_mails').append(
                                    '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                                    data.result[i].from +
                                    '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                                    data.result[i].description +
                                    '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                                    data.result[i].sent_at +
                                    ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                                    data.result[i].id + '"></td>'
                                )
                                $('#star-' + data.result[i].id + '').empty()
                                if (data.result[i].starred == 1) {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                                } else {
                                    $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                        .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                                }
                            }

                        }
                    }
                });
            }
        </script>
    @endpush



@stop
