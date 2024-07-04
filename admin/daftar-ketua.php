<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_admin']) || empty($_SESSION['id_admin'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}

$datas = mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang USING(id_ruangbarang)");

if (isset($_GET['hapus'])) {
  $id_hapus = mysqli_escape_string($conn, $_GET['hapus']);
  $condition = [
    'id_pj' => $id_hapus,
  ];
  delete('pj_ruang', $condition);
  header('location: daftar-ketua.php');
  exit();
}

if (isset($_GET['resetpw'])) {
  $id_pj = mysqli_escape_string($conn, $_GET['resetpw']);
  $data_pj = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang WHERE id_pj = '$id_pj'"));
  $data = [
    'password_pj' => $data_pj['username_pj'],
  ];
  $condition = [
    'id_pj' => $id_pj,
  ];
  update('pj_ruang', $data, $condition);
  header('location: daftar-ketua.php');
  exit();
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
              <h1 class="m-0">Daftar Ketua Ruang</h1>
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
              <strong>Sukses</strong> <?= $_SESSION['msg'] ?>
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
              <strong>Sukses</strong> <?= $_SESSION['msg'] ?>
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
              <strong>Gagal</strong><?= $_SESSION['msg'] ?>
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
                  <h3 class="card-title">Data Ketua Ruang</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Ruangan</th>
                        <th style="width: 11%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($datas as $data) : ?>
                        <tr>
                          <td><?= $data['nama_pj'] ?></td>
                          <td><?= $data['jk_pj'] ?></td>
                          <td><?= $data['telp_pj'] ?></td>
                          <td><?= $data['alamat_pj'] ?></td>
                          <td><?= $data['nama_ruangbarang'] ?></td>
                          <td>
                            <a href="edit-ketua.php?edit=<?= $data['id_pj'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-pen-alt"></i></a>
                            <a href="?hapus=<?= $data['id_pj'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Data Ini Akan di Hapus?')"><i class="fas fa-trash-alt"></i></a>
                            <a href="?resetpw=<?= $data['id_pj'] ?>" class="btn btn-sm btn-primary" onclick="return confirm('Reset Password Akun ini?')"><i class="fas fa-undo"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Ruangan</th>
                        <th style="width: 11%">Aksi</th>
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