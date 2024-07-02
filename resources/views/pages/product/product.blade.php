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

    @foreach ($products as $product)
    <!-- Modal Edit -->
    <div class="modal fade" id="myModalEdit_{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="data">
                        @include('pages.product.product-edit')
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <!-- End Edit Modal -->
    @endforeach

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
                                        <button class="btn btn-primary my-2" style="width: 180px; margin:20px"
                                            data-bs-toggle="modal" data-bs-target="#myModalCreate">Tambah Produk</button>
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
                                                <th>Deskripsi</th>
                                                <th>Kategori</th>
                                                <th>Varian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        @php
                                                            $maxWords = 15;
                                                            $description = $product->description;
                                                            $words = explode(' ', $description);
                                                            $shortDescription = implode(
                                                                ' ',
                                                                array_slice($words, 0, $maxWords),
                                                            );
                                                            $remainingWords = implode(
                                                                ' ',
                                                                array_slice($words, $maxWords),
                                                            );
                                                        @endphp
                                                        <div class="description-container">
                                                            <p class="description">{!! $shortDescription !!}</p>
                                                            @if (count($words) > $maxWords)
                                                                <span class="remaining-words"
                                                                    style="display: none;">{!! $remainingWords !!}</span>
                                                                <button class="btn btn-sm btn-link see-more">See
                                                                    more</button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{ $product->category->category }}</td>
                                                    <td>
                                                        <button class="btn btn-primary my-2" data-bs-toggle="modal"
                                                            data-bs-target="#varModal{{ $product->id }}">Daftar
                                                            Varian</button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            @if (Auth::user()->role_id == 2)
                                                                <button class="btn btn-icon btn-warning edit mx-2"
                                                                    data-id="{{ $product->id }}"><i
                                                                        class="far fa-edit" data-bs-toggle="modal"
                                                                        data-bs-target="#myModalEdit_{{ $product->id }}"></i></button>
                                                            @endif
                                                            <button class="btn btn-icon btn-danger delete-btn mx-2"
                                                                data-id="{{ $product->id }}" data-bs-toggle="modal"
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Tambah Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                        onsubmit="return validateForm();">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Nama Produk <span style="color: red">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Deskripsi <span style="color: red">*</span></label>
                            <textarea name="description" class="summernote-simple"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="control-label">Kategori <span style="color: red">*</span></label>
                            <select name="category_id" class="form-control">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->role_id == 1)
                            <div class="form-group">
                                <label for="seller_id" class="control-label">Penjual</label>
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
    </div>
    <!-- End Modal Tambah -->

    <!-- Modal Delete -->
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
    <!-- End Modal Delete -->

    {{-- Modal Variant --}}
    @foreach ($products as $product)
        <div class="modal fade" id="varModal{{ $product->id }}" tabindex="-1"
            aria-labelledby="varModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="varModalLabel{{ $product->id }}">Varian Produk:
                            {{ $product->name }}
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                        <!-- Tampilkan daftar varian -->
                        <table class="table table-striped border border-color-black">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Varian</th>
                                    <th>Harga</th>
                                    <th>Diskon(%)</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $varNo = 1; @endphp
                                @foreach ($product->variants as $variant)
                                    <tr>
                                        <td>{{ $varNo++ }}</td>
                                        <td>{{ $variant->name }}</td>
                                        <td>{{ $variant->price }}</td>
                                        <td>{{ $variant->discount }}</td>
                                        <td><a href="{{ Storage::url($variant->image) }}"><img src="{{ Storage::url($variant->image) }}" alt="Image" width="50"
                                                style="object-fit: cover;"></a>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                @if (Auth::user()->role_id == 2)
                                                    <button class="btn btn-icon btn-warning edit-variant-btn mx-2"
                                                        data-id="{{ $variant->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editVariantModal{{ $variant->id }}"><i
                                                            class="far fa-edit"></i></button>
                                                @endif
                                                <button class="btn btn-icon btn-danger delete-variant-btn mx-2"
                                                    data-id="{{ $variant->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteVariantModal"><i
                                                        class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Form untuk menambah varian -->

                        @if (Auth::user()->role_id == 2)
                        <h6 class="mt-3">
                            <center>Tambah Varian</center>
                        </h6>

                        <form action="{{ route('products.variants.store', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="variantContainer{{ $product->id }}">
                                <div class="variant">
                                    <div class="form-group">
                                        <label>Nama Varian <span style="color: red">*</span></label>
                                        <input type="text" name="variant_name[]" class="form-control"
                                            placeholder="Misal : Warna/Ukuran/Rasa" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga Varian <span style="color: red">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="border-radius: 4px">
                                                    Rp
                                                </div>
                                            </div>
                                            <input type="text" name="variant_price[]" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Diskon Varian (%)</label>
                                        <input type="text" name="variant_discount[]" class="form-control"
                                            placeholder="Misal : 10 (boleh dikosongkan bila tidak ada diskon)">
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar Varian <span style="color: red">*</span></label>
                                        <input type="file" name="variant_image[]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal Variant --}}

    {{-- Modal Edit Variant --}}
    @foreach ($products as $product)
        @foreach ($product->variants as $variant)
            <div class="modal fade" id="editVariantModal{{ $variant->id }}" tabindex="-1"
                aria-labelledby="editVariantModalLabel{{ $variant->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editVariantModalLabel{{ $variant->id }}">Edit Varian Produk:
                                {{ $product->name }}
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('products.variants.update', $variant->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Nama Varian</label>
                                    <input type="text" name="variant_name" class="form-control"
                                        value="{{ $variant->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Harga Varian</label>
                                    <input type="text" name="variant_price" class="form-control"
                                        value="{{ $variant->price }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Diskon Varian (%)</label>
                                    <input type="text" name="variant_discount" class="form-control"
                                        placeholder="(boleh dikosongkan bila tidak ada diskon)"
                                        value="{{ $variant->discount }}">
                                </div>
                                <div class="form-group">
                                    <label>Gambar Varian</label>
                                    <input type="file" name="variant_image" class="form-control">
                                    <img src="{{ Storage::url($variant->image) }}" alt="Image" width="50">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
    {{-- End Modal Edit Variant --}}

    {{-- Modal Delete Variant --}}
    <div class="modal fade" id="deleteVariantModal" role="dialog" aria-labelledby="deleteVariantModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteVariantModalLabel">Hapus Varian</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus varian ini?</p>
                    <form id="deleteVariantForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="row justify-content-end">
                            <button type="button" class="btn btn-danger col-2 mx-2" data-bs-dismiss="modal">
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
    {{-- End Modal Delete Variant --}}


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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                $("#myModalEdit").modal('show');
                $.post('{{ route('products.edit') }}', {
                    id: $(this).attr('data-id'),
                    _token: '{{ csrf_token() }}'
                }, function(html) {
                    $(".data").html(html);
                });
            });

            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.action = `{{ url('/products/delete') }}/${id}`;
                });
            });

            // Tambahkan event listener untuk setiap tombol "Lihat Varian"
            const variantButtons = document.querySelectorAll('[data-bs-target^="#varModal"]');
            variantButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = button.dataset.productId;
                    const modalId = `#varModal${productId}`;
                    const myModal = new bootstrap.Modal(document.querySelector(modalId));
                    myModal.show();
                });
            });

            const seeMoreButtons = document.querySelectorAll('.see-more');
            seeMoreButtons.forEach(seeMoreBtn => {
                seeMoreBtn.addEventListener('click', function() {
                    const descriptionContainer = this.parentElement;
                    const moreContent = descriptionContainer.querySelector('.remaining-words');

                    moreContent.style.display = (moreContent.style.display === 'none' || moreContent
                        .style.display === '') ? 'inline' : 'none';
                    this.textContent = moreContent.style.display === 'none' ? 'See more' :
                        'See less';
                });
            });

            const deleteVariantButtons = document.querySelectorAll('.delete-variant-btn');
            deleteVariantButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const deleteForm = document.getElementById('deleteVariantForm');
                    deleteForm.action = `{{ url('/products/variants') }}/${id}`;
                });
            });


            // Function to format number input
            function formatNumber(input) {
                var value = input.value.replace(/\./g, '');
                value = value.replace(/[^0-9]/g, '');
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                input.value = formattedValue;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Cek jika ada pesan sukses dan produk baru dibuat
            @if (session('product_id'))
                // Buka modal tambah varian
                var productId = {{ session('product_id') }};
                $('#varModal' + productId).modal({
                    backdrop: 'static',
                    keyboard: false
                }).modal('show');
            @endif

            // Cegah penutupan modal jika belum ada varian
            $('[id^=varModal]').on('hide.bs.modal', function(e) {
                var variantsExist = $(this).find('tbody tr').length > 0; // Cek jika ada varian
                if (!variantsExist) {
                    e.preventDefault();
                    alert('Anda harus menambah minimal satu varian untuk dapat menampilkan produk.');
                }
            });

            // Event listener ketika modal tambah produk ditutup
            $('#myModalCreate').on('hidden.bs.modal', function() {
                var productId = {{ session('product_id') ?? 'null' }};
                if (productId) {
                    $('#varModal' + productId).modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }
            });

            // Cegah penutupan modal ketika diklik di luar area modal
            $('[id^=varModal]').on('click', function(e) {
                if ($(e.target).hasClass('modal')) {
                    var variantsExist = $(this).find('tbody tr').length > 0;
                    if (!variantsExist) {
                        e.preventDefault();
                        alert('Anda harus menambah minimal satu varian untuk dapat menampilkan produk.');
                    }
                }
            });
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
        @endif

        @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
        @endif

        @if ($errors->any())
        let errorMessages = '';
        @foreach ($errors->all() as $error)
            errorMessages += '{{ $error }}\n';
        @endforeach
        Swal.fire({
            icon: 'error',
            title: 'Proses Gagal',
            html: errorMessages,
            showConfirmButton: true
        });
        @endif
    });
</script>

@endsection
