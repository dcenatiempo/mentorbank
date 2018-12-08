<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @yield('main-script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        .content {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .card {
            max-width: 400px;
            margin: auto;
        }
        .card-header {
            font-size: 2em;
        }
        button[type=submit] {
            margin-top: 1rem;
            margin-left: auto;
            display: block;
        }
        .form-check {
            display: flex;
            align-items: center;
        }
        .flex-row {
            display: flex;
        }
        #welcome .content {
            text-align: center;
        }
        #welcome .subtitle {
            padding-bottom: 2rem;
            font-size: 1.1rem;
            color: gray;
        }

        #welcome .title {
            font-size: 24vw;
        }
        @media screen and (min-width: 480px) {
            #welcome .title {
                font-size: 115px;
            }
        }
        #welcome a.btn {
            margin-top: 2rem;
        }

    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @yield('id')

        <default-header
            :logged-in="{{ Auth::check() ? 'true' : 'false'}}"
            :verified="{{ Auth::check() && Auth::user()->email_verified_at === null ? 'false' : 'true' }}"
            :portal="{{ Session::has('portal') ? 'true' : 'false' }}"
            :account-id="{{ Session::has('account_id') ? Session::get('account_id') : 0 }}"
            page-id="{{ isset($pageId) ? $pageId : substr($_SERVER['REQUEST_URI'], 1) }}">
        </default-header>
        
        

        <main>
            @yield('content')
        </main>
        <default-footer></default-footer>
    </div>
</body>
</html>
