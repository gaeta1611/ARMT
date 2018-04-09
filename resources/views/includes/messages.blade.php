@if(Session::has('success'))

<div class="alert alert-success">
    {!! Session::pull('success') !!}
</div>

@endif
@if(Session::has('errors'))
<div class="alert alert-danger">
    @if(is_array(Session::get('errors')))
        <p> {!! implode ('<br>', Session::pull('errors')) !!} </p>
    @else
        @foreach (Session::get('errors')->toArray() as $error => $tMessages)
        <p> {!! implode ('<br>', $tMessages) !!} </p>
        @endforeach
    @endif
</div>
@endif

