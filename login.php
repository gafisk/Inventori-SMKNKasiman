<?php
session_start();
include('config/config.php');

if (isset($_POST['submit'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username) || empty($password)) {
    $_SESSION['gagal'] = true;
    $_SESSION['msg'] = "Username atau Password tidak boleh kosong";
    header('location:login.php');
    exit();
  } else {
    $check_users = mysqli_query($conn, "SELECT * FROM users WHERE username_user = '$username'");
    if (mysqli_num_rows($check_users) > 0) {
      $query = mysqli_query($conn, "SELECT * FROM users WHERE username_user = '$username' AND password_user = '$password'");
      if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        session_regenerate_id(true); // Regenerasi ID sesi
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['nama_user'] = $row['nama_user'];
        $_SESSION['ni_user'] = $row['ni_user'];
        $_SESSION['role_user'] = $row['role_user'];
        if ($row['role_user'] == 'Guru' || $row['role_user'] == 'Siswa') {
          echo '<script>alert("Anda berhasil login. Redirecting..."); window.location.href="users/";</script>';
          add_log('NULL', 'NULL', $_SESSION['nama_user'] . " User Berusaha Login");
          exit();
        } else {
          add_log('NULL', 'NULL', "Kepala Sekolah Login");
          echo '<script>alert("Anda berhasil login. Redirecting..."); window.location.href="kepala-sekolah/";</script>';
          exit();
        }
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Password salah";
        header('location:login.php');
        exit();
      }
    } else {
      $_SESSION['gagal'] = true;
      $_SESSION['msg'] = "Akunmu belum terdaftar";
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
            <a href="ketua-ruang/login.php" class="text-center">Anda Ketua Ruangan? Login disini</a>
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