@extends('layouts.dashboard')

@section('title', '|| Produk')

@section('content')

@if(session('success'))
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

@if(session('error'))
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
        <div class="section-header">
            <h1>Kelola Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-bs-toggle="modal" data-bs-target="#myModalCreate">Tambah Produk</button>
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
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Seller ID</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td><img src="{{ asset('storage/'.$product->image) }}" alt="product_image" class="img-fluid img-thumbnail" width="50"></td>
                                            <td>{{ $product->category->category }}</td>
                                            <td>{{ $product->seller->name }}</td>
                                            <td>
                                                <div class="d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-icon btn-warning edit mx-2" data-id="{{ $product->id }}"><i class="far fa-edit"></i></button>
                                                    <button class="btn btn-icon btn-danger delete-btn mx-2" data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#myModalDelete"><i class="fas fa-trash"></i></button>
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

{{-- Modal Tambah --}}
<div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label" value="{{ old('name') }}">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label value="{{ old('price') }}">Harga Produk</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                            </div>
                            <input type="text" class="form-control currency" name="price" id="price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label"
                            value="{{ old('description') }}">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="seller_id" class="control-label"
                            value="{{ old('seller_id') }}">Seller</label>
                        <textarea name="seller_id" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="control-label"
                            value="{{ old('category_id') }}">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
                </form>

            </div>
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
    $(function(){
        $(document).on('click','.edit',function(e){
            e.preventDefault();
            $("#myModalEdit").modal('show');
            $.post('{{ route("products.edit") }}',
                {id: $(this).attr('data-id'), _token: '{{ csrf_token() }}'},
                function(html){
                $(".data").html(html);
            }
            );
        });
    });
</script>

{{-- Js Hapus --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `{{ url('/products/delete') }}/${id}`;
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
