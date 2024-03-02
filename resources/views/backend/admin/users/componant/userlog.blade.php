<link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet"
    href="{{ URL::asset('admin/assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">


<h3>Log Of User {{ $user->name }}</h3>
<div class="block-content block-content-full">
    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
    <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
        <thead>
            <tr>
                <th class="text-center" style="width: 80px;">ID</th>
                <th>Name</th>
                <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                <th class="d-none d-sm-table-cell" style="width: 30%;">Action</th>
                <th class="d-none d-sm-table-cell" style="width: 30%;">Created AT</th>
                <th style="width: 15%;">More Details </th>
            </tr>
        </thead>
        <tbody>

            @if (isset($user_log))

                @foreach ($user_log as $log)
                    <tr>
                        {{-- {{ $i++ }} --}}
                        <td class="text-center font-size-sm">{{ $log->id }}</td>
                        <td class="font-w600 font-size-sm">{{ $log->model_name }}</td>
                        <td class="d-none d-sm-table-cell font-size-sm">
                            <em class="text-muted">{{ $log->user_name }}</em>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $log->action }}
                        </td>
                        <td>
                            <em class="text-muted font-size-sm">{{ $log->time_stamps }}</em>
                        </td>
                        <td>
                            <button class="btn btn-primary js-swal-info" id="{{ $log->id }}"
                                onclick="setvalue('{{ $log->id }}')"><i class="fa fa-eye"></i></button>
                        </td>




                    </tr>
                @endforeach
            @endif


        </tbody>
    </table>
</div>
