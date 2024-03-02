<div>
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Violations
                        <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">
                            Penalties in Clients
                        </small>
                        {{--
                            //TODO
                            //ADD Filter Select Box
                            --}}
                        {{-- <br>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="example-ltf-email2">Actions</label>
                                <select class=" form-control boot-select" name="selected_actions[]" required
                                    data-live-search="true" wire:model.live="selected_actions">
                                    @foreach ($actions as $action)
                                        <option></option>
                                        <option value="{{ $action->id }}">
                                            {{ $action->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Violations</a>
                            </li>
                        </ol>
                    </nav>
                </div>

                {{-- <div class="form-group">
                        <label for="example-ltf-email2">Actions</label>
                        <select class=" form-control boot-select" name="hotel_id" required data-live-search="true">
                            @foreach ($actions as $action)
                                <option value="{{ $action->id }}">
                                    s</option>
                            @endforeach
                        </select>
                    </div> --}}
            </div>
        </div>
        <div class="content">
            <div class="block block-rounded">
                <div class="block-header">
                    <a href="{{ route('violations.create') }}">
                        <button class="btn btn-primary">
                            Add New Violations
                        </button>
                    </a>
                </div>
                <div class="block-content block-content-full">
                    <div class="block block-rounded">
                        <div class="block-header">
                            <label>
                                <select wire:model.live="limit" class="form-control form-control-sm">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="100">100</option>
                                </select>
                            </label>

                            <div class="block-options">
                                <input type="search" class="form-control form-control-sm" placeholder="Search.."
                                    wire:model.live="search">
                            </div>
                        </div>
                        <div class="block-content">
                            <table class="table table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">ID</th>
                                        <th>Reasons</th>
                                        <th>Unit</th>
                                        <th>Cost</th>
                                        <th class="d-none d-sm-table-cell">Owner</th>
                                        <th class="d-none d-sm-table-cell">Created At</th>
                                        <th class="d-none d-sm-table-cell">Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($violations as $violation)
                                        <tr>
                                            <th class="text-center" scope="row">{{ $violation->id }}</th>
                                            <td class="font-w600 font-size-sm">
                                                {{ $violation->V_Action->name }}
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ $violation->Unite->unite_name }}
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ $violation->cost }}
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ $violation->Unite->Owner->first_name . ' ' . $violation->Unite->Owner->last_name }}
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ date('Y-m-d H:i:s', strtotime($violation->created_at)) }}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-outline-dark dropdown-toggle" id="dropdown-default-outline-dark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{$violation->Status->name}}
                                                    </button>
                                                    <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-outline-dark">
                                                        @foreach ($status as $stat )
                                                            @if ($stat->name != 'Payed')
                                                                <a class="dropdown-item"     wire:confirm="Are you sure you want Change Status"  href="javascript:void(0)" wire:click='update_status({{ $violation->id}} , {{$stat->id}} )'>{{$stat->name}}</a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('posts.edit', $violation->id) }}">
                                                        <button type="button"
                                                            class="btn btn-sm btn-light js-tooltip-enabled"
                                                            data-toggle="tooltip" title=""
                                                            data-original-title="Edit Client">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </button>
                                                    </a>

                                                    <button wire:click="delete({{ $violation->id }})"
                                                        type="button"class="btn btn-sm btn-light js-tooltip-enabled">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $violations->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Dynamic Table Full -->




        </div>
        <!-- END Page Content -->
    </main>
</div>
