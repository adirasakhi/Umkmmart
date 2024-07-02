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
    <label for="description" class="control-label">Description</label>
    <textarea name="description" class="summernote-simple">{{ $product->description }}</textarea>
    <label for="category_id" class="control-label">Kategori</label>
    <select name="category_id" class="form-control mb-3">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->category }}
            </option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary col-12" onclick="removeFormatBeforeSubmit()"><span
            class="fa fa-save"></span> Save</button>
</form>
<script>
    $(document).ready(function() {
        $('.summernote-simple').summernote({
            placeholder: 'Enter description here...',
            tabsize: 2,
            height: 100
        });
    });
    document.getElementById('imageInput').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear existing previews
            const files = event.target.files;

            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.style.maxWidth = '100%';
                    imgElement.style.height = 'auto';
                    imgElement.classList.add('img-thumbnail');

                    const removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;';
                    removeButton.style.position = 'absolute';
                    removeButton.style.top = '10px';
                    removeButton.style.right = '10px';
                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm');

                    const previewContainer = document.createElement('div');
                    previewContainer.style.position = 'relative';
                    previewContainer.style.display = 'inline-block';
                    previewContainer.appendChild(imgElement);
                    previewContainer.appendChild(removeButton);

                    removeButton.addEventListener('click', function() {
                        imagePreview.innerHTML = '';
                        document.getElementById('imageInput').value = '';
                    });

                    imagePreview.appendChild(previewContainer);
                }

                reader.readAsDataURL(file);
            }
        });
</script>
