<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') . '?' . random_int(1, 999999) }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') . '?' . random_int(1, 999999) }}" rel="stylesheet">
    <style>
        .styled-scrollbars {
            /* Foreground, Background */
            scrollbar-color: #999 #333;
        }
        .styled-scrollbars::-webkit-scrollbar {
            width: 10px; /* Mostly for vertical scrollbars */
            height: 10px; /* Mostly for horizontal scrollbars */
        }
        .styled-scrollbars::-webkit-scrollbar-thumb { /* Foreground */
            background: #999;
        }
        .styled-scrollbars::-webkit-scrollbar-track { /* Background */
            background: #333;
        }
    </style>
</head>
<body style="overflow: hidden; background-color: #292b2c">
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
