@extends('shared.main')

@section('content')

	<category-page-component :category="{{$category}}" :tabs="{{$tabs}}" :checkboxes="{{$checkboxes}}" :products="{{$products}}"></category-page-component>

@endsection