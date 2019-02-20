<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-134456724-1"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top" style="background-color: black; border-bottom: 3px solid #e16729;">
            <div class="container-fluid">
                <a href="{{ route('page.index') }}">
                    <img style="filter: brightness(4);" width="150" src="{{asset('img/logo.svg')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse px-4" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/">Головна</a>
						</li>
						<li class="nav-item">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/menu">Меню</a>
						</li>
						<li class="nav-item">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/delivery">Доставка</a>
						</li>
						<li class="nav-item">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/clients">Клієнтам</a>
						</li>
						<li class="nav-item">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="#">Акції</a>
						</li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>

            @include('shared.left-sidebar')

            @include('shared.right-sidebar')

        	@yield('content')
	        
        </main>
	</div>
</body>
</html>