<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <button class="btn btn-outline-secondary" id="toggle-btn" onclick="toggleSidebar()">
        <i id="toggle-icon" class="bi bi-list"></i>
    </button>
    
    @if (Route::currentRouteName() == 'home')
        <a class="navbar-brand ms-3" href="#">Dashboard</a>
    @elseif (Route::currentRouteName() == 'category.list'|| Route::currentRouteName() == 'category.create' || Route::currentRouteName() == 'category.edit')
        <a class="navbar-brand ms-3" href="#">Category</a>
    @elseif (Route::currentRouteName() == 'brand.list' || Route::currentRouteName() == 'brand.create'|| Route::currentRouteName() == 'brand.edit' || Route::currentRouteName() == 'brand.show')
        <a class="navbar-brand ms-3" href="#">Brand</a>
    @endif
    <div class="ms-auto dropdown">
        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{$name}}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
        </ul>
    </div>
</nav>
