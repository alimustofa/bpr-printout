<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Bahan Baku</h1>
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
      <h3 class="card-title">Data Bahan Baku</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
    <button type="submit" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Tambah Bahan Baku</button>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover" id='table-data'>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Min. Stock</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Image</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (empty($bahanBaku)):
              ?>
              <tr>
                <td colspan="10" align="center">Tidak ada data</td>
              </tr>
              <?php
                endif
              ?>

              <?php
                foreach ($bahanBaku as $v):
              ?>
              <tr>
                <td><?=$v->id?></td>
                <td><?=$v->name?></td>
                <td><?=$v->supplierName?></td>
                <td>Rp. <?=$v->price?></td>
                <td><?=$v->stock?></td>
                <td><?=$v->min_stock?></td>
                <td><?=$v->unit?></td>
                <td><?=$v->stock <= $v->min_stock ? '<span class="text-red">restock</span>' : '<span class="text-green">tercukupi</span>'?></td>
                <td><img src="<?=base_url('assets/uploads/bahanbaku/' . $v->image)?>" height="100px"></td>
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
        <h5 class="modal-title" id="addModalLabel">Tambah Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/bahanbaku/action_insert')?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name='name' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Stok</label>
                <input type="number" name='stock' class="form-control" required>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Unit</label>
                <select class='form-control' name='unit' required>
                  <option>Meter</option>
                  <option>Gulung</option>
                  <option>Buah</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Minimum Stok</label>
                <input type="number" name='min_stock' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Harga</label>
                <input type="number" name='price' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Supplier</label>
                <select class='form-control' name='supplier_id' required>
                <?php
                  foreach ($supplier as $v):
                ?>
                  <option value="<?=$v->id?>"><?=$v->name?> (<?=$v->telephone?>)</option>
                <?php
                  endforeach
                ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Gambar</label>
                <div><input type="file" name="image" accept="image/*" required/></div>
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
        <h5 class="modal-title" id="editModalLabel">Edit Bahan Baku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/bahanbaku/action_edit')?>" enctype="multipart/form-data">
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
            <div class="col-sm-4">
              <div class="form-group">
                <label>Stok</label>
                <input type="number" id='editStock' name='stock' class="form-control" required>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Unit</label>
                <select class='form-control' name='unit' id='editUnit' required>
                  <option>Meter</option>
                  <option>Gulung</option>
                  <option>Buah</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Minimum Stok</label>
                <input type="number" id='editMinStock' name='min_stock' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Harga</label>
                <input type="number" name='price' id='editPrice' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Supplier</label>
                <select class='form-control' name='supplier_id' id='editSupplierId' required>
                <?php
                  foreach ($supplier as $v):
                ?>
                  <option value="<?=$v->id?>"><?=$v->name?> (<?=$v->telephone?>)</option>
                <?php
                  endforeach
                ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Gambar</label>
                <div><input type="file" name="image" accept="image/*"/></div>
              </div>
              <div class="mb-2">
                <img id="editImage" height="100px" />
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
  $('#editUnit').val(data.unit)
  $('#editStock').val(data.stock)
  $('#editMinStock').val(data.min_stock)
  $('#editPrice').val(data.price)
  $('#editSupplierId').val(data.supplier_id)
  $('#editImage').attr('src', "<?=base_url('assets/uploads/bahanbaku')?>/" + data.image)

  $('#editModal').modal('show')
}

$(function () {
  $("#table-data").DataTable();
});

function del(id) {
  var result = confirm("Yakin menghapus?");
  if (result) {
      location.href = "<?=base_url('admin/bahanbaku/delete')?>/" + id
  }
}
</script>