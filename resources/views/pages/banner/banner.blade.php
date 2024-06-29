@extends('layouts.dashboard')

@section('title', '|| Banner')


@section('content')

@if (session('success'))
<div id="successPopup" class="popup success">
    {{ session('success') }}
</div>
<script>
    window.onload = function() {
        var popup = document.getElementById('successPopup');
        popup.style.display = 'block';
        setTimeout(function() {
            popup.style.display = 'none';
        }, 3000);
    }
</script>
@endif

@if (session('error'))
<div id="errorPopup" class="popup error">
    {{ session('error') }}
</div>
<script>
    window.onload = function() {
        var popup = document.getElementById('errorPopup');
        popup.style.display = 'block';
        setTimeout(function() {
            popup.style.display = 'none';
        }, 3000);
    }
</script>
@endif

<!-- Modal Edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Banner</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="data">

                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end Edit Modal -->
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">


            <div class="section-body">

                <div class="row">
                    <!-- dipake -->
                    <div class="col-12">
                        <div class="card">
                            <div class="section-header">
                                <h1>Kelola Banner</h1>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button class="btn btn-primary my-2" style="width: 180px; margin:20px"
                                    data-bs-toggle="modal" data-bs-target="#myModalCreate">Tambah Banner</button>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" id="example">
                                        <thead>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Gambar</th>
                                            <th>Tipe</th>
                                            <th>Aksi</th>
                                        </thead>
                                        @php
                                        $no = 1;
                                        @endphp
                                        @foreach ($banner as $val)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $val->title }}</td>
                                            <td>@php
                                            $maxWords = 15;
                                            $description = $val->description;
                                            $words = explode(' ', $description);
                                            $shortDescription = implode(' ', array_slice($words, 0, $maxWords));
                                            $remainingWords = implode(' ', array_slice($words, $maxWords));
                                            @endphp
                                            <div class="description-container">
                                                <p class="description">{!! $shortDescription !!}</p>
                                                @if (count($words) > $maxWords)
                                                <span class="remaining-words" style="display: none;">{!! $remainingWords !!}</span>
                                                <button class="btn btn-sm btn-link see-more">See more</button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $val->image) }}">
                                                <img src="{{ asset('storage/' . $val->image) }}" alt="val_image" class="img-fluid img-thumbnail" width="200">
                                            </a>
                                        </td>
                                        <td>{{ $val->type }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <button class="btn btn-icon btn-warning edit mx-2"
                                                data-id="{{ $val->id }}"><i
                                                class="far fa-edit"></i></button>
                                                <button class="btn btn-icon btn-danger delete-btn mx-2"
                                                data-id="{{ $val->id }}" data-bs-toggle="modal"
                                                data-bs-target="#myModalDelete"><i
                                                class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('banner/store/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Deskripsi</label>
                            <textarea name="description" class="summernote-simple"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">Tipe</label>
                            <select name="type" class="form-control">
                                <option value="">-- Pilih Tipe Banner --</option>
                                <option value="slideshow">Banner Slideshow</option>
                                @php
                                $headBannerExists = $banner->contains('type', 'head');
                                @endphp
                                @if (!$headBannerExists)
                                    <option value="head">Banner Head</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label">Foto Banner</label>
                            <input type="file" name="image" class="form-control" id="imageInput">
                            <div id="imagePreview" class="mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>

    {{-- end Tambah Modal --}}
    {{-- Modal delete --}}
    <div class="modal fade" id="myModalDelete" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Hapus Kategori</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus Banner ini?</p>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
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
    {{-- end Modal delete  --}}
    {{-- Js Edit --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $("#myModalEdit").modal('show');
                $.post('{{ route('banner.edit') }}', {
                    id: $(this).attr('data-id'),
                    _token: '{{ csrf_token() }}'
                },
                function(html) {
                    $(".data").html(html);
                }
                );
            });
        });
    </script>
    {{-- Js Hapus --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `{{ url('/banner/delete') }}/${id}`;
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
