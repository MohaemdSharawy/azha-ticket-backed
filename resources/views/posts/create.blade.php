@extends('layouts.admin')
@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Posts <small>Create</small></h3>
                        </div>
                        <div class="block-content">
                            <form class="js-validation" method="POST" action="{{ route('posts.store') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="department_report" name="report_type">

                                @csrf
                                <div class="form-group">
                                    <label for="example-ltf-email2">Hotels*</label>
                                    <select class=" form-control boot-select" name="hotel_id" required
                                        data-live-search="true">
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" name="{{ $hotel->hotel_name }}">
                                                {{ $hotel->hotel_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="from_date">Title</label>
                                    <input type="text" class=" form-control bg-white" name="title"required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="js-ckeditor5-classic" name="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label> Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input js-custom-file-input-enabled"
                                            data-toggle="custom-file-input" id="one-profile-edit-avatar" name="image">
                                        <label class="custom-file-label" for="one-profile-edit-avatar">Choose a new
                                            Image</label>
                                    </div>
                                </div>

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
    @push('scripts')
        <script src="{{ URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
        <script>
            jQuery(function() {

                One.helpers(['ckeditor5']);
            });
        </script>
    @endpush
@stop
