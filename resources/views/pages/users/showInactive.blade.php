@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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
        <label for="photo" class="form-label">Foto</label>
        <img src="{{ asset('storage/' . $user->support_document) }}" class="img-fluid rounded mb-2 img-thumbnail"
            alt="">
    </div>
    <div class="form-group">
        <label for="facebook" class="control-label">Facebook</label>
        <input type="text" name="facebook" class="form-control" placeholder="Facebook"
            value="{{ $sosmed->first()->facebook ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="whatsapp" class="control-label">WhatsApp</label>
        <input type="text" name="whatsapp" class="form-control" placeholder="WhatsApp"
            value="{{ $sosmed->first()->whatsapp ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="tiktok" class="control-label">Tiktok</label>
        <input type="text" name="tiktok" class="form-control" placeholder="Tiktok"
            value="{{ $sosmed->first()->tiktok ?? '' }}" style="background-color: #e9ecef; cursor: default" readonly>
    </div>
    <div class="form-group">
        <label for="instagram" class="control-label">Instagram</label>
        <input type="text" name="instagram" class="form-control" placeholder="Instagram"
            value="{{ $sosmed->first()->instagram ?? '' }}" style="background-color: #e9ecef; cursor: default"
            readonly>
    </div>
    <div class="d-flex justify-content-start align-items-center">
        <button type="submit" name="action" value="approve" class="btn btn-primary mt-3 mr-2 col-6 text-light">
            <i class="bi bi-check-circle-fill"></i> Setuju
        </button>
        <button type="button" class="btn btn-danger mt-3 col-6 text-light" data-toggle="modal"
            data-target="#myModalReject">
            <i class="bi bi-x-circle-fill"></i> Tolak
        </button>
    </div>
</form>

<!-- Modal for Rejecting User -->
<div class="modal fade" id="myModalReject" role="dialog" aria-labelledby="myModalLabelReject" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabelReject">Tolak Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menolak Pengguna ini?</p>
                <form id="rejectForm" action="{{ route('users.action.reject', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="description" class="form-label">Deskripsi Kesalahan</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row justify-content-end">
                        <button type="button" class="btn btn-danger col-2 mx-2" data-dismiss="modal">
                            <span class="fa fa-times"></span> Batal
                        </button>
                        <button type="submit" class="btn btn-primary col-2 mr-3">
                            <span class="fa fa-check"></span> Yakin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
