@extends('shared.main')

@section('content')
	
	<section id="main-section">
        <div class="container-fluid p-3">
        	<h3 class="text-white text-center">Дякуємо за покупку</h3>
        	{!!$gtagResponce!!}
        </div>
    </section>

@endsection
