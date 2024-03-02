@if (Session::has('permission'))
    <div class="alert alert-danger"> {{ Session::get('permission') }}</div>
@endif
@if (Session::has('success'))
    <div class="alert alert-danger"> {{ Session::get('success') }}</div>
@endif
@if (Session::has('success_notify'))
    <script>
        $(document).ready(function($) {
            setTimeout(function() {
                One.helpers('notify', {
                    type: 'success',
                    icon: 'fa fa-check mr-1',
                    message: "{{ Session::get('success_notify') }}"
                });
            }, 10);
        });
    </script>
    {{-- <div class="alert alert-danger"> {{ Session::get('success') }}</div> --}}
@endif
@if (Session::has('failed_notify'))
    <script>
        $(document).ready(function($) {
            setTimeout(function() {
                One.helpers('notify', {
                    type: 'danger',
                    icon: 'fa fa-times mr-1',
                    message: "{{ Session::get('failed_notify') }}"
                });
            }, 10);
        });
    </script>
    {{-- <div class="alert alert-danger"> {{ Session::get('success') }}</div> --}}
@endif
