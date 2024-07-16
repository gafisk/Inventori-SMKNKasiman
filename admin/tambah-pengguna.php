<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_admin']) || empty($_SESSION['id_admin'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}


if (isset($_POST['submit'])) {
  $data = [
    'nama_user' => $_POST['nama_user'],
    'ni_user' => $_POST['ni_user'],
    'jk_user' => $_POST['jk_user'],
    'telp_user' => $_POST['telp_user'],
    'alamat_user' => $_POST['alamat_user'],
    'username_user' => $_POST['ni_user'],
    'password_user' => $_POST['ni_user'],
    'role_user' => $_POST['role_user'],
  ];
  if (!input_check($data)) {
    echo "<script>alert('Semua kolom inputan tidak boleh kosong atau berisi spasi saja!');</script>";
  } else {
    add_log($_SESSION['id_admin'], 'NULL', "Menambahkan Akun Users " . $_POST['nama_user']);
    insert('users', $data);
    header('location:daftar-pengguna.php');
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
              <h1 class="m-0">Tambah Pengguna</h1>
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
          <div class="row">
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Data Pengguna</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_user">Nama Pengguna</label>
                      <input type="text" class="form-control" id="nama_user" name="nama_user"
                        placeholder="Nama Pengguna...">
                    </div>
                    <div class="form-group">
                      <label for="ni_user">Id Pengguna</label>
                      <input type="text" name="ni_user" class="form-control" id="ni_user" placeholder="NIP / NISN...">
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin Pengguna</label>
                      <select class="form-control" name="jk_user">
                        <option value="Laki - laki">Laki - Laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="telp_user">No Telp Pengguna</label>
                      <input type="text" name="telp_user" class="form-control" id="telp_user"
                        placeholder="No Telp Pengguna...">
                    </div>
                    <div class="form-group">
                      <label for="alamat_user">Alamat Pengguna</label>
                      <textarea class="form-control" name="alamat_user" id="alamat_user" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Status Pengguna</label>
                      <select name="role_user" class="form-control select2bs4" style="width: 100%;">
                        <option value="">Pilih Status</option>
                        <option value="Siswa">Siswa</option>
                        <option value="Guru">Guru</option>
                        <option disabled value="Kepsek">Kepala Sekolah</option>
                      </select>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" name="submit" class="btn btn-primary"
                        onclick="return confirm('Anda yakin ingin menyimpan data?')">Simpan Data</button>
                    </div>
                </form>
              </div>
              <!-- /.card -->


              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('layouts/footer.php') ?>
</body>

</html>