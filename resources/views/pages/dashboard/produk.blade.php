@extends("layouts.dashboard")
@section("content")
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
          <button class="btn btn-primary my-2" style="width: 180px; margin:20px" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Produk</button>
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
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </thead>
                  <tr>
                    <td>1</td>
                    <td>rrq lemon</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <button class="btn btn-icon btn-warning edit" data-id=""><i class="far fa-edit"></i></button>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Irwansyah Saputra</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>rrq lemon</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Irwansyah Saputra</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>rrq lemon</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Irwansyah Saputra</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>rrq lemon</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Irwansyah Saputra</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>rrq lemon</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Irwansyah Saputra</td>
                    <td>2017-01-09</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href="#" class="btn btn-icon btn-warning"><i class="far fa-edit"></i></a>
                      <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Tambah Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data">
          @csrf
          <label for="id" class="control-label">ID </label>
          <input type="text" placeholder="id" name="id" value="" class="form-control input-sm" readonly>

          <label for="tittle" class="control-label">Judul Buku</label>
          <input type="text" placeholder="Judul Buku" name="tittle" class="form-control input-sm">

          <label for="author" class="control-label">Penulis</label>
          <input type="text" placeholder="Penulis" name="author" class="form-control input-sm">

          <label for="publisher" class="control-label">Penerbit</label>
          <input type="text" placeholder="Kata Kunci" name="publisher" class="form-control input-sm">
          <br>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary my-2"><span class="fa fa-save"></span> Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Edit Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<!-- end -->


<script type="text/javascript">
  $(function(){
    $(document).on('click','.edit',function(e){
      e.preventDefault();
      $("#myModalEdit").modal('show');
      $.post('',
       {id: $(this).attr('data-id'), _token: '{{ csrf_token() }}'},
       function(html){
        $(".data").html(html);
      }
      );
    });
  });
</script>
@endsection
