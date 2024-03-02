<script>
    Echo.channel('user_active').listen('ActiveUserEvent', (e) =>
        onlineUser()
        // console.log('sent')
    );
    var auth_mail = "{{ Auth::user()->email }}"

    function activeTap(TapId) {
        var activeId = $(".active");
        activeId.removeClass("active");
        $('#side_title').empty();

        $('#side_title').append(TapId);
        $('#' + TapId + '').addClass("active");

        if (TapId == 'starred') {
            StarLoad()
        }
        if (TapId == 'inbox') {
            inboxLoad()
        }
        if (TapId == 'sent') {
            sendLoad()
        }
        if (TapId == 'deleted') {
            deletedLoad()
        }


    }

    function setStar(status, Id) {
        var mail_status;
        if (status == 0) {
            mail_status = 1
        } else {
            mail_status = 0
        }
        url = "{{ route('star') }}"
        $.ajax({
            url: url,
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": Id,
                "status": mail_status
            },
            success: function(data) {
                $('#star-' + data.id + '').empty()
                if (data.star_status == 0) {
                    $('#star-' + data.id + '').append(
                        '<i  onclick="setStar(' + data.star_status + '  , ' + data.id +
                        ')"class="fa fa-star text-defult"></i>'
                    );
                    $('#star_count').empty();
                    $('#star_count').append(data.count);

                    One.helpers('notify', {
                        type: 'danger',
                        icon: 'fa fa-check mr-1',
                        message: data.message
                    });

                } else {
                    $('#star-' + data.id + '').append(
                        '<i  onclick="setStar(' + data.star_status + '  , ' + data.id +
                        ')"class="fa fa-star text-warning"></i>'
                    );
                    $('#star_count').empty();
                    $('#star_count').append(data.count);
                    One.helpers('notify', {
                        type: 'success',
                        icon: 'fa fa-check mr-1',
                        message: data.message
                    });
                }
            }
        });

    }




    function StarLoad() {
        $.ajax({
            url: "{{ route('get_star') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.main_mails').empty()
                console.log(data.result);
                for (let i = 0; i < data.result.length; i++) {
                    if (data.result[i]['from'] == auth_mail) {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].to +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            '</a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '}}"> <i onclick="setStar(1  , ' + data.result[i].id +
                            ')"class="fa fa-star text-warning"></i> </td>'
                        );

                    } else {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].from +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '}}"><i onclick="setStar(1  , ' + data.result[i].id +
                            ')"class="fa fa-star text-warning"></i> </td>'
                        )
                    }

                }
            }
        });
    }


    function inboxLoad() {
        $.ajax({
            url: "{{ route('get_inbox_ajax') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.main_mails').empty()
                for (let i = 0; i < data.result.length; i++) {
                    if (data.result[i]['from'] == auth_mail) {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].to +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '">  </td>'
                        );

                        $('#star-' + data.result[i].id + '').empty()

                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            console.log(data.result[i].id);

                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }

                    } else {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].from +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '"></td>'
                        )
                        $('#star-' + data.result[i].id + '').empty()
                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }
                    }

                }
            }
        });
    }

    function sendLoad() {
        $.ajax({
            url: "{{ route('get_send_ajax') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.main_mails').empty()
                for (let i = 0; i < data.result.length; i++) {
                    if (data.result[i]['from'] == auth_mail) {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].to +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '">  </td>'
                        );

                        $('#star-' + data.result[i].id + '').empty()

                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            console.log(data.result[i].id);

                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }

                    } else {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].from +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '"></td>'
                        )
                        $('#star-' + data.result[i].id + '').empty()
                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }
                    }

                }
            }
        });
    }


    function deletedLoad() {
        $.ajax({
            url: "{{ route('get_deleted_ajax') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                $('.main_mails').empty()
                for (let i = 0; i < data.result.length; i++) {
                    if (data.result[i]['from'] == auth_mail) {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].to +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            ' </a></td>  <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td>   <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '">  </td>'
                        );

                        $('#star-' + data.result[i].id + '').empty()

                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            console.log(data.result[i].id);

                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }

                    } else {
                        $('.main_mails').append(
                            '<tr><td class="text-center" style="width: 60px;"> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" id="inbox-msg15"name="inbox-msg15">  <label class="custom-control-label font-w400" for="inbox-msg15"></label></div></td> <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">' +
                            data.result[i].from +
                            '</td> <td> <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message" href="#">' +
                            data.result[i].description +
                            '</a></td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;"><em> ' +
                            data.result[i].sent_at +
                            ' </em> </td> <td class="d-none d-xl-table-cell text-muted" style="width: 120px;" id="star-' +
                            data.result[i].id + '"></td>'
                        )
                        $('#star-' + data.result[i].id + '').empty()
                        if (data.result[i].starred == 1) {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(1  , ' + data
                                .result[i].id + ')"class="fa fa-star text-warning"></i> ')
                        } else {
                            $('#star-' + data.result[i].id + '').append('<i onclick="setStar(0  , ' + data
                                .result[i].id + ')"class="fa fa-star text-defult"></i> ')

                        }
                    }

                }
            }
        });

    }

    function onlineUser() {
        $.ajax({
            url: "{{ route('user.online') }}",
            dataType: "json",
            type: 'GET',
            success: function(data) {
                $('#active-user').empty()
                data.users.forEach(element => {
                    $('#active-user').append(`
                        <li>
                            <div class="media py-2">
                                <div class="mr-3 ml-2 overlay-container overlay-bottom">
                                        <img class="img-avatar img-avatar48" src="{{ URL::asset('admin/assets/media/avatars/avatar4.jpg') }}" alt="">
                                            <span class="overlay-item item item-tiny item-circle border border-2x border-white bg-success"></span>
                                    </div>
                                    <div class="media-body">
                                    <div class="font-w600">${element.name}</div>
                                </div>
                            </div>
                        </li>
                    `)
                });
            }
        });
    }

    function showMessage() {

    }
</script>
