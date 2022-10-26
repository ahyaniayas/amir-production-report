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
              <label>Nama</label>
              <input type="text" class="form-control" name="nama" value="<?= !empty($user[0]['nama'])? $user[0]['nama']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <label>Alamat</label>
              <textarea class="form-control" name="alamat" required><?= !empty($user[0]['alamat'])? $user[0]['alamat']: '' ?></textarea>
            </div>
            <div class="form-group mb-3">
              <label>No. HP</label>
              <input type="text" class="form-control" name="no_hp" value="<?= !empty($user[0]['no_hp'])? $user[0]['no_hp']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <label>Divisi</label>
              <select class="form-control" name="divisi" required>
                <option value="">Pilih Divisi</option>
                <?php foreach($divisis as $isiDivisis){ ?>
                <option value="<?= $isiDivisis['id_divisi'] ?>" <?= !empty($user[0]['divisi'])? ($user[0]['divisi']==$isiDivisis['id_divisi']? "selected": ""): '' ?>><?= $isiDivisis['nama_divisi'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group mb-3">
              <label>Username</label>
              <input type="text" class="form-control" name="username" value="<?= !empty($user[0]['username'])? $user[0]['username']: '' ?>" required <?= !empty($user[0]['username'])? 'readonly': '' ?>/>
            </div>
            <div class="form-group mb-3">
              <label>Password</label>
              <input type="text" class="form-control" name="password" value="<?= !empty($user[0]['password'])? $user[0]['password']: '' ?>" required/>
            </div>
            <div class="form-group mb-3">
              <input type="hidden" name="id_user" value="<?= !empty($user[0]['id_user'])? $user[0]['id_user']: '' ?>"/>
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