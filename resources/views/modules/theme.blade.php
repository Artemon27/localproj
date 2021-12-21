<div id="theme" class="btn btn-sm btn-outline-primary" route='{{ route('USettings.toggle', Auth::user()->id) }}'>Сменить тему</div>
@push ('styles')
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    @if (Auth::user()->settings)
    <link rel="stylesheet"
          @if (Auth::user()->settings->design != 1)
          disabled="1"
          @endif
          href="{{ asset('css/calendarDark.css') }}" theme="1">
    <link rel="stylesheet"
          @if (Auth::user()->settings->design != 2)
          disabled="1"
          @endif href="{{ asset('css/calendar.css')}}" theme="2">
    <link rel="stylesheet"
          @if (Auth::user()->settings->design != 3)
          disabled="1"
          @endif
          @if (Auth::user()->colors)
          href="{{ asset('css/holiuser/theme_'.Auth::user()->id.'.css') }}"
          @else
          href="{{ asset('css/calendarDark.css') }}"
          @endif theme="3">
    @else
    <link rel="stylesheet" disabled="1" href="{{ asset('css/calendarDark.css') }}" theme="1">
    <link rel="stylesheet" href="{{ asset('css/calendar.css')}}" theme="2">
    <link rel="stylesheet" disabled="1" href="{{ asset('css/calendar.css') }}" theme="3">
    @endif
@endpush

@push('scripts')
<script src="{{ asset('js/theme.js') }}"></script>
@endpush