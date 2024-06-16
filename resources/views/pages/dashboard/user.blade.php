@extends('layouts.dashboard')
@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kelola Users</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-toggle="modal" data-target="#myModalCreate">Tambah User</button>
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
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Photo</th>
                                            <th>Social Media ID</th>
                                            <th>Role ID</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td><img src="{{ asset('storage/'.$user->photo ) }}" alt="photo_user" class="img-fluid img-thumbnail"></td>
                                        <td>{{ $user->social_media_id }}</td>
                                        <td>{{ $user->role_id }}</td>
                                        <td>
                                            <button class="btn btn-icon btn-warning edit" data-id="{{ $user->id }}"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-icon btn-danger delete-btn" data-id="{{ $user->id }}"><i class="fas fa-trash"></i></button>
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

<!-- Modal Tambah -->
<div class="modal fade" id="myModalCreate" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="control-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="photo" class="control-label">Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="social_media_id" class="control-label">Social Media ID</label>
                        <input type="number" name="social_media_id" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="control-label">Role ID</label>
                        <input type="number" name="role_id" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary col-12"><span class="fa fa-save"></span> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end Tambah Modal -->

<!-- Modal Edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="data"></div>
            </div>
        </div>
    </div>
</div>
<!-- end Edit Modal -->

<!-- Js Edit -->
<script type="text/javascript">
    $(function(){
        $(document).on('click','.edit',function(e){
            e.preventDefault();
            $("#myModalEdit").modal('show');
            $.post('{{ route("users.edit") }}',
            {id: $(this).attr('data-id'), _token: '{{ csrf_token() }}'},
            function(html){
                $(".data").html(html);
            });
        });
    });
</script>

<!-- Js Hapus -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                if (confirm('Anda Yakin menghapus data ini?')) {
                    fetch(`{{ url('/users/delete/') }}/${id}`, {
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
@endsection
