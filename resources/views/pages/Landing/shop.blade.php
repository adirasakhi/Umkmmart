@extends('layouts.landingPage')
@section('content')
    <!-- Single Page Header Start -->
    <div class="container-fluid page-header py-5 bg-primary text-white text-center">
        <h1 class="display-5">Shop</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start -->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="form-group w-100 d-flex mb-4">
                        <form action="{{ route('katalog.search') }}" class="w-100 d-flex">
                            <input type="search" class="form-control p-3 flex-grow-1 me-2" name="keywords" placeholder="Cari Produk UMKM ..." value="{{ request('keywords') }}">
                            <button type="submit" class="btn btn-primary p-3" id="searchButton"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Filter Section -->
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="card">
                        <div class="card-header text-center">
                            <h6 class="fw-bold">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('katalog.filter') }}" method="GET">
                                <h6 class="text-center">Kategori</h6>
                                @foreach ($categories as $category)
                                    <div class="form-check my-3">
                                        <input type="checkbox" class="form-check-input" name="id" id="category_id{{ $category->id }}" value="{{ $category->id }}" @if (request('id') == $category->id) checked @endif>
                                        <label class="form-check-label" for="category_id{{ $category->id }}">{{ $category->category }} ({{ $category->products_count }})</label>
                                    </div>
                                @endforeach
                                <hr>
                                <h6 class="text-center">Harga</h6>
                                <div class="mb-2">
                                    <input type="text" placeholder="Min" name="min" value="{{ request('min') }}" class="form-control mb-2">
                                    <input type="text" placeholder="Max" name="max" value="{{ request('max') }}" class="form-control">
                                </div>
                                <hr>
                                <h6 class="text-center">Urutkan Harga</h6>
                                <div class="mb-2">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="sort" id="desc" value="desc" @if (request('sort') == 'desc') checked @endif>
                                        <label class="form-check-label" for="desc">Tertinggi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="sort" id="asc" value="asc" @if (request('sort') == 'asc') checked @endif>
                                        <label class="form-check-label" for="asc">Terendah</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <a href="{{ route('katalog.index') }}" class="btn btn-secondary me-2">Reset</a>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Filter Button and Modal -->
                <button id="filterModalToggle" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">Filter</button>


                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('katalog.filter') }}" method="GET">
                                    <h6 class="text-center">Kategori</h6>
                                    @foreach ($categories as $category)
                                        <div class="form-check my-3">
                                            <input type="checkbox" class="form-check-input" name="id" id="category_id{{ $category->id }}" value="{{ $category->id }}" @if (request('id') == $category->id) checked @endif>
                                            <label class="form-check-label" for="category_id{{ $category->id }}">{{ $category->category }}</label>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <h6 class="text-center">Harga</h6>
                                    <div class="mb-2">
                                        <input type="text" placeholder="Min" name="min" value="{{ request('min') }}" class="form-control mb-2">
                                        <input type="text" placeholder="Max" name="max" value="{{ request('max') }}" class="form-control">
                                    </div>
                                    <hr>
                                    <h6 class="text-center">Urutkan Harga</h6>
                                    <div class="mb-2">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="sort" id="desc" value="desc" @if (request('sort') == 'desc') checked @endif>
                                            <label class="form-check-label" for="desc">Tertinggi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="sort" id="asc" value="asc" @if (request('sort') == 'asc') checked @endif>
                                            <label class="form-check-label" for="asc">Terendah</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <a href="{{ route('katalog.index') }}" class="btn btn-secondary me-2">Reset</a>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product List -->
                <div class="col-lg-9">
                    <div class="row g-4">
                        @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-lg-4">
                                <div class="card h-100" style="border-radius: 10px;">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="..." style="height: 150px; object-fit: cover; border-radius: 10px 10px 0 0;">
                                    <div class="card-body text-center">
                                        <a href="{{ route('katalog.detail', ['id' => $product->id]) }}" class="text-decoration-none">
                                            <h6 class="card-title">{{ $product->name }}</h6>
                                        </a>
                                        <h6><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></h6>
                                        <p class="small text-muted"><i class="fas fa-store"></i> {{ $product->seller->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End -->

    <script>
        function toggleAdditionalCategories() {
            var additionalCategories = document.getElementById("additionalCategories");
            var viewMoreBtn = document.getElementById("viewMoreBtn");

            if (additionalCategories.style.display === "none") {
                additionalCategories.style.display = "block";
                viewMoreBtn.textContent = "Tampilkan Lebih Sedikit";
            } else {
                additionalCategories.style.display = "none";
                viewMoreBtn.textContent = "Tampilkan Semua";
            }
        }
    </script>
@endsection
