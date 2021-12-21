@extends('app')


@section('content')

@if ($user->settings)
<input type="hidden" value="{{$user->settings->design}}" name="design" id="inpDesign">
@else
<input type="hidden" value="1" name="design" id="inpDesign">
@endif
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-2">
                @include ('modules.theme')
            </div>
            <div class="col-2">
            </div>
            <div class="col-1"> 
            </div>
            <div class="col-2 text-center">
            </div>
            <div class="col-3 text-end">
            </div>
            <div class="col-2 text-end">
                @include ('modules.menu')
            </div>
        </div>
    </div>

    <div class="card-body d-flex flex-wrap justify-content-center align-items-start" id="holiday">
        <div class="container">
            <div class="d-flex justify-content-center main-table-row" id="main-table">
                @forelse ($menus as $menu)
                <div class="text-center m-2 icon_area">
                    <div class="main-table-item">
                        <a href="{{$menu->url}}">
                            <img src="{{getThumbs($menu->src)}}" alt="{{$menu->title}}" width="100" height="100" class="icon">
                        </a>
                    </div>
                    <div class="text-center menu-text">
                        {{$menu->title}}
                    </div>
                </div>
                @if ($loop->iteration%4 == 0)
                </div>
                <div class="d-flex justify-content-center main-table-row">
                @endif
                @empty
                @endforelse
            </div>
          </div>
    </div>
</div>

@endsection


@push('styles')

@endpush

@push('beforescripts')
<script src="{{ asset('js/popper.min.js') }}"></script>
@endpush
@push('scripts')
<script src="{{ asset('js/holiday.js') }}"></script>
<script>

function logout(){
    $.ajax({
        url: `{{ route('logout') }}`,
        data: {
          '_token': '{{ csrf_token() }}'
        },
        type: 'POST',
        success: function () {
         window.location.href="/";
        },
        error: function(){
         window.location.href="/";
        }
      });
}

</script>
@endpush
