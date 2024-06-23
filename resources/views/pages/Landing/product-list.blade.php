@foreach ($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card h-100">
            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height: 150px" alt="Product Image">
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
