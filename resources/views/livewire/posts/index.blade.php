<div>
    <main id="main-container">

        <!-- Hero -->
        <div class="bg-body-light">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill h3 my-2">
                        Posts
                        <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">
                            New Information For Clinets
                        </small>
                    </h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="link-fx" href="">Posts</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="block block-rounded">
                <div class="block-header">
                    <a href="{{ route('posts.create') }}">
                        <button class="btn btn-primary">
                            Add New Post
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
                                        <th>Title</th>
                                        <th class="d-none d-sm-table-cell">Created By</th>
                                        <th class="d-none d-sm-table-cell">Created At</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <th class="text-center" scope="row">{{ $post->id }}</th>
                                            <td class="font-w600 font-size-sm">
                                                {{ $post->title }}</a>
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ $post->User->name }}
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                {{ date('Y-m-d H:i:s', strtotime($post->created_at)) }}
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('posts.edit', $post->id) }}">
                                                        <button type="button"
                                                            class="btn btn-sm btn-light js-tooltip-enabled"
                                                            data-toggle="tooltip" title=""
                                                            data-original-title="Edit Client">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </button>
                                                    </a>

                                                    <button wire:click="delete({{ $post->id }})"
                                                        type="button"class="btn btn-sm btn-light js-tooltip-enabled">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Dynamic Table Full -->




        </div>
        <!-- END Page Content -->
    </main>
</div>
