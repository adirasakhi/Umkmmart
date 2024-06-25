@extends('layouts.landingPage')
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-5">Shop</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group w-100 mx-auto d-flex mb-4">
                                <form action="{{ route('katalog.search') }}" class="w-100 d-flex align-items-stretch">
                                    <input type="search" class="form-control p-3 flex-grow-1 mx-2" name="keywords"
                                        placeholder="Cari Produk UMKM ..." aria-describedby="search-icon-1"
                                        value="{{ request('keywords') }}">
                                    <button type="submit" style="color: white" class="btn btn-primary p-3"
                                        id="searchButton"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Konten Filter --}}
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="">
                            <div class="mb-4">
                                <div class="row g-4">
                                    <div class="container" id="filterContainer">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h6 style="margin-top: 5px; font-weight: bold;">Filter</h6>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('katalog.filter') }}" method="GET">
                                                    <h6>
                                                        <center>Kategori</center>
                                                    </h6>
                                                    @foreach ($categories as $category)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center fruite-name my-3">
                                                            <input type="checkbox" name="id" id="category_id"
                                                                value="{{ $category->id }}"
                                                                @if (request('id') == $category->id) checked @endif>
                                                            <label
                                                                style="text-align:center">{{ $category->category }}</label>
                                                            <span>({{ $category->products_count }})</span>
                                                        </div>
                                                    @endforeach
                                                    <hr>
                                                    <h6>
                                                        <center>Harga</center>
                                                    </h6>
                                                    <div class="my-2 d-flex justify-content-center align-items-center">
                                                        <input type="text" placeholder="Min" name="min"
                                                            value="{{ request('min') }}" class="form-control input-sx me-1">
                                                        <input type="text" placeholder="Max" name="max"
                                                            value="{{ request('max') }}" class="form-control input-sx me-1">
                                                        <input type="hidden" name="keywords"
                                                            value="{{ request('keywords') }}" id="keywords">
                                                    </div>
                                                    <hr>
                                                    <h6>
                                                        <center>Urutkan Harga</center>
                                                    </h6>
                                                    <div class="my-2 d-flex justify-content-center align-items-center">
                                                        <label for="" class="me-3">
                                                            <input type="radio" name="sort" id="desc"
                                                                value="desc" class="me-1"
                                                                {{ request('sort') == 'desc' ? 'checked' : '' }}>Tertinggi
                                                        </label>
                                                        <label for="" class="me-3">
                                                            <input type="radio" name="sort" id="asc"
                                                                value="asc" class="me-1"
                                                                {{ request('sort') == 'asc' ? 'checked' : '' }}>Terendah
                                                        </label>
                                                    </div>
                                                    <div class="my-2 d-flex justify-content-center align-items-center">
                                                        <a href="{{ route('katalog.index') }}"><button type="button"
                                                                style="color: white" class="btn btn-primary me-1">
                                                                Reset
                                                            </button>
                                                        </a>
                                                        <button type="submit" style="color: white"
                                                            class="btn btn-primary me-1 my-2">
                                                            Filter
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button to open modal on mobile -->
                    <button id="filterModalToggle" class="btn btn-primary" data-toggle="modal" data-target="#filterModal"
                        style="color: white">Filter</button>

                    {{-- Modal Filter Mobile --}}
                    <div class="modal fade" id="filterModal" role="dialog" aria-labelledby="filterModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="filterModalLabel" style="text-align: center;">
                                        Filter
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('katalog.filter') }}" method="GET">
                                        <h6>
                                            <center>Kategori</center>
                                        </h6>
                                        @php $initialCount = 4; @endphp
                                        @foreach ($categories as $index => $category)
                                            @if ($index < $initialCount)
                                                <div
                                                    class="d-flex justify-content-start align-items-center fruite-name my-3">
                                                    <input type="checkbox" name="id"
                                                        id="category_id{{ $category->id }}" class="me-2"
                                                        value="{{ $category->id }}"
                                                        @if (request('id') == $category->id) checked @endif>
                                                    <label style="text-align:center">{{ $category->category }}</label>
                                                </div>
                                            @endif
                                        @endforeach

                                        <!-- Item Tambahan (Awalnya Tersembunyi) -->
                                        <div id="additionalCategories"
                                            style="display: none; max-height: 200px; overflow-y: auto;">
                                            @foreach ($categories as $index => $category)
                                                @if ($index >= $initialCount)
                                                    <div
                                                        class="d-flex justify-content-start align-items-center fruite-name my-3 additional-category">
                                                        <input type="checkbox" name="id"
                                                            id="category_id{{ $category->id }}" class="me-2"
                                                            value="{{ $category->id }}"
                                                            @if (request('id') == $category->id) checked @endif>
                                                        <label style="text-align:center">{{ $category->category }}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- Tombol View More -->
                                        <div style="text-align: center">
                                            <button type="button" id="viewMoreBtn"
                                                onclick="toggleAdditionalCategories()"
                                                style="border: none; background: none; padding: 0; margin: 0; font-size: inherit; color: inherit; cursor: pointer;">Tampilkan
                                                Semua</button>
                                        </div>
                                        <hr>
                                        <h6>
                                            <center>Harga</center>
                                        </h6>
                                        <div class="my-2 d-flex justify-content-center align-items-center">
                                            <input type="text" placeholder="Min" name="min"
                                                value="{{ request('min') }}" class="form-control input-sx me-1">
                                            <input type="text" placeholder="Max" name="max"
                                                value="{{ request('max') }}" class="form-control input-sx me-1">
                                            <input type="hidden" name="keywords" value="{{ request('keywords') }}"
                                                id="keywords">
                                        </div>
                                        <hr>
                                        <h6>
                                            <center>Urutkan Harga</center>
                                        </h6>
                                        <div class="my-2 d-flex justify-content-center align-items-center">
                                            <label for="" class="me-3">
                                                <input type="radio" name="sort" id="desc" value="desc"
                                                    class="me-1"
                                                    {{ request('sort') == 'desc' ? 'checked' : '' }}>Tertinggi
                                            </label>
                                            <label for="" class="me-3">
                                                <input type="radio" name="sort" id="asc" value="asc"
                                                    class="me-1"
                                                    {{ request('sort') == 'asc' ? 'checked' : '' }}>Terendah
                                            </label>
                                        </div>
                                        <div class="my-2 d-flex justify-content-center align-items-center">
                                            <a href="{{ route('katalog.index') }}"><button type="button"
                                                    style="color: white" class="btn btn-primary me-1">
                                                    Reset
                                                </button>
                                            </a>
                                            <button type="submit" style="color: white"
                                                class="btn btn-primary me-1 my-2">
                                                Filter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Konten Produk --}}
                    <div class="col-lg-9">
                        <div class="mb-6">
                            <div class="row g-4 justify-content-start " id="result">
                                {{-- @include('pages.Landing.result') --}}
                                @foreach ($products as $product)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                                style="height: 150px" alt="...">
                                            <div class="card-body">
                                                <a href="{{ route('katalog.detail', ['id' => $product->id]) }}">
                                                    <h6 class="card-title">{{ $product->name }}</h6>
                                                </a>
                                                <h6><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                                                </h6>
                                                <p class="small"><i class="fas fa-store"></i>
                                                    {{ $product->seller->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="pagination d-flex justify-content-center mt-5">
                            {{ $products->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
