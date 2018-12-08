<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/' . (isset($pageId) ? $pageId : str_replace('/', '-', substr($_SERVER['REQUEST_URI'], 1))) . '.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="{{ isset($pageId) ? $pageId : str_replace('/', '-', substr($_SERVER['REQUEST_URI'], 1)) }}">
        <default-header
            :logged-in="{{ Auth::check() ? 'true' : 'false'}}"
            :verified="{{ Auth::check() && Auth::user()->email_verified_at === null ? 'false' : 'true' }}"
            :portal="{{ Session::has('portal') ? 'true' : 'false' }}"
            :account-id="{{ Session::has('account_id') ? Session::get('account_id') : 0 }}"
            page-id="{{ isset($pageId) ? $pageId : str_replace('/', '-', substr($_SERVER['REQUEST_URI'], 1)) }}">
        </default-header>

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
