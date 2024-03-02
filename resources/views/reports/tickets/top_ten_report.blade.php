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
            font-size: 15px;
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
            border: 1px solid black;
            padding-left: 10px;
            width: 55%;
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

                    <img src="{{ URL::asset('Logo/' . $hotel->logo) }}" style="width: 100%; max-width: 200px" />
                    <br><br>
                    <h4>{{ $hotel->hotel_name }}</h4>
                    <h4>For: {{ $currentMonthName }}</h4>
                    <!-- <h4>{{ $to_title }}</h4> -->

                    <br><br>
                </th>
                <th>
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
    </table>

    <br>

    <br>
    <br>
    <div class="card-title">
        <span style="color: #fff; font-size:25px ;"> Admin Request </span>
    </div>
    <br>
    <br>
    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr style="background-color: #00cec9;">
                <th class="custom-th" style="color: #fff; font-size:25px; width:80% !important;">Service Name</th>
                <th class="custom-th" style="color: #fff; font-size:25px; width:20% !important;">{{ $currentMonthName }}</th>
                <th class="custom-th" style="color: #fff; font-size:25px; width:20% !important;">{{ $previousMonthName }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($admin as $row)
                <tr>
                    <td style="font-size:15px ; text-align: center; width:80% !important;">{{ $row['service_name'] }}</td>
                    <td style="font-size:15px ; text-align: center; width:20% !important;">{{ $row['current'] }}</td>
                    <td style="font-size:15px ; text-align: center; width:20% !important;">{{ $row['previous'] }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>

    <div class="card-title">
        <span style="color: #fff; font-size:25px ;"> Guest Request </span>
    </div>
    <br>
    <br>
    <table class="table table-striped table-bordered" style="width:100%" >
        <thead>
            <tr style="background-color: #00cec9;">
                <th class="custom-th" style="color: #fff; font-size:25px; width:80% !important;">Service Name</th>
                <th class="custom-th" style="color: #fff; font-size:25px; width:20% !important;">{{ $currentMonthName }}</th>
                <th class="custom-th" style="color: #fff; font-size:25px; width:20% !important;">{{ $previousMonthName }}
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($guest as $row)
                <tr>
                    <td style="font-size:15px ; text-align: center; width:80% !important;">{{ $row['service_name'] }}</td>
                    <td style="font-size:15px ; text-align: center; width:20% !important;">{{ $row['current'] }}</td>
                    <td style="font-size:15px ; text-align: center; width:20% !important;">{{ $row['previous'] }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @endforeach --}}

</body>

</html>
