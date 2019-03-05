@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            @include('admin.shared.sidebar')
            <div class="col-12 col-md-9 p-2">
                <div class="py-4 bg-white border rounded border-light shadow">
                	<h2 class="text-center font-weight-bold text-uppercase pb-5">Сторінка адміністратора</h2>
                	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	            	<div class="container">
	                    <div class="row justify-content-center">
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.categories.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fas fa-th-list"></i></h1>
	                                    <h4 class="text-center text-uppercase">Категорії</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.components.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fas fa-sort-amount-up"></i></h1>
	                                    <h4 class="text-center text-uppercase">Компоненти</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.attributes.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fas fa-list"></i></h1>
	                                    <h4 class="text-center text-uppercase">Атрибути</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.products.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fas fa-clipboard-list"></i></h1>
	                                    <h4 class="text-center text-uppercase">Продукти</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.promotions.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fab fa-adversal"></i></h1>
	                                    <h4 class="text-center text-uppercase">Акції</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.orders.index')}}">
	                                	<h1 class="display-1 text-center"><i class="fas fa-shopping-cart"></i></h1>
	                                    <h4 class="text-center text-uppercase">Замовлення</h4>
	                                </a>
	                            </div>
	                        </div>
	                        <div class="col-12 col-md-6 my-2">
	                            <div class="card h-100 shadow">
	                                <a class="card-link text-secondary p-1" href="{{route('admin.modals.index')}}">
	                                	<h1 class="display-1 text-center"><i class="far fa-window-restore"></i></h1>
	                                    <h4 class="text-center text-uppercase">Модальні вікна</h4>
	                                </a>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection