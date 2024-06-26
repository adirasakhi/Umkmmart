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
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}" readonly
            style="background-color:#e9ecef; cursor: default;">
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <img src="{{ asset('storage/' . $user->support_document) }}" class="img-fluid rounded mb-2 img-thumbnail"
            alt="">
    </div>
    <div class="mb-3">
        <label for="social_media_id" class="form-label">Social Media</label>
        <div>
            <span class="badge bg-primary text-white"><i class="bi bi-facebook text-white"></i> Facebook</span>
            <a href="https://api.whatsapp.com/send/?phone=628812248087"><span class="badge bg-success text-white"><i
                        class="bi bi-whatsapp text-white"></i> WhatsApp</span></a>
            <span class="badge bg-dark text-white"><i class="bi bi-tiktok text-white"></i> TikTok</span>
            <span class="badge bg-danger text-white"><i class="bi bi-instagram text-white"></i> Instagram</span>
        </div>
    </div>

    <div class="d-flex justify-content-start align-items-center">
        <button type="submit" class="btn btn-danger mt-3 mr-2 col-12 text-light"><i class="bi bi-x-circle-fill"></i>
            UnApprove</button>
    </div>

</form>
