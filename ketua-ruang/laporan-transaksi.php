<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];

if (isset($_POST['submit'])) {
  $tgl_awal = $_POST['tanggal_awal'];
  $tgl_akhir = $_POST['tanggal_akhir'];
  if (empty($tgl_awal) || empty($tgl_akhir)) {
    echo "<script>alert('Kolom Inputan Data Tidak Boleh Kosong!');</script>";
    echo "<script>window.location.href='laporan-transaksi.php';</script>";
    exit();
  } else {
    $data_pengembalian = mysqli_query($conn, "SELECT *, pengembalian.tanggal_kembali AS tgl_serah FROM pengembalian INNER JOIN peminjaman ON pengembalian.id_peminjaman = peminjaman.id_peminjaman INNER JOIN barang ON peminjaman.id_barang = barang.id_barang INNER JOIN users ON peminjaman.id_user = users.id_user WHERE pengembalian.id_pj = '$id_pj' AND peminjaman.tanggal_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'");
  }
} else {
  $data_pengembalian = mysqli_query($conn, "SELECT *, pengembalian.tanggal_kembali AS tgl_serah FROM pengembalian INNER JOIN peminjaman ON pengembalian.id_peminjaman = peminjaman.id_peminjaman INNER JOIN barang ON peminjaman.id_barang = barang.id_barang INNER JOIN users ON peminjaman.id_user = users.id_user WHERE pengembalian.id_pj = '$id_pj'");
}



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

    <!-- Main Sidebar Container -->
    <?php include('layouts/main-user.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Laporan Transaksi</h1>
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
                <div class="card-header">
                  <h3 class="card-title">Pilih Waktu</h3>
                </div>
                <div class="card-body">
                  <form action="" method="POST">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="tanggal_awal">Dari Tanggal</label>
                          <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="tanggal_akhir">Sampai Tanggal</label>
                          <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                        </div>
                      </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Pilih Waktu</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title">Laporan Data Transaksi</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Status Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Serah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data_pengembalian as $dp) : ?>
                      <tr>
                        <td><?= $dp['ni_user'] ?></td>
                        <td><?= $dp['nama_user'] ?></td>
                        <td><?= $dp['nama_barang'] ?></td>
                        <td><?= $dp['status_barang'] ?></td>
                        <td><?= $dp['tanggal_pinjam'] ?></td>
                        <td><?= $dp['tanggal_kembali'] ?></td>
                        <td><?= $dp['tgl_serah'] ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Status Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Serah</th>
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