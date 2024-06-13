@extends("partials.layouts.dashboard")
@section("content")
     <!-- Main Content -->
     <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Tambah Produk</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Forms</a></div>
              <div class="breadcrumb-item">Advanced Forms</div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Deskripsi Produk</label>
                    <textarea class="form-control">

                    </textarea>
                  </div>
                  <div class="form-group">
                    <label>Kategori Produk</label>
                    <select class="form-control">
                      <option>Option 1</option>
                      <option>Option 2</option>
                      <option>Option 3</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Harga Produk</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          Rp
                        </div>
                      </div>
                      <input type="text" class="form-control currency">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Gambar Produk</label>
                    <input type="file" class="form-control">
                  </div>
                  <a href="components-table.html" class="btn btn-primary col-12">Submit</a>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection
