@extends('shared.main')

@section('content')

	<section id="main-section">
        <div class="container-fluid p-3">
  			<h3 class="text-white text-center">{{$gallery->title}}</h3> 

			<div class="row justify-content-center">
				@foreach($photos as $photo)
					<div style="background-color: black;" class="p-3 card col-12 col-sm-6 col-md-4">
						<div style="border-radius: 20px;" class="px-2">
							<img class="img-fluid card-img-top" src="{{asset($photo->url)}}">
						</div>
	                </div>
				@endforeach
			</div>
        </div>
    </section>
	

@endsection