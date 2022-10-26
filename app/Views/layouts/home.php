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
          <h1 class="m-0"><a href="<?= base_url('org') ?>" class="m-0">Struktur Org.</a></h1>
        </div>
      </div><!-- /.row -->
      <div class="row mb-2">
        <div class="container">
          <div class="row mt-3">
            <div class="col-4 text-right">
              <img src="<?= base_url('assets/docs/logo-rrc.png') ?>" style="height: 100px;" />
            </div>
            <div class="col-8">
              <h2 style="line-height: 100px;font-weight: bold;">Company Profile</h2>
            </div>
          </div>
          <hr>
          <p class="mb-3 text-justify">
            PT Raja Roti Cemerlang didirikan pada 11 Januari 2014 di Bekasi 
            dan kini telah menjadi salah satu industri breadcrumb yang kompetitif di Indonesia dan memiliki standar HACCP.
            Dengan membawa merk dagang ROYAL, ECO ROYAL dan RAJA, ECO RAJA. 
            Kami berusaha memenuhi kebutuhan konsumen di Indonesia akan bahan dan produk tambahan pangan yang berkualitas dan terjamin mutunya.
          </p>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Visi</h5>
          <p>
            Menjadi perusahaan  breadcrumb yang mengutamakan mutu dan kualitas produk demi kepuasan pelanggan.
          </p>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Misi</h5>
          <ul>
            <li>Memproduksi breadcrumb yang berkualitas dengan menggumakan teknologi dan melibatkan tenaga ahli</li>
            <li>Menjadi produsen breadcrumb yang terus berinovasi dalam produk dan pemasaran</li>
            <li>Meningkatkan kualitas produk dengan melakukan riset secara berkesinambungan demi kepuasan pelanggan</li>
            <li>Memciptakan produk breadcrumb Japanese style dan American style</li>
            <li>Mengembangkan pabrik di beberapa tempat yang strategis di Indonesia</li>
          </ul>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Sertifikasi</h5>
          <p class="text-justify">
            Dengan Komitmen untuk memberikan jaminan mutu dan standard keamanan pangan bagi seluruh konsumen produk - produk PT Raja Roti Cemerlang, 
            telah di lengkapi sertifikasi HALAL dari Majelis Ulama Indonesia, 
            terdaftar di Badan Pengawas Obat dan Makanan Republik Indonesia (BPOM-RI) 
            dan standard  Hazard Analisis and Critical Control Point (HACPP)
          </p>
          <img class="w-100" src="<?= base_url('assets/docs/sertifikasi.png') ?>" />
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Produk Kami</h5>
          <ul>
            <li>
              Japanese Style
              <img class="w-100 img-rounded" src="<?= base_url('assets/docs/japan-s.png') ?>" />
            </li>
            <li>
              American Style
              <img class="w-100 img-rounded" src="<?= base_url('assets/docs/american-s.png') ?>" />
            </li>
          </ul>
          <p class="text-justify">
            PT Raja Roti Cemerlang menyediakan breadcrumb dengan berbagai variant warna 
            seperti Mix, White, Orange, Yellow, Red dan untuk partikel bisa di sesuaikan dengan kebutuhan konsumen, 
            tersedia yang kualitas premium dan ekonomis.
          </p>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Pasar Kami</h5>
          <p class="text-justify">
            Target market dan pengembangan pemasaran produk-produk kami, meliputi Industri nugget dan frozen food, bisnis Food Servise ( Bakery,Restaurant,home industry ) 
            serta pasar-pasar tradisional.
          </p>
          <p class="text-justify">
            Dengan di bantu oleh 3 cabang perusahaan yang tersebar di Bekasi, Solo, Pemalang, 
            serta distributor yang tersebar secara nasional di Sumatra, Sulawesi, Bali, Batam, Kalimantan  kita akan dengan mudah mensuplay kebutuhan breadcrumb anda.
          </p>
          <h5 class="mt-3 mb-0" style="font-weight: bold;">Aplikasi</h5>
          <img class="w-100 img-rounded" src="<?= base_url('assets/docs/aplikasi-1.png') ?>" />
          <img class="w-100 img-rounded" src="<?= base_url('assets/docs/aplikasi-2.png') ?>" />
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