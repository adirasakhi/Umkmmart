@extends('layouts.landingPage')
@section('content')

<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <!-- Main Image and Thumbnails -->
            <div class="col-lg-4">
                <div class="main-image-container border rounded mb-3">
                    <a href="#">
                        <img src="{{ asset('storage/' . $product->variants->sortBy('price')->first()->image) }}"
                             class="img-fluid rounded" alt="Image" id="expandedImg" style="object-fit: cover;">
                    </a>
                </div>
                <div class="scrollable-row">
                    @foreach ($variants as $variant)
                        <div class="col">
                            <img src="{{ asset('storage/' . $variant->image) }}" class="img-fluid rounded imgClick"
                                 alt="Image" style="object-fit: cover;" data-variant-id="{{ $variant->id }}"
                                 data-variant-name="{{ $variant->name }}" data-variant-price="{{ $variant->price }}"
                                 data-variant-discounted-price="{{ $variant->discounted_price }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Product Details -->
            <div class="col-lg-5 scrollable-column">
                <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                <p class="mb-1">{{ $product->category->category }}</p>
                <a href="#" data-bs-toggle="modal" data-bs-target="#myModalSeller">
                    <p class="mb-2"><i class="fas fa-store"></i> {{ $product->seller->name }}</p>
                </a>
                <div>
                    @if ($product->variants->sortBy('price')->first()->price > $product->variants->sortBy('price')->first()->discounted_price)
                        <p>Rp{{ number_format($product->variants->sortBy('price')->first()->price, 0, ',', '.') }}</p>
                        <h2 class="discounted-price" id="orderVariantPrice">
                            Rp{{ number_format($product->variants->sortBy('price')->first()->discounted_price, 0, ',', '.') }}</h2>
                    @else
                        <h2 class="discounted-price" id="orderVariantPrice">
                            Rp{{ number_format($product->variants->sortBy('price')->first()->price, 0, ',', '.') }}</h2>
                    @endif
                </div>
                <h6><strong>Pilih Varian</strong></h6>
                <div class="variant-container">
                    @foreach ($variants as $variant)
                        <div class="variant-item" data-variant-id="{{ $variant->id }}"
                             data-variant-name="{{ $variant->name }}" data-variant-price="{{ $variant->price }}"
                             data-variant-discounted-price="{{ $variant->discounted_price }}"
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
            <!-- Order Section -->
            <div class="col-lg-3 border rounded" style="height:300px">
                <div class="nav nav-tabs my-3 justify-content-center">
                    <h6 class="nav-link">
                        Atur Pesanan
                    </h6>
                </div>
                <div class="row">
                    <div class="d-flex my-3">
                        <img src="{{ asset('storage/' . $product->variants->sortBy('price')->first()->image) }}"
                             class="img-fluid" alt="Image" id="orderVariantImage"
                             style="object-fit: cover; width:30px; border-radius:4px;">
                        <div class="variant-item bg-white border-0"><strong
                                id="orderVariantName">{{ $product->variants->sortBy('price')->first()->name }}</strong>
                        </div>
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
                    <h5>
                        <strong id="orderVariantTotal" data-variant-id="{{ $variant->id }}"
                                data-variant-name="{{ $variant->name }}" data-variant-price="{{ $variant->price }}"
                                data-variant-discounted-price="{{ $variant->discounted_price }}"
                                data-variant-image="{{ asset('storage/' . $variant->image) }}">
                            Rp{{ number_format($product->variants->sortBy('discounted_price')->first()->discounted_price, 0, ',', '.') }}
                        </strong>
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
                            <a href="https://www.tiktok.com/@{{ $product->seller->social->tiktok }}"
                               style="display: inline-block; margin-right: 10px;">
                                <span class="badge bg-dark text-white" style="padding: 10px; border-radius: 5px;">
                                    <i class="bi bi-tiktok text-white"></i> TikTok
                                </span>
                            </a>
                        @endif
                        @if ($product->seller->social->youtube)
                            <a href="https://www.youtube.com/{{ $product->seller->social->youtube }}"
                               style="display: inline-block; margin-right: 10px;">
                                <span class="badge bg-danger text-white" style="padding: 10px; border-radius: 5px;">
                                    <i class="bi bi-youtube text-white"></i> YouTube
                                </span>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imgClickElements = document.querySelectorAll('.imgClick');
        const variantItems = document.querySelectorAll('.variant-item');
        const expandedImg = document.getElementById('expandedImg');
        const orderVariantImage = document.getElementById('orderVariantImage');
        const orderVariantName = document.getElementById('orderVariantName');
        const orderVariantPrice = document.getElementById('orderVariantPrice');
        const orderVariantTotal = document.getElementById('orderVariantTotal');
        const productQuantity = document.getElementById('productQuantity');

        imgClickElements.forEach(imgClick => {
            imgClick.addEventListener('click', function() {
                const variantId = this.dataset.variantId;
                const variantName = this.dataset.variantName;
                const variantPrice = this.dataset.variantPrice;
                const variantDiscountedPrice = this.dataset.variantDiscountedPrice;
                const variantImage = this.src;

                expandedImg.src = variantImage;
                orderVariantImage.src = variantImage;
                orderVariantName.textContent = variantName;
                if (variantPrice > variantDiscountedPrice) {
                    orderVariantPrice.innerHTML = `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}<br>
                                                   Rp${new Intl.NumberFormat('id-ID').format(variantDiscountedPrice)}`;
                } else {
                    orderVariantPrice.textContent = `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}`;
                }
                updateTotalPrice();
            });
        });

        variantItems.forEach(variantItem => {
            variantItem.addEventListener('click', function() {
                const variantId = this.dataset.variantId;
                const variantName = this.dataset.variantName;
                const variantPrice = this.dataset.variantPrice;
                const variantDiscountedPrice = this.dataset.variantDiscountedPrice;
                const variantImage = this.dataset.variantImage;

                expandedImg.src = variantImage;
                orderVariantImage.src = variantImage;
                orderVariantName.textContent = variantName;
                if (variantPrice > variantDiscountedPrice) {
                    orderVariantPrice.innerHTML = `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}<br>
                                                   Rp${new Intl.NumberFormat('id-ID').format(variantDiscountedPrice)}`;
                } else {
                    orderVariantPrice.textContent = `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}`;
                }
                updateTotalPrice();
            });
        });

        const quantityMinusButton = document.querySelector('.btn-minus');
        const quantityPlusButton = document.querySelector('.btn-plus');

        quantityMinusButton.addEventListener('click', function() {
            let quantity = parseInt(productQuantity.value);
            if (quantity > 0) {
                quantity--;
                productQuantity.value = quantity;
                updateTotalPrice();
            }
        });

        quantityPlusButton.addEventListener('click', function() {
            let quantity = parseInt(productQuantity.value);
            quantity++;
            productQuantity.value = quantity;
            updateTotalPrice();
        });

        function updateTotalPrice() {
            const variantDiscountedPrice = parseFloat(orderVariantPrice.textContent.replace(/[^\d]/g, ''));
            const total = variantDiscountedPrice * parseInt(productQuantity.value);
            orderVariantTotal.textContent = `Rp${new Intl.NumberFormat('id-ID').format(total)}`;
        }
    });
</script>

@endsection
