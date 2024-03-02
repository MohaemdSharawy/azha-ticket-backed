<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">{{ $client->first_name . ' ' . $client->last_name }}</h3>
    </div>
    <div class="block-content block-content-full">
        <div class="row">

            <div class="col-lg-12">

                {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="example-ltf-email2">First Name</label>
                        <input type="text" class="form-control form-control-alt" id="example-ltf-email2"
                            name="name" placeholder="User Name" required value="{{ $client->first_name }}">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">Last Name</label>
                        <input type="text" class="form-control form-control-alt" id="example-ltf-email2"
                            name="name" placeholder="User Name" required value="{{ $client->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">User Email</label>
                        <input type="email" class="form-control form-control-alt" id="example-ltf-email2"
                            name="email" placeholder="User Email" required value="{{ $client->email }}">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">Password</label>
                        <input type="password" class="form-control form-control-alt" id="example-ltf-email2"
                            name="password" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label> Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input js-custom-file-input-enabled" data-toggle="custom-file-input" id="one-profile-edit-avatar" name="one-profile-edit-avatar">
                            <label class="custom-file-label" for="one-profile-edit-avatar">Choose a new avatar</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="example-ltf-email2">Hotels</label>
                        <select class="boot-select form-control" name="hotels[]" data-live-search="true"
                            data-style="btn-info" multiple required>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    @if (isset($client->id))
                                        @if(in_array($hotel->id , $client_property))
                                        {{'selected="selected"'}}
                                        @endif
                                     @endif>
                                    {{ $hotel->code }} </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="form-group">

                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="example-switch-custom2"
                                name="worker" value="1" @if ($client->active == 1) checked @endif>
                            <label class="custom-control-label" for="example-switch-custom2">
                                Active
                            </label>
                        </div>

                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn-dark" style="margin-top: 30px; ">Save</button>
                    </div>
                </form>
                <!-- END Form Labels on top - Alternative Style -->
            </div>
        </div>
    </div>
</div>
