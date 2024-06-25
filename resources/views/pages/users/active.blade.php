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

    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detail Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="data"></div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalDelete" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Blokir Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin Memblokir Pengguna ini?</p>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
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

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengguna Aktif</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-bs-toggle="modal"
                            data-bs-target="#myModalCreate">Tambah Pengguna</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" id="example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Telepon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <button class="btn btn-icon btn-primary edit"
                                                                data-id="{{ $user->id }}"><i
                                                                    class="bi bi-eye-fill"></i></button>
                                                            <button class="btn btn-icon btn-danger delete-btn mx-2"
                                                                data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#myModalDelete"><i
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
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}">
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
                            <input type="tel" name="phone" class="form-control" placeholder="No. Telepon"
                                value="{{ old('phone') }}" pattern="[0-9]+" title="Masukkan hanya angka">
                            @if ($errors->has('phone'))
                                <div class="error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" id="address" placeholder="Alamat">{{ old('address') }}</textarea>
                            @if ($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="file" name="support_documents" id="support_documents"
                                accept=".jpeg,.png,.jpg,.pdf" style="color: #404040">
                            <label for="support_documents" style="color: #404040">
                                <span class="text-danger">*</span>
                                Dokumen Pendukung: KTP, Surat Domisili, Surat Keterangan Usaha<br>
                                <small>Jenis file yang dapat dikirimkan: jpeg, png, jpg, pdf</small>
                            </label>
                            @if ($errors->has('support_documents'))
                                <div class="error">{{ $errors->first('support_documents') }}</div>
                            @endif
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
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `{{ url('/users/action-reject') }}/${id}`;
                });
            });

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
