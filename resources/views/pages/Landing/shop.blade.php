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
                                <input type="search" class="form-control p-3 flex-grow-1 mx-2" name="keywords"
                                    autocomplete="off" placeholder="Cari Produk UMKM ..." aria-describedby="search-icon-1"
                                    onkeyup="search_data(this.value);">
                                <button type="submit" style="color: white" class="btn btn-primary p-3" id="searchButton"><i
                                        class="fa fa-search"></i></button>
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
                                    <div class="container">
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
                                                                value="{{ $category->id }}" @if(request('id') == $category->id) checked @endif>
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

                    {{-- Konten Produk --}}
                    <div class="col-lg-9">
                        <div class="mb-6">
                            <div class="row g-4 justify-content-start " id="result">
                                @include('pages.Landing.result')
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
    </div>
    <!-- Fruits Shop End-->

    <script>
        function search_data(search_value) {
            $.ajax({
                url: '{{ route('katalog.search') }}',
                method: 'GET',
                data: {
                    keywords: search_value
                },
                success: function(response) {
                    $('#result').html(response);
                }
            });
        }
    </script>
@endsection
