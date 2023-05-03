<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fs-4" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto navbar-dark">
                        <li class="nav-item px-1">
                            <a class="nav-link" href="{{ route('topics.index') }}">{{ __('Topics') }}</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="{{ route('posts.index') }}">{{ __('Posts') }}</a>
                        </li>
                        <li class="nav-item px-1">
                            <a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @foreach (config('app.available_locales') as $locale)
                            <li class="nav-item px-1">
                                <a class="nav-link @if (app()->getLocale() === $locale) active @endif" href="{{ route('setlocale', $locale) }}">
                                    {{ strtoupper($locale) }}
                                </a>
                            </li>
                        @endforeach
                        <span class="mx-4"></span>

                        <!-- Authentication Links -->
                        @guest
                            <div class="btn-group" role="group">
                                <a class="btn btn-outline-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                                <a class="btn btn-outline-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </div>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Edit profile') }}</a>

                                    <hr class="dropdown-divider">

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
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
