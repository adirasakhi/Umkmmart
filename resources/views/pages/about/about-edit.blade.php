@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ url('about/update', $about->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="content" class="control-label">Isi Konten</label>
    <textarea name="content" class="summernote-simple">{{ $about->content }}</textarea>
    <label for="image" class="control-label">Logo</label>
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
