@extends('layouts.landingPage')

@section('content')
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Dukung UMKM Lokal</h4>
                    <h1 class="mb-5 display-3 text-primary">Produk Unggulan UMKM</h1>
                    <div class="position-relative mx-auto">
                        <a href="shop.html"
                            class="btn btn-primary border-2 border-secondary py-3 px-4 rounded-pill text-white">Belanja
                            Sekarang</a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ asset('LandingPage/img/hero-img-1.png') }}"
                                    class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Kerajinan</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ asset('LandingPage/img/hero-img-2.jpg') }}"
                                    class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Kuliner</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
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
                <h1 class="display-4">Produk Terlaris</h1>
                <p>Dukung produk lokal berkualitas yang dihasilkan oleh UMKM unggulan.</p>
            </div>
            <div class="row g-4">
                @foreach ([
            ['image' => 'best-product-1.jpg', 'title' => 'Keripik Singkong', 'price' => 'Rp 15.000'],
            ['image' => 'best-product-2.jpg', 'title' => 'Keripik Pisang', 'price' => 'Rp 20.000'],
            // Add more products as needed
        ] as $product)
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="{{ asset('LandingPage/img/' . $product['image']) }}"
                                        class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">{{ $product['title'] }}</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">{{ $product['price'] }}</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah ke Keranjang
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

    <!-- Fact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="bg-light p-5 rounded">
                <div class="row g-4 justify-content-center">
                    @foreach ([['icon' => 'fa-users', 'title' => 'Pelanggan Puas', 'value' => '1963'], ['icon' => 'fa-cogs', 'title' => 'Kualitas Layanan', 'value' => '99%'], ['icon' => 'fa-certificate', 'title' => 'Sertifikat Kualitas', 'value' => '33'], ['icon' => 'fa-boxes', 'title' => 'Produk Tersedia', 'value' => '789']] as $fact)
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa {{ $fact['icon'] }} text-secondary"></i>
                                <h4>{{ $fact['title'] }}</h4>
                                <h1>{{ $fact['value'] }}</h1>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial py-5">
        <div class="container py-5">
            <div class="testimonial-header text-center">
                <h4 class="text-primary">Testimoni</h4>
                <h1 class="display-5 mb-5 text-dark">Kata Pelanggan Kami!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                @foreach ([
            ['image' => 'testimonial-1.jpg', 'name' => 'Andi Rahmat', 'profession' => 'Pengusaha', 'quote' => 'Produk dari UMKMMART sangat berkualitas dan pengirimannya cepat. Saya sangat puas dengan layanan mereka.'],
            ['image' => 'testimonial-2.jpg', 'name' => 'Rina Dewi', 'profession' => 'Ibu Rumah Tangga', 'quote' => 'Belanja di UMKMMART sangat mudah dan produk-produknya berkualitas.'],
            // Add more testimonials as needed
        ] as $testimonial)
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">{{ $testimonial['quote'] }}</p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('LandingPage/img/' . $testimonial['image']) }}"
                                        class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">{{ $testimonial['name'] }}</h4>
                                    <p class="m-0 pb-3">{{ $testimonial['profession'] }}</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
@endsection
