@extends('layouts.landingPage')

@section('content')
<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 " style="color: #747d88; font-family: 'Open Sans', sans-serif;">Dukung UMKM Lokal</h4>
                <h1 class="mb-5 display-3 text-primary">Produk Unggulan UMKM</h1>
                <div class="position-relative mx-auto">
                    <a href="{{ route('katalog.index') }}"
                       class="btn btn-primary border-2 border-secondary py-3 px-4 rounded-pill text-white">Belanja Sekarang</a>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="{{ asset('LandingPage/img/kerajinan.jpg') }}"
                                 class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Kerajinan</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="{{ asset('LandingPage/img/gula.jpg') }}"
                                 class="img-fluid w-100 h-100 rounded" alt="Second slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Olahan Makanan</a>
                        </div>
                        <div class="carousel-item rounded">
                            <img src="{{ asset('LandingPage/img/gula.jpg') }}"
                                 class="img-fluid w-100 h-100 rounded" alt="Third slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Sembako</a>
                        </div>
                    </div>
                    <div class="carousel-item rounded">
                        <img src="{{ asset('LandingPage/img/hero-img-2.jpg') }}"
                        class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        <a href="#" class="btn px-4 py-2 text-white rounded">Sayuran</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
{{-- Cara Berbelanja --}}
<div class="container-fluid py-3">
    <div class="container py-3">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-5" style="margin-top: 10px;">Cara berbelanja</h1>
            <p>Bagaimana cara belanja di UMKMart.id simak ilustrasi berikut</p>
            <img src="{{ asset('LandingPage/img/how-to-shop.png') }}" style="width: 500px; height: 350px;">

        </div>
    </div>
</div>
{{-- End About Us --}}
<!-- Bestseller Product Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-5">Produk Terlaris</h1>
            <p>Dukung produk lokal berkualitas yang dihasilkan oleh UMKM unggulan.</p>
        </div>
        <div class="row g-4">
           @foreach ($popularProduct as $product)
           <div class="col-lg-6 col-xl-4">
            <div class="p-4 rounded bg-light">
                <div class="row align-items-center">
                    <div class="col-6">
                        <img src="{{ asset('storage/' . $product->image) }}"
                        class="img-fluid rounded-circle w-100" alt="" style=" width:120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="col-6">
                        <a href="{{ route('katalog.detail', ['id' => $product->id]) }}" class="h6">{{ $product->name }}</a>
                        <h4 class="mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                        <p class="small"><i class="fas fa-store"></i> {{ $product->saller_name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bestseller Product End -->

{{-- About Us --}}
<div class="container-fluid py-5" id="aboutus">
    <div class="container py-5">
        <div class="text-center mx-auto mb-9" style="max-width: 700px;">
            <h1 class="display-5" style="margin-top: 50px;">About Us</h1>
            <p>Dukung produk lokal berkualitas yang dihasilkan oleh UMKM unggulan.</p>
        </div>
    </div>
</div>
{{-- End About Us --}}

<script type="text/javascript">
    // Melacak klik
    function trackClick(productId) {
        fetch(`/track-click/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => console.log(data));
    }

    // Mendapatkan produk populer
    function getPopularProducts() {
        fetch('/popular-products')
        .then(response => response.json())
        .then(products => {
            // Render produk populer ke UI
            console.log(products);
        });
    }

    // Panggil fungsi untuk menampilkan produk populer saat halaman dimuat
    document.addEventListener('DOMContentLoaded', getPopularProducts);
</script>
@endsection
