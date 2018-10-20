<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/' . (isset($pageId) ? $pageId : substr($_SERVER['REQUEST_URI'], 1)) . '.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="{{ isset($pageId) ? $pageId : substr($_SERVER['REQUEST_URI'], 1) }}">
        <default-header></default-header>

        <main>
            @yield('content')
        </main>
        <default-footer></default-footer>
        <overlay>
            @yield('modals')
        </overlay>
    </div>
</body>
</html>
