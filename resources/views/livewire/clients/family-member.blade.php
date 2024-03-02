<div>
    <div class="row">
        @foreach ($family_members as  $family)
            <div class="col-6">
                <a class="media py-2" href="{{route('clients.edit' ,$family->id)}}">
                    <div class="mr-3 ml-2 overlay-container overlay-left">
                        <img class="img-avatar img-avatar48" src="{{URL::asset('admin/assets/media/avatars/avatar2.jpg')}}" alt="">
                        <span
                            class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                    </div>
                    <div class="media-body">
                        <div class="font-w600">{{$family->first_name . ' ' . $family->last_name}}</div>
                        <div class="font-size-sm text-muted">{{$family->role}}</div>
                    </div>
                </a>
            </div>
            {{-- <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit Client" wire:click="change_status">
                <i class="fa fa-fw fa-pencil-alt"></i>
            </button> --}}
        @endforeach
    </div>
</div>
