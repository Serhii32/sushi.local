@extends('shared.main')

@section('content')

	<product-page-component :product="{{$product}}" :components="{{$components}}"></product-page-component>

@endsection