<?php ini_set('pcre.backtrack_limit', '5000000');
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ URL::asset('Logo/launcher_icon.png') }}" />
    <title>TIcket System</title>


    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto;
            background-color: #2196F3;
            padding: 10px;
        }

        .grid-item {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
        }

        table {
            font-family: sans-serif;
            /* border: 7mm solid aqua; */
            border-collapse: collapse;
        }

        table.table2 {
            /* border: 2mm solid aqua; */
            border-collapse: collapse;
        }

        table.layout {
            border: 0mm solid black;
            border-collapse: collapse;
        }

        td.layout {
            text-align: center;
            border: 0mm solid black;
        }

        td {
            padding: 2mm;
            border: 2px solid black;
            vertical-align: middle;
            font-size: 14px;
        }

        .custom-th {
            padding: 2mm;
            border: 2px solid black;
            vertical-align: middle;
        }

        td.redcell {
            border: 3mm solid red;
        }

        td.redcell2 {
            border: 2mm solid red;
        }

        .card-title {
            height: 50px !important;
            border: 1px solid black;
            padding-left: 10px;
            padding-top: 10px;
            width: 35%;
            background-color: #00cec9;
            color: #fff;
        }

        .card-title-white {
            border: 1mm solid black;
            padding-left: 10px;
            /* width: 50%; */
            color: #0f0f0f;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>
                    {{-- <img src="{{ public_path('uploads/logo/' . $hotel->logo) }}" style="width: 100%; max-width: 200px" /> --}}
                    <img src="{{ URL::asset('Logo/' . $hotel->logo) }}" style="width: 100%; max-width: 200px" />

                    <h4>{{ $hotel->hotel_name }}</h4>
                    <h4>{{ $from_title }}</h4>
                    <h4>{{ $to_title }}</h4>
                    <br><br>
                </th>
                <th>
                    {{-- <div class="card-title-white "> --}}
                    <h3>{{ $title }}</h3>

                    <br><br>

                    <table class="table table-striped table-bordered" style="margin-left: 140px; ">
                        <thead>
                            <thead>
                                <tr>
                                    <th class="custom-th" style=" color: #fff; background-color: #ced6e0;">0-19</th>
                                    <th class="custom-th" style=" color: #fff; background-color: #0f74e7;">20-30</th>
                                    <th class="custom-th" style=" color: #fff; background-color: #f1c40f;">30-40</th>
                                    <th class="custom-th" style=" color: #fff; background-color: #e75e0f;">40-50</th>
                                    <th class="custom-th" style=" color: #fff; background-color: #e70f0f;">50-60</th>
                                    <th class="custom-th" style=" color: #fff; background-color: #181a1b;">More 60</th>
                                </tr>
                            </thead>
                    </table>

                </th>
            </tr>
            {{-- <table class="table table-striped table-bordered">
                <thead>
                    <thead>
                        <tr>
                            <th style=" color: #fff; background-color: #0f74e7;">20-30</th>
                            <th style=" color: #fff; background-color: #f1c40f;">30-40</th>
                            <th style=" color: #fff; background-color: #e75e0f;">40-50</th>
                            <th style=" color: #fff; background-color: #e70f0f;">50-60</th>
                            <th style=" color: #fff; background-color: #181a1b;">More 60</th>
                        </tr>
                    </thead>
            </table> --}}

            {{-- <img src="{{ public_path('uploads/logo/' . $hotel->logo) }}" style="width: 100%; max-width: 200px" />
        <h4>{{ $hotel->hotel_name }}</h4> --}}

    </table>
    @if (count($department_names) > 0)
        <h3>Admin Request</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <thead>
                    <tr style="background-color: #00cec9;">
                        @foreach ($department_names as $dep_name)
                            <th class="custom-th" style=" color: #fff; font-size:25px ; height:80px; ! important"
                                width="15%">
                                {{ $dep_name }}
                            </th>
                        @endforeach
                    </tr>

                </thead>
            <tbody>
                <tr>
                    @foreach ($department_count as $count)
                        <td style="font-size:25px ; text-align:center;">{{ $count }}</td>
                    @endforeach
                </tr>

            </tbody>
        </table>
        <h3>Guest Request</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <thead>
                    <tr style="background-color: #00cec9;">
                        @foreach ($department_names as $dep_name)
                            <th class="custom-th" style=" color: #fff; font-size:25px ; height:80px; ! important"
                                width="15%">
                                {{ $dep_name }}
                            </th>
                        @endforeach
                    </tr>

                </thead>
            <tbody>
                <tr>
                    @foreach ($department_count_guest as $counts)
                        <td style="font-size:25px ; text-align:center;">{{ $counts }}</td>
                    @endforeach
                </tr>

            </tbody>
        </table>
    @else
        <table class="table table-striped table-bordered">
            <thead>
                <thead>
                    <tr style="background-color: #00cec9;">
                        <th class="custom-th" style=" color: #fff;" width="10%">All Department</th>

                    </tr>

                </thead>
            <tbody>
                <tr>
                    <td style="font-size:25px ;">0</td>
                </tr>

            </tbody>
        </table>
    @endif
    <br>
    <div class="card-title">
        <span style="color: #fff; font-size:25px ;">In House Guest</sapn>
    </div>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <thead>
                <tr style="background-color: #00cec9;">
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="15%">Room No</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="15%">Department</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="40%">Service</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Status</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Sart Time</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Time H:M</th>
                </tr>

            </thead>
        <tbody>

            @foreach ($guest_request as $row)
                @php
                    $time_sheet = get_time_diff($row->created_at, $row->end_at);
                @endphp

                <tr>
                    <td style="font-size:30px ; text-align: center;">{{ $row->room->room_num }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->to_department->dep_name }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->services->name }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->status->name }}</td>
                    <td style="font-size:30px ; text-align: center;">
                        {{ date('Y-m-d H:i:s', strtotime($row->created_at)) }}</td>
                    <td
                        style="background-color: {{ $time_sheet['color'] }}; color:white; font-size:30px ; text-align: center;">
                        {{ $time_sheet['time'] }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>



    <br>
    <div class="card-title">
        <span style="color: #fff; font-size:25px ;">ADMIN REQUEST </span>
    </div>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <thead>
                <tr style="background-color: #00cec9;">
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="15%">Name</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="15%">Department</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="40%">Service</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Status</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Start Time</th>
                    <th class="custom-th" style="color: #fff; font-size:25px ;" width="10%">Time H:M</th>
                </tr>

            </thead>
        <tbody>

            @foreach ($admin_request as $row)
                @php
                    $time_sheet = get_time_diff($row->created_at, $row->end_at);
                @endphp
                <tr>
                    <td style="font-size:30px ; text-align: center;">{{ $row->facility->name }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->to_department->dep_name }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->services->name }}</td>
                    <td style="font-size:30px ; text-align: center;">{{ $row->status->name }}</td>
                    <td style="font-size:30px ; text-align: center;">
                        {{ date('Y-m-d H:i:s', strtotime($row->created_at)) }}</td>

                    <td
                        style="background-color: {{ $time_sheet['color'] }}; color:white; font-size:30px ; text-align: center;">
                        {{ $time_sheet['time'] }}
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

</body>

</html>
