@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            @include('admin.shared.sidebar')
            <div class="col-12 col-md-9 p-2">
                <div class="container py-4 bg-white border rounded border-light shadow">
                    <h2 class="text-center font-weight-bold text-uppercase pb-5">Користувачі</h2>
                    @if(count($users))
                        <div class="container">
                            @foreach($users as $user)
                                <div class="row my-3 h-100 shadow p-2 bg-white">
                                    <div class="col-12 col-md-3">
                                        <div class="text-center">
                                            <img class="img-fluid img-thumbnail my-2" src="{{$user->avatar ? asset($user->avatar) : asset('img/avatars/default.png')}}" alt="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <h4 class="text-left text-uppercase">Имя: {{$user->name}}</h4>
                                        <h4 class="text-left text-uppercase">Телефон: {{$user->phone}}</h4>
                                        <h4 class="text-left" style="word-break: break-word;"><span class="text-uppercase">Email:</span> {{$user->email}}</h4>
                                        <h4 class="text-left text-uppercase">Вулиця: {{$user->street}}</h4>
                                        <h4 class="text-left text-uppercase">Будинок: {{$user->building}}</h4>
                                        <h4 class="text-left text-uppercase">Квартира: {{$user->apartment}}</h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="custom-links py-4">{{$users->links()}}</div>
                    @endif
                </div>
            </div>
        </div>
	</div>
</main>
@endsection