<div>
    <div>
        <main id="main-container">

            <!-- Hero -->
            <div class="bg-body-light">
                <div class="content content-full">
                    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                        <h1 class="flex-sm-fill h3 my-2">
                            categories
                            <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">
                                All category Reqiestes
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
                                    <a class="link-fx" href="">categories</a>
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
                        <button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#category" wire:click="set_value">Create
                            Add New category<i class="fa fa-edit"></i></button>
                        {{-- <a href="{{ route('discover-category.create') }}">
                            <button class="btn btn-primary">
                                Add New category
                            </button>
                        </a> --}}
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
                                            <th>Name Ar</th>
                                            <th>Name En</th>
                                            <th class="d-none d-sm-table-cell">Created At</th>
                                            <th>Active</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $category->id }}</th>
                                                <td class="font-w600 font-size-sm">
                                                    {{ $category->title_en }}
                                                </td>
                                                <td class="font-w600 font-size-sm">
                                                    {{ $category->title_ar }}
                                                </td>


                                                <td class="font-w600 font-size-sm">
                                                    {{ date('Y-m-d H:i:s', strtotime($category->created_at)) }}
                                                </td>
                                                <td>
                                                    <i id="mail_stats-285">
                                                        @if($category->active == 1)
                                                            <button class="btn btn-success js-swal-info" wire:click='activation(({{ $category->id}}))'><i class="fa fa-check"></i></button>
                                                        @else
                                                            <button class="btn btn-danger js-swal-info" wire:click='activation(({{ $category->id}}))'><i class="fa fa-fw fa-times"></i></button>
                                                        @endif
                                                    </i>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                            <button type="button"
                                                                wire:click='set_value({{ $category->id}})'
                                                                class="btn btn-sm btn-light js-tooltip-enabled"
                                                                data-toggle="modal" data-target="#category">
                                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                                            </button>

                                                        <button wire:click="delete({{ $category->id }})"
                                                            type="button"class="btn btn-sm btn-light js-tooltip-enabled">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Dynamic Table Full -->




            </div>
            <!-- END Page Content -->
        </main>
        <!-- Modal -->
        <div class="modal fade" id="category" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="categoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h5 class="modal-title" id="categoryLabel" style="color: white;">Add New Hotel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color: white;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit="save" enctype="multipart/form-data">

                            <label>Title English*</label>
                            <input type="text" class="form-control" name="hotel_name" required wire:model="title_en">
                            <br>
                            <label>Title Arabic</label>
                            <input type="text" class="form-control" wire:model="title_ar">
                            <br>
                            <label>Discription English</label>
                            <input type="text" class="form-control" wire:model="description_en">
                            <br>
                            <label>Discription Arabic</label>
                            <input type="text" class="form-control" wire:model="description_ar">
                            <label>Rank</label>
                            <input type="number" class="form-control"wire:model="rank" wire:model="rank">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
