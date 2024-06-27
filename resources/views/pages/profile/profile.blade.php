@extends('layouts.dashboard')

@section('title', '|| Profile Penjual')

@section('content')
    {{-- Modal Tambah --}}
    <div class="modal fade" id="myModalCreate_{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.profile.update', ['id' => $user->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" required
                                value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required
                                value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Kata Sandi"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Konfirmasi Kata Sandi" value="">
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" id="address" placeholder="Alamat" required>{{ $user->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label">Nomor Telepon <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="No. Telepon" required
                                value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="photo" class="control-label">Foto Profile</label>
                            <input type="file" name="photo" class="form-control" placeholder="Foto Profile"
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="facebook" class="control-label">Facebook</label>
                            <input type="text" name="facebook" class="form-control" placeholder="Facebook"
                                value="{{ $sosmed->first()->facebook ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="whatsapp" class="control-label">WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="tel" name="whatsapp" placeholder="WhatsApp"
                                    value="{{ $sosmed->first()->whatsapp ? (substr($sosmed->first()->whatsapp, 0, 1) === '0' ? '62' . substr($sosmed->first()->whatsapp, 1) : $sosmed->first()->whatsapp) : '' }}"
                                    pattern="[0-9]+" title="Masukkan hanya angka" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tiktok" class="control-label">Tiktok</label>
                            <input type="text" name="tiktok" class="form-control" placeholder="Tiktok"
                                value="{{ $sosmed->first()->tiktok ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="instagram" class="control-label">Instagram</label>
                            <input type="text" name="instagram" class="form-control" placeholder="Instagram"
                                value="{{ $sosmed->first()->instagram ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span>
                            Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end Tambah Modal --}}
    <div class="main-content">
        <section class="section">
            <div class="container mt-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <div class="card p-3 py-4">
                            <div class="section-header">
                                <h1>Kelola Produk</h1>
                            </div>
                            @if ($user->photo != null)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $user->photo) }}" width="100"
                                        class="rounded-circle">
                                </div>
                            @else
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/avatar/avatar-1.png') }}" width="100"
                                        class="rounded-circle">
                                </div>
                            @endif

                            <div class="text-center mt-3">
                                <span class="bg-secondary p-1 px-4 rounded text-white">
                                    @if ($user->role_id == 1)
                                        Admin
                                    @elseif ($user->role_id == 2)
                                        Penjual
                                    @else
                                        Pengguna
                                    @endif
                                </span>
                                <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                                <div class="px-4 mt-1">
                                    <p class="fonts">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                        ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                                @foreach ($sosmed as $val)
                                    <div class="m-3">
                                        @if ($val->facebook != null)
                                            <a href="https://www.facebook.com/{{ $val->facebook }}"><span
                                                    class="badge bg-primary text-white"><i
                                                        class="bi bi-facebook text-white"></i> Facebook</span></a>
                                        @endif
                                        @if ($val->whatsapp != null)
                                            <a href="https://api.whatsapp.com/send/?phone={{ $val->whatsapp }}"><span
                                                    class="badge bg-success text-white"><i
                                                        class="bi bi-whatsapp text-white"></i> WhatsApp</span></a>
                                        @endif
                                        @if ($val->tiktok != null)
                                            <a href="https://www.tiktok.com/{{ $val->tiktok }}"><span
                                                    class="badge bg-dark text-white"><i
                                                        class="bi bi-tiktok text-white"></i> Tiktok</span></a>
                                        @endif
                                        @if ($val->instagram != null)
                                            <a href="https://www.instagram.com/{{ $val->instagram }}"><span
                                                    class="badge bg-danger text-white"><i
                                                        class="bi bi-instagram text-white"></i> Instagram</span></a>
                                        @endif
                                    </div>
                                @endforeach
                                @if ($user->role_id == 2)
                                    <div class="buttons">
                                        <button class="btn btn-primary my-2" style="width: 180px; margin:20px"
                                            data-bs-toggle="modal"
                                            data-bs-target="#myModalCreate_{{ $user->id }}">Edit Akun</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
