@extends('layouts.landingPage')

@section('content')
<!-- Hero Start -->
<div class="container-fluid py-5 mb-5 hero-header position-relative">
    <img src="{{ $bannerHead ? asset('storage/' . $bannerHead->image) : '' }}" class="position-absolute top-0 end-0 w-100" >
    <div class="container py-5 ">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3" style="color: #747d88; font-family: 'Open Sans', sans-serif;"></h4>
                <h1 class="mb-5 display-3 text-primary"></h1>
                <div class="position-relative mx-auto">
                    <a href="{{ route('katalog.index') }}" class="btn btn-primary border-2 border-secondary py-3 px-4 rounded-pill text-white">Belanja Sekarang</a>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="{{ asset('LandingPage/img/kerajinan.jpg') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Kerajinan</a>
                        </div>
                        @foreach($slide as $value)
                        <div class="carousel-item rounded">
                            <div class="image-wrapper">
                                <img src="{{ asset('storage/' . $value->image) }}" class="img-fluid equal-img" alt="Slide">
                            </div>
                            <a href="#" class="btn px-4 py-2 text-white rounded">{!! $value->description !!}</a>
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Hero End -->
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
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>

<!-- Bestseller Product End -->
{{-- Cara Berbelanja --}}
<div class="container-fluid py-3">
    <div class="container py-3">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-5" style="margin-top: 10px;">Cara Berbelanja</h1>
            <p>Bagaimana cara belanja di UMKMart.id simak ilustrasi berikut</p>
            <img src="{{ asset('LandingPage/img/how-to-shop.png') }}" class="img-fluid" style="max-width: 100%; height: auto;">
        </div>
    </div>
</div>

{{-- End About Us --}}
{{-- About Us --}}
<div class="container-fluid py-5" id="aboutus">
    <div class="text-center mx-auto mb-9" style="max-width: 700px;">
        <h1 class="display-5" style="margin-top: 50px;">Tentang Kami</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-xl-10">
            @if ($about)
            <div class="text-center">
                @if ($about->image)
                <img src="{{ asset('storage/' . $about->image) }}" class="img-fluid mb-3" alt="About Image" width="200px" height="200px">
                @endif
            </div>
            <div class="text-center">
                <p>{!! $about->content !!}</p>

            </div>
            @else
            <p>Data tentang kami belum tersedia.</p>
            @endif
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
