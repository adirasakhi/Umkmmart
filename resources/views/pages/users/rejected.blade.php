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

    @foreach ($rejectedUsers as $user)
    <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Detail Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="data">
                        @include('pages.users.showReject')
                    </div>
                </div>
                <div class="modal-footer"></div>
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
                            <div class="card-body p-3">
                                <div class="section-header">
                                    <h1>Pengguna
                                        Diblokir</h1>
                                </div>
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
                                            @foreach ($rejectedUsers as $user)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td><a href="{{ asset('storage/'. $user->support_document) }}">
                                                        <img src="{{ asset('storage/'. $user->support_document) }}" alt="Dokumen Pendukung" class="img-fluid img-thumbnail" width="100">
                                                    </a></td>
                                                    <td>
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <button class="btn btn-icon btn-primary edit"
                                                                data-id="{{ $user->id }}" data-toggle="modal"
                                                                data-target="#myModalEdit_{{ $user->id }}"><i
                                                                    class="bi bi-eye-fill"></i></button>
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
            // const deleteButtons = document.querySelectorAll('.delete-btn');

            // deleteButtons.forEach(button => {
            //     button.addEventListener('click', function() {
            //         const id = this.getAttribute('data-id');
            //         const deleteForm = document.getElementById('deleteForm');
            //         deleteForm.action = `{{ url('/users/restore') }}/${id}`;
            //     });
            // });

            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $("#myModalEdit").modal('show');
                $.post('{{ route('showRejected') }}', {
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
            color: white;
        }

        .popup.success {
            background-color: #4CAF50;
        }

        .popup.error {
            background-color: #f44336;
        }
    </style>

@endsection
