<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- font et icone -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css" integrity="sha512-+8BbSZlGv/f47XlJZWbAm5fpt7e2cU6vk5gM+cRzD8WU6x+U3qX9yFqUHdV7MIuFv3q1ZwPxmc+Jjwyf2Q1lBQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons%401.7.2/font/bootstrap-icons.css" integrity="sha384-tQfHmB9kuuIIZhb8l0WQ5vblL6Gh0oRMZ8oUWUE6v+qBN9DWi6Uy8E+Oax6vB+kC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carte_ajoute.css') }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="width:100%; position: fixed;z-index: 1000; background-color:#fff">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home_hotel') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto" style="display: flex;justify-content: space-around;flex-wrap: nowrap;width: 100%;">
                        @if (Auth::user())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Hotel
                                </a>
                                <div class="dropdown-menu dropdown-menu-center" aria-labelledby="navbarDropdown">
                                    @foreach ($hotel_personnel as $hp)
                                        <a class="dropdown-item" href="{{ route('home.hotel.chambre.gestion', $hp->id) }}">{{ $hp->nom_hotel }}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home.hotel.chambre.commande') }}">{{ __('Les commandes de chambres') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home.demande-hotel.create') }}">{{ __('Demande d\'offre') }}</a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nom_complete }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-center" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('home.profile') }}">{{ __('Profile') }}</a> --}}
                                    <a class="dropdown-item" href="{{ route('home.notifications-hotel') }}">{{ __('Notifications') }}</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        {{ __('Déconnexion') }}
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
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://kit.fontawesome.com/6fe423de62.js" crossorigin="anonymous"></script>
</body>
</html>
