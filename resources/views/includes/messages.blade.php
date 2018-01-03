@if(Session::has('success'))

<div class="alert alert-success">
    {{ Session::pull('success') }}
</div>

@elseif(Session::has('errors'))
<div class="alert alert-danger">
    @if(count($errors)>0)
        @for($i=0;$i<count($errors);$i++)
            <p>{{ Session::pull("errors.$i")}} </p>
        @endfor
    @endif
    {{ Session::forget('errors') }}
</div>
@endif