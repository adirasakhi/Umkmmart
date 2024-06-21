@extends('layouts.landingPage')
@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop</h1>
</div>
<!-- Single Page Header End -->

<!-- Fruits Shop Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Fresh fruits shop</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="input-group w-100 mx-auto d-flex mb-4">
                            <form action="{{ route('katalog.search') }}">
                                <input type="search" class="form-control p-3" name="keywords" placeholder="Keywords" aria-describedby="search-icon-1">
                                <button type="submit" class="btn btn-primary input-group-text p-3" id="searchButton"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block"></div>
                    <div class="col-md-6 col-lg-3">
                        <div class="sorting-form bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4 {{ $categoryId  == null ? 'd-none' : null }}">
                            <form action="{{ route('katalog.search') }}" class="d-flex justify-content-between align-items-center">
                                <input type="text" placeholder="Min" name="min" value="" class="form-control input-sx me-2">
                                <input type="text" placeholder="Max" name="max" value="" class="form-control input-sx me-2">
                                <input type="hidden" name="category" value="{{ $categoryId }}"  id="category" class="form-control input-sx me-2 {{ $categoryId != null ? 'd-none' : null }}">
                                <input type="hidden" name="keywords" value="{{ request('keywords') }}"  id="keywords" class="form-control input-sx me-2 {{ request('keywords') == null ? 'd-none' : null }}">
                                <button type="submit" class="btn btn-primary me-3">Filter</button>
                            </form>
                        </div>
                        <div class="sorting-form bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4 {{ request('keywords')  == null ? 'd-none' : null }}">
                            <form action="{{ route('katalog.search') }}" class="d-flex justify-content-between align-items-center">
                                <input type="text" placeholder="Min" name="min" value="" class="form-control input-sx me-2">
                                <input type="text" placeholder="Max" name="max" value="" class="form-control input-sx me-2">
                                <input type="hidden" name="category" value="{{ $categoryId }}"  id="category" class="form-control input-sx me-2 {{ $categoryId != null ? 'd-none' : null }}">
                                <input type="hidden" name="keywords" value="{{ request('keywords') }}"  id="keywords" class="form-control input-sx me-2 {{ request('keywords') == null ? 'd-none' : null }}">
                                <button type="submit" class="btn btn-primary me-3">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Categories</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        @foreach ($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('katalog.index', ['id' => $category->id]) }}"><i
                                                    class="fas fa-apple-alt me-2" class="category-link"></i>{{ $category->category }}</a>
                                                    <span>({{ $category->products_count }})</span>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-start">
                                @foreach ($products as $product)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card h-100">
                                        <img src="{{ asset('/' . $product->image) }}" class="card-img-top"
                                        style="height: 150px" alt="...">
                                        <div class="card-body">
                                            <a href="{{ route('katalog.detail', ['id' => $product->id]) }}">
                                                <h6 class="card-title">{{ $product->name }}</h6>
                                            </a>
                                            <h6><strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></h6>
                                            <p class="small"><i class="fas fa-store"></i> {{ $product->seller->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="pagination d-flex justify-content-center mt-5">
                                <a href="#" class="rounded">&laquo;</a>
                                <a href="#" class="active rounded">1</a>
                                <a href="#" class="rounded">2</a>
                                <a href="#" class="rounded">3</a>
                                <a href="#" class="rounded">4</a>
                                <a href="#" class="rounded">5</a>
                                <a href="#" class="rounded">6</a>
                                <a href="#" class="rounded">&raquo;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
    @endsection
