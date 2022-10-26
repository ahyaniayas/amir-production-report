
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $appname ?></title>
  <link rel="icon" href="<?= base_url('assets/docs/logo-rrc.png') ?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.min.css') ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
</head>

<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="return false">
            <?= ucwords($username) ?> (<?= strtoupper($divisi) ?>)
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('logout-process') ?>">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link" onclick="return false">
      <img src="<?= base_url('assets/docs/logo-rrc.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">R.R.C</span>
    </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= base_url() ?>" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>Beranda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('laporan') ?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Laporan</p>
              </a>
            </li>
            <?php if($id_divisi==1){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Manajemen
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('mnj/user') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>User</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('mnj/divisi') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Divisi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('mnj/shift') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Shift</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('mnj/ayaktepung') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ayak Tepung</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('mnj/mixing') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mixing</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('mnj/drying') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Drying</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>
            <li class="nav-item">
              <a href="<?= base_url('logout-process') ?>" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Log out</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <?= $this->renderSection('content-admin-lte') ?>

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= base_url() ?>"><?= $appname ?></a>.</strong>
      All rights reserved.
    </footer>
    
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- Toastr -->
  <script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <!-- AdminLTE -->
  <script src="<?= base_url('assets/dist/js/adminlte.js') ?>"></script>
  
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/dist/js/demo.js') ?>"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="<?= base_url('assets/dist/js/pages/dashboard3.js') ?>"></script> -->

  <script>
    $(document).ready(function() {
      if("<?= $msg ?>".length>0){
        toastr.warning('<?= $msg ?>')
      }

      $(".table-master").DataTable({
        "order": [[0, 'asc']],
        "autoWidth": false,
        "responsive": true,
      });
      $(".tabel-report").DataTable({
        "order": [[1, 'desc']],
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>