<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Supplier</h1>
        </div><!-- /.col -->
        
        <?php
          if (!empty($this->session->flashdata('response'))):
          ?>
          <div class="alert alert-success alert-dismissible fade show" style="position: absolute; right: 0; top: 15; z-index: 9999;" role="alert">
            <strong>Hore! </strong><?=$this->session->flashdata('response')['msg']?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <?php
          endif;
          ?>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title">Data Supplier</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
    <button type="submit" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Tambah Supplier</button>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover" id='table-data'>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Address</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (empty($supplier)):
              ?>
              <tr>
                <td colspan="7" align="center">Tidak ada data</td>
              </tr>
              <?php
                endif
              ?>

              <?php
                foreach ($supplier as $v):
              ?>
              <tr>
                <td><?=$v->id?></td>
                <td><?=$v->name?></td>
                <td><?=$v->telephone?></td>
                <td><?=$v->address?></td>
                <td>
                  <button onClick='edit(<?=json_encode($v)?>)' class='btn btn-primary btn-sm'>Edit</button>
                  <button onClick='del(<?=$v->id?>)' class='btn btn-danger btn-sm'>Hapus</button>
                </td>
              </tr>
              <?php
                endforeach
              ?>
            </tbody>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/supplier/action_insert')?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name='name' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Telephone</label>
                <input type="text" name='telephone' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" name='address' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="float-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/supplier/action_edit')?>" enctype="multipart/form-data">
          <input type="hidden" id="editId" name="id">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" id='editName' name='name' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Telephone</label>
                <input type="text" id='editTelephone' name='telephone' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Alamat</label>
                <input type="text" id='editAddress' name='address' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="float-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url('assets/plugins/jquery/jquery.min.js')?>"></script>
<!-- DataTables -->
<script src="<?=base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>

<script>
function edit(data) {
  $('#editId').val(data.id)
  $('#editName').val(data.name)
  $('#editTelephone').val(data.telephone)
  $('#editAddress').val(data.address)

  $('#editModal').modal('show')
}

$(function () {
  $("#table-data").DataTable();
});

function del(id) {
  var result = confirm("Yakin menghapus?");
  if (result) {
      location.href = "<?=base_url('admin/supplier/delete')?>/" + id
  }
}
</script>