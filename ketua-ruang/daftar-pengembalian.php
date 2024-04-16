<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('layouts/head.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60" />
    </div>

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
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include('layouts/main-user.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Daftar Barang</h1>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_SESSION['sukses']) && $_SESSION['sukses']) : ?>
            <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
              <strong>Sukses</strong> Data Berhasil di Simpan.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['sukses']);
          endif; ?>

          <?php if (isset($_SESSION['edit']) && $_SESSION['edit']) : ?>
            <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
              <strong>Sukses</strong> Data Berhasil di Edit.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['edit']);
          endif; ?>

          <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']) : ?>
            <div class="alert alert-danger alert-dismissible fade show" id="myAlert" role="alert">
              <strong>Gagal</strong> Data Gagal di Simpan.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['gagal']);
          endif; ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title">Data Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Serah</th>
                        <th style="width: 5%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>190411100177</td>
                        <td>Galih Pinjam</td>
                        <td>Tablet</td>
                        <td>14-04-2024</td>
                        <td>20-04-2024</td>
                        <td>18-04-2024</td>
                        <td>
                          <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Serah</th>
                        <th>Aksi</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <?php include('layouts/footer.php'); ?>
</body>

</html>
<script>
  // Ambil elemen alert
  var alert = document.getElementById('myAlert');

  // Tutup alert setelah 3 detik
  setTimeout(function() {
    alert.style.display = 'none';
  }, 10000);
</script>