@extends('layouts.dashboard')

@section('title', '|| Profile Penjual')


@section('content')
    {{-- Modal Tambah --}}
    <div class="modal fade" id="myModalCreate_{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.profile.update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Alamat</label>
                            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="photo" class="control-label">Foto Profile</label>
                            <input type="file" name="photo" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" value="">
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
                        <div class="card">
                            <div class="section-header">
                                <h1>Profile</h1>
                            </div>
                            <div class="text-center">
                                @if ($user->photo != null)
                                <img src="{{ asset ('storage/'. $user->photo) }}" class="img-fluid img-thumbnail" width="100">
                                @else
                                <img src="{{ asset('assets/img/avatar/avatar-1.png') }}"width="100" class="rounded-circle">
                                @endif
                            </div>

                            <div class="text-center mt-3">
                                <span class="bg-secondary p-1 px-4 rounded text-white">                                    @if ($user->role_id == 1)
                                    Admin
                                @elseif ($user->role_id == 2)
                                    penjual
                                @else
                                    Pengguna
                                @endif</span>
                                <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                                <p class="mt-2 mb-0">{{ $user->address }}</p>
                                @if($user->role_id ==2)
                                @foreach ($sosmed as $val)
                                    <div class="m-3">

                                        @if ($val->facebook != null)
                                        <a href="https://facebook.com/{{ $val->facebook }}"><span class="badge bg-primary text-white"><i
                                                    class="bi bi-facebook text-white"></i> Facebook</span></a>
                                        @endif
                                        @if ($val->whatsapp != null)
                                            <a href="https://api.whatsapp.com/send/?phone={{ $val->whatsapp }}"><span
                                                    class="badge bg-success text-white"><i
                                                        class="bi bi-whatsapp text-white"></i> WhatsApp</span></a>
                                        @endif
                                        @if ($val->tiktok != null)
                                        <a href="https://tiktok.com/{{ $val->tiktok }}">
                                            <span class="badge bg-dark text-white">
                                                <i class="bi bi-tiktok text-white"></i> TikTok
                                            </span>
                                        </a>
                                    @endif


                                        @if ($val->instagram != null)
                                        <a href="https://instagram.com/{{ $val->instagram }}"><span class="badge bg-danger text-white"><i
                                                    class="bi bi-instagram text-white"></i> Instagram</span></a>
                                        @endif
                                    </div>
                                @endforeach
                                @endif

                                @if ($user->role_id == 2)
                                <div class="buttons">
                                    <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-bs-toggle="modal" data-bs-target="#myModalCreate_{{  $user->id }}">Edit Profile</button>
                                </div>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>

            </div>


        @endsection
