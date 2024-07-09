<?php
session_start();
include('../config/config.php');
if (isset($_POST['submit'])) {
  $username = mysqli_escape_string($conn, $_POST['username']);
  $password = mysqli_escape_string($conn, $_POST['password']);
  if (empty($username) || empty($password)) {
    $_SESSION['gagal'] = true;
    $_SESSION['msg'] = "Username Atau Password Tidak Boleh Kosong";
    header('location:login.php');
    exit();
  } else {
    $check_users = mysqli_query($conn, "SELECT * FROM pj_ruang WHERE username_pj = '$username'");
    if (mysqli_num_rows($check_users) > 0) {
      $query = mysqli_query($conn, "SELECT * FROM pj_ruang WHERE username_pj = '$username' AND password_pj = '$password'");
      if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['id_pj'] = $row['id_pj'];
        $_SESSION['nama_pj'] = $row['nama_pj'];
        $_SESSION['id_ruangbarang'] = $row['id_ruangbarang'];
        add_log('NULL', $_SESSION['id_pj'], "Ketua Ruang Login");
        echo '<script>alert("Anda Berhasil Login. Redirecting..."); window.location.href="index.php";</script>';
        exit();
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Password Salah";
        header('location:login.php');
        exit();
      }
    } else {
      $_SESSION['gagal'] = true;
      $_SESSION['msg'] = "Akunmu Belum Terdaftar";
      header('location:login.php');
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Ketua Ruangan Inventori</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="login.php" class="h1">KETUA RUANGAN<br>INVENTORI<br><b>SMKN</b> KESIMAN </a>
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
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.min.js"></script>
</body>

</html>