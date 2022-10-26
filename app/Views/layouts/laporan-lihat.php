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
        <div class="col-6 text-right">
          <h1 class="m-0"><a href="<?= base_url('laporan') ?>" class="m-0">Kembali</a></h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <?php if($laporan_id_divisi=='2'){ ?>
          <div class="card mb-3">
            <div class="card-header bg-info">
              <?= $laporan_divisi ?>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label class="mb-0">Tanggal</label>
                <p class="my-0"><?= $laporan['tanggal'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Shift</label>
                <p class="my-0"><?= $laporan['nama_shift'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Terigu</label>
                <p class="my-0"><?= $laporan['produk'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">QTY</label>
                <p class="my-0"><?= $laporan['qty'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">QTY Stok</label>
                <?php $qty_stok = explode(';', $laporan['qty_stok']) ?>
                <p class="my-0"><?= $qty_stok[0] ?></p>
                <p class="my-0"><?= $qty_stok[1] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">QTY Limbah</label>
                <p class="my-0"><?= $laporan['qty_limbah'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Operator</label>
                <p class="my-0"><?= $laporan['operator'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Kendala</label>
                <p class="my-0"><?= $laporan['kendala'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">User</label>
                <p class="my-0"><?= $laporan['user'] ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
          <?php if($laporan_id_divisi=='3'){ ?>
          <div class="card mb-3">
            <div class="card-header bg-info">
              <?= $laporan_divisi ?>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label class="mb-0">Tanggal</label>
                <p class="my-0"><?= $laporan['tanggal'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Shift</label>
                <p class="my-0"><?= $laporan['nama_shift'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">No. Planprod</label>
                <p class="my-0"><?= $laporan['no_planprod'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Jenis Baking</label>
                <p class="my-0"><?= $laporan['jenis_oven'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Produk</label>
                <p class="my-0"><?= $laporan['produk'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">QTY</label>
                <p class="my-0"><?= $laporan['qty'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Operator</label>
                <p class="my-0"><?= $laporan['operator'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Kendala</label>
                <p class="my-0"><?= $laporan['kendala'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">User</label>
                <p class="my-0"><?= $laporan['user'] ?></p>
              </div>
          </div>
          <?php } ?>
          <?php if($laporan_id_divisi=='4'){ ?>
          <div class="card mb-3">
            <div class="card-header bg-info">
              <?= $laporan_divisi ?>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label class="mb-0">Tanggal</label>
                <p class="my-0"><?= $laporan['tanggal'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Shift</label>
                <p class="my-0"><?= $laporan['nama_shift'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">No. Planprod</label>
                <p class="my-0"><?= $laporan['no_planprod'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">No. Mesin</label>
                <p class="my-0"><?= $laporan['no_mesin'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Jenis Baking</label>
                <p class="my-0"><?= $laporan['jenis_oven'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Produk</label>
                <p class="my-0"><?= $laporan['produk'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Operator</label>
                <p class="my-0"><?= $laporan['operator'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">Kendala</label>
                <p class="my-0"><?= $laporan['kendala'] ?></p>
              </div>
              <div class="form-group mb-3">
                <label class="mb-0">User</label>
                <p class="my-0"><?= $laporan['user'] ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php if($flaghapus=="1"){ ?>
        <div class="col-sm-12">
          <form action="<?= base_url('laporan/del-act') ?>" method="post">
            <input type="hidden" name="id_laporan" value="<?= $laporan['id_laporan'] ?>" />
            <button type="submit" class="btn btn-danger form-control">Hapus</button>
          </form>
        </div>
        <?php } ?>
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