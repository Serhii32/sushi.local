<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light navbar-laravel sticky-top">
            <div class="container-fluid">
                <a href="{{ route('page.index') }}">
                    <img width="200" src="{{asset('img/logo.svg')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="#">Головна</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Меню</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Доставка</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Клієнтам</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Новини</a>
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
        <section class="container-fluid bg-white">
        	<div class="row">
	        	<aside class="col-1">
	        		<div class="position-fixed">
	        			<ul class="nav flex-column">
						  	<li class="nav-item">
						    	<a class="nav-link" href="#">Active</a>
						  	</li>
						  	<li class="nav-item">
						    	<a class="nav-link" href="#">Link</a>
						  	</li>
						  	<li class="nav-item">
						    	<a class="nav-link" href="#">Link</a>
						  	</li>
						  	<li class="nav-item">
						    	<a class="nav-link" href="#">Disabled</a>
						  	</li>
						</ul>
	        		</div>
	        	</aside>
                
	        	<div class="col-8" style="background-color: black">
                    <div class="container-fluid p-1">
                        <div class="row">
                            <div class="col-12 col-lg-4 my-auto px-4">
                                <h1 class="text-white">Доставка суші для істинних поціновувачів</h1>
                                <p class="text-white">Замовляйте суші преміум класу для всієї компанії додому та в офіс</p>
                                <b-button class="text-uppercase font-weight-bold" style="border-radius: 20px; background: #e16729; border-color: #e16729;">Зробити замовлення</b-button>
                            </div>
                            <div class="col-12 col-lg-8">
                                <img class="img-fluid" src="/img/front/index-page-main.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid p-1">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3 text-center">
                                <div class="row">
                                    <div class="col-3 col-lg-12 my-auto">
                                        <img class="img-fluid" src="/img/front/icons/icon1.svg">
                                    </div>
                                    <div class="col-9 col-lg-12 text-white">
                                        <h4>Fresh Made</h4>
                                        <p>
                                            Мы гарантируем свежесть продуктов и не используем замороженную рыбу
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 text-center">
                                <div class="row">
                                    <div class="col-3 col-lg-12 my-auto">
                                        <img class="img-fluid" src="/img/front/icons/icon2.svg">
                                    </div>
                                    <div class="col-9 col-lg-12 text-white">
                                        <h4>Рецепты от шеф-повара</h4>
                                        <p>
                                            Мы предлагаем как классические суши, так и авторские рецепты от шеф-повара
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 text-center">
                                <div class="row">
                                    <div class="col-3 col-lg-12 my-auto">
                                        <img class="img-fluid" src="/img/front/icons/icon3.svg">
                                    </div>
                                    <div class="col-9 col-lg-12 text-white">
                                        <h4>Качественные ингредиенты</h4>
                                        <p>
                                            Мы не используем усилители вкуса. Все продукты закупаем у проверенных поставщиков
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 text-center">
                                <div class="row">
                                    <div class="col-3 col-lg-12 my-auto">
                                        <img class="img-fluid" src="/img/front/icons/icon4.svg">
                                    </div>
                                    <div class="col-9 col-lg-12 text-white">
                                        <h4>Чистая кухня</h4>
                                        <p>
                                            Весь процесс приготовления проходит в соответствии со всеми санитарными нормами
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-white">Топ позиції</h1>
                        <p class="text-white">В ассортименте Ninja Sushi представлены роллы, суши, сеты и напитки на любой вкус. Мы рекомендуем обязательно попробовать топ позиции нашего меню!</p>
                        <carousel :navigation-enabled="true" :per-page="3">
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 1 Content
                            </slide>
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 2 Content
                            </slide>
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 1 Content
                            </slide>
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 2 Content
                            </slide>
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 1 Content
                            </slide>
                            <slide>
                                <img class="img-fluid" src="/img/default.png">
                                Slide 2 Content
                            </slide>
                        </carousel>
                    </div>
	        	</div>
	        	<div class="col-3">
	        		kek
	        	</div>
	        </div>
        </section>
	</div>
</body>
</html>