<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image') }}" href="{{ asset('assets/img/favicon.png') }}" sizes="16x16">
    <title>Shivam Travels</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="text-center" style="padding-top: 50px;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="logo_regular" src="{{ asset('assets/img/bg_logo.png') }}" alt="" width="200"/>
            </a>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
