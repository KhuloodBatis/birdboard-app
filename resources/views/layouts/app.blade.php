<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-grey-light">
       <div id="app">
            <nav class="bg-white">
               <div class="container mx-auto">

                <div class="flex justify-between items-center py-2 ">


                <a class="navbar-brand flex items-center  " href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="enable-background:new 0 0 121.24 122.88" viewBox="0 0 121.24 122.88" class="h-10 fill-cyan-500 ">
                        <path d="M10.05 96.6C6.38 105.51 1.42 113.97 0 122.88l5.13-.44c8.1-23.56 15.4-39.4 31.23-59.21 11.88-14.84 24.77-26.65 41.3-36.03 8.8-5 20.07-10.47 30.21-11.85 2.77-.38 5.58-.49 8.46-.24-31.4 7.19-56.26 23.84-76.12 48.8C32.1 74.09 25.05 85.4 18.57 97.32l11.94 2.18-4.97-2.47 17.78-2.83c-6.6-2.33-13.12-1.55-15.21-4.06 18.3-.83 33.34-4.78 43.9-12.45-3.93-.55-8.46-1.04-10.82-2.17 17.69-5.98 27.92-16.73 40.9-26.27-16.87 3.54-32.48 2.96-37-.25 29.77 2.21 49-6.02 55.59-26.77.57-2.24.73-4.5.37-6.78C118.74.62 92.49-4.39 83.95 7.77c-1.71 2.43-4.12 4.66-6.11 7.48L85.97 0c-21.88 7.39-23.68 15.54-35 40.09.9-7.47 2.97-14.24 5.66-20.63-27.34 10.55-36.45 37.11-37.91 59.7-.79-7.88.67-17.78 3.49-28.9-7.98 8-13.41 17.39-11.47 30.79l-3.65-1.63 1.92 7.19-5.46-2.59 6.5 12.58z" style="fill-rule:evenodd;clip-rule:evenodd"/>
                    </svg>
                    <h1 class="text-lg font-semibold ">birdboard</h1>
                </a>


                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>


                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a href='/projects' class="dropdown-item">Your Projects</a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

                </div>
            </div>
            </div>
        </nav>

        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
