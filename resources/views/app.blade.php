<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ELAVT</title>  
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        @stack('styles')
    </head>
    <body>
        <div class="wrapper">
            @include('header')

            @yield('content')

            @include('footer')
        </div>
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        @stack('scripts')
    </body>
</html>
