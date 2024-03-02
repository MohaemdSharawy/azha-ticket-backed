<tr>
    <td class="header">
        <a style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                {{-- <img src="{{ URL::asset('mail_logo/' . $logo) }}" class="logo" alt="Laravel Logo"> --}}
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
