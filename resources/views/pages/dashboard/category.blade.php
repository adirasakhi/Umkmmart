@extends('layouts.dashboard')
@section('content')
<!-- Modal Edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Edit Kategori</h4>
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
        <div class="section-header">
            <h1>Kelola Kategori</h1>
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
                    data-bs-target="#myModalCreate">Tambah Kategori</button>
                </div>
            </div>
            <div class="row">
                <!-- dipake -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="example">
                                    <thead>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </thead>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($category as $val)
                                    <tr>
                                        <td>{{ $no++; }}</td>
                                        <td>{{ $val->category }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                <button class="btn btn-icon btn-warning edit mx-2"
                                                    data-id="{{ $val->id }}"><i
                                                        class="far fa-edit"></i></button>
                                                <button class="btn btn-icon btn-danger delete-btn mx-2"
                                                    data-id="{{ $val->id }}" data-bs-toggle="modal" data-bs-target="#myModalDelete"><i
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
                    <form action="{{ url('kategori/insert/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>No</label>
                            <input type="text" name="id" class="form-control" value="{{ ($val->id)+1 }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" name="category" class="form-control">
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
                <p>Apakah Anda yakin ingin menghapus Kategori ini?</p>
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
            $.post('{{ route("kategori.edit") }}',
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
                deleteForm.action = `{{ url('/kategori/delete') }}/${id}`;
            });
        });
    });
</script>
@endsection
