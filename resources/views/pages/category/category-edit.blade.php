@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ url('kategori/update', $data->id) }}" method="POST" enctype="multipart/form-data">

    @csrf
    <label for="kategori" class="control-label">Nama</label>
    <input type="text" placeholder="Judul Buku" name="category" class="form-control input-sm mb-3"
        value="{{ $data->category }}">
    <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
</form>
