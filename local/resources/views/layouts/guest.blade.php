<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tower Tide Gauge Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {

            }
        </style>
        <link rel="stylesheet" href="{{asset('css/home.css')}}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('style')
    </head>
    <body class="font-sans text-gray-900 antialiased h-screen">
        <div class="topnav" id="myTopnav">
            <div>
                <a href="{{url('/')}}"><img id="logo" src="{{asset('img/tower.png')}}"></a>
                <div class="dropdown">
                    <button class="dropbtn">Tide Gauges
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div id="dropdown" class="dropdown-content">
                    </div>
                </div>
            </div>
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-10 text-right">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                           class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        @yield('content')
        <script src="https://cdnjs.cloudflare.com/polyfill/v3/polyfill.min.js?features=default"></script>
        <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAod1NL-93chXYK_hmcn49HLBBpI_udsA&callback=initMap&v=weekly"
                defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            let base_url = '{{url('/')}}';
        </script>
        @yield('script')
    </body>
</html>
