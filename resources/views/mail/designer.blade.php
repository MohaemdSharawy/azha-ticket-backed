@component('mail::message')
    <a href="{{ $data['url'] }}">View Ticket</a>
    <br>
    {!! html_entity_decode($data['message']) !!}
@endcomponent
