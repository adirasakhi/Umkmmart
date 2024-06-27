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
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            <a href="#">
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                alt="Image" style="height: 300px">

                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
                        <p class="mb-1">{{ $product->category->category }}</p>
                        <a href="" data-bs-toggle="modal" data-bs-target="#myModalSeller">
                            <p class="mb-5"><i class="fas fa-store"></i> {{ $product->seller->name }}</p>
                        </a>
                        <h5 class="fw-bold mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h5>
                        <div class="input-group quantity mb-3" style="width: 100px;">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" id="productQuantity" class="form-control form-control-sm text-center border-0" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
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
        </div>
        <h1 class="fw-bold mb-0">Related products</h1>
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
</div>
</div>
{{-- end Modal Info Toko  --}}
<script>
    document.getElementById('contactSellerBtn').addEventListener('click', function() {
        var quantity = document.getElementById('productQuantity').value;
        var productName = "{{ $product->name }}";
        var productPrice = {{ $product->price }};
        var totalPrice = productPrice * quantity;
        var sellerPhone = "{{ $product->seller->phone }}";
        var message = `Halo, saya tertarik dengan produk Anda.%0A
        Nama produk: ${productName}%0A
        Harga produk: Rp${productPrice.toLocaleString('id-ID')}%0A
        Jumlah produk yang dibeli: ${quantity}%0A
        Total harga produk: Rp${totalPrice.toLocaleString('id-ID')}`;

        var whatsappUrl = `https://wa.me/${sellerPhone}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    });
</script>
@endsection
