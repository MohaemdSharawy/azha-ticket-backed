@extends('layouts.admin')
@section('content')
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-image overflow-hidden"
            style="background-image: url('{{ URL::asset('admin/assets/media/photos/photo3@2x.jpg') }}');">
            <div class="bg-primary-dark-op">
                <div class="content content-full">
                    <div
                        class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-left">
                        <div class="flex-sm-fill">
                            <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Ticket System</h1>
                            <h2 class="h4 font-w400 text-white-75 mb-0 invisible" data-toggle="appear" data-timeout="250">
                                Welcome {{ Auth::user()->name }}</h2>
                        </div>
                        <div class="flex-sm-00-auto mt-3 mt-sm-0 ml-sm-3">
                            <span class="d-inline-block invisible" data-toggle="appear" data-timeout="350">
                                <a class="btn btn-primary px-4 py-2" data-toggle="click-ripple" href="{{ route('task') }}">
                                    <i class="fa fa-list"></i> Tasks
                                </a>
                                <a class="btn btn-primary px-4 py-2" data-toggle="click-ripple"
                                    href="{{ route('ticket.create') }}">
                                    <i class="fa fa-plus mr-1"></i> New Ticket
                                </a>
                                <a class="btn btn-primary px-4 py-2" data-toggle="click-ripple"
                                    href="{{ route('ticket') }}">
                                    <i class="fa fa-list"></i> GSC
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Stats -->
            <div class="row">
                <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="font-size-h2 text-primary">{{ $my_current_task }}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="font-w600 font-size-sm text-muted mb-0">
                                My Current Tasks
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="font-size-h2 text-primary">{{ $my_finish_task }}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="font-w600 font-size-sm text-muted mb-0">
                                Finish Tasks This Month
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="font-size-h2 text-primary">{{ $finish_ticket }}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="font-w600 font-size-sm text-muted mb-0">
                                My Departments Finished Ticket This Month
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-6 col-xl-3">
                    <a class="block block-rounded block-link-shadow text-center">
                        <div class="block-content block-content-full">
                            <div class="font-size-h2 text-primary">{{ $created_ticket }}</div>
                        </div>
                        <div class="block-content py-2 bg-body-light">
                            <p class="font-w600 font-size-sm text-muted mb-0">
                                My Departments Created Ticket This Month
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <!-- END Stats -->
            <div class="row">
                <div class="col-xl-12 d-flex flex-column">
                    <!-- Earnings Summary -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Earnings Summary</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center">
                            <!-- Earnings Chart Container -->
                            <!-- Chart.js Chart is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
                            <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                            <canvas class="js-chartjs-earnings"></canvas>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="row items-push text-center w-100">
                                <div class="col-sm-4">
                                    <dl class="mb-0">
                                        <dt class="font-size-h3 font-w700">
                                            <i class="fa fa-check font-size-lg text-success"></i> 2.5
                                        </dt>
                                        <dd class="text-muted mb-0">Total Happy Monthly</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="mb-0">
                                        <dt class="font-size-h3 font-w700">
                                            <i class="fa fa-times font-size-lg text-success"></i> 3.8
                                        </dt>
                                        <dd class="text-muted mb-0">Total Sad Monthly</dd>
                                    </dl>
                                </div>
                                <div class="col-sm-4">
                                    <dl class="mb-0">
                                        <dt class="font-size-h3 font-w700">
                                            <i class="fa fa-lightbulb font-size-lg text-success"></i> 1.7
                                        </dt>
                                        <dd class="text-muted mb-0">Total idea Monthly</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Earnings Summary -->
                </div>

            </div>

            <!-- Customers and Latest Orders -->
            <div class="row row-deck">
                <!-- Latest Customers -->
                <div class="col-lg-6">
                    <div class="block block-rounded block-mode-loading-oneui">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Latest Tickets</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <table
                                class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 80px;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-center" style="width: 190px;">
                                            Created From</th>
                                        <th class="font-w700">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-center" style="width: 80px;">
                                            Departmant</th>
                                        <th class="font-w700 text-center" style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($last_tickets && $last_tickets->count())
                                        @foreach ($last_tickets as $ticket)
                                            <tr>
                                                <td>
                                                    <span class="font-w600">{{ $ticket->id }}</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell text-center">
                                                    {{ $ticket->created_at->diffForHumans(Carbon\Carbon::now()) }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="font-w600 text-warning">{{ $ticket->status->name }}</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    {{ $ticket->to_department->dep_name }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                                        onclick="ViewTicket('{{ $ticket->id }}')" data-placement="left"
                                                        title="View">
                                                        <i class="fa  fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END Latest Customers -->

                <!-- Latest Orders -->
                <div class="col-lg-6">
                    <div class="block block-rounded block-mode-loading-oneui">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Latest Tasks</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <table
                                class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th class="font-w700">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700">Created At</th>
                                        <th class="font-w700">State</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 120px;">
                                            Department</th>
                                        <th class="font-w700 text-center" style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($last_tasks && $last_tasks->count())
                                        @foreach ($last_tasks as $task)
                                            <tr>
                                                <td>
                                                    <span class="font-w600">{{ $task->id }}</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span
                                                        class="font-size-sm text-muted">{{ $task->created_at->diffForHumans(Carbon\Carbon::now()) }}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-warning">{{ $task->status->name }}</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    {{ $task->department->dep_name }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                                        onclick="ViewTask('{{ $task->id }}')" data-placement="left"
                                                        title="View">
                                                        <i class="fa  fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END Latest Orders -->
            </div>
            <!-- END Customers and Latest Orders -->
        </div>
        <!-- END Page Content -->
    </main>

    @push('scripts')
        @include('layouts.dashboard_script')
    @endpush

@stop
