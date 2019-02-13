@extends('shared.main')

@section('content')

	<category-page-component :category="{{$category}}" :tabs="{{$tabs}}" :checkboxes="{{$checkboxes}}"></category-page-component>

@endsection