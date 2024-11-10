<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PlantPal') }}</title>
    <link rel="icon" href="{{ url('./images/logo.ico') }}">

    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('./images/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <style>
        body {
            background-color: #f0f0f0;
        }

        .full-height {
            height: 100vh;
        }
    </style>
    @livewireStyles
</head>

<body>
    <nav>
        <ul>
            @auth
                <li><a href="{{ route('home') }}">Startseite</a></li>
                <li><a href="{{ route('devices.index') }}">Meine Geräte</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Abmelden</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Anmelden</a></li>
                <li><a href="{{ route('register') }}">Registrieren</a></li>
            @endauth
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    @livewireScripts

    <script src="{{ asset('/sw.js') }}"></script>

    <script>
        if (!navigator.serviceWorker.controller) {

            navigator.serviceWorker.register("/sw.js").

            then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>

</body>

</html>
