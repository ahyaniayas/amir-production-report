<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0">Manajemen/User</h1>
        </div><!-- /.col -->
        <div class="col-6" style="text-align: right;">
          <h1 class="m-0"><a href="<?= base_url('mnj/user/add') ?>">Tambah</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <table class="table table-master table-striped">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Divisi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($users as $isiUsers){ ?>
              <tr>
                <td><?= $isiUsers['nama'] ?></td>
                <td><?= $isiUsers['username'] ?></td>
                <td><?= $isiUsers['nama_divisi'] ?></td>
                <td>
                  <a href="<?= base_url('mnj/user/edit/'.bin2hex($isiUsers['username'].';'.$isiUsers['id_user'])) ?>" class="btn btn-sm btn-warning m-1"><i class="fa fa-pencil-alt"></i></a>
                  <a href="<?= base_url('mnj/user/del/'.bin2hex($isiUsers['username'].';'.$isiUsers['id_user'])) ?>" class="btn btn-sm btn-danger m-1"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
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