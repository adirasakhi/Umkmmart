@extends('layouts.dashboard')
@section('content')
<!-- Modal Edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Edit Produk</h4>
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
            <h1>Kelola Akun Sosial Media</h1>
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
                    data-bs-target="#myModalCreate">Tambah Akun</button>
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
                                        <th>Facebook</th>
                                        <th>Whatsapp</th>
                                        <th>Instagram</th>
                                        <th>Tiktok</th>
                                        <th>Aksi</th>
                                    </thead>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($sosmed as $val)
                                    <tr>
                                        <td>{{ $no++; }}</td>
                                        <td>{{ $val->facebook }}</td>
                                        <td>{{ $val->whatsapp }}</td>
                                        <td>{{ $val->instagram }}</td>
                                        <td>{{ $val->tiktok }}</td>
                                        <td>
                                            <button class="btn btn-icon btn-warning edit" data-id="{{ $val->id }}"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-icon btn-danger delete-btn" data-id="{{ $val->id }}"><i class="fas fa-trash"></i></button>
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
                <h4 class="modal-title" id="myModalLabel">Tambah Akun Sosial Media</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('sosial-media/insert/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" name="id" class="form-control" value="{{ ($val->id)+1 }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Whatsapp</label>
                            <input type="text" name="whatsapp" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="text" name="instagram" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="text" name="facebook" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tiktok</label>
                            <input type="text" name="tiktok" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end Tambah Modal --}}
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
@endsection

{{-- Js Hapus --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                if (confirm('Anda Yakin menghapus data ini?')) {
                    fetch(`{{ url('/kategori/delete/') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Data berhasil dihapus');
                            location.reload();
                        } else {
                            throw new Error('Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        location.reload();
                    });
                }
            });
        });
    });
</script>


