@extends('layouts.landingPage')
@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop Detail</h1>
</div>
<!-- Single Page Header End -->


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
                                    data-variant-name="{{ $variant->name }}"
                                    data-variant-price="{{ number_format($variant->price, 0, ',', '.') }}"
                                    data-variant-discounted-price="{{ number_format($variant->discounted_price, 0, ',', '.') }}"
                                    data-variant-image="{{ asset('storage/' . $variant->image) }}">
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
                        @if (
                            $product->variants->sortBy('price')->first()->price >
                                $product->variants->sortBy('price')->first()->discounted_price)
                            <p class="strike-through">Rp{{ number_format($product->variants->sortBy('price')->first()->price, 0, ',', '.') }}</p>
                            <h2 class="discounted-price" id="orderVariantPrice">
                                Rp{{ number_format($product->variants->sortBy('price')->first()->discounted_price, 0, ',', '.') }}
                            </h2>
                        @else
                            <h2 class="discounted-price" id="orderVariantPrice">
                                Rp{{ number_format($product->variants->sortBy('price')->first()->price, 0, ',', '.') }}
                            </h2>
                        @endif
                    </div>
                    <h6><strong>Pilih Varian</strong></h6>
                    <div class="variant-container">
                        @foreach ($variants as $variant)
                            <div class="variant-item" data-variant-id="{{ $variant->id }}"
                                data-variant-name="{{ $variant->name }}"
                                data-variant-price="{{ number_format($variant->price, 0, ',', '.') }}"
                                data-variant-discounted-price="{{ number_format($variant->discounted_price, 0, ',', '.') }}"
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
                    <div class="col-lg-12">
                        <nav>
                            <div class="nav nav-tabs mb-3">
                                <button class="nav-link active border-white border-bottom-0" type="button"
                                role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                aria-controls="nav-about" aria-selected="true">Description</button>
                            </div>
                        </nav>
                        <div class="tab-content mb-5">
                            <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                <p style="text-align: justify">{{ $product->description }} </p>
                                <div class="px-2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Produk Terkait</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($related_products as $related_product)
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $related_product->min_variant_image) }}" class="card-img-top"
                                style="height: 150px; object-fit: cover;" alt="Image">
                            <div class="card-body">
                                <a href="{{ route('katalog.detail', ['id' => $related_product->id]) }}">
                                    <h6 class="card-title">{{ $related_product->name }}</h6>
                                </a>
                                <h6><strong>Rp{{ number_format($related_product->min_price, 0, ',', '.') }}</strong></h6>
                                <p class="small"><i class="fas fa-store"></i> {{ $related_product->seller_name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->

    {{-- Modal Info Toko --}}
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
                            <span class="badge bg-primary text-white"
                            style="padding: 10px; border-radius: 5px;">
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
                            <img src="{{asset('storage/logo-tiktok-svgrepo-com (1).svg')}}" style="width: 12px" alt=""> TikTok
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
            const btnPlus = document.querySelector('.btn-plus');
            const btnMinus = document.querySelector('.btn-minus');
            const contactSellerBtn = document.getElementById('contactSellerBtn');

            imgClickElements.forEach(imgClick => {
                imgClick.addEventListener('click', function() {
                    updateVariantDetails(this);
                });
            });

            variantItems.forEach(variantItem => {
                variantItem.addEventListener('click', function() {
                    updateVariantDetails(this);
                });
            });

            btnPlus.addEventListener('click', function() {
                productQuantity.value = parseInt(productQuantity.value); // Increment quantity by 1

                updateTotalPrice();
            });

            btnMinus.addEventListener('click', function() {
                if (parseInt(productQuantity.value) > 0) {
                    productQuantity.value = parseInt(productQuantity
                    .value); // Decrement quantity by 1, but not below 1

                    updateTotalPrice();
                }
            });

            function updateVariantDetails(element) {
                const variantId = element.dataset.variantId;
                const variantName = element.dataset.variantName;
                const variantPrice = parseFloat(element.dataset.variantPrice.replaceAll('.', ''));
                const variantDiscountedPrice = parseFloat(element.dataset.variantDiscountedPrice.replaceAll('.', ''));
                const variantImage = element.dataset.variantImage;
                expandedImg.src = variantImage;
                orderVariantImage.src = variantImage;
                orderVariantName.textContent = variantName;

                if (variantPrice > variantDiscountedPrice) {
                    orderVariantPrice.innerHTML =
                        `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}<br>Rp${new Intl.NumberFormat('id-ID').format(variantDiscountedPrice)}`;
                } else {
                    orderVariantPrice.textContent = `Rp${new Intl.NumberFormat('id-ID').format(variantPrice)}`;
                }

                updateTotalPrice();
            }

            function updateTotalPrice() {
                let quantity = parseInt(productQuantity.value);
                let priceElements = orderVariantPrice.innerHTML.split('<br>');
                let discountedPrice;

                if (priceElements.length > 1) {
                    discountedPrice = parseFloat(priceElements[1].replace(/[^\d]/g, ''));
                } else {
                    discountedPrice = parseFloat(priceElements[0].replace(/[^\d]/g, ''));
                }

                let total = discountedPrice * quantity;
                orderVariantTotal.textContent = `Rp${new Intl.NumberFormat('id-ID').format(total)}`;
            }

            // Initial update on page load
            updateTotalPrice();

            contactSellerBtn.addEventListener('click', function(event) {
                event.preventDefault();
                var quantity = productQuantity.value;
                var productName = "{{ $product->name }}";
                var variantName = orderVariantName.textContent;
                var priceElements = orderVariantPrice.innerHTML.split('<br>');
                var originalPrice = priceElements.length > 1 ? parseFloat(priceElements[0].replace(/[^\d]/g,
                    '')) : null;
                var variantPrice = parseFloat(priceElements[priceElements.length - 1].replace(/[^\d]/g,
                ''));

                var totalPrice = variantPrice * quantity;
                var sellerPhone = "{{ $product->seller->phone }}";

                var message = `Halo, saya tertarik dengan produk Anda.
    Nama produk: ${productName}
    Varian: ${variantName}
    Harga produk: ${originalPrice ? `Rp${originalPrice.toLocaleString('id-ID')} (diskon menjadi: Rp${variantPrice.toLocaleString('id-ID')})` : `Rp${variantPrice.toLocaleString('id-ID')}`}

    Jumlah produk yang dibeli: ${quantity}
    Total harga produk: Rp${totalPrice.toLocaleString('id-ID')}
    Link produk: ${location.href}`;

                var whatsappUrl = `https://wa.me/${sellerPhone}?text=${encodeURIComponent(message)}`;
                window.open(whatsappUrl, '_blank');
            });
        });
    </script>

@endsection

