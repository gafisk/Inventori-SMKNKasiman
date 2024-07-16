<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];

$pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM peminjaman WHERE id_pj = '$id_pj' AND status_peminjaman ='Pinjam'"));
$kembali = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM peminjaman WHERE id_pj = '$id_pj' AND status_peminjaman ='Kembali'"));
$temp_pj_ruang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang WHERE id_pj = '$id_pj'"));
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = " . $temp_pj_ruang['id_ruangbarang']));

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
      <img class="animation__shake" src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
        width="60" />
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

    <?php include('layouts/main-user.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
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
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-4 col-12">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?=$barang['total_item']?></h3>
                  <p>Total Barang</p>
                </div>
                <div class="icon">
                  <i class="fas fa-box"></i>
                </div>
                <a href="laporan-barang.php" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?=$pinjam['total_item']?></h3>
                  <p>Total Peminjaman</p>
                </div>
                <div class="icon">
                  <i class="fas fa-handshake"></i>
                </div>
                <a href="data-peminjaman.php" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?=$kembali['total_item']?></h3>
                  <p>Total Pengembalian</p>
                </div>
                <div class="icon">
                  <i class="fas fa-undo"></i>
                </div>
                <a href="daftar-pengembalian.php" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include('layouts/footer.php') ?>
</body>

</html>