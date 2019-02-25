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
    <script defer>
        function showMobileCart(){
            let cart = document.getElementById("right-sidebar");
            if (cart.style.display === "none") {
                cart.style.display = "block";
            } else {
                cart.style.display = "none";
            }
        }
    </script>

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
                
                <button style="background-color: #e16729; margin-left: auto;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 60px">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item text-center">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/">Головна</a>
						</li>
						<li class="nav-item text-center">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/menu">Меню</a>
						</li>
						<li class="nav-item text-center">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/delivery">Доставка</a>
						</li>
						<li class="nav-item text-center">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="/clients">Клієнтам</a>
						</li>
						<li class="nav-item text-center">
							<a class="header-menu-link nav-link text-white font-weight-bold" style="font-size: 1.1rem" href="#">Акції</a>
						</li>
                    </ul>
                </div>
                <div id="header-phone-number">
                    <a href="tel:+380962092020" class="nav-link text-center p-0"><p class="text-white font-weight-bold m-0">096 20 920 20</p></a>
                    <a href="tel:+380932092020" class="nav-link text-center p-0"><p class="text-white font-weight-bold m-0">093 20 920 20</p></a>
                    <p class="text-white font-weight-bold m-0 text-center">Прийом замовлень:<br>11.00-22.30</p>
                </div>
                <div id="header-social-icons">
                    <a href="https://facebook.vn.ua" style="filter: brightness(3);" class="nav-link p-1" target="_blanc"><img width=30 src="/img/front/icons/facebook.svg"></a>
                    <a href="https://instagram.vn.ua" style="filter: brightness(3);" class="nav-link p-1" target="_blanc"><img width=30 src="/img/front/icons/instagram.svg"></a>
                </div>
                <a id="header-cart-icon" href="javascript:void(0)" onclick="showMobileCart()" class="nav-link"><img width=40 src="/img/front/icons/cart.svg"></a>
                <a href="javascript:void(0)" class="nav-link"><img width=40 src="/img/front/icons/favorite.svg"></a>
                
                <ul class="navbar-nav ml-auto">
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white p-0 text-center" href="{{ route('login') }}">Логін</a>
                            <a class="nav-link text-white p-0 text-center" href="{{ route('register') }}">Реєстрація</a>
                        </li>
                            
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
        </nav>
        <main>

            @include('shared.left-sidebar')

            @include('shared.right-sidebar')

        	@yield('content')
	        
        </main>
        <div id="bottom-left-sidebar" style="position: fixed; z-index: 2; bottom: 0px; color: white; width: 100%; text-align: center; border-top: 3px solid #e16729; background-color: black;">
            <div>
                <ul class="nav" style="justify-content: center;">
                    @foreach($categories as $category)
                        <li class="left-sidebar-nav nav-item text-center py-2">
                            <a class="nav-link text-left" href="{{route('page.category', $category->id)}}">
                                <img width=40 class="left-sidebar-img img-fluid" src="{{$category->icon ? asset($category->icon) : asset('img/default.svg')}}" alt="{{$category->title}}">
                                <span class="left-sidebar-title text-white font-weight-bold pl-3">{{$category->title}}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
	</div>
</body>
</html>