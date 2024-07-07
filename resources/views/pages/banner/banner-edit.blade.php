@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ url('banner/update', $banner->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="title" class="control-label">Judul</label>
    <input type="text" name="title" class="form-control mb-3" value="{{ $banner->title }}">
    <label for="description" class="control-label">Descripsi</label>
    <textarea name="description" class="summernote-simple" >{{ $banner->description }}</textarea>
    <label for="type" class="control-label">Tipe</label>
    <select name="type" class="form-control mb-3" style="display: none;">
        <option value="">-- Pilih Tipe Banner --</option>
        <option value="head" {{ $banner->type == 'head' ? 'selected' : '' }}>Banner Head</option>
        <option value="slideshow" {{ $banner->type == 'slideshow' ? 'selected' : '' }}>Banner Slideshow</option>
    </select>
    <label for="image" class="control-label">Image</label>
    <input type="file" name="image" class="form-control mb-3">
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
