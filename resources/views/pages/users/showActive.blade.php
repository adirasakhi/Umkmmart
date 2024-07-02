@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update.status', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">No. Telepon</label>
        <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label d-flex">Dokumen</label>
        <img src="{{ asset('storage/' . $user->support_document) }}" class="img-fluid rounded img-thumbnail"
            width="150">
    </div>
    <div class="form-group">
        <label for="facebook" class="control-label">Facebook</label>
        <input type="text" name="facebook" class="form-control" placeholder="Facebook"
            value="{{ $user->socialMedia->facebook ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="whatsapp" class="control-label">WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" placeholder="WhatsApp"
            value="{{ $sosmed->socialMedia->whatsapp ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="tiktok" class="control-label">Tiktok</label>
        <input type="text" name="tiktok" class="form-control" placeholder="Tiktok"
            value="{{ $sosmed->socialMedia->tiktok ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="instagram" class="control-label">Instagram</label>
        <input type="text" name="instagram" class="form-control" placeholder="Instagram"
            value="{{ $sosmed->socialMedia->instagram ?? '' }}" style="background-color: #e9ecef; cursor: default"
            readonly>
    </div>
    <div class="d-flex justify-content-start align-items-center">
        <button type="submit" class="btn btn-danger mt-3 mr-2 col-12 text-light"><i class="bi bi-x-circle-fill"></i>
            Non Aktifkan</button>
    </div>

</form>
