@extends('shared.main')

@section('content')

	<section id="main-section">
        <div class="container-fluid p-3">
  			<h3 class="text-white text-center">Наші клієнти</h3>
			<div class="row justify-content-center">
				@foreach($galleries as $gallery)
					<div style="background-color: black;" class="p-3 card col-12 col-sm-6 col-md-4">
						<a class="card-link" href="{{route('page.gallery', $gallery->id)}}">
							<div style="border-radius: 20px;" class="px-2">
								<img class="img-fluid card-img-top" src="{{$gallery->photo ? asset($gallery->photo) : asset('img/default.png')}}">
			                    <div class="card-body">
			                        <h3 class="text-white text-center p-2 card-title">{{$gallery->title}}</h3>
			                    </div>
							</div>
						</a>
	                </div>
				@endforeach
			</div>
        </div>
    </section>
	

@endsection