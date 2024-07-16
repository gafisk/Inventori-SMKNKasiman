<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}

$lab1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 1"));
$lab2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 2"));
$lab3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 3"));
$lab4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 4"));
$lab5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 5"));
$lab6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 6"));
$lab7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(COUNT(*), 0) AS total_item FROM barang WHERE id_ruangbarang = 7"));


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
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4><?=$lab1['total_item']?> Barang</h4>
                  <p>Teknik Komputer dan Jaringan</p>
                </div>
                <div class="icon">
                  <i class="fas fa-network-wired"></i>
                </div>
                <a href="laporan-barang.php?id_rb=1" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4><?=$lab2['total_item']?> Barang</h4>

                  <p>Desain Komunikasi Visual</p>
                </div>
                <div class="icon">
                  <i class="fas fa-palette"></i>
                </div>
                <a href="laporan-barang.php?id_rb=2" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4><?=$lab3['total_item']?> Barang</h4>

                  <p>Akuntansi dan Keuangan Lembaga</p>
                </div>
                <div class="icon">
                  <i class="fas fa-calculator"></i>
                </div>
                <a href="laporan-barang.php?id_rb=3" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4><?=$lab4['total_item']?> Barang</h4>

                  <p>CBT</p>
                </div>
                <div class="icon">
                  <i class="fas fa-laptop"></i>
                </div>
                <a href="laporan-barang.php?id_rb=4" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h4><?=$lab5['total_item']?> Barang</h4>
                  <p>Teknik Kendaraan Ringan</p>
                </div>
                <div class="icon">
                  <i class="fas fa-car"></i>
                </div>
                <a href="laporan-barang.php?id_rb=5" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h4><?=$lab6['total_item']?> Barang</h4>

                  <p>Teknik Ototronik</p>
                </div>
                <div class="icon">
                  <i class="fas fa-robot"></i>
                </div>
                <a href="laporan-barang.php?id_rb=6" class="small-box-footer">More info <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-12">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h4><?=$lab7['total_item']?> Barang</h4>

                  <p>Teknik Pengelasan</p>
                </div>
                <div class="icon">
                  <i class="fas fa-fire"></i>
                </div>
                <a href="laporan-barang.php?id_rb=7" class="small-box-footer">More info <i
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