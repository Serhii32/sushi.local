@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            @include('admin.shared.sidebar')
            <div class="col-12 col-md-9 p-2">
                <div class="container py-4 bg-white border rounded border-light shadow">
                    <h2 class="text-center font-weight-bold text-uppercase pb-5">Галереї</h2>
                    <admin-galleries-index-component></admin-galleries-index-component>
                </div>
            </div>
        </div>
	</div>
</main>
@endsection