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
              <label>Jenis Tepung</label>
              <input type="text" class="form-control" name="jenis_tepung" value="<?= !empty($ayaktepung[0]['jenis_tepung'])? $ayaktepung[0]['jenis_tepung']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <input type="hidden" name="id_ayaktepung" value="<?= !empty($ayaktepung[0]['id_ayaktepung'])? $ayaktepung[0]['id_ayaktepung']: '' ?>"/>
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