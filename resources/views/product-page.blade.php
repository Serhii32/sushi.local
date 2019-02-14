@extends('shared.main')

@section('content')

	<product-page-component :product="{{$product}}"></product-page-component>

@endsection