@extends('layouts.dashboard')

@section('title', '|| Produk')

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
                    <h4 class="modal-title" id="myModalLabel">Edit Produk</h4>
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
    <!-- end Edit Modal -->

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="section-header">
                            <h1>Kelola Produk</h1>
                        </div>
                        <div class="row">
                            @if (Auth::user()->role_id == 2)
                            <div class="col d-flex justify-content-end">
                                <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-bs-toggle="modal"
                                    data-bs-target="#myModalCreate">Tambah Produk</button>
                            </div>
                            @endif
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Deskripsi</th>
                                            <th>Foto Produk</th>
                                            <th>Kategori</th>
                                            <th>Penjual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>
                                                @php
                                                $maxWords = 15; // Jumlah kata maksimum untuk deskripsi yang dipotong
                                                $description = $product->description;
                                                $words = explode(' ', $description);
                                                $shortDescription = implode(' ', array_slice($words, 0, $maxWords));
                                                $remainingWords = implode(' ', array_slice($words, $maxWords));
                                                @endphp
                                                <div class="description-container">
                                                    <p class="description">{{ $shortDescription }}</p>
                                                    @if (count($words) > $maxWords)
                                                    <span class="remaining-words"
                                                        style="display: none;">{{ $remainingWords }}</span>
                                                    <button class="btn btn-sm btn-link see-more">See more</button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                               <a href="{{ asset('storage/' . $product->image) }}"><img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="product_image" class="img-fluid img-thumbnail" width="200"></td>
                                               </a>
                                            <td>{{ $product->category->category }}</td>
                                            <td>{{ $product->seller->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-icon btn-warning edit mx-2"
                                                        data-id="{{ $product->id }}"><i
                                                            class="far fa-edit"></i></button>
                                                    <button class="btn btn-icon btn-danger delete-btn mx-2"
                                                        data-id="{{ $product->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#myModalDelete"><i class="fas fa-trash"></i></button>
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
        </section>
    </div>

{{-- Modal Tambah --}}
<div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label" value="{{ old('name') }}">Nama Produk</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label value="{{ old('price') }}">Harga Produk</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                                <input type="text" class="form-control currency" name="price" id="price"
                                    onkeyup="formatNumber(this)">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label"
                            value="{{ old('description') }}">Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Foto Produk</label>
                        <input type="file" name="image" class="form-control" id="imageInput">
                        <div id="imagePreview" class="mt-2"></div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="control-label"
                            value="{{ old('category_id') }}">Kategori</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (Auth::user()->role_id == 1)
                    <div class="form-group">
                        <label for="seller_id" class="control-label"
                            value="{{ old('seller_id') }}">Penjual</label>
                        <select name="seller_id" class="form-control">
                            <option value="">-- Pilih Penjual --</option>
                            @foreach ($user as $users)
                            <option value="{{ $users->id }}">{{ $users->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span>
                        Save</button>
                </form>
            </div>
        </div>
    </div>
    {{-- end Tambah Modal --}}

    {{-- Modal delete --}}
    <div class="modal fade" id="myModalDelete" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Hapus Produk</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus Produk ini?</p>
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
                $.post('{{ route('products.edit') }}', {
                        id: $(this).attr('data-id'),
                        _token: '{{ csrf_token() }}'
                    },
                    function(html) {
                        $(".data").html(html);
                    }
                );
            });
        });
    });
</script>
<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Clear existing previews
        const files = event.target.files;

        if (files.length > 0) {
            const file = files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.maxWidth = '100%';
                imgElement.style.height = 'auto';
                imgElement.classList.add('img-thumbnail');

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '&times;';
                removeButton.style.position = 'absolute';
                removeButton.style.top = '10px';
                removeButton.style.right = '10px';
                removeButton.classList.add('btn', 'btn-danger', 'btn-sm');

                const previewContainer = document.createElement('div');
                previewContainer.style.position = 'relative';
                previewContainer.style.display = 'inline-block';
                previewContainer.appendChild(imgElement);
                previewContainer.appendChild(removeButton);

                removeButton.addEventListener('click', function() {
                    imagePreview.innerHTML = '';
                    document.getElementById('imageInput').value = '';
                });

                imagePreview.appendChild(previewContainer);
            }

            reader.readAsDataURL(file);
        }
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
                    deleteForm.action = `{{ url('/products/delete') }}/${id}`;
                });
            });
        });
    </script>

    {{-- Js See More --}}
    <script>
        const seeMoreButtons = document.querySelectorAll('.see-more');
        seeMoreButtons.forEach(seeMoreBtn => {
            seeMoreBtn.addEventListener('click', function() {
                const descriptionContainer = this.parentElement;
                const description = descriptionContainer.querySelector('.description');
                const moreContent = descriptionContainer.querySelector('.remaining-words');

                moreContent.style.display === 'none' || moreContent.style.display === '' ?
                    moreContent.style.display = 'inline' :
                    moreContent.style.display = 'none';

                this.textContent = moreContent.style.display === 'none' ? 'See more' : 'See less';
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

    <script>
        function formatNumber(input) {
            // Remove non-numeric characters
            var value = input.value.replace(/[^0-9]/g, '');

            // Format the value with dots for thousands separator
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Update the input value with the formatted value
            input.value = formattedValue;
        }

        function removeFormat(input) {
            // Remove non-numeric characters
            var value = input.value.replace(/[^0-9]/g, '');

            // Update the input value with the cleaned numeric value
            input.value = value;
        }

        function removeFormatBeforeSubmit() {
            var priceInput = document.getElementById('price');

            // Call removeFormat function to clean thousand separators
            removeFormat(priceInput);
        }
    </script>

@endsection
