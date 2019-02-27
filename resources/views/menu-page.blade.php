@extends('shared.main')

@section('content')

	<section id="main-section">
		<div class="container-fluid">
			<div class="row justify-content-center">
				@foreach($categories as $category)
					<div style="background-color: black;" class="p-3 card col-12 col-sm-6 col-md-4">
						<a class="card-link" href="{{route('page.category', $category->id)}}">
							<div style="border-radius: 20px;" class="px-2">
								<img class="img-fluid card-img-top" src="{{$category->photo ? asset($category->photo) : asset('img/default.png')}}">
			                    <div class="card-body">
			                        <h3 class="text-white text-center p-2 card-title">{{$category->title}}</h3>
			                    </div>
							</div>
						</a>
	                </div>
				@endforeach
			</div>
		</div>
	</section>

@endsection