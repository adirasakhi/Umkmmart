@if ($errors->any())
<div>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<form action="{{ url('sosial-media/update', $data->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<label for="id" class="control-label">Nama User</label>
	<input type="text" placeholder="ID" name="id" value="{{ $data->user->name }}" class="form-control input-sm" readonly>
	<label for="whatsapp" class="control-label">Whatsapp</label>
	<input type="text" placeholder="Judul Buku" name="whatsapp" class="form-control input-sm" value="{{ $data->whatsapp }}">
	<label for="facebook" class="control-label">Facebook</label>
	<input type="text" placeholder="Judul Buku" name="facebook" class="form-control input-sm" value="{{ $data->facebook }}">
	<label for="instagram" class="control-label">Instagram</label>
	<input type="text" placeholder="Judul Buku" name="instagram" class="form-control input-sm" value="{{ $data->instagram }}">
	<label for="tiktok" class="control-label">Tiktok</label>
	<input type="text" placeholder="Judul Buku" name="tiktok" class="form-control input-sm" value="{{ $data->tiktok }}">
	<button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
</form>
