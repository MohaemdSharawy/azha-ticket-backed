<hr>
<h2>File Attached</h2>
@php $attached = get_attach($data->id, $module_id);   $i =1;  $count = 1; @endphp
@if (count($attached) > 0)
    @foreach ($attached as $att)
        <div style="margin-left: 30px;">
            
            {{$count++}} - 
            @if ( Auth::user()->is_admin == 1 )
                <a href="{{ url('del/attach/'.$att->id) }}"><i class="fas fa-trash-alt" style="color:#da542e;"></i></a>
            @endif
            <a href="{{ asset('images/'. $att->photo) }}" target="_blank" ><i style="color:#008502;" class="fas fa-file-pdf"></i> Attach Number {{ $i++}} </a>


        </div>   
    @endforeach
@else
        No File Attached <i style="color:#da542e;" class="fas fa-file-pdf"></i>
@endif