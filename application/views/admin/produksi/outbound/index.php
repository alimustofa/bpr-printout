<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Outbound</h1>
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
      <h3 class="card-title">Data Outbound</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
    
      <button type="submit" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal">Tambah Outbound</button>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover" id='table-data'>
            <thead>
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Bahan Baku</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if (empty($outbound)):
              ?>
              <tr>
                <td colspan="4" align="center">Tidak ada data</td>
              </tr>
              <?php
                endif
              ?>

              <?php
                foreach ($outbound as $v):
              ?>
              <tr>
                <td><?=$v->id?></td>
                <td><?=$v->date?></td>
                <td><?=$v->bahanBakuName?></td>
                <td><?=$v->amount?></td>
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
        <h5 class="modal-title" id="addModalLabel">Tambah Outbound</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method='post' action="<?=base_url('admin/outbound/action_insert')?>" enctype="multipart/form-data">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Bahan Baku</label>
                <select class='form-control' name='bahan_baku_id' required>
                <?php
                  foreach ($bahanBaku as $v):
                ?>
                  <option value="<?=$v->id?>"><?=$v->name?> (<?=$v->stock?> - <?=$v->unit?>)</option>
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

<script src="<?=base_url('assets/plugins/jquery/jquery.min.js')?>"></script>
<!-- DataTables -->
<script src="<?=base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>

<script>

$(function () {
  $("#table-data").DataTable({
    "order": [[ 0, "desc" ]]
  });
});
</script>