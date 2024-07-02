@extends('layouts.dashboard')

@section('title', '|| Pengguna')

@section('content')

    @if (session('success'))
        <div id="successPopup" class="popup success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="errorPopup" class="popup error">
            {{ session('error') }}
        </div>
    @endif
    @foreach ($users as $user)
    <div class="modal fade" id="myModalEditStatus_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detail Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="data">
                        @include('pages.users.showActive')
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- Modal for Editing User --}}
    @foreach ($users as $user)
        <div class="modal fade" id="myModalEdit_{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabelEdit" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabelEdit">Edit Profil Pengguna</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.update.user', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $user->name }}" style="background-color:#e9ecef; cursor: default;">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}" style="background-color:#e9ecef; cursor: default;">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" class="form-control" id="address"
                                    value="{{ $user->address }}" style="background-color:#e9ecef; cursor: default;">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    value="{{ $user->phone }}" style="background-color:#e9ecef; cursor: default;">
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label d-flex">Dokumen</label>
                                <img src="{{ asset('storage/' . $user->support_document) }}"
                                    class="img-fluid rounded mb-3 img-thumbnail d-flex" width="150px">
                                <input type="file" name="support_document" id="support_document"
                                    accept=".jpeg,.png,.jpg,.pdf" style="color: #404040">
                            </div>
                            <div class="form-group">
                                <label for="facebook" class="control-label">Facebook</label>
                                <input type="text" name="facebook" class="form-control" placeholder="Facebook"
                                    value="{{ $user->socialMedia->facebook ?? '' }}"
                                    style="background-color: #e9ecef; cursor: default">
                            </div>
                            <div class="form-group">
                                <label for="whatsapp" class="control-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" placeholder="WhatsApp"
                                    value="{{ $user->socialMedia->whatsapp ?? '' }}"
                                    style="background-color: #e9ecef; cursor: default">
                            </div>
                            <div class="form-group">
                                <label for="tiktok" class="control-label">Tiktok</label>
                                <input type="text" name="tiktok" class="form-control" placeholder="Tiktok"
                                    value="{{ $user->socialMedia->tiktok ?? '' }}"
                                    style="background-color: #e9ecef; cursor: default">
                            </div>
                            <div class="form-group">
                                <label for="instagram" class="control-label">Instagram</label>
                                <input type="text" name="instagram" class="form-control" placeholder="Instagram"
                                    value="{{ $user->socialMedia->instagram ?? '' }}"
                                    style="background-color: #e9ecef; cursor: default">
                            </div>
                            <button type="submit" class="btn btn-primary col-12">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($users as $user)
        <div class="modal fade" id="myModalDelete_{{ $user->id }}" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
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
    @endforeach


    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="section-header">
                                <h1>Pengguna Aktif</h1>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-primary my-2" style="width: 180px; margin:20px"
                                        data-bs-toggle="modal" data-bs-target="#myModalCreate">Tambah Pengguna</button>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>No. Telepon</th>
                                                <th>Dokumen Pendukung</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td><a href="{{ asset('storage/' . $user->support_document) }}">
                                                            <img src="{{ asset('storage/' . $user->support_document) }}"
                                                                alt="Dokumen Pendukung" class="img-fluid img-thumbnail"
                                                                width="100">
                                                        </a></td>
                                                    <td>
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <button class="btn btn-icon btn-primary edit"
                                                                data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#myModalEditStatus_{{ $user->id }}"><i
                                                                    class="bi bi-eye-fill"></i></button>

                                                            <div class="button">
                                                                <button class="btn btn-warning mx-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#myModalEdit_{{ $user->id }}"><i
                                                                        class="far fa-edit"></i></button>
                                                            </div>
                                                            <button class="btn btn-icon btn-danger delete-btn"
                                                                data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#myModalDelete_{{ $user->id }}"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Tambah Pengguna --}}
    <div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Nama"
                                value="{{ old('name') }}" required>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Kata Sandi <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Konfirmasi Kata Sandi <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Konfirmasi Kata Sandi">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label">No. Telepon <span
                                    class="text-danger">*</span></label>
                            <div style="display: flex; align-items: center;">
                                <span
                                    style="padding: 10px; border: 1px solid #e4e6fc; background-color: #fdfdff; border-radius: 7px 0 0 7px; color: grey">+62</span>
                                <input type="tel" name="phone" placeholder="No. Telepon"
                                    value="{{ old('phone') ? substr(old('phone'), 3) : '' }}" pattern="[0-9]+"
                                    title="Masukkan hanya angka" class="form-control"
                                    style="border-radius: 0 7px 7px 0;">
                            </div>
                            @if ($errors->has('phone'))
                                <div class="error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" id="address" placeholder="Alamat" required>{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="support_documents" style="color: #404040">
                                <span class="text-danger">*</span>
                                Dokumen Pendukung: KTP, Surat Domisili, Surat Keterangan Usaha<br>
                                <small>Jenis file yang dapat dikirimkan: jpeg, png, jpg, pdf</small>
                            </label>
                            <input type="file" name="support_documents" id="support_documents"
                                accept=".jpeg,.png,.jpg,.pdf" style="color: #404040">
                            @if ($errors->has('support_documents'))
                                <div class="error">{{ $errors->first('support_documents') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="facebook" class="control-label">Facebook</label>
                            <input type="text" name="facebook" class="form-control" placeholder="Facebook"
                                value="{{ old('facebook') }}">
                        </div>
                        <div class="form-group">
                            <label for="whatsapp" class="control-label">WhatsApp</label>
                            <div class="input-group">
                                <input type="tel" name="whatsapp" placeholder="WhatsApp"
                                    value="{{ old('whatsapp') ? (substr(old('whatsapp'), 0, 1) === '0' ? '62' . substr(old('whatsapp'), 1) : old('whatsapp')) : '' }}"
                                    pattern="[0-9]+" title="Masukkan hanya angka" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tiktok" class="control-label">Tiktok</label>
                            <input type="text" name="tiktok" class="form-control" placeholder="@ Akun Tiktok"
                                value="{{ old('tiktok') }}">
                        </div>
                        <div class="form-group">
                            <label for="instagram" class="control-label">Instagram</label>
                            <input type="text" name="instagram" class="form-control" placeholder="Instagram"
                                value="{{ old('instagram') }}">
                        </div>
                        <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span>
                            Save</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
    {{-- end Modal Tambah Pengguna --}}

    <script>
        window.onload = function() {
            var successPopup = document.getElementById('successPopup');
            var errorPopup = document.getElementById('errorPopup');

            if (successPopup) {
                successPopup.style.display = 'block';
                setTimeout(function() {
                    successPopup.style.display = 'none';
                }, 3000);
            }

            if (errorPopup) {
                errorPopup.style.display = 'block';
                setTimeout(function() {
                    errorPopup.style.display = 'none';
                }, 3000);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $("#myModalEdit").modal('show');
                $.post('{{ route('showActive') }}', {
                    id: $(this).attr('data-id'),
                    _token: '{{ csrf_token() }}'
                }, function(html) {
                    $(".data").html(html);
                });
            });
        });
    </script>

    <style>
        .popup {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .popup.success {
            background-color: #4caf50;
            color: white;
        }

        .popup.error {
            background-color: #f44336;
            color: white;
        }
    </style>

@endsection
