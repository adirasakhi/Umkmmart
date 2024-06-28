@extends('layouts.landingPage')

@section('content')

    <!-- Single Page Header start -->

    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-4 custom-container">
        <div class="container py-4 custom-container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-12">
                    <div class="row g-4 justify-content-center">
                        <div class="col-10 col-md-8">
                            <div class="form-group w-100 mx-auto d-flex mb-1">
                                <form action="{{ route('katalog.search') }}" class="w-100 d-flex align-items-stretch">
                                    <div class="position-relative flex-grow-1" style="margin-top:100px">
                                        <input type="search" class="form-control p-3 pe-5" name="keywords"
                                            placeholder="Cari Produk UMKM ..." aria-describedby="search-icon-1"
                                            value="{{ request('keywords') }}" style="border-radius: 4px;">
                                        <button type="submit"
                                            style="color: black; position: absolute; top: 50%; right: 20px; transform: translateY(-50%); background: none; border: none; padding: 0;"
                                            id="searchButton">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <!-- Button to open modal on mobile -->
                                    <a id="filterModalToggle" class="btn btn-primary col-2 d-block d-lg-none ms-2"
                                        data-toggle="modal" data-target="#filterModal"
                                        style="color: white; border-radius: 4px; margin-top:100px">
                                        <i class="fa fa-filter" style="margin-top: 12px"></i>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Konten Filter --}}
                <div class="col-lg-3">
                    <div class="">
                        <div class="mb-4">
                            <div class="row g-4">
                                <div class="container custom-container" id="filterContainer">
                                    <div class="card" style="border-radius: 4px">
                                        <div class="card-header text-center">
                                            <h6 style="margin-top: 5px; font-weight: bold;">Filter</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('katalog.filter') }}" method="GET"
                                                onsubmit="removeFormatBeforeSubmit()">
                                                <h6>
                                                    <center>Kategori</center>
                                                </h6>
                                                @foreach ($categories as $category)
                                                    <div class="d-flex justify-content-start fruite-name my-2">
                                                        <input type="checkbox" name="id"
                                                            id="category_id_{{ $category->id }}"
                                                            class="custom-checkbox my-1" value="{{ $category->id }}"
                                                            @if (request('id') == $category->id) checked @endif>
                                                        <label class="ms-1">{{ $category->category }}</label>
                                                    </div>
                                                @endforeach
                                                <hr>
                                                <h6>
                                                    <center>Harga</center>
                                                </h6>
                                                <div class="my-2 justify-content-center align-items-center">
                                                    <div class="input-group my-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" style="border-radius: 4px">Rp
                                                            </div>
                                                        </div>
                                                        <input type="text" placeholder="Minimum"
                                                            style="border-radius: 4px" class="form-control input-sx"
                                                            name="min" id="min" value="{{ request('min') }}"
                                                            onkeyup="formatNumber(this)">
                                                    </div>
                                                    <div class="input-group my-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" style="border-radius: 4px">Rp
                                                            </div>
                                                        </div>
                                                        <input type="text" placeholder="Maksimum"
                                                            style="border-radius: 4px" class="form-control input-sx"
                                                            name="max" id="max" value="{{ request('max') }}"
                                                            onkeyup="formatNumber(this)">
                                                    </div>
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
                                                    <a href="{{ route('katalog.index') }}">
                                                        <button type="button" style="color: white; border-radius: 4px"
                                                            class="btn btn-primary me-1">Reset</button>
                                                    </a>
                                                    <button type="submit" style="color: white; border-radius: 4px"
                                                        class="btn btn-primary me-1 my-2">Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- Konten Produk --}}
                <div class="col-lg-9">
                    <div class="mb-6">
                        <div class="row g-4 justify-content-start " id="result">
                            @foreach ($products as $product)
                                <div class="col-6 col-md-4 col-lg-4">
                                    <div class="card h-100" style="border-radius: 4px">
                                        <a href="{{ route('katalog.detail', ['id' => $product->id]) }}">
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                                style="height: 150px; object-fit:cover;border-radius: 4px" alt="...">
                                            <div class="card-body">
                                                <h6 class="card-title" style="font-weight:medium">{{ $product->name }}
                                                </h6>
                                                <h6><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong>
                                                </h6>
                                                <h6 class="small"><i class="fas fa-store"></i>
                                                    {{ $product->seller->name }}</h6>
                                            </div>
                                        </a>
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
    <!-- Fruits Shop End -->

    {{-- Modal Filter Mobile --}}
    <div class="modal fade" id="filterModal" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel" style="text-align: center;">Filter</h5>
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
                                <div class="d-flex justify-content-start align-items-center fruite-name my-3">
                                    <input type="checkbox" name="id" id="modal_category_id{{ $category->id }}"
                                        class="custom-checkbox me-2" value="{{ $category->id }}"
                                        @if (request('id') == $category->id) checked @endif>
                                    <label style="text-align:center">{{ $category->category }}</label>
                                </div>
                            @endif
                        @endforeach

                        <!-- Item Tambahan (Awalnya Tersembunyi) -->
                        <div id="additionalCategories" style="display: none; max-height: 200px; overflow-y: auto;">
                            @foreach ($categories as $index => $category)
                                @if ($index >= $initialCount)
                                    <div
                                        class="d-flex justify-content-start align-items-center fruite-name my-3 additional-category">
                                        <input type="checkbox" name="id" id="modal_category_id{{ $category->id }}"
                                            class="custom-checkbox me-2" value="{{ $category->id }}"
                                            @if (request('id') == $category->id) checked @endif>
                                        <label style="text-align:center">{{ $category->category }}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Tombol View More -->
                        <div style="text-align: center">
                            <button type="button" id="viewMoreBtn" onclick="toggleAdditionalCategories()"
                                style="border: none; background: none; padding: 0; margin: 0; font-size: inherit; color: inherit; cursor: pointer;">Tampilkan
                                Semua</button>
                        </div>
                        <hr>
                        <h6>
                            <center>Harga</center>
                        </h6>
                        <div class="my-2 d-flex justify-content-center align-items-center">
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="border-radius: 4px">
                                        Rp
                                    </div>
                                </div>
                                <input type="text" placeholder="Minimum" style="border-radius: 4px"
                                    class="form-control input-sx me-2" name="min" id="min"
                                    value="{{ request('max') }}">
                            </div>
                            <div class="input-group my-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="border-radius: 4px">
                                        Rp
                                    </div>
                                </div>
                                <input type="text" placeholder="Maksimum" style="border-radius: 4px"
                                    class="form-control input-sx" name="max" id="max"
                                    value="{{ request('max') }}">
                            </div>
                            <input type="hidden" name="keywords" value="{{ request('keywords') }}"
                                id="keywords">
                        </div>
                        <hr>
                        <h6>
                            <center>Urutkan Harga</center>
                        </h6>
                        <div class="my-2 d-flex justify-content-center align-items-center">
                            <label for="" class="me-3">
                                <input type="radio" name="sort" id="desc_modal" value="desc" class="me-1"
                                    {{ request('sort') == 'desc' ? 'checked' : '' }}>Tertinggi
                            </label>
                            <label for="" class="me-3">
                                <input type="radio" name="sort" id="asc_modal" value="asc" class="me-1"
                                    {{ request('sort') == 'asc' ? 'checked' : '' }}>Terendah
                            </label>
                        </div>
                        <div class="my-2 d-flex justify-content-center align-items-center">
                            <a href="{{ route('katalog.index') }}">
                                <button type="button" style="color: white; border-radius: 4px"
                                    class="btn btn-primary me-1">
                                    Reset
                                </button>
                            </a>
                            <button type="submit" style="color: white; border-radius: 4px"
                                class="btn btn-primary me-1 my-2">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


    {{-- Script for Filter Modal and Number Formatting --}}
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

        function formatNumber(input) {
            // Remove non-numeric characters
            var value = input.value.replace(/[^0-9]/g, '');

            // Format the value with dots for thousands separator
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Update the input value with the formatted value
            input.value = formattedValue;
        }

        function removeFormat(input) {
            // Remove non-numeric characters
            var value = input.value.replace(/[^0-9]/g, '');

            // Update the input value with the cleaned numeric value
            input.value = value;
        }

        function removeFormatBeforeSubmit() {
            var minInput = document.getElementById('min');
            var maxInput = document.getElementById('max');

            // Call removeFormat function to clean thousand separators
            removeFormat(minInput);
            removeFormat(maxInput);
        }
    </script>
@endsection
