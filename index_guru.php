<?php
session_start();
require_once("config/koneksi.php");
if (isset($_SESSION['Username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>

        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search">

              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>

                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Guru</span>
    </a>

    <div class="sidebar">

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2">
        </div>

        <div class="info">
          <a href="#" class="d-block">Nayaka Jibran</a>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search">

          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- MENU GURU -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                GURU
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="guru_profil.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profil</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="guru_kelas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kelas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="guru_jadwal.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal</p>
                </a>
              </li>
            </ul>
          </li>

         
          <!-- TRANSAKSI -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                TRANSAKSI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="jadwal.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Logout
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>

        </ul>
      </nav>

    </div>
  </aside>

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Starter Page</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div>
        </div>

      </div>
    </div>

    <div class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12">

            <div class="card">
              <div class="card-body">

                <h5 class="card-title">Dashboard</h5>

                <p class="card-text">
                  <?php
                  if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                  } else {
                    $page = "";
                  }

                  if ($page == "") {
                    include "page/dashboard.php";
                  } elseif (!file_exists("page/$page.php")) {
                    echo "File Tidak Ditemukan";
                  } else {
                    include "page/$page.php";
                  }
                  ?>
                </p>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>

  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>

    <strong>
      Copyright &copy; 2014-2021 
      <a href="https://adminlte.io">AdminLTE.io</a>.
    </strong>
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