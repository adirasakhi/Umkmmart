<!-- Main Sidebar -->
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <a href="/dashboard">UMKMart</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/dashboard">UM</a>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">

            <!-- Dashboard Section -->
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <!-- Admin Section -->
            @if (Auth::user()->role_id == 1)
                <li class="{{ request()->is('users') ? 'active' : '' }}">
                    <a href="/users" class="nav-link">
                        <i class="fas fa-user"></i><span>Pengguna</span>
                    </a>
                </li>
                <li class="{{ request()->is('kategori') ? 'active' : '' }}">
                    <a href="/kategori" class="nav-link">
                        <i class="fas fa-th"></i><span>Kategori</span>
                    </a>
                </li>
            @endif

            <!-- Common Section -->
            <li class="{{ request()->is('products') ? 'active' : '' }}">
                <a href="/products" class="nav-link">
                    <i class="fas fa-th-large"></i><span>Produk</span>
                </a>
            </li>
            <li class="{{ request()->is('sosial-media') ? 'active' : '' }}">
                <a href="/sosial-media" class="nav-link">
                    <i class="fab fa-facebook"></i><span>Sosial Media</span>
                </a>
            </li>
        </ul>

    </aside>
</div>
