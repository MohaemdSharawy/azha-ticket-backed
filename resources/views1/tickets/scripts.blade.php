<script>
    Echo.channel('event').listen('RealTimePush', (e) =>
        (e.message) ? fillter() : ''
    );
    var mainTicket;
    var user_department;
    var pmsHotel;
    var selected_ticket;
    var prev = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() - 1)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)
    var today = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)
    $("#from_time").val(prev);
    $("#to_time").val(today);


    /////////////////////////////////////////////////////////////////////////////#
    //                                                                           #
    //                                                                           #
    //                                                                           #
    //                                                                           #
    // /////////////////////////Inedx PageScripts/////////////////////////////////
    //                                                                           #
    //                                                                           #
    //                                                                           #
    /////////////////////////////////////////////////////////////////////////////#


    function fillter() {
        $('#ticket').DataTable().destroy();
        getData();
    }

    function getData() {
        hotels = $('#hotels').val();
        from_time = $('#from_time').val();
        to_time = $('#to_time').val();
        status = $('#status').val();
        types = $('#types').val();
        priority = $('#priority').val();



        $.ajax({
            url: "{{ route('ticket.data') }}",
            type: "GET",
            dataType: "json",
            data: {
                hotels,
                from_time,
                to_time,
                status,
                priority,
                types
            },
            success: function(data) {
                $('#ticket').DataTable({
                    "data": data.ticket,
                    "responsive": true,
                    order: [
                        [0, "DESC"]
                    ],
                    "columns": [{
                            "data": "id",
                        },
                        {
                            "render": function(data, type, row, meta) {
                                if (row.room_id != null) {
                                    return `${row.room.room_num + ' ' + row.room.guest_name}`;

                                } else {

                                    return `${row.facility.name}`;
                                }
                            }
                        },
                        {
                            "data": "hotels",
                            "render": function(data, type, row, meta) {
                                return `${row.hotels.hotel_name}`;
                            }
                        },
                        {
                            "data": "status",
                            "render": function(data, type, row, meta) {
                                return `${row.status.name}`;
                            }
                        },
                        {
                            "data": "level",
                            "render": function(data, type, row, meta) {
                                return `<span class="${row.level.color}" >${row.level.name}</span>`;
                            }
                        },
                        {
                            "data": "created_at",
                            "render": function(data, type, row, meta) {
                                return moment(row.created_at).format('MMMM Do YYYY')
                            }

                        },

                        {
                            "render": function(data, type, row, meta) {
                                let actions = '';
                                actions +=
                                    `<button onclick="ViewTicket('${row.id}')" class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button></a> `;

                                return actions;
                            }
                        }

                    ]
                })
            }
        })
    }


    /////////////////////////////////////////////////////////////////////////////#
    //                                                                           #
    //                                                                           #
    //                                                                           #
    //                                                                           #
    /////////////////////////////View PageScripts/////////////////////////////////
    //                                                                           #
    //                                                                           #
    //                                                                           #
    /////////////////////////////////////////////////////////////////////////////#


    function ViewTicket(TicketId) {
        $('#master').addClass('active')
        $.ajax({
            url: "{{ url('ticket/show') }}" + '/' + TicketId,
            dataType: "json",
            type: 'GET',
            success: function(data) {
                mainTicket = data.ticket;
                selected_ticket = mainTicket;
                user_department = data.user_dep;
                $('.viewTicket').modal('show')
                buildTicketData(data.ticket)
                buildTicketTabs(data.subTickets)
            }
        });
    }

    function buildTicketTabs(subTicket) {
        $('.sub-tabs').empty();
        let index = 1;
        subTicket.forEach(element => {
            index++;
            let sub_data = encodeURIComponent(JSON.stringify(element))
            $('.sub-tabs').append(`
            <li class="nav-item">
                <a class="nav-link  ticket-taps" id="sub-${element.id}"  onclick="ToggleTicket('${sub_data}')">${index}- Ticket# ${element.id}</a>
             </li>
            `)
        })
    }

    function buildTicketData(ticket) {
        var output = '';
        let color = 'color:' + ticket.status.color + '';
        let action_output = '';

        var created_at = moment(ticket.created_at).format('MMMM Do YYYY');

        if (ticket.room_id != null) {
            output += `<tr><td style="width: 20%;">Name</td>
            <td style="${color}">Room - ${ticket.room.room_num}</td> </tr>`
        } else {
            output += `<tr><td style="width: 20%;">Name</td>
            <td style="${color}">Name ${ticket.facility.name}</td> </tr>`
        }
        output += `<tr><td style="width: 20%;">Hotel</td>
            <td style="${color}">${ticket.hotels.hotel_name}</td> </tr>`
        output += `<tr><td style="width: 20%;">Department</td>
            <td style="${color}">${ticket.to_department.dep_name}</td> </tr>`
        output += `<tr><td style="width: 20%;"><i class="fa fa-server text-muted mr-1" > Service</td>
            <td style="${color}">${ticket.services.name}</td> </tr>`
        output += `<tr><td style="width: 20%;"><i class="fa fa-circle-notch text-muted mr-1" > Status</td>
            <td style="${color}">${ticket.status.name}</td> </tr>`
        output += `<tr><td style="width: 20%;"><i class="fa fa-bolt text-muted mr-1"> Priority</td>
            <td ><span class="${ticket.level.color}">${ticket.level.name}</span>
            </td> </tr>`
        output += `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-calendar text-muted mr-1"></i> Date</td><td style="${color}">${created_at}</td></tr>`
        output +=
            `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-user text-muted mr-1"></i> Created By</td><td style="${color}">${ticket.users.name}</td></tr>`
        if (ticket.description != null) {
            output +=
                `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-align-left text-muted mr-1"></i>Description</td><td style="${color}">
                <div id="faq3" role="tablist" aria-multiselectable="true">
                    <div class="block block-rounded block-bordered mb-1">
                        <a class="text-muted" data-toggle="collapse" data-parent="#faq3" href="#faq3_q3" aria-expanded="true" aria-controls="faq3_q3">
                            <div class="block-header block-header-default" role="tab" id="faq3_h3">
                                Details
                            </div>
                        </a>
                        <div id="faq3_q3" class="collapse" role="tabpanel" aria-labelledby="faq3_h3" data-parent="#faq3">
                            <div class="block-content">
                                {!! html_entity_decode('${ticket.description}') !!}
                            </div>
                        </div>
                    </div>
                </div>
                </td></tr>`
        }
        $('.ticket-body').empty();
        $('.ticket-body').append(output);
        $('.actions').empty();

        action_output += `<h4>Ticket Action</h4>  `
        if (ticket.status_id == 5) {
            action_output += `<button class="btn btn-rounded  bg-flat-light">Completed</button>`
        }
        if (ticket.status_id == 3) {
            action_output += `
                <button class="btn btn-rounded  btn-success">Guest Confirm</button><br><br>
                <button class="btn btn-rounded  btn-danger">Re-open</button>`
        }
        if (mainTicket.status_id != 4 && mainTicket.status_id != 3) {
            action_output +=
                `<a target="_blank" href="{{ url('ticket/create/${mainTicket.id}') }}"><button class="btn btn-rounded  btn-info"  >Create Sub Ticket</button></a>`
        }

        action_output += '<hr>'

        if (ticket.end_at != null) {
            let created_at = moment(ticket.created_at)
            let end_at = moment(ticket.end_at);
            action_output += `
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr><td>Time To End Ticket: ${moment.duration(created_at.diff(end_at)).humanize() } </td></tr>
                </tbody>
            </table>`
        }
        action_output += `<br><br><hr>`
        $('.actions').append(action_output);

        buildTasksTaps(ticket.tasks)
        buildTaskData(ticket.tasks[0])
    }




    function buildTasksTaps(tasks) {
        $('#tasks_tab').empty()
        let index = 0;
        tasks.forEach(element => {
            index++
            let sub_data = encodeURIComponent(JSON.stringify(element))
            if (index == 1) {
                $('#tasks_tab').append(`
                <li class="nav-item mb-1 ">
                    <a class="nav-link  active d-flex justify-content-between align-items-center nav-ticket-list"
                        href="javascript:void(0)" onclick="ToggleTask('${sub_data}')" id="task-${element.id}">
                        Task ${index}
                    </a>
                </li>`);
            } else {
                $('#tasks_tab').append(`
                    <li class="nav-item mb-1 ">
                        <a class="nav-link  d-flex justify-content-between align-items-center nav-ticket-list"
                            href="javascript:void(0)" onclick="ToggleTask('${sub_data}')" id="task-${element.id}">
                            Task ${index}
                         </a>
                    </li>`);
            }
        });
    }

    function ToggleTask(task) {
        $('.nav-ticket-list').removeClass('active');
        task_data = JSON.parse(decodeURIComponent(task))
        $(`#task-${task_data.id}`).addClass('active')
        buildTaskData(task_data)
    }

    function buildTaskData(task) {
        var output = '';
        var actions = '';
        let color = 'color:' + task.status.color + '';

        output += `<tr><td style="width: 20%;">Name</td>
                <td style="${color}">${task.name}</td> </tr>`
        output += `<tr><td style="width: 20%;">Status</td>
                <td style="${color}"> ${task.status.name}</td> </tr>`
        if (task.user != null) {
            output += `<tr><td style="width: 20%;">worker</td>
                    <td style="${color}"> ${task.user.name}</td> </tr>`
        } else {
            if ("{{ check_create_permission('8') }}" && user_department.includes(task.dep_id)) {

                getDepartmentUser(task.dep_id, task.id, 'worker')
                output += `<tr><td style="width: 20%;">Assign User</td>
                <td id="assign_user">
                </tr>`
            }
        }
        output += `<tr><td style="width: 20%;">Department</td>
                <td style="${color}"> ${task.department.dep_name}</td> </tr>`
        output +=
            `<tr><td style="width: 20%;">Time</td>
                <td style="${color}" > At  ${moment(task.created_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.created_at).fromNow()} )</td> </tr>`
        if (task.assigned_at) {
            output +=
                `<tr><td style="width: 20%;">Assinged At</td>
                <td style="${color}"> At  ${moment(task.assigned_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.assigned_at).fromNow()} )</td> </tr>`
        }
        if (task.end_at) {
            output +=
                `<tr><td style="width: 20%;">End At</td>
                    <td style="${color}">At  ${moment(task.end_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.end_at).fromNow()} )</td> </tr>`
        }

        let encodedData = encodeURIComponent(JSON.stringify(task))

        $('.task-action').empty()
        actions += `<h4>Task Actions</h4>`
        actions +=
            `<button class="btn btn-rounded  bg-flat-light" onclick="sendReminder('${encodedData}')">Send Message</button> `

        let check_satatus = [1, 2, 5].includes(selected_ticket.status_id)

        if ("{{ check_create_permission('8') }}" && user_department.includes(task.dep_id) && check_satatus) {

            actions +=
                `<button class="btn btn-rounded  btn-info" style="margin-left: 10px;" onclick="createTask('${encodedData}')">Add Task</button> `
        }
        if ([2, 5].includes(task.status_id)) {
            actions +=
                `<br><br><a href="{{ url('task/change_status/${task.id}/3') }}"><button class="btn btn-rounded  btn-info" >Confirm</button></a>`
        }

        if (task.assigned_at != null) {
            actions += '<br><br><h4>Time Sheet</h4>'
            let created_at = moment(task.created_at)
            let assign_at = moment(task.assigned_at);
            let end_at = moment(task.end_at);
            actions += `  <table class="table table-striped table-borderless"><tbody>`
            actions +=
                ` <tr><td> Time To assign :</td><td>  ${moment.duration(created_at.diff(assign_at)).humanize() }  </td></tr>`
            if (task.end_at != null) {
                actions +=
                    `<tr><td>Workin Time :</td>   <td>${moment.duration(assign_at.diff(end_at)).humanize() } </td></tr>`
            }
            actions += `</tbody></table>`

        }



        $('.task-action').append(actions)

        $('.task-body').empty();
        $('.task-body').append(output);

    }

    function diff_time(time) {

    }

    function ToggleTicket(ticket = false) {
        $('.ticket-taps').removeClass('active');
        if (ticket) {
            ticket_data = JSON.parse(decodeURIComponent(ticket))
            $(`#sub-${ticket_data.id}`).addClass('active')
            selected_ticket = ticket_data;
            buildTicketData(ticket_data)
        } else {
            $('#master-ticket').addClass('active')
            selected_ticket = mainTicket;
            buildTicketData(mainTicket)
        }
    }

    function mapHotels(hid) {
        switch (hid) {
            case "1":
                pmsHotel = 5;
                break;
            case "2":
                pmsHotel = 7;
                break;
            case "3":
                pmsHotel = 3;
                break;
            case "4":
                pmsHotel = 2;
                break;
            case "5":
                pmsHotel = 6;
                break;
            case "6":
                pmsHotel = 4;
                break;
            case "7":
                pmsHotel = 1;
                break;
            case "8":
                pmsHotel = 9;
                break;
            case "9":
                pmsHotel = 10;
                break;
            case "10":
                pmsHotel = 19;
                break;
            case "11":
                pmsHotel = 20;
                break;
            case "12":
                pmsHotel = 22;
                break;
            case "13":
                pmsHotel = 23;
                break;
            case "14":
                pmsHotel = 24;
                break;
            case "15":
                pmsHotel = 25;
                break;
            case "16":
                pmsHotel = 26;
                break;
            case "17":
                pmsHotel = 21;
                break;
            case "19":
                pmsHotel = 27;
                break;
            default:
                console.log(`Sorry, we are out of ${hid}.`);
        }

    }

    function buildTaskTabs() {

    }

    function saveFacility() {
        let type_name = $('#facility_id option:selected').attr("name");
        let data = type_name.split('--');
        $('.hide-input').empty();
        $('.hide-input').append(`
            <input name="guest_name" value="${data[1] + data[2]}" type="hidden">
            <input name="room" value="${data[0]}" type="hidden">
            <input name="reservation_no" value="${data[3]}" type="hidden">
        `);
    }

    function getDepartmentUser(dep_id, task_id, type) {
        $.ajax({
            url: "{{ url('department/department_user') }}" + '/' + dep_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (type == "worker") {
                    addWorker(data.department.workers, task_id)
                } else {
                    userToReminder(data.department.users)
                }
            }
        })
    }

    function addWorker(workers, task_id) {
        $('#assign_user').empty()
        $('#assign_user').append(`
        <form method="POST" action="{{ route('task.assign.worker') }}">
            @csrf
            <input type="hidden" name="task_id" value="${task_id}">
            <div class="row">
                <div class="col-lg-8 ">
                    <div class="form-group">
                        <select class='js-select2 form-control' name="worker_id" id="worker" style="width: 100%;"
                                data-live-search="true" data-placeholder="Select Worker" required>
                        </select>
                    </div>
                </div>
                <div class="col-log-4">
                    <button  type="submit" class="btn btn-rounded  bg-flat-light">Save</button>
                </div>
            <div>
        </form>
        `)
        $('#worker').empty()
        $('#worker').select2()
        $('#worker').append(`<option></option>`)
        workers.forEach(element => {
            if (element.in_task > 0) {
                $('#worker').append(`
                    <option  value="${element.id}"> ${element.name}  (In Task) </option>
                `)
            } else {
                $('#worker').append(`
                    <option value="${element.id}">${element.name}</option>
                `)
            }
        })
    }

    function sendReminder(task) {
        $('.create-task').empty()
        $('.sendResonse').show()
        task_data = JSON.parse(decodeURIComponent(task))

        getDepartmentUser(task_data.dep_id, task_data.id, 'User')
    }

    function userToReminder(Users) {
        $('#remder_user').empty()
        $('#remder_user').select2()
        $('#remder_user').append(`<option></option>`)
        Users.forEach(element => {
            $('#remder_user').append(`
                <option value="${element.id}">${element.name}</option>
            `)
        })
    }

    function closeReminder() {
        $('.sendResonse').hide()
    }

    function createTask(task) {
        let task_data = JSON.parse(decodeURIComponent(task))
        $('.sendResonse').hide()
        $('.create-task').empty()
        $('.create-task').append(`
            <form action="{{ route('task.create') }}"  method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" value="${task_data.ticket_id}" name="ticket_id">
                    <input type="hidden" value="${task_data.dep_id}" name="dep_id">
                    <input type="hidden" value="${task_data.hid}" name="hid">
                    <input type="hidden" value="{{ Auth::id() }}" name="uid">
                    <div class="col-6">
                        <label >Task Name</label>
                        <input type="text" name="name"  class="form-control"><br>
                        <button class="btn btn-rounded  btn-info" type="submmit">Confirm</button>
                    </div>
                    <div class="col-6">
                        <div id="editor"  name="description"></div>
                    </div>
                </div>
            </form>
            <br><br>
        `)
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    }




    /////////////////////////////////////////////////////////////////////////////#
    //                                                                           #
    //                                                                           #
    //                                                                           #
    //                                                                           #
    /////////////////////////////CreatePageScripts////////////////////////////////
    //                                                                           #
    //                                                                           #
    //                                                                           #
    /////////////////////////////////////////////////////////////////////////////#






    function typeChange() {
        let type = $('#type_id').val();
        let type_name = $('#type_id option:selected').attr("name");
        $('#lab_name').text(type_name);
        $('#rooms').show();
        if (type == "1") {
            getGuestData()
        } else {

            get_facilities();
        }
    }
    async function getGuestData() {
        mapHotels($('#h_id').val())
        var response = await fetch(
            "https://pms.sunrise-resorts.com:3000/reservations/get-reservation-in-house/?hotel=" +
            pmsHotel
        )
        var result = await response.json()
        $("#facility_id").empty();
        $('#facility_id').append('<option></option>');
        result.forEach(element => {
            $('#facility_id').append(`
                <option name="${element.room_number}--${element.firstname}--${element.lastname}--${element.reservation_no}">
                    ${element.room_number + ' '  +  element.firstname +  ' ' + element.lastname }
                </option>
            `)

        });
    }

    function get_facilities() {
        let type = $('#type_id').val();
        $.ajax({
            url: "{{ route('ticket.facility') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                type
            },
            success: function(data) {
                $("#facility_id").empty();
                data.facility.forEach(element => {
                    $('#facility_id').append('<option value="' + element.id + '"> ' +
                        element.name +
                        '</option>');
                });
            }
        });
    }

    function getServices() {
        let dep_id = $('#dep').val();
        $.ajax({
            url: "{{ route('ticket.dep_service') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                dep_id
            },
            success: function(data) {
                $("#services").empty();
                data.services.forEach(element => {
                    $('#services').append('<option value="' + element.id + '"> ' +
                        element.name +
                        '</option>');
                });
            }
        });
    }
</script>