<aside class="position-fixed p-0" style="background-color: black; border-right: 1px white solid; width: 60px; min-height: 100vh; left: 0px; z-index: 1">
	<div class="py-3">
		<ul class="nav flex-column">
            @foreach($categories as $category)
                <li class="nav-item text-center py-2">
                    <a class="nav-link" href="{{route('page.category', $category->id)}}">
                        <img class="img-fluid" src="{{$category->icon ? asset($category->icon) : asset('img/default.svg')}}" alt="{{$category->title}}">
                    </a>
                </li>
            @endforeach
		</ul>
	</div>
</aside>