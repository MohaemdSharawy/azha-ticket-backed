<div>
    <div class="table-responsive">

    <table class="table table-striped table-borderless">
        <thead>
            <tr>
                <th colspan="2">Violations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($violations as $violation )
                <tr>
                    <td style="width: 20%;">
                        <i class="fa fa-fw fa-calendar text-muted mr-1"></i> Data
                    </td>
                    <td><strong>Action:</strong> {{$violation->V_Action->name}}</td>
                    <td><strong>Cost:</strong> {{$violation->V_Action->cost}}</td>
                    <td><strong>Action:</strong> {{$violation->Unite->unite_name}}</td>
                    <td><span class="badge badge-warning"> {{$violation->Status->name}} </span></td>
                    <td><strong> {{date('Y-m-d H:i'  , strtotime($violation->created_at))}} </strong> </td>
                </tr>
            @endforeach

            {{-- <tr>
                <td>
                    <i class="fa fa-fw fa-anchor text-muted mr-1"></i> File Size
                </td>
                <td>265.36 MB</td>
            </tr> --}}


        </tbody>
    </table>
    </div>
</div>
