<nav class="sidebar vh-100" id="sidebar">
    <div class="header">
        <span class="header-icon bi bi-person-circle"></span>
        <span class="header-text">Admin</span>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('category.list') }}" class="nav-link">
                <i class="bi bi-list-ul me-2"></i></i> <span>Categories</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('brand.list') }}" class="nav-link">
                <i class="bi bi-shop me-2"></i> <span>Brands</span>
            </a>
        </li>        
        <li class="nav-item">
            <a
                href="#productsMenu"
                class="nav-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse"
            >
                <div class="d-flex align-items-center">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Product Management</span>
                </div>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="productsMenu" class="collapse">
                <li class="nav-item">
                    <a href="{{route('product.list')}}" class="nav-link">
                        <i class="bi bi-plus-circle me-2"></i>Product List
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-pencil-square me-2"></i>Variant List
                    </a>
                </li>
            </ul>
        </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="bi bi-basket3 me-2"></i> <span>Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="bi bi-gear me-2"></i> <span>Settings</span>
        </a>
      </li>
    </ul>
</nav>