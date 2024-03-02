<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">{{ $user->name }}</h3>
    </div>
    <div class="block-content block-content-full">
        <div class="row">

            <div class="col-lg-12">

                {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="example-ltf-email2">User Name</label>
                        <input type="text" class="form-control form-control-alt" id="example-ltf-email2"
                            name="name" placeholder="User Name" required value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">User Email</label>
                        <input type="email" class="form-control form-control-alt" id="example-ltf-email2"
                            name="email" placeholder="User Email" required value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">Password</label>
                        <input type="password" class="form-control form-control-alt" id="example-ltf-email2"
                            name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">Hotels</label>
                        <select class="boot-select form-control" name="hotels[]" data-live-search="true"
                            data-style="btn-info" multiple required>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    @if (isset($user->id)) {{ array_assoc_value_exists($users_hotels, 'hid', $hotel->id) ? 'selected="selected"' : false }} @endif>
                                    {{ $hotel->code }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-ltf-email2">Departments</label>
                        <select class=" boot-select form-control" name="dep[]" data-live-search="true"
                            data-style="btn-info" multiple required>
                            @foreach ($departments as $dep)
                                <option value="{{ $dep->id }}"
                                    @if (isset($user->id)) {{ array_assoc_value_exists($user_departments, 'dep_id', $dep->id) ? 'selected="selected"' : false }} @endif>
                                    {{ $dep->dep_code }} </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">

                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="example-switch-custom2"
                                name="worker" value="1" @if ($user->is_worker == 1) checked @endif>
                            <label class="custom-control-label" for="example-switch-custom2">
                                Worker
                            </label>
                        </div>
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="example-switch-custom3"
                                name="notify" value="1" @if ($user->notify == 1) checked @endif>
                            <label class="custom-control-label" for="example-switch-custom3">
                                Notification
                            </label>
                        </div>
                        <div class="custom-control custom-switch mb-1">
                            <input type="checkbox" class="custom-control-input" id="example-switch-custom4"
                                name="can_login" value="1" @if ($user->can_login == 1) checked @endif>
                            <label class="custom-control-label" for="example-switch-custom4">
                                Can login
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
