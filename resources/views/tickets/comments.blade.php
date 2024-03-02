@extends('layouts.admin')
@section('content')


    <main id="main-container">



        <div class="content content-boxed">
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <!-- Updates -->
                    <a style="margin:5px ;" href="{{ url('ticket/show-model/' . $ticket_id) }}">
                        <button class="btn btn-primary"><i class="fa fa-list"></i> Back </button>
                    </a>
                    <form method="POST" action="{{ route('ticket.comments.create', $ticket_id) }}">
                        <h1>Add New Comment</h1>
                        <input type="hidden" value="{{ Auth::id() }}" name="uid">
                        <input type="hidden" value="{{ $ticket_id }}" name="ticket_id">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="js-ckeditor5-classic" name="comment"></textarea>
                        </div>
                        @include('layouts.dropzone')
                        <button type="submit" class="btn btn-rounded  bg-flat-light"> <i class="fa fa-database"></i> Save
                        </button>
                    </form>
                    <hr>
                    <ul class="timeline timeline-alt py-0">
                        {{-- <li class="timeline-event">
                            <div class="timeline-event-icon bg-default">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                            <div class="timeline-event-block block invisible" data-toggle="appear">
                                <div class="block-header">
                                    <h3 class="block-title">Facebook</h3>
                                    <div class="block-options">
                                        <div class="timeline-event-time block-options-item font-size-sm">
                                            just now
                                        </div>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <p class="font-w600 mb-2">
                                        + 290 Page Likes
                                    </p>
                                    <p>
                                        This is great, keep it up!
                                    </p>
                                </div>
                            </div>
                        </li> --}}
                        @if ($comments && $comments->count() > 0)
                            @foreach ($comments as $comment)
                                @if (!is_null($comment->Ticket->users))
                                    @if ($comment->Ticket->users->email)
                                        @php
                                            $mail = $comment->Ticket->users->email;
                                        @endphp
                                    @endif
                                @endif
                                <li class="timeline-event">
                                    <div class="timeline-event-icon bg-modern">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="timeline-event-block block invisible" data-toggle="appear">
                                        <div class="block-header">
                                            <h3 class="block-title">{{ $comment->User->name }}</h3>
                                            <div class="block-options">
                                                <div class="timeline-event-time block-options-item font-size-sm">
                                                    {{ date('Y-m-d H:i:s', strtotime($comment->created_at)) }}
                                                    ({{ $comment->created_at->diffForHumans(Carbon\Carbon::now()) }})
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full">
                                            <p class="font-w600 mb-2">
                                                {!! html_entity_decode($comment->comment) !!}

                                            </p>
                                            <h5>Attachment</h5>
                                            <h6>Mail Send To Creator : ({{ $mail }})</h6>
                                            <a href="{{ route('ticket.comments.mail', $comment->id) }}">
                                                <button type="button" class="btn btn-rounded  bg-flat-light">
                                                    <i class="fa fa-envelope"></i>
                                                    Sent Mail With Attachment
                                                </button>
                                            </a>
                                            <br><br>
                                            {{-- @if ($ticket->status_id != 3 || $ticket->status_id != 4) --}}
                                            @if (!in_array($ticket->status_id, [3, 4]))
                                                @if ($in_dep && check_create_permission(8))
                                                    <a
                                                        href="{{ route('ticket.comments.mail.with.confirm', $comment->id) }}">

                                                        <button type="button" class="btn btn-rounded  bg-flat-light">
                                                            <i class="fa fa-envelope"></i>
                                                            Sent Mail With Attachment & Confirm Ticket With All Tasks
                                                            ({{ $all_tasks }})

                                                        </button>
                                                    </a>
                                                @endif
                                            @endif

                                            </br></br>
                                            <div class="d-flex">
                                                @if ($comment->CommentAttachment && $comment->CommentAttachment->count() > 0)
                                                    @foreach ($comment->CommentAttachment as $attach)
                                                        <a class="item item-rounded bg-info mr-2"
                                                            href="{{ URL::asset('uploads/attach/' . $attach->file) }}"
                                                            target="_blank">
                                                            <i class="far fa-copy fa-2x text-white-75"></i>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                    <!-- END Updates -->
                </div>
            </div>
        </div>
    </main>

@stop

@push('scripts')
    <script src="{{ URL::asset('admin/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script>
        jQuery(function() {

            One.helpers(['ckeditor5']);
        });
    </script>
@endpush
