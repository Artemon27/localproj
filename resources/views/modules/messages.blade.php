@if(isset($errors))
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {!! $error !!}<br/>
            @endforeach
        </div>
    @endif

    @foreach(['success', 'warning', 'info', 'danger', 'message'] as $type)
        @continue(empty(Session::get($type)))

        <div class="alert alert-{{ $type }}">
            @if(is_array(json_decode(Session::get($type), true)))
                {!! implode('', Session::get($type)->all(':message<br/>')) !!}
            @else
                {!! Session::get($type) !!}
            @endif
        </div>
    @endforeach
@endif