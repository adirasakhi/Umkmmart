<!-- Navbar start -->
<div class="container-fluid fixed-top bg-white" style="background-color: white;">
    <div class="container pt-4 top-link">
        <nav class="navbar navbar-light bg-white navbar-expand-xl align-items-center">
            <a href="/" class="navbar-brand">
                {{-- <h1 class="text-primary display-6">UMKMart.id</h1> --}}
                <img src="{{ asset('storage/logo.png' ) }}" alt="" style="width: 150px">
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="ms-auto d-flex align-items-center">
                    <div class="navbar-nav" style="font-weight: bold; color: black;">
                        <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Beranda</a>
                        <a href="/katalog"
                            class="nav-item nav-link {{ Request::is('katalog') ? 'active' : '' }}">Belanja</a>
                        <a href="/#aboutus"
                            class="nav-item nav-link {{ Request::is('aboutus') ? 'active' : '' }}">Tentang Kami</a>
                        <a href="#contact"
                            class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Kontak</a>

                        <a href="/login" class="nav-item nav-link d-xl-none">Masuk</a>
                        <a href="/login" class="ms-3 d-flex align-items-center user-icon d-none d-xl-inline">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div>
                </div>
        </nav>
    </div>
</div>

</div>
<!-- Navbar End -->
