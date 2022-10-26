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
              <label>Nama Shift</label>
              <input type="text" class="form-control" name="nama_shift" value="<?= !empty($db_shift[0]['nama_shift'])? $db_shift[0]['nama_shift']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <label>Jam Masuk</label>
              <input type="text" class="form-control" name="jam_masuk" value="<?= !empty($db_shift[0]['jam_masuk'])? date('H:i', strtotime($db_shift[0]['jam_masuk'])): '' ?>" placeholder="HH:MM" required/>
            </div>
            <div class="form-group mb-3">
              <label>Jam Keluar</label>
              <input type="text" class="form-control" name="jam_keluar" value="<?= !empty($db_shift[0]['jam_keluar'])? date('H:i', strtotime($db_shift[0]['jam_keluar'])): '' ?>" placeholder="HH:MM" required/>
            </div>
            <div class="form-group mb-3">
              <input type="hidden" name="id_shift" value="<?= !empty($db_shift[0]['id_shift'])? $db_shift[0]['id_shift']: '' ?>"/>
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