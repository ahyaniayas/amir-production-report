<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0"><?= $title ?></h1>
        </div><!-- /.col -->
        <div class="col-6" style="text-align: right;">
          <h1 class="m-0"><a href="<?= base_url($segment1.'/'.$segment2) ?>">Kembali</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <form action="<?= $postUrl ?>" method="post">
            <div class="form-group mb-3">
              <label>Jenis Roti</label>
              <input type="text" class="form-control" name="jenis_roti" value="<?= !empty($mixing[0]['jenis_roti'])? $mixing[0]['jenis_roti']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <input type="hidden" name="id_mixing" value="<?= !empty($mixing[0]['id_mixing'])? $mixing[0]['id_mixing']: '' ?>"/>
              <button type="submit" class="btn <?= $btnStyle ?> form-control"><?= $btnLabel ?></button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection() ?>