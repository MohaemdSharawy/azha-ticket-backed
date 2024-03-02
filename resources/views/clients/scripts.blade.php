<script>
    // Echo.channel('event').listen('RealTimePush', (e) =>
    //     (e.message) ? fillter() : ''
    // );

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
        $('#clients').DataTable().destroy();
        // $('#ticket').DataTable().ajax.reload();
        getData();
    }

    function getData() {
        // hotels = $('#hotels').val();
        // from_time = $('#from_time').val();
        // to_time = $('#to_time').val();
        // status_ids = $('#stat').val();
        // types = $('#types').val();
        // priority = $('#priority').val();
        // department = $('#department').val();
        // creator = $('#creator').val();
        // console.log(status_ids);

        $('#clients').DataTable({
            ajax: {
                url: "{{ route('clients.data') }}",
                type: "GET",
                dataType: "json",
                data: {
                    // hotels,
                    // from_time,
                    // to_time,
                    // status_ids,
                    // priority,
                    // types,
                    // department,
                    // creator
                },
                dataSrc: 'clients'
            },
            "pageLength": 25,
            order: [
                [0, "DESC"]
            ],
            columns: [{
                    "data": "id",
                },
                {
                    "render": function(data, type, row, meta) {
                        return `${row.first_name + ' ' + row.last_name}`;
                    }
                },
                {
                    "data": "email",
                    "render": function(data, type, row, meta) {
                        return `${row.email}`;
                    }
                },
                {
                    "data": "phone",
                    "render": function(data, type, row, meta) {
                        return `${row.phone}`;
                    }
                },
                {
                    "data": "active",
                    "render": function(data, type, row, meta) {
                        if(row.role =='owner'){
                          return  `<span class="badge badge-success">OWNER</span>`
                        }
                        if(row.role == 'family member'){
                          return  `<span class="badge badge-primary">FAMILY MEMBER</span>`
                        }
                        if(row.role  = 'tenant'){
                          return  `<span class="badge badge-warning">TENANT</span>`
                        }
                        return `<span class="badge badge-danger">${row.role}</span>`
                    }
                },
                {
                    "data": "created_at",
                    "render": function(data, type, row, meta) {
                        return `${moment(row.created_at).format('DD-MM-YYYY')}`
                    }

                },

                {
                    "render": function(data, type, row, meta) {
                        let actions = '';
                        actions += `
                        <a href="{{url('clients/edit/${row.id}')}}">
                            <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit Client">
                                <i class="fa fa-fw fa-pencil-alt"></i>
                            </button>
                        </a> `;
                        actions += `
                        <a href="{{url('clients/edit/${row.id}')}}">
                            <button type="button" class="btn btn-sm btn-light js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Remove Client">
                               <i class="fa fa-fw fa-times"></i>
                            </button>
                        </a> `;
                        return actions;
                    }
                }

            ]
        })
    };
    getData();
</script>
