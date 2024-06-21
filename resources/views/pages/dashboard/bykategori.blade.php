 <h1>Products in {{ $category->name }} Category</h1>

    @if ($category->products->isEmpty())
        <p>No products found in this category.</p>
    @else
        <ul>
            @foreach ($category->products as $product)
                <li>{{ $product->name }} - ${{ $product->price }}</li>
            @endforeach
        </ul>
    @endif