<!-- Navbar Background -->
<div class="navbar-bg"></div>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg main-navbar">

    <!-- Sidebar Toggle Button -->
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>

    <!-- User Dropdown Menu -->
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @php
                    $user = Auth::user()
                @endphp
                @if($user->photo != null )
                <img alt="User Avatar" src="{{ asset('storage/'. $user->photo) }}" class="rounded-circle mr-1 img-fluid" width="50" height="50">
                @elseif ($user->photo == null && $user->role_id == 1)
                <img alt="User Avatar" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">
                    Hi, @auth {{ Auth::user()->name }} @endauth
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="/users/profile" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

</nav>
