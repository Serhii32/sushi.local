@extends('shared.main')

@section('content')

    <section id="main-section">
        <div class="container p-4">
            <div>
                <img class="img-fluid" src="{{$promotion->photo?asset($promotion->photo):asset('img/default.png')}}">
            </div>
            <div class="mt-4">
                <h1 class="text-center text-white font-weight-bold">
                    {{$promotion->title}}
                </h1>
            </div>
            <div class="mt-4">
                <p class="text-justify text-white font-weight-bold">
                    {{$promotion->description}}
                </p>
            </div>
        </div>
    </section>

@endsection