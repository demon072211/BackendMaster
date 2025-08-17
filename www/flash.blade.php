<div class="flash-message col-lg-12">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(session()->has('alert-' . $msg))
            <p class="alert alert-{{ $msg }} p-2">{{ Session::get('alert-' . $msg) }}</p>
        @endif
    @endforeach
</div>