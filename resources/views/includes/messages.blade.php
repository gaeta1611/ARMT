@if(Session::has('success'))

<div class="alert alert-success">
    {{ Session::pull('success') }}
</div>

@elseif(Session::has('errors'))
<div class="alert alert-danger">
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{ $error}} </p>
        @endforeach
    @endif
</div>

@endif