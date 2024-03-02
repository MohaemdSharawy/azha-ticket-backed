<script>
    // Echo.channel('event').listen('RealTimePush', (e) =>
    //     (e.message) ? fillter() : ''

    // );

    var prev = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() - 1)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)
    var today = new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '-' + ("0" + new Date()
        .getDate()).slice(-2)
    $("#from_time").val(prev);
    $("#to_time").val(today);
    var user_department;
    var hid;

    function fillter() {
        $('#task').DataTable().destroy();
        getDataTask();
    }

    function getDataTask() {
        hotels = $('#hotels').val();
        from_time = $('#from_time').val();
        to_time = $('#to_time').val();
        status = $('#status').val();
        types = $('#types').val();
        my_task = $('.my_task').is(":checked");

        console.log(my_task);

        $.ajax({
            url: "{{ route('task.data') }}",
            type: "GET",
            dataType: "json",
            data: {
                hotels,
                from_time,
                to_time,
                status,
                types,
                my_task
            },
            success: function(data) {
                $('#task').DataTable({
                    "data": data.ticket,
                    "responsive": true,
                    order: [
                        [0, "DESC"]
                    ],
                    "columns": [{
                            "data": "id",
                        },
                        {
                            "data": "name"
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
                            "data": "created_at",
                            "render": function(data, type, row, meta) {
                                return moment(row.created_at).format('MMMM Do YYYY')
                            }

                        },

                        {
                            "render": function(data, type, row, meta) {
                                let actions = '';
                                actions +=
                                    `<button onclick="ViewTask('${row.id}')" class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button></a> `;

                                return actions;
                            }
                        }

                    ]
                })
            }
        })
    }

    function ViewTask(TaskId) {
        $('#master').addClass('active')
        $.ajax({
            url: "{{ url('task/show') }}" + '/' + TaskId,
            dataType: "json",
            type: 'GET',
            success: function(data) {
                console.log(data);
                user_department = data.user_dep;
                hid = data.task.hid;

                $('.viewTask').modal('show')
                buildTask(data.task)
                // buildTicketData(data.ticket)
                // buildTicketTabs(data.subTickets)
            }
        });
    }

    function buildTask(task) {
        let color = 'color:' + task.status.color + '';
        let output;
        $('.TaskBody').empty()
        $('.TaskBody').append(`

        <div class="col-xl-12 order-xl-0">
            <div class="block block-rounded">
                <div class="block-content">
                    <div class="tab-pane pull-x active" id="ecom-product-info" role="tabpanel">
                        <table class="table table-striped table-borderless">
                            <thead>
                                <tr>
                                    <th colspan="2">Details </th>
                                </tr>
                            </thead>
                            <tbody class="task_body">


                            </tbody>
                        </table>
                        <div class="time_sheet"></div>

                    </div>
                </div>
            </div>
        </div>
        `)


        output += `
        <tr>
            <td style="width: 20%;"><i class="fa fa-fw fa-comment-dots text-muted mr-1"></i> Name</td><td style="${color}">
                ${task.name}
            </td>
        </tr>
        `
        output += `
        <tr>
            <td style="width: 20%;"><i class="fa fa-fw fa-hospital text-muted mr-1"></i> Department</td><td style="${color}">
                ${task.department.dep_name}
            </td>
        </tr>
        `
        output += `
        <tr>
            <td style="width: 20%;"><i class="fa fa-fw fa-certificate text-muted mr-1"></i> Status</td><td style="${color}">
                ${task.status.name}
            </td>
        </tr>
        `
        output += `
        <tr>
            <td style="width: 20%;"><i class="fa fa-fw fa-hospital text-muted mr-1"></i> Hotel</td><td style="${color}">
                ${task.hotels.hotel_name}
            </td>
        </tr>
        `
        if (task.worker_id != null) {
            output += `
            <tr>
                <td style="width: 20%;"><i class="fa fa-fw fa-user  text-muted mr-1"></i> Worker</td><td style="${color}">
                    ${task.user.name}
                </td>
            </tr>
            `
        } else {
            if ("{{ check_create_permission('8') }}" && user_department.includes(task.dep_id)) {

                getDepartmentUser(task.dep_id, task.id, 'worker')
                output += `<tr><td style="width: 20%;">Assign User</td>
                <td id="assign_user">
                </tr>`
            }
        }

        output += `
        <tr>
            <td style="width: 20%;"><i class="fa fa-fw fa-calendar  text-muted mr-1"></i> Date</td><td style="${color}">
                  ${moment(task.created_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.created_at).fromNow()})
            </td>
        </tr>
        `

        if (task.assigned_at != null) {
            output += `
            <tr>
                <td style="width: 20%;"><i class="fa fa-fw fa-calendar  text-muted mr-1"></i> Assigned At</td><td style="${color}">
                    ${moment(task.assigned_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.assigned_at).fromNow()})
                </td>
            </tr>
            `
        }
        if (task.end_at != null) {
            output += `
            <tr>
                <td style="width: 20%;"><i class="fa fa-fw fa-calendar  text-muted mr-1"></i> End At</td><td style="${color}">
                    ${moment(task.end_at).format('MMMM Do YYYY, h:mm:ss a')}   (${moment(task.end_at).fromNow()})
                </td>
            </tr>
            `
        }
        if (task.status_id == 2) {
            if ("{{ Auth::id() }}" == task.worker_id || "{{ check_create_permission('8') }}") {
                output += `
                    <tr>
                        <td style="width:20%"><i class="fa fa-gem   text-muted mr-1" > Actions</td>
                        <td><a href="{{ url('task/change_status/${task.id}/3') }}"><button class="btn bg-flat-light" > <i class="fa fa-check"></i>  Confirm</button></a></td>
                    </tr>
                `
            }

        }
        if (task.description != null) {
            output += `
            <tr>
                <td style="width: 20%;"><i class="fa fa-fw fa-align-left  text-muted mr-1"></i> Description</td><td style="${color}">
                    <div id="faq3" role="tablist" aria-multiselectable="true">
                        <div class="block block-rounded block-bordered mb-1">
                            <a class="text-muted" data-toggle="collapse" data-parent="#faq3" href="#faq3_q3" aria-expanded="true" aria-controls="faq3_q3">
                                <div class="block-header block-header-default" role="tab" id="faq3_h3">
                                    Details
                                </div>
                            </a>
                            <div id="faq3_q3" class="collapse" role="tabpanel" aria-labelledby="faq3_h3" data-parent="#faq3">
                                <div class="block-content">
                                    ${task.description}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            `
        }



        $('.task_body').append(output)

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
</script>
