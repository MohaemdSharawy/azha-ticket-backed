<script>
    Echo.channel('event').listen('RealTimePush', (e) =>
        (e.message) ? fillter() : ''
    );

    var mainTicket;
    var user_department;
    var pmsHotel;
    var selected_ticket;
    var hid;
    var prev = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() - 0)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)
    var today = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)


    var show_queue;
    var queue;



    function yesterday() {
        var today = new Date();
        today.setDate(today.getDate() - 2);

        var yesterday = today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + ("0" + today
            .getDate()).slice(-2);

        return yesterday;
    }

    // var yesterday = new Date(Date.now() - 86400000);
    // console.log(yesterday);
    $("#from_time").val(yesterday());
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
        // $('#ticket').DataTable().ajax.reload();
        getData();
    }

    function getData() {
        hotels = $('#hotels').val();
        from_time = $('#from_time').val();
        to_time = $('#to_time').val();
        status_ids = $('#stat').val();
        types = $('#types').val();
        priority = $('#priority').val();
        department = $('#department').val();
        creator = $('#creator').val();
        // console.log(status_ids);

        $('#ticket').DataTable({
            ajax: {
                url: "{{ route('ticket.data') }}",
                type: "GET",
                dataType: "json",
                data: {
                    hotels,
                    from_time,
                    to_time,
                    status_ids,
                    priority,
                    types,
                    department,
                    creator
                },
                dataSrc: 'ticket'
            },
            "pageLength": 25,
            order: [
                [0, "DESC"]
            ],
            columns: [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        if (row.uid == null) {
                            return `<span style ='color:red'>${row.id}</span>`;
                        } else {
                            return `<span>${row.id}</span>`;

                        }
                    }
                },
                {
                    "render": function(data, type, row, meta) {
                        if (row.uid == null) {
                            if (row.room_id != null) {
                                return `<span style ='color:red'>${row.room.room_num + ' ' + row.room.guest_name}</span>`;

                            } else {

                                return `<span style ='color:red'>${row.facility.name}</span>`;
                            }
                        } else {

                            if (row.room_id != null) {
                                return `${row.room.room_num + ' ' + row.room.guest_name}`;

                            } else {

                                return `${row.facility.name}`;
                            }
                        }
                    }
                },
                {
                    "data": "hotels",
                    "render": function(data, type, row, meta) {
                        if (row.uid == null) {
                            return `<span style ='color:red'>${row.hotels.hotel_name}</span>`;

                        }
                        return `${row.hotels.hotel_name}`;
                    }
                },
                {
                    "data": "department",
                    "render": function(data, type, row, meta) {
                        if (row.uid == null) {
                            return `<span style ='color:red'>${row.to_department.dep_name}</span><br>
                                <span style ='color:red'>${row.services.name}</span>`;
                        }
                        if (row.to_dep == "15") {
                            return `<span>${row.to_department.dep_name}</span><br>
                                <span>${row.design_task}</span>`;
                        } else {
                            return `${row.to_department.dep_name}<br>
                                <span>${row.services.name}</span>`;

                        }
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta) {
                        if (row.uid == null) {
                            return `<span style ='color:red'>${row.status.name}</span>`;
                        }
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
                        // return moment(row.created_at).format('MMMM Do YYYY')



                        if (row.task != null && row.task.assigned_at != null) {
                            // return `Start: ${moment(row.created_at).format('DD-MM-YYYY  h:mm:ss a')}<br>
                            //         End:  ${moment(row.end_at).format('DD-MM-YYYY  h:mm:ss a')}`
                            return `Start: ${moment(row.created_at).format('DD-MM-YYYY  h:mm:ss a')}<br>
                                    Assign:  ${moment(row.task.assigned_at).format('DD-MM-YYYY  h:mm:ss a')}`
                        } else {
                            return `Start: ${moment(row.created_at).format('DD-MM-YYYY  h:mm:ss a')}`
                        }
                    }

                },

                {
                    "data": "end_at",
                    "render": function(data, type, row, meta) {
                        if (row.end_at === null) {
                            return '<span class="font-size-sm font-w600 px-2 py-1 rounded  bg-danger-light bg-gray">00:00</span>'
                        } else {

                            let creation = moment(row.created_at)
                            let end = moment(row.end_at)
                            let diff = end.diff(creation, 'minutes')
                            // console.log(diff);
                            // console.log(moment.utc(duration(diff, 'milliseconds')
                            //     .format('h [hours] m [minutes] s [seconds]')
                            //     ))

                            let t = moment(moment(end, "YYYY-MM-DD HH:mm:ss")
                                    .diff(
                                        moment(creation, "YYYY-MM-DD HH:mm:ss")))
                                .format("HH:mm")

                            // let duration = moment.duration(diff);
                            return `<span class="font-size-sm font-w600 px-2 py-1 rounded  "  style="background-color:${TimeColor(diff)}; color:white">
                                       ${moment.duration(creation.diff(end)).humanize()}
                                    </span>`
                        }
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
    };

    function getData_old() {
        hotels = $('#hotels').val();
        from_time = $('#from_time').val();
        to_time = $('#to_time').val();
        status = $('#status').val();
        types = $('#types').val();
        priority = $('#priority').val();
        department = $('#department').val();
        creator = $('#creator').val();


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
                types,
                department,
                creator
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
                            "data": "department",
                            "render": function(data, type, row, meta) {
                                return `${row.to_department.dep_name}<br>
                                <span>${row.services.name}</span>`;
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
                                return 'xxxxxxxxx';

                                // if (row.end_at != null) {
                                //     return `${moment(row.created_at).format('DD-MM-YYYY')}<br>
                                //     ${moment(row.end_at).format('DD-MM-YYYY')}`
                                // } else {
                                //     return `${moment(row.created_at).format('DD-MM-YYYY')}`
                                // }
                            }

                        },

                        {
                            "data": "end_at",
                            "render": function(data, type, row, meta) {
                                if (row.end_at === null) {
                                    return '<span class="font-size-sm font-w600 px-2 py-1 rounded  bg-danger-light bg-gray">00:00</span>'
                                } else {

                                    let creation = moment(row.created_at)
                                    let end = moment(row.end_at)
                                    let diff = end.diff(creation, 'minutes')
                                    // console.log(diff);
                                    // console.log(moment.utc(duration(diff, 'milliseconds')
                                    //     .format('h [hours] m [minutes] s [seconds]')
                                    //     ))

                                    let t = moment(moment(end, "YYYY-MM-DD HH:mm:ss")
                                            .diff(
                                                moment(creation, "YYYY-MM-DD HH:mm:ss")))
                                        .format("HH:mm")

                                    // let duration = moment.duration(diff);
                                    return `<span class="font-size-sm font-w600 px-2 py-1 rounded  "  style="background-color:${TimeColor(diff)}; color:white">
                                       ${moment.duration(creation.diff(end)).humanize()}
                                    </span>`
                                }
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
                console.log(data);
                show_queue = data.show_queue;

                if (data.queue_count == 0) {
                    queue = 'Working On It'
                } else {

                    queue = data.queue_count + ' Ticket Open To Start Work on This Ticket';
                }



                mainTicket = data.ticket;
                selected_ticket = mainTicket;
                user_department = data.user_dep;
                hid = data.ticket.hid;
                $('.viewTicket').modal('show')
                buildTicketData(data.ticket)
                buildTicketTabs(data.subTickets)
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                setTimeout(function() {
                    One.helpers('notify', {
                        type: 'danger',
                        icon: 'fa fa-times mr-1',
                        message: XMLHttpRequest.responseJSON.message
                    });
                }, 30);
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
        let secoud_action = '';
        let timeshet = '';


        var created_at = moment(ticket.created_at).format('MMMM Do YYYY');

        if (ticket.room_id != null) {
            output += `<tr><td style="width: 20%;">Name</td>
            <td style="${color}">Room - ${ticket.room.room_num}  - Guest : ${ticket.room.guest_name}</td> </tr>`
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

        if (ticket.design_task != null) {
            output += `<tr><td style="width: 20%;"><i class="fa fa-bolt text-muted mr-1">Task Name (Design)</td>
            <td >${ticket.design_task}
            </td> </tr>`
        }
        if (ticket.design_size != null) {
            output += `<tr><td style="width: 20%;"><i class="fa fa-bolt text-muted mr-1"> Size of Design</td>
            <td >${ticket.design_size}
            </td> </tr>`
        }

        output += `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-calendar text-muted mr-1"></i> Date</td><td style="${color}">${created_at}</td></tr>`

        if (show_queue) {
            output +=
                `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-calendar text-muted mr-1"></i> Remaining </td><td style="${color}"> ${queue}</td></tr>`
        }

        if (ticket.uid == null) {
            output +=
                `<tr><td style="width: 20%;">
            <i class="fa fa-fw fa-user text-muted mr-1"></i> Created By</td><td style="${color}"> Guest From App</td></tr>`
        } else {
            output +=
                `<tr><td style="width: 20%;">
                <i class="fa fa-fw fa-user text-muted mr-1"></i> Created By</td><td style="${color}">${ticket.users.name}</td></tr>`
        }
        if (ticket.description != null) {
            output +=
                `<tr><td style="width: 20%;">
                <i class="fa fa-bolt text-muted mr-1"></i> Details</td><td style="${color}">   {!! html_entity_decode('${ticket.description}') !!}</td></tr>`
            // output +=
            //     `<tr><td style="width: 20%;">
            // <i class="fa fa-fw fa-align-left text-muted mr-1"></i>Description</td><td style="${color}">
            //     <div id="faq3" role="tablist" aria-multiselectable="true">
            //         <div class="block block-rounded block-bordered mb-1">
            //             <a class="text-muted" data-toggle="collapse" data-parent="#faq3" href="#faq3_q3" aria-expanded="true" aria-controls="faq3_q3">
            //                 <div class="block-header block-header-default" role="tab" id="faq3_h3">
            //                     Details
            //                 </div>
            //             </a>
            //             <div id="faq3_q3" class="collapse" role="tabpanel" aria-labelledby="faq3_h3" data-parent="#faq3">
            //                 <div class="block-content">
            //                     {!! html_entity_decode('${ticket.description}') !!}
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            //     </td></tr>`
        }

        $('.ticket-body').empty();
        $('.ticket-body').append(output);
        $('.main-actions').empty();
        $('.secoud-actions').empty();
        $('.actions').empty();
        buildComments();
        buildAttachment();
        if (ticket.status_id == 3) {
            action_output +=
                `
            <a class="dropdown-item" href="{{ url('ticket/update_status/${mainTicket.id}/4') }}"><i class="fa fa-handshake"></i> Done</a>
            <a class="dropdown-item" href="{{ url('ticket/update_status/${mainTicket.id}/2') }}"><i class="fa fa-history"> </i> Re-open</a>`
        }
        // if (ticket.status_id == 4) {
        //     action_output += `<a class="dropdown-item" href="#"><i class="fa fa-history"> </i> Re-open</a>`
        // }
        if (mainTicket.status_id != 4 && mainTicket.status_id != 3) {
            secoud_action += `
            <a class="dropdown-item" href="{{ url('ticket/create/${mainTicket.id}') }}"> <i class="fa fa-plus-circle"> </i>
                Create Sub Ticket
            </a>
            <a class="dropdown-item" href="#"> <i class="fa fa-fw fa-pencil-alt"> </i>
                Edit
            </a>
            `
        }


        function buildAttachment() {
            let count = 0;
            $('.attachment-data').empty();
            if (selected_ticket.attachment.length > 0) {
                $('.attachment-data').append('<h3>Attchment</h3>')
                selected_ticket.attachment.forEach(element => {
                    count++;
                    $('.attachment-data').append(`
                    <a href="{{ asset('uploads/attach/${element.file}') }}" target="_blank" ><i style="color:#008502;" class="fas fa-file-pdf"></i> Attach # ${count} </a>
                    `)
                })
            }
        }

        function buildComments() {
            $('.comments').empty();
            if (selected_ticket.status_id != 1) {
                $('.comments').append(`
                <a href="{{ url('ticket_comments/show/${selected_ticket.id}') }}">
                    <button class="btn bg-flat-light">
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-pill badge-primary ml-2">${selected_ticket.ticket_comments_count}</span>
                        </button>
                        </a>
                        `);
            }
        }



        // action_output += '<hr>'




        if (ticket.end_at != null) {
            let created_at = moment(ticket.created_at)
            let end_at = moment(ticket.end_at);
            timeshet += `
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr><td>Time To End Ticket: ${moment.duration(created_at.diff(end_at)).humanize() } </td></tr>
                </tbody>
            </table>`
        }
        action_output += `<br><br><hr>`
        $('.main-actions').append(action_output);
        $('.secoud-actions').append(secoud_action);
        $('.actions').append(timeshet);

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
        if (selected_ticket.status_id != 1) {
            actions +=
                `<a href="ticket_comments/show/${selected_ticket.id}"><button class="btn btn-rounded  bg-flat-light" >Add Comment</button> </a>`
        }
        // actions +=
        //     `<button class="btn btn-rounded  bg-flat-light" onclick="sendReminder('${encodedData}')">Send Message</button> `

        let check_satatus = [1, 2, 5].includes(selected_ticket.status_id)

        if ("{{ check_create_permission('8') }}" && user_department.includes(task.dep_id) && check_satatus) {

            actions +=
                `<button class="btn btn-rounded  btn-info" style="margin-left: 10px; " onclick="createTask('${encodedData}')">Add Task</button> `
        }
        if ([2, 5].includes(task.status_id) && user_department.includes(task
                .dep_id) && "{{ check_create_permission('8') }}") {
            actions +=
                `<br><br><a href="{{ url('task/change_status/${task.id}/3') }}"><button class="btn btn-rounded  btn-info" >Complete</button></a>`
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
        let type = $('#type_id').val();
        if (type == 1) {
            let type_name = $('#facility_id option:selected').attr("name");
            let data = type_name.split('--');
            $('.hide-input').empty();
            $('.hide-input').append(`
                <input name="guest_name" value="${data[1] + data[2]}" type="hidden">
                <input name="room" value="${data[0]}" type="hidden">
                <input name="reservation_no" value="${data[3]}" type="hidden">
            `);
        }
    }

    function getDepartmentUser(dep_id, task_id, type) {

        $.ajax({
            url: "{{ url('department/department_user') }}" + '/' + hid + '/' + dep_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (type == "worker") {
                    addWorker(data.workers, task_id)
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
            if (type == 9) {
                $('#dep').val('15');
                $('#dep').selectpicker('refresh');
                getServices();

                // $("#facility_id").val('7487');
                // $('#facility_id').selectpicker('refresh');



            }
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
        $('#facility_id').append('<option value=""></option>');
        result.forEach(element => {
            $('#facility_id').append(`
                <option name="${element.room_number}--${element.firstname}--${element.lastname}--${element.reservation_no}">
                    ${element.room_number + ' '  +  element.firstname +  ' ' + element.lastname }
                </option>
            `)
        });
        $('#facility_id').selectpicker('refresh');

    }


    function get_facilities() {
        let type = $('#type_id').val();
        let hid = $('#h_id').val();
        $.ajax({
            url: "{{ route('ticket.facility') }}",
            dataType: "json",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                type,
                hid
            },
            success: function(data) {
                $("#facility_id").empty();
                $('#facility_id').append('<option></optian>');

                data.facility.forEach(element => {
                    $('#facility_id').append('<option value="' + element.id + '"> ' +
                        element.name +
                        '</option>');
                });
                $('#facility_id').selectpicker('refresh');

                if (type == 9) {
                    $("#facility_id").val('7487');
                    $('#facility_id').selectpicker('refresh');
                }


                // $('#facility_id').selectpicker();

            }
        });
    }

    function getServices() {
        let dep_id = $('#dep').val();
        if (dep_id == "15") {
            $('.designer-tab').show()
        } else {
            $('.designer-tab').hide()
        }
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
                $('#services').append('<option></optian>');
                data.services.forEach(element => {
                    $('#services').append('<option value="' + element.id + '"> ' +
                        element.name +
                        '</option>');
                });
                $('#services').selectpicker('refresh');
                if (dep_id == 15) {
                    $("#services").val('192');
                    $('#services').selectpicker('refresh');
                }

            }
        });
    }

    function TimeColor(diff) {
        // console.log(diff);
        // let creation = moment(created_at)
        // let end = moment(end_at);
        // // var diff = moment.duration(creation.diff(end, 'minutes'))
        // var diff = end.diff(created_at, 'minutes')




        if (diff < 21) { //From 0 to  20
            return '#ced4da!important'
        } else if (20 < diff && diff < 31) {
            return '#3498db!important'
        } else if (30 < diff && diff < 41) {
            return '#f1c40f!important'
        } else if (40 < diff && diff < 51) {
            return '#e67e22!important'
        } else if (50 < diff && diff < 61) {
            return '#e74c3c!important'
        } else if (61 < diff) {
            return '#262d3b!important'
        }
    }
</script>
