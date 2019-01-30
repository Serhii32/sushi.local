@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            @include('admin.shared.sidebar')
            <div class="col-12 col-md-9 p-2">
                <div class="py-4 bg-white border rounded border-light shadow">
                	<h2 class="text-center font-weight-bold text-uppercase pb-5">Редагувати категорію</h2>
					<admin-categories-edit-component :category="{{$category}}"></admin-categories-edit-component>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection