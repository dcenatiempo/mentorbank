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
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        header {
            display: grid;
            grid-template-columns: 2rem auto auto;
            align-items: center;
            padding: 0 1rem;
            background: white;
            box-shadow: 0 4px 9px -4px rgba(0,0,0,.2);
        }

        header .brand {
            display: flex;
            justify-content: center;
        }

        header nav ul {
                display: flex;
                flex-flow: row nowrap;
                justify-content: flex-end;
                padding: 0;
                margin: 0;
        }

        header nav ul li {
            list-style: none;
        }
        header nav ul li a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="{{ isset($pageId) ? $pageId : substr($_SERVER['REQUEST_URI'], 1) }}">

        <header>
            <div class="brand">
                <a href="/">MentorBank</a>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>
        <default-footer></default-footer>
    </div>
</body>
</html>
