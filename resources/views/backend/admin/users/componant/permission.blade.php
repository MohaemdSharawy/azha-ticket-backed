<div class="card">
    <div class="card-header">
        User Permission
    </div>
    <div class="card-body">

        <form action="{{ route('update.user.permission', $user->id) }}" method="POST">
            @csrf
            <table id="" class="table" style="margin-top:2%;width:100%;">
                <thead>
                    <tr>
                        <th width="20%">Module</th>
                        <th width="5%">View</th>
                        <th width="8%">Private View</th>
                        <th width="5%">Create</th>
                        <th width="5%">Edit</th>
                        <th width="5%">Remove</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $key => $module)
                        <tr>
                            <td width="20%">
                                <input type="hidden" name="accs[{{ $module['id'] }}][id]"
                                    value="{{ isset($modules[$key]['permission']['id']) ? $modules[$key]['permission']['id'] : '' }}">
                                <input type="hidden" name="accs[{{ $module['id'] }}][module_id]"
                                    value="{{ $modules[$key]['id'] }}">
                                <strong> {{ $module['name'] }} </strong>
                            </td>

                            <td width="5%">
                                @if ($modules[$key]['view'] == 1)
                                    <label style="padding-left: 20px;">
                                        <input type='hidden' value='0' name='accs[{{ $module['id'] }}][view]'>
                                        <input type="checkbox" name="accs[{{ $module['id'] }}][view]" value="1"
                                            class="listCheckbox"
                                            {{ isset($modules[$key]['permission']['view']) && $modules[$key]['permission']['view'] == '1' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                            </td>
                            <td width="5%">
                                @if ($modules[$key]['p_view'] == 1)
                                    <label style="padding-left: 50px;">
                                        <input type='hidden' value='0' name='accs[{{ $module['id'] }}][p_view]'>
                                        <input type="checkbox" name="accs[{{ $module['id'] }}][p_view]" value="1"
                                            class="listCheckbox"
                                            {{ isset($modules[$key]['permission']['p_view']) && $modules[$key]['permission']['p_view'] == '1' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                            </td>
                            <td width="5%">
                                @if ($modules[$key]['create'] == 1)
                                    <label style="padding-left: 20px;">
                                        <input type='hidden' value='0' name='accs[{{ $module['id'] }}][create]'>
                                        <input type="checkbox" name="accs[{{ $module['id'] }}][create]" value="1"
                                            class="listCheckbox"
                                            {{ isset($modules[$key]['permission']['create']) && $modules[$key]['permission']['create'] == '1' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                            </td>
                            <td width="5%">
                                @if ($modules[$key]['edit'] == 1)
                                    <label style="padding-left: 10px;">
                                        <input type='hidden' value='0' name='accs[{{ $module['id'] }}][edit]'>
                                        <input type="checkbox" name="accs[{{ $module['id'] }}][edit]" value="1"
                                            class="listCheckbox"
                                            {{ isset($modules[$key]['permission']['edit']) && $modules[$key]['permission']['edit'] == '1' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                            </td>
                            <td width="5%">
                                @if ($modules[$key]['remove'] == 1)
                                    <label style="padding-left: 30px;">
                                        <input type='hidden' value='0' name='accs[{{ $module['id'] }}][remove]'>
                                        <input type="checkbox" name="accs[{{ $module['id'] }}][remove]" value="1"
                                            class="listCheckbox"
                                            {{ isset($modules[$key]['permission']['remove']) && $modules[$key]['permission']['remove'] == '1' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                @endif
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" name="submit" class="btn btn-primary " style="margin-top:5%;width:15%">
                <strong><i class=" fas fa-dot-circle"></i>&nbsp; Save</strong>
            </button>
        </form>


    </div>
</div>
