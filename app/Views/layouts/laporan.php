<?= $this->extend('templates/admin-lte') ?>

<?= $this->section('content-admin-lte') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h1 class="m-0">Laporan</h1>
        </div><!-- /.col -->
        <?php if($id_divisi==1){ ?>
        <div class="col-6 text-right">
          <h1 class="m-0"><a href="#" class="m-0 <?= $flagfilter? 'btn btn-primary': '' ?>" data-toggle="modal" data-target="#modalFilter">Filter</a></h1>
        </div><!-- /.col -->
        <?php } ?>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <?php if($id_divisi=='2'){ ?>
          <div class="card mb-3">
            <form action="<?= base_url('laporan/aksi-ayaktepung') ?>" method="post">
              <div class="card-header bg-info">
                <?= $divisi ?>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <label>Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Shift</label>
                  <select class="form-control" name="nama_shift" required>
                    <option value="">Pilih Shift</option>
                    <?php foreach($shift as $isiShift){ ?>
                    <option value="<?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)">
                      <?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Terigu</label>
                  <select class="form-control" name="produk" required>
                    <option value="">Pilih Terigu</option>
                    <?php foreach($tepung as $isiTepung){ ?>
                    <option value="<?= $isiTepung['jenis_tepung'] ?>">
                      <?= $isiTepung['jenis_tepung'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>QTY</label>
                  <div class="input-group">
                    <input type="number" class="form-control" name="qty" required>
                    <div class="input-group-append">
                      <span class="input-group-text">SAK</span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label>QTY Stok</label>
                  <div class="input-group">
                    <input type="number" class="form-control" name="qty_stok[]" required>
                    <div class="input-group-append">
                      <span class="input-group-text">Box - 10Kg</span>
                    </div>
                  </div>
                  <div class="input-group">
                    <input type="number" class="form-control" name="qty_stok[]" required>
                    <div class="input-group-append">
                      <span class="input-group-text">Box - 25Kg</span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label>QTY Limbah</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="qty_limbah" required>
                    <div class="input-group-append">
                      <span class="input-group-text">Gram</span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label>Operator</label>
                  <input type="text" class="form-control" name="operator" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Kendala</label>
                  <textarea class="form-control" name="kendala" required></textarea>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary form-control">Kirim</button>
              </div>
            </form>
          </div>
          <?php } ?>
          <?php if($id_divisi=='3'){ ?>
          <div class="card mb-3">
            <form action="<?= base_url('laporan/aksi-mixing') ?>" method="post">
              <div class="card-header bg-info">
                <?= $divisi ?>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <label>Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Shift</label>
                  <select class="form-control" name="nama_shift" required>
                    <option value="">Pilih Shift</option>
                    <?php foreach($shift as $isiShift){ ?>
                    <option value="<?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)">
                      <?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>No. Planprod</label>
                  <input type="text" class="form-control" name="no_planprod" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Jenis Baking</label>
                  <select class="form-control" name="jenis_oven" required>
                    <option value="">Pilih Jenis Baking</option>
                    <option>Electric Baking</option>
                    <option>Oven Baking</option>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Roti</label>
                  <select class="form-control" name="produk" required>
                    <option value="">Pilih Roti</option>
                    <?php foreach($roti as $isiRoti){ ?>
                    <option value="<?= $isiRoti['jenis_roti'] ?>">
                      <?= $isiRoti['jenis_roti'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>QTY</label>
                  <div class="input-group">
                    <input type="number" class="form-control" name="qty" required>
                    <div class="input-group-append">
                      <span class="input-group-text">Batch</span>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label>Operator</label>
                  <input type="text" class="form-control" name="operator" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Kendala</label>
                  <textarea class="form-control" name="kendala" required></textarea>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary form-control">Kirim</button>
              </div>
            </form>
          </div>
          <?php } ?>
          <?php if($id_divisi=='4'){ ?>
          <div class="card mb-3">
            <form action="<?= base_url('laporan/aksi-drying') ?>" method="post">
              <div class="card-header bg-info">
                <?= $divisi ?>
              </div>
              <div class="card-body">
                <div class="form-group mb-3">
                  <label>Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Shift</label>
                  <select class="form-control" name="nama_shift" required>
                    <option value="">Pilih Shift</option>
                    <?php foreach($shift as $isiShift){ ?>
                    <option value="<?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)">
                      <?= $isiShift['nama_shift'] ?> (<?= date('H:i', strtotime($isiShift['jam_masuk'])) ?> - <?= date('H:i', strtotime($isiShift['jam_keluar'])) ?>)
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>No. Planprod</label>
                  <input type="text" class="form-control" name="no_planprod" required/>
                </div>
                <div class="form-group mb-3">
                  <label>No. Mesin</label>
                  <select class="form-control" name="no_mesin" required>
                    <option value="">Pilih Mesin</option>
                    <option>Mesin 1</option>
                    <option>Mesin 2</option>
                    <option>Mesin 3</option>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Jenis Baking</label>
                  <select class="form-control" name="jenis_oven" required>
                    <option value="">Pilih Jenis Baking</option>
                    <option>Electric Baking</option>
                    <option>Oven Baking</option>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Roti</label>
                  <select class="form-control" name="produk[]" required>
                    <option value="">Pilih Roti</option>
                    <?php foreach($roti as $isiRoti){ ?>
                    <option value="<?= $isiRoti['jenis_roti'] ?>">
                      <?= $isiRoti['jenis_roti'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Label</label>
                  <select class="form-control" name="produk[]" required>
                    <option value="">Pilih Label</option>
                    <?php foreach($label as $isiLabel){ ?>
                    <option value="<?= $isiLabel['jenis_label'] ?>">
                      <?= $isiLabel['jenis_label'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Operator</label>
                  <input type="text" class="form-control" name="operator" required/>
                </div>
                <div class="form-group mb-3">
                  <label>Kendala</label>
                  <textarea class="form-control" name="kendala" required></textarea>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary form-control">Kirim</button>
              </div>
            </form>
          </div>
          <?php } ?>
          <div class="card mb-3">
            <div class="card-header bg-secondary">
              <div class="row">
                <div class="col-6">
                  History Laporan
                </div>
                <?php if($id_divisi==1 && count($laporan)>0){ ?>
                <div class="col-6 text-right">
                  <a href="<?= base_url('laporan/print/'.bin2hex($f_divisi.';'.$f_bulan.';'.$f_tahun).'/laporan-'.$f_nama_divisi.$f_tahun.$f_bulan.'.pdf') ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Print</a>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="card-body">
              <table class="table tabel-report table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <?php if($id_divisi==1){ ?>
                    <th>Divisi</th>
                    <?php } ?>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($laporan as $isiLaporan){ ?>
                  <tr>
                    <td>
                      <a href="<?= base_url('laporan/del/'.bin2hex($isiLaporan['divisi'].';'.$isiLaporan['id_laporan'])) ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                    <td><?= $isiLaporan['tanggal'] ?></td>
                    <td><?= $isiLaporan['nama_shift'] ?></td>
                    <?php if($id_divisi==1){ ?>
                    <td><?= $isiLaporan['divisi'] ?></td>
                    <?php } ?>
                    <td>
                      <a href="<?= base_url('laporan/lihat/'.bin2hex($isiLaporan['divisi'].';'.$isiLaporan['id_laporan'])) ?>"><i class="fa fa-external-link-alt"></i></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      
    <!-- Modal -->
      <div class="modal fade" id="modalFilter">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="<?= base_url('laporan') ?>" method="post">
              <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group mb-3">
                  <label>Divisi</label>
                  <select class="form-control" name="f_divisi">
                    <option value="">Pilih Divisi</option>
                    <?php foreach($divisis as $isiDivisis){ if($isiDivisis['id_divisi']!=1){ ?>
                    <option value="<?= $isiDivisis['id_divisi'] ?>" <?= $isiDivisis['id_divisi']==$f_divisi? 'selected': '' ?>>
                      <?= $isiDivisis['nama_divisi'] ?>
                    </option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Bulan</label>
                  <select class="form-control" name="f_bulan">
                    <option value="">Pilih Bulan</option>
                    <?php foreach($bulans as $isiBulans){ ?>
                    <option value="<?= $isiBulans['bulan'] ?>" <?= $isiBulans['bulan']==$f_bulan? 'selected': '' ?>>
                      <?= date("F", strtotime("9999-".$isiBulans['bulan']."-01")) ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group mb-3">
                  <label>Tahun</label>
                  <select class="form-control" name="f_tahun">
                    <!-- <option value="">Pilih Tahun</option> -->
                    <?php foreach($tahuns as $isiTahuns){ ?>
                    <option value="<?= $isiTahuns['tahun'] ?>" <?= $isiTahuns['tahun']==$f_tahun? 'selected': '' ?>>
                      <?= $isiTahuns['tahun'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection() ?>