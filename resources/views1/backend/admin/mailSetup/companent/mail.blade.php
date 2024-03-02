<div class="block block-rounded">
    <div class="block-header">
        {{-- <h3 class="block-title">Mail Assigned TO {{ $data[0]->dep_name }} - {{ $data[0]->hotel_name }}</small> --}}
        </h3>
        <button class="btn btn-primary js-swal-info" data-toggle="modal" data-target="#staticBackdrop">Add New
            Mail
            <i class="fa fa-edit"></i></button>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
        <table class="table  table-striped table-vcenter js-dataTable-full-pagination">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">ID</th>
                    <th>hotel Name</th>
                    <th class="d-none d-sm-table-cell" style="width: 30%;">Department</th>
                    <th>E-Mail </th>
                    <th>Edit </th>
                    <th>Status </th>
                </tr>
            </thead>
            <tbody>

                @if (isset($data))

                    @foreach ($data as $mail)
                        @if ($mail->type == 13)
                            <tr>
                                {{-- {{ $i++ }} --}}
                                <td class="text-center font-size-sm">{{ $mail->id }}</td>
                                <td class="font-w600 font-size-sm">{{ $mail->hotel_name }}</td>
                                <td class="d-none d-sm-table-cell font-size-sm">
                                    <em class="text-muted">{{ $mail->dep_name }}</em>
                                </td>
                                <td class="font-w600 font-size-sm">{{ $mail->name }}</td>
                                <td>
                                    <button
                                        onclick="edit('{{ $mail->name }}' , '{{ $mail->id }}')"{{-- data-target="#edit_model" data-toggle="modal" --}}
                                        class="btn btn-primary js-swal-info"><i class="fa fa-eye"></i></button>

                                </td>
                                <td>
                                    <i id="mail_stats-{{ $mail->id }}">
                                        @if ($mail->deleted == 0)
                                            <a onclick="mailStatus({{ $mail->id }},  1)"><button
                                                    class="btn btn-success js-swal-info"><i
                                                        class="fa fa-user"></i></button></a>
                                        @else
                                            <a onclick="mailStatus({{ $mail->id }},  0)"><button
                                                    class="btn btn-danger js-swal-info"><i
                                                        class="fa fa-user-slash"></i></button></a>
                                        @endif
                                    </i>
                                </td>


                            </tr>
                        @endif
                    @endforeach
                    {{-- @else
                    <tr>
                        <td colspan="5"><img src=""> </td>
                    </tr> --}}
                @endif


            </tbody>
        </table>
    </div>
</div>
