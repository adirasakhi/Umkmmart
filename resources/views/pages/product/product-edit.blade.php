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
    <label for="name" class="control-label">Nama Produk</label>
    <input type="text" name="name" class="form-control mb-3" value="{{ $product->name }}">

    <label for="price" class="control-label">Harga Produk</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                Rp
            </div>
        </div>
        <input type="text" class="form-control currency mb-3" name="price" id="price" value="{{ number_format($product->price, 0, ',', '.') }}" onkeyup="formatNumber(this)">
    </div>
    <label for="description" class="control-label">Description</label>
    <textarea name="description" class="summernote-simple">{{ $product->description }}</textarea>
    <label for="image" class="control-label">Image</label>

    <input type="file" name="image" class="form-control mb-3">
    <label for="category_id" class="control-label">Kategori</label>
    <select name="category_id" class="form-control mb-3">
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->category }}
        </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary col-12" onclick="removeFormatBeforeSubmit()"><span class="fa fa-save"></span> Save</button>
</form>
<script>
    $(document).ready(function() {
        $('.summernote-simple').summernote({
            placeholder: 'Enter description here...',
            tabsize: 2,
            height: 100
        });
    });
</script>