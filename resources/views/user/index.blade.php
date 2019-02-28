@extends('shared.main')

@section('content')
	
	<section id="main-section">
        <div class="row p-4">
            <h1 class="text-white font-weight-bold text-center col-12 col-md-8">Персональний кабінет</h1>
            <div class="col-12 col-md-4">
                <a class="btn btn-warning font-weight-bold text-uppercase text-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Вийти</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
            
        </div>
		<user-home-component :user="{{$user}}" :orders="{{$orders}}" :favorites="{{$favorites}}" :route="{{json_encode(route('user.home.update'))}}"></user-home-component>
	</section>
	
@endsection