<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Inbound Pengajuan Bahan Baku</h1>
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
      <h3 class="card-title">Data Inbound</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
    <?php if (in_array($this->session->userdata['login']['type'], ['produksi'])): ?>
      <button type="submit" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Tambah Pengajuan</button>
    <?php endif ?>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover" id='table-data'>
            <thead>
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Bahan Baku</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>No. Faktur</th>
                <th>Image Faktur</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (empty($inbound)):
              ?>
              <tr>
                <td colspan="9" align="center">Tidak ada data</td>
              </tr>
              <?php
                endif
              ?>

              <?php
                foreach ($inbound as $v):
              ?>
              <tr>
                <td><?=$v->id?></td>
                <td><?=$v->date?></td>
                <td><?=$v->supplierName?></td>
                <td><?=$v->bahanBakuName?></td>
                <td><?=$v->amount?></td>
                <td>Rp. <?=$v->total_price?></td>
                <td><?=$v->no_faktur?></td>
                <td>
                  <?php if (!empty($v->image_faktur)):?>
                    <img src="<?=base_url('assets/uploads/faktur/' . $v->image_faktur)?>" height="100px"></td>
                  <?php endif ?>
                <td>
                  <?php if ($v->status == 'Pending'):?>
                    <span class="text-default"><?=$v->status?></span>
                  <?php endif ?>

                  <?php if ($v->status == 'Accepted'):?>
                    <span class="text-primary"><?=$v->status?></span>
                  <?php endif ?>

                  <?php if ($v->status == 'Rejected'):?>
                    <span class="text-danger"><?=$v->status?></span>
                  <?php endif ?>

                  <?php if ($v->status == 'Purchased'):?>
                    <span class="text-info"><?=$v->status?></span>
                  <?php endif ?>

                  <?php if ($v->status == 'Done'):?>
                    <span class="text-success"><?=$v->status?></span>
                  <?php endif ?>
                </td>
                <td>
                  <?php if (in_array($this->session->userdata['login']['type'], ['kepala']) && $v->status == 'Pending'): ?>
                    <button onClick='accept(<?=$v->id?>)' class='btn btn-info btn-sm'>Setujui</button>
                    <button onClick='reject(<?=$v->id?>)' class='btn btn-warning btn-sm'>Tidak Setujui</button>
                  <?php endif ?>

                  <?php if (in_array($this->session->userdata['login']['type'], ['kepala']) && $v->status == 'Purchased'): ?>
                    <button onClick='done(<?=$v->id?>)' class='btn btn-info btn-sm'>Selesai</button>
                  <?php endif ?>
                  
                  <?php if (in_array($this->session->userdata['login']['type'], ['logistik']) && $v->status == 'Accepted'): ?>
                    <button onClick='edit(<?=json_encode($v)?>)' class='btn btn-primary btn-sm'>Isi faktur</button>
                  <?php endif ?>
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
        <h5 class="modal-title" id="addModalLabel">Tambah Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/inbound/action_insert')?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Bahan Baku</label>
                <select class='form-control' name='bahan_baku_id' required>
                <?php
                  foreach ($bahanBaku as $v):
                ?>
                  <option value="<?=$v->id?>"><?=$v->name?> (Rp. <?=$v->price?>)</option>
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
                <label>Jumlah</label>
                <input type="number" name='amount' class="form-control" required>
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
        <form role="form" method='post' action="<?=base_url('admin/inbound/action_edit')?>" enctype="multipart/form-data">
          <input type="hidden" id="editId" name="id">
          <input type="hidden" id="editStatus" name="status">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>No. Faktur</label>
                <input type="text" name='no_faktur' class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Gambar</label>
                <div><input type="file" name="image" accept="image/*"/></div>
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
  $('#editStatus').val('Purchased')

  $('#editModal').modal('show')
}

$(function () {
  $("#table-data").DataTable({
    "order": [[ 0, "desc" ]]
  });
});

function accept(id) {
  var result = confirm("Yakin setujui?");
  if (result) {
      location.href = "<?=base_url('admin/inbound/accept')?>/" + id
  }
}

function reject(id) {
  var result = confirm("Yakin tidak setujui?");
  if (result) {
      location.href = "<?=base_url('admin/inbound/reject')?>/" + id
  }
}

function done(id) {
  var result = confirm("Yakin selesaikan pengajuan ini?");
  if (result) {
      location.href = "<?=base_url('admin/inbound/done')?>/" + id
  }
}
</script>