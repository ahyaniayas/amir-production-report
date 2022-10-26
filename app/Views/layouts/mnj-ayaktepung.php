<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0">Manajemen/Ayak Tepung</h1>
        </div><!-- /.col -->
        <div class="col-6" style="text-align: right;">
          <h1 class="m-0"><a href="<?= base_url('mnj/ayaktepung/add') ?>">Tambah</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <table class="table table-master table-striped">
            <thead>
              <tr>
                <th>Jenis Tepung</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($ayaktepungs as $isiAyaktepungs){ ?>
              <tr>
                <td><?= $isiAyaktepungs['jenis_tepung'] ?></td>
                <td>
                  <a href="<?= base_url('mnj/ayaktepung/edit/'.bin2hex($isiAyaktepungs['jenis_tepung'].';'.$isiAyaktepungs['id_ayaktepung'])) ?>" class="btn btn-sm btn-warning m-1"><i class="fa fa-pencil-alt"></i></a>
                  <a href="<?= base_url('mnj/ayaktepung/del/'.bin2hex($isiAyaktepungs['jenis_tepung'].';'.$isiAyaktepungs['id_ayaktepung'])) ?>" class="btn btn-sm btn-danger m-1"><i class="fa fa-trash"></i></a>
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