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
                                            href="javascript:void(0)" id="deleted" onclick="activeTap('deleted')">
                                            <span>
                                                <i class="fa fa-fw fa-trash-alt mr-1"></i> Trash
                                            </span>
                                            <span class="badge badge-pill badge-secondary">{{ $deleted_count }}</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                        <!-- END Inbox Menu -->

                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Active Users</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-toggle="block-option"
                                        data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option"
                                        data-action="content_toggle"></button>
                                </div>
                            </div>
                            <div class="block-content">
                                <!-- Users Navigation -->
                                <ul class="nav-items mb-0" id="active-user">
                                    @foreach ($active_users as $user)
                                        <li>
                                            <div class="media py-2">
                                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                                    <img class="img-avatar img-avatar48"
                                                        src="{{ URL::asset('admin/assets/media/avatars/avatar4.jpg') }}"
                                                        alt="">
                                                    <span
                                                        class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-w600">{{ $user->name }}</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach



                                </ul>
                                <!-- END Users Navigation -->
                            </div>
                        </div>

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
                                                            id="check-{{ $mail->id }}"
                                                            name="check-{{ $mail->id }}">
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
        @include('backend.inbox_script')
    @endpush



@stop
