<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zhihu') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }} " defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

        @yield('content')

    </div>

    @include('layouts._footer')

    <flash message="{{ session('flash') }}"></flash>
</div>
</body>

@if (config('app.debug'))
    @include('sudosu::user-selector')
@endif

<script>
    window.App = {!! json_encode([
        'signedIn' => Auth::check()
    ]) !!}
</script>
</html>
