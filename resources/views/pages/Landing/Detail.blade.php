@extends('layouts.landingPage')
@section('content')

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <div class="main-image-container border rounded mb-3">
                        <a href="#">
                            <img src="{{ asset('storage/' . $product->variants->sortBy('price')->first()->image) }}" class="img-fluid rounded"
                                alt="Image" id="expandedImg" style="object-fit: cover;">
                        </a>
                    </div>
                    <div class="scrollable-row">
                        @foreach ($variants as $variant)
                            <div class="col">
                                <img src="{{ asset('storage/' . $variant->image) }}" class="img-fluid rounded imgClick"
                                    alt="Image" style="object-fit: cover;" data-variant-id="{{ $variant->id }}"
                                    data-variant-name="{{ $variant->name }}" data-variant-price="{{ $variant->price }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5 scrollable-column">
                    <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                    <p class="mb-1">{{ $product->category->category }}</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#myModalSeller">
                        <p class="mb-2"><i class="fas fa-store"></i> {{ $product->seller->name }}</p>
                    </a>
                    <h2 class="fw-bold mb-3" id="orderVariantPrice">
                        Rp{{ number_format($product->variants->min('price'), 0, ',', '.') }}</h2>
                    <h6><strong>Pilih Varian</strong></h6>
                    <div class="variant-container">
                        @foreach ($variants as $variant)
                            <div class="variant-item" data-variant-id="{{ $variant->id }}"
                                data-variant-name="{{ $variant->name }}" data-variant-price="{{ $variant->price }}"
                                data-variant-image="{{ asset('storage/' . $variant->image) }}">
                                {{ $variant->name }}
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <div class="nav nav-tabs mb-3 justify-content-center">
                            <h6 class="nav-link active border-white border-bottom-0">
                                Deskripsi
                            </h6>
                        </div>
                    </div>
                    <div class="tab-content mb-5">
                        <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                            <p style="text-align: justify">{!! $product->description !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 border rounded" style="height:300px">
                    <div class="nav nav-tabs my-3 justify-content-center">
                        <h6 class="nav-link">
                            Atur Pesanan
                        </h6>
                    </div>
                    <div class="row">
                        <div class="d-flex my-3">
                            <img src="{{ asset('storage/' . $variants->first()->image) }}" class="img-fluid" alt="Image"
                                id="orderVariantImage" style="object-fit: cover; width:30px; border-radius:4px;">
                            <div class="variant-item bg-white border-0"><strong
                                    id="orderVariantName">{{ $variants->first()->name }}</strong></div>
                        </div>
                    </div>
                    <div class="input-group quantity mb-3" style="width: 100px;">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" id="productQuantity" class="form-control form-control-sm text-center border-0"
                            value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Total Pesanan</p>
                        <h5><strong
                                id="orderVariantPrice">Rp{{ number_format($variants->first()->price, 0, ',', '.') }}</strong>
                        </h5>
                    </div>
                    <div class="d-flex contact-seller justify-content-center">
                        <a href="#" id="contactSellerBtn" class="btn-custom">
                            <i class="fa fa-phone me-2"></i> Hubungi Penjual
                        </a>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Produk Terkait</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($related_products as $related_product)
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $related_product->image) }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;" alt="Image">
                            <div class="card-body">
                                <a href="{{ route('katalog.detail', ['id' => $related_product->id]) }}">
                                    <h6 class="card-title">{{ $related_product->name }}</h6>
                                </a>
                                <h6><strong>Rp{{ number_format($related_product->price, 0, ',', '.') }}</strong></h6>
                                <p class="small"><i class="fas fa-store"></i> {{ $related_product->seller->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->

    <!-- Modal Info Toko -->
    <div class="modal fade" id="myModalSeller" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Informasi Toko</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <img src="{{ asset('storage/' . $product->seller->photo) }}" alt="">
                        <p><strong>Toko :</strong> {{ $product->seller->name }}</p>
                    </div>
                    <p><strong>Lokasi :</strong> {{ $product->seller->address }}</p>
                    <p><strong>Nomor Telepon :</strong> {{ $product->seller->phone }}</p>
                    <p><strong>Tanggal Bergabung :</strong>
                        {{ \Carbon\Carbon::parse($product->seller->created_at)->locale('id_ID')->isoFormat('DD MMMM YYYY') }}
                    </p>
                    <hr>
                    <p><strong>Media Sosial</strong></p>
                    <div>
                        @if ($product->seller->social)
                            @if ($product->seller->social->facebook)
                                <a href="https://www.facebook.com/{{ $product->seller->social->facebook }}"
                                    style="display: inline-block; margin-right: 10px;">
                                    <span class="badge bg-primary text-white" style="padding: 10px; border-radius: 5px;">
                                        <i class="bi bi-facebook text-white"></i> Facebook
                                    </span>
                                </a>
                            @endif
                            @if ($product->seller->social->instagram)
                                <a href="https://www.instagram.com/{{ $product->seller->social->instagram }}"
                                    style="display: inline-block; margin-right: 10px;">
                                    <span class="badge bg-danger text-white" style="padding: 10px; border-radius: 5px;">
                                        <i class="bi bi-instagram text-white"></i> Instagram
                                    </span>
                                </a>
                            @endif
                            @if ($product->seller->social->tiktok)
                                <a href="https://www.tiktok.com/{{ $product->seller->social->tiktok }}"
                                    style="display: inline-block; margin-right: 10px;">
                                    <span class="badge bg-dark text-white" style="padding: 10px; border-radius: 5px;">
                                        <img src="{{ asset('storage/logo-tiktok-svgrepo-com.svg') }}" style="width: 12px"
                                            alt=""> TikTok
                                    </span>
                                </a>
                            @endif
                        @else
                            <p>Tidak ada akun sosial media</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Info Toko -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantItems = document.querySelectorAll('.variant-item');
            const expandedImg = document.getElementById('expandedImg');
            const orderVariantImage = document.getElementById('orderVariantImage');
            const orderVariantName = document.getElementById('orderVariantName');
            const orderVariantPrice = document.getElementById('orderVariantPrice');

            variantItems.forEach(item => {
                item.addEventListener('click', function() {
                    const variantId = this.getAttribute('data-variant-id');
                    const variantName = this.getAttribute('data-variant-name');
                    const variantPrice = this.getAttribute('data-variant-price');
                    const variantImage = this.getAttribute('data-variant-image');

                    expandedImg.src = variantImage;
                    orderVariantImage.src = variantImage;
                    orderVariantName.textContent = variantName;
                    orderVariantPrice.textContent =
                        `Rp${parseInt(variantPrice).toLocaleString('id-ID')}`;
                });
            });
        });

        const expandedImg = document.getElementById('expandedImg');
        const imgClick = document.querySelectorAll('.imgClick');

        imgClick.forEach(function(element) {
            element.addEventListener('click', function() {
                expandedImg.src = this.src;
            });
        });
    </script>
@endsection
