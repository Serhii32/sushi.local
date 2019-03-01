<aside id="left-sidebar" class="position-fixed p-0" style="background-color: black; border-right: 3px solid #e16729; min-height: 100vh; left: 0px; z-index: 2">
	<div class="py-3">
		<ul class="nav flex-column">
            @foreach($categories as $category)
                <li class="left-sidebar-nav nav-item text-center py-2">
                    <a class="nav-link text-left" href="{{route('page.category', $category->id)}}">
                        <img width=40 class="left-sidebar-img img-fluid" src="{{$category->icon ? asset($category->icon) : asset('img/default.svg')}}" alt="{{$category->title}}">
                        <span class="left-sidebar-title text-white font-weight-bold pl-3">{{$category->title}}</span>
                    </a>
                </li>
            @endforeach
		</ul>
	</div>
</aside>