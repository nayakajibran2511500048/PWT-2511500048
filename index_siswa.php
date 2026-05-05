<?php
session_start();
require_once("config/koneksi.php");

// KHUSUS SISWA
if (isset($_SESSION['Username']) && $_SESSION['level'] == 'siswa') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa Panel</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fas fa-bars"></i>
        </a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-user"></i>
        </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">Siswa</span>
    </a>

    <div class="sidebar">

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2">
        </div>

        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['Username']; ?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

          <!-- MENU SISWA -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                SISWA
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>

        </ul>
      </nav>

    </div>
  </aside>

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Dashboard Siswa</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">

        <?php
        $page = $_GET['page'] ?? '';

        if ($page == "") {
          include "page/dashboard.php"; // FIX DI SINI
        } elseif (!file_exists("page/$page.php")) {
          echo "File Tidak Ditemukan";
        } else {
          include "page/$page.php";
        }
        ?>

      </div>
    </div>

  </div>

  <footer class="main-footer text-center">
    <strong>Sistem Siswa</strong>
  </footer>

</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>

<?php
} else {
  echo "<meta http-equiv='refresh' content='0; url=login.php'>";
}
?>