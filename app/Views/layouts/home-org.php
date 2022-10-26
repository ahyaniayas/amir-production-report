<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0">Beranda</h1>
        </div><!-- /.col -->
        <div class="col-6 text-right">
          <h1 class="m-0"><a href="<?= base_url() ?>" class="m-0">Kembali</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="container">
          <div class="row mt-3">
            <div class="col-12 text-center">
              <h2 style="line-height: 100px;font-weight: bold;">Struktur Organisasi</h2>
            </div>
          </div>
          <img class="w-100 img-rounded" src="<?= base_url('assets/docs/org.jpg') ?>" />
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Head Office</h5>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">PT Raja Roti Cemerlang</h5>
          <p class="m-0">Kp Pulo Kendal RT 02 RW 03</p>
          <p class="m-0">Desa Setia Asih, Kecamatan Taruma Jaya</p>
          <p class="m-0">Bekasi – Indonesia</p>
          <p class="m-0">021-29084611</p>
          <div class="text-right">
            <img class="w-50 img-rounded" src="<?= base_url('assets/docs/logo-s.png') ?>" />
          </div>
        </div>
      </div><!-- /.row -->
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