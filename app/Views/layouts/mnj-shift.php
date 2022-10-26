<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0">Manajemen/Shift</h1>
        </div><!-- /.col -->
        <div class="col-6" style="text-align: right;">
          <h1 class="m-0"><a href="<?= base_url('mnj/shift/add') ?>">Tambah</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <table class="table table-master table-striped">
            <thead>
              <tr>
                <th>Nama Shift</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($shifts as $isiShifts){ ?>
              <tr>
                <td><?= $isiShifts['nama_shift'] ?></td>
                <td><?= date("H:i", strtotime($isiShifts['jam_masuk'])) ?></td>
                <td><?= date("H:i", strtotime($isiShifts['jam_keluar'])) ?></td>
                <td>
                  <a href="<?= base_url('mnj/shift/edit/'.bin2hex($isiShifts['nama_shift'].';'.$isiShifts['id_shift'])) ?>" class="btn btn-sm btn-warning m-1"><i class="fa fa-pencil-alt"></i></a>
                  <a href="<?= base_url('mnj/shift/del/'.bin2hex($isiShifts['nama_shift'].';'.$isiShifts['id_shift'])) ?>" class="btn btn-sm btn-danger m-1"><i class="fa fa-trash"></i></a>
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