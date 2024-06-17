@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ url('products/update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name" class="control-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
    <label for="price" class="control-label">Price</label>
    <input type="number" name="price" class="form-control" value="{{ $product->price }}">
    <label for="description" class="control-label">Description</label>
    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
    <label for="image" class="control-label">Image</label>
    <input type="file" name="image" class="form-control">
    <label for="category_id" class="control-label">Category</label>
    <select name="category_id" class="form-control">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->category }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
</form>

