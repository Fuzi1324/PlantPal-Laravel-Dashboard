<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'LawogWeb') }}</title>
    <link rel="icon" href="{{ url('images/favicon.ico') }}">
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
    {{-- @include('layout.navigation.navigation_horizontal') --}}

    <div class="container-fluid full-height d-flex">
        <div class="row flex-grow-1 w-100">
            <div class="col-md-2 p-0">
                {{-- @include('layout.navigation.navigation_vertical') --}}
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="pl-5 pr-5 w-100">
                        <div class="container mt-3">
                            @include('layout.errors')
                            <div class="card shadow-sm rounded-3">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
