<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];
$data_pj = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang using(id_ruangbarang) WHERE id_pj = '$id_pj'"));
$id_ruangbarang = $data_pj['id_ruangbarang'];
$data_barang = mysqli_query($conn, "SELECT * FROM barang_details WHERE barang_details.id_ruangbarang = '$id_ruangbarang'");

if (isset($_GET['hapus'])) {
  $id_barang = mysqli_escape_string($conn,  $_GET['hapus']);
  $kode_barang = explode('-', $id_barang)[0];
  $status_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status_barang FROM barang_details WHERE kode_barang = '$id_barang'"));
  $id_category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_barang FROM barang WHERE kode_barang = '$kode_barang'"));

  $query = mysqli_query($conn, "DELETE FROM barang_details WHERE kode_barang = '$id_barang'");
  $countstok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok_barang FROM `barang` WHERE kode_barang = '$kode_barang'"));
  $countstok = $countstok['stok_barang'] - 1;
  $queryupd = mysqli_query($conn, "UPDATE barang SET stok_barang = '$countstok' WHERE kode_barang = '$kode_barang'");
  if ($status_barang['status_barang'] === 'Baik') {
    $countbaik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_baik FROM `keadaan_barang` WHERE id_barang = '$id_category[id_barang]'"));
    $countbaik = $countbaik['jumlah_baik'] - 1;
    $updcountbaik = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_baik = '$countbaik' WHERE id_barang = '$id_category[id_barang]'");
  } else {
    $countrusak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_rusak FROM `keadaan_barang` WHERE id_barang = '$id_category[id_barang]'"));
    $countrusak = $countrusak['jumlah_rusak'] - 1;
    $updcountbaik = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_rusak = '$countrusak' WHERE id_barang = '$id_category[id_barang]'");
  }
  if ($query) {
    $_SESSION['sukses'] = true;
    $_SESSION['msg'] = 'Berhasil Menghapus Data';
    add_log('NULL', $_SESSION['id_pj'], "Menghapus Data");
    header('location:daftar-satuan-barang.php');
    exit();
  } else {
    $_SESSION['gagal'] = true;
    $_SESSION['msg'] = 'Gagal Menghapus Data';
    header('location:daftar-satuan-barang.php');
    exit();
  }
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
              <h1 class="m-0">Daftar Satuan Barang</h1>
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
              <strong>Sukses</strong> <?= $_SESSION['msg'] ?>.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['sukses']);
            unset($_SESSION['msg']);
          endif; ?>

          <?php if (isset($_SESSION['edit']) && $_SESSION['edit']) : ?>
            <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
              <strong>Sukses</strong> <?= $_SESSION['msg'] ?>.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['edit']);
            unset($_SESSION['msg']);
          endif; ?>

          <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']) : ?>
            <div class="alert alert-danger alert-dismissible fade show" id="myAlert" role="alert">
              <strong>Gagal</strong> <?= $_SESSION['msg'] ?>.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
            unset($_SESSION['gagal']);
            unset($_SESSION['msg']);
          endif; ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h3 class="card-title">Data Satuan Barang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Keadaan Barang</th>
                        <th>Spesifikasi Barang</th>
                        <th style="width: 12%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data_barang as $barang) : ?>
                        <tr>
                          <td><?= $barang['kode_barang'] ?></td>
                          <td><?= $barang['nama'] ?></td>
                          <td><?= 'Rp ' . number_format($barang['harga'], 2, ",", ".") ?></td>
                          <td><?= $barang['status_barang'] ?></td>
                          <td><?= (!empty($barang['spesifikasi'])) ? nl2br(htmlspecialchars($barang['spesifikasi'])) : '-' ?></td>
                          <td>
                            <a href="edit-satuan-barang.php?edit=<?= urlencode($barang['kode_barang']) ?>" class="btn btn-sm btn-warning"><i
                                class="fas fa-pencil-alt"></i></a>
                            <a href="?hapus=<?= $barang['kode_barang'] ?>"
                              onclick="return confirm('Anda Yakin Ingin Menghapus Data?')"
                              class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Keadaan Barang</th>
                        <th>Spesifikasi Barang</th>
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