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
                <li class="dropdown {{ request()->is('users*') ? 'active' : '' }}">
                    <a href="/users" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>Management
                            User</span></a>
                    <ul class="dropdown-menu" style="display: {{ request()->is('users*') ? 'block' : 'none' }};">
                        <li class="{{ request()->is('users/active') ? 'active' : '' }}">
                            <a href="/users/active" class="nav-link">Pengguna Aktif</a>
                        </li>
                        <li class="{{ request()->is('users/inactive') ? 'active' : '' }}">
                            <a href="/users/inactive" class="nav-link">Pengguna Tidak Aktif</a>
                        </li>
                        <li class="{{ request()->is('users/reject') ? 'active' : '' }}">
                            <a href="/users/reject" class="nav-link">Pengguna Diblokir</a>
                        </li>
                    </ul>
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
        </ul>

    </aside>
</div>
