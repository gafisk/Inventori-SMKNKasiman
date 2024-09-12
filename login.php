<?php
session_start();
include('config/config.php');

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  if (empty($username) || empty($password) || empty($status)) {
    $_SESSION['gagal'] = true;
    $_SESSION['msg'] = "Identitas Login Tidak Boleh Kosong!!";
    header('location:login.php');
    exit();
  } else {
    if($status == 'Admin'){
      $check_users = mysqli_query($conn, "SELECT * FROM admin WHERE username_admin = '$username'");
      if (mysqli_num_rows($check_users) > 0) {
        $query = mysqli_query($conn, "SELECT * FROM admin WHERE username_admin = '$username' AND password_admin = '$password'");
        if (mysqli_num_rows($query) > 0) {
          $row = mysqli_fetch_assoc($query);
          $_SESSION['id_admin'] = $row['id_admin'];
          $_SESSION['nama_admin'] = $row['nama_admin'];
          add_log($row['id_admin'], 'NULL', "ADMIN Login");
          echo '<script>alert("Anda Berhasil Login. Redirecting..."); window.location.href="admin/";</script>';
          exit();
        } else {
          $_SESSION['gagal'] = true;
          $_SESSION['msg'] = "Password Salah";
          header('location:login.php');
          exit();
        }
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Tidak ada akun";
        header('location:login.php');
        exit();
      }
    }else if($status == 'Kepsek'){
      $check_users = mysqli_query($conn, "SELECT * FROM users WHERE username_user = '$username'");
      if (mysqli_num_rows($check_users) > 0) {
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username_user = '$username' AND password_user = '$password' AND role_user = '$status'");
        if (mysqli_num_rows($query) > 0) {
          $row = mysqli_fetch_assoc($query);
          session_regenerate_id(true);
          $_SESSION['id_user'] = $row['id_user'];
          $_SESSION['nama_user'] = $row['nama_user'];
          $_SESSION['ni_user'] = $row['ni_user'];
          $_SESSION['role_user'] = $row['role_user'];
          add_log('NULL', 'NULL', "Kepala Sekolah Login");
          echo '<script>alert("Anda berhasil login. Redirecting..."); window.location.href="kepala-sekolah/";</script>';
          exit();
        }else{
          $_SESSION['gagal'] = true;
          $_SESSION['msg'] = "Password salah";
          header('location:login.php');
          exit();
        }
      }else{
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Akunmu belum terdaftar";
        header('location:login.php');
        exit();
      }
    }else{
      $check_users = mysqli_query($conn, "SELECT * FROM pj_ruang WHERE username_pj = '$username'");
      if (mysqli_num_rows($check_users) > 0) {
        $query = mysqli_query($conn, "SELECT * FROM pj_ruang WHERE username_pj = '$username' AND password_pj = '$password'");
      if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['id_pj'] = $row['id_pj'];
        $_SESSION['nama_pj'] = $row['nama_pj'];
        $_SESSION['id_ruangbarang'] = $row['id_ruangbarang'];
        add_log('NULL', $row['id_pj'], "Ketua Ruang Login");
        echo '<script>alert("Anda Berhasil Login. Redirecting..."); window.location.href="ketua-ruang/";</script>';
        exit();
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Password Salah";
        header('location:login.php');
        exit();
      }
      }else{
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Akunmu belum terdaftar";
        header('location:login.php');
        exit();
      }
    }
    
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Inventori</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="login.php" class="h1">INVENTORI<br><b>SMKN</b> KESIMAN </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Login Untuk Memulai Aplikasi</p>
        <?php if (isset($_SESSION['gagal']) && $_SESSION['gagal']) : ?>
        <div class="alert alert-danger alert-dismissible fade show" id="myAlert" role="alert">
          <strong>Gagal Login</strong> <?= $_SESSION['msg'] ?> .
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php
          unset($_SESSION['gagal']);
          unset($_SESSION['msg']);
        endif; ?>
        <form action="" method="POST">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username..." name="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-alt"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select name="status" id="status" class="form-control">
              <option value="">--- Pilih Jenis ---</option>
              <option value="Admin">Admin</option>
              <option value="Kepsek">Kepala Sekolah</option>
              <option value="Ketua">Ketua Ruangan</option>
            </select>
          </div>
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
      </div>
      </form>
      <p class="mb-2 ml-2">
        <a href="index.php" class="text-center">Kembali Ke Halaman Depan</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
</body>

</html>