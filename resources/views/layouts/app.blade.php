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
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <!-- Scripts -->
    {{-- @viteReactRefresh
    @vite('resources/react/app.tsx') --}}
</head>
<body>
    <div id="app">

        <header>
            <div class="logo">
                <a href="{{route('home')}}">MyLogo</a>
            </div>
            <nav>
                <ul>
                    <li><a href="{{route('my-fellows')}}">Fellows</a></li>
                    <li><a href="{{route('mine-clearence')}}">Mine Clearence</a></li>
                    <li><a href="#">Sandtopia</a></li>
                    @guest
                        @if (Route::has('login'))
                            <li >
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <div >
                                <a href="{{ route('logout') }}"
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
            </nav>
        </header>
        

        <main class="main-container">
            @yield('content')
        </main>
    </div>
</body>
</html>
