<div class="col-12 col-md-3 ">
    <div class="m-2 bg-white border border-light shadow rounded">
        <a href="{{route('page.index')}}">
            <img class="img-fluid py-3 px-5" src="{{asset('img/logo.svg')}}" alt="Garazo">
        </a>
    </div>
    <div class="m-2 bg-white border border-light shadow rounded">
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.home.index')}}">Сторінка адміністратора</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.home.edit')}}">Дані адміністратора</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.categories.index')}}">Категорії</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.components.index')}}">Компоненти</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.attributes.index')}}">Атрибути</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{route('admin.products.index')}}">Продукти</a>
            </li>
            <li class="list-group-item list-group-item-action p-0">
                <a class="nav-link text-dark font-weight-bold text-uppercase text-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Вийти</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </li>
        </ul>
    </div>
</div>