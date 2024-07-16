<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_admin']) || empty($_SESSION['id_admin'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}

$datas = mysqli_query($conn, "SELECT * FROM users");

if (isset($_GET['hapus'])) {
  $id_hapus = mysqli_escape_string($conn, $_GET['hapus']);
  $condition = [
    'id_user' => $id_hapus,
  ];
  $temp_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id_user = $id_hapus"));
  add_log($_SESSION['id_admin'], 'NULL', "Menghapus " . $temp_data['nama_user']);
  delete('users', $condition);
  header('location: daftar-pengguna.php');
  exit();
}


if (isset($_GET['resetpw'])) {
  $id_user = mysqli_escape_string($conn, $_GET['resetpw']);
  $datas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'"));
  $data = [
    'password_user' => $datas['ni_user'],
  ];
  $condition = [
    'id_user' => $id_user,
  ];
  add_log($_SESSION['id_admin'], 'NULL', "Mereset Password " . $datas['nama_user']);
  update('users', $data, $condition);
  header('location: daftar-pengguna.php');
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
              <h1 class="m-0">Daftar Pengguna</h1>
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
            <strong>Gagal</strong> <?= $_SESSION['msg'] ?>
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
                  <h3 class="card-title">Data Pengguna</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Identitas</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th style="width: 11%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($datas as $data) : ?>
                      <tr>
                        <td><?= $data['ni_user'] ?></td>
                        <td>
                          <?= $data['nama_user'] ?>
                        </td>
                        <td>
                          <?= $data['jk_user'] ?>
                        </td>
                        <td>
                          <?= $data['telp_user'] ?>
                        </td>
                        <td>
                          <?= $data['alamat_user'] ?>
                        </td>
                        <td>
                          <?= $data['role_user'] ?>
                        </td>
                        <td>
                          <a href="edit-pengguna.php?edit=<?= $data['id_user'] ?>" class="btn btn-sm btn-warning"><i
                              class="fas fa-pen-alt"></i></a>
                          <a href="?hapus=<?= $data['id_user'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Data ini akan dihapus?')"><i class="fas fa-trash-alt"></i></a>
                          <a href="?resetpw=<?= $data['id_user'] ?>" class="btn btn-sm btn-primary"
                            onclick="return confirm('Reset Password Akun ini?')"><i class="fas fa-undo"></i></a>
                        </td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Identitas</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Status</th>
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