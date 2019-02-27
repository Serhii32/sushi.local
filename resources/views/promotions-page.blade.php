@extends('shared.main')

@section('content')

	<section id="main-section">
		<div class="container-fluid">
			<div class="row justify-content-center">
				@foreach($promotions as $promotion)
					<div style="background-color: black;" class="p-3 card col-12 col-sm-6">
						<a class="card-link" href="{{route('page.promotion', $promotion->id)}}">
							<div style="border-radius: 20px;" class="px-2">
								<img class="img-fluid card-img-top" src="{{$promotion->photo ? asset($promotion->photo) : asset('img/default.png')}}">
			                    <div class="card-body">
			                        <h3 class="text-white text-center p-2 card-title">{{$promotion->title}}</h3>
			                    </div>
							</div>
						</a>
	                </div>
				@endforeach
			</div>
		</div>
		@if($promotions->lastPage() > 1)
			<div class="custom-links py-4">{{$promotions->links()}}</div>
		@endif
	</section>

@endsection