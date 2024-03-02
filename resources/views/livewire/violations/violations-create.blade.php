
<div wire:ignore>

    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Violations <small>Create</small></h3>
                        </div>
                        <div class="block-content">
                            <form class="js-validation" method="POST" action="{{ route('posts.store') }}"
                                enctype="multipart/form-data" wire:submit="save">
                                <input type="hidden" value="department_report" name="report_type">

                                @csrf
                                <div class="form-group">
                                    <label for="example-ltf-email2">Actions</label>
                                    <select class=" form-control boot-select" name="action_id" required
                                        data-live-search="true" wire:model="action_id"
                                        wire:change="select_action($event.target.value)">
                                        <option></option>
                                        @foreach ($actions as $action)
                                            <option value="{{ $action->id }}">
                                                {{ $action->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="from_date">Cost</label>
                                    <input type="text" class=" form-control " wire:model="cost" disabled>
                                </div>


                                <div class="form-group">
                                    <label for="example-ltf-email2">Actions</label>
                                    <select class=" form-control boot-select" name="action_id" required
                                        data-live-search="true" wire:model="unite_id">
                                        <option></option>
                                        @foreach ($unites as $unite)
                                            <option value="{{ $unite->id }}">
                                                {{ $unite->unite_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- @include('layouts.dropzone') --}}

                                <livewire:admin.custom-dropzone wire:model="photos" :folder="'violations'" />


                                {{-- <div class="form-group">
                                    <label> Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled"
                                            data-toggle="custom-file-input" id="one-profile-edit-avatar" name="image">
                                        <label class="custom-file-label" for="one-profile-edit-avatar">Choose a new
                                            Image</label>
                                    </div>
                                </div> --}}

                                <button class="btn btn-info" type="submit">Save</button>

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

</div>
