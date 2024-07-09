<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];

if (isset($_GET['edit'])){
  $id_peminjaman = mysqli_escape_string($conn, $_GET['edit']);
  $datas = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM peminjaman WHERE id_peminjaman = $id_peminjaman"));
  $data_peminjam = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id_user = ". $datas['id_user']));
  $data_barang = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM barang WHERE id_barang = ". $datas['id_barang']));
  if(isset($_POST['submit'])){
    $up = [
      'tanggal_kembali' => $_POST['tanggal_kembali'],
    ];
    $condition = [
      'id_peminjaman' => $id_peminjaman,
    ];
    if (!input_check($up)) {
      echo "<script>alert('Semua kolom inputan tidak boleh kosong atau berisi spasi saja!');</script>";
    } else {
      add_log('NULL', $_SESSION['id_pj'], "Mengedit data peminjaman " . $id_peminjaman);
      update('peminjaman', $up, $condition);
      header('location:data-peminjaman.php');
      exit();
    }

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
              <h1 class="m-0">Edit Data Peminjaman</h1>
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
                  <h3 class="card-title">Data Peminjaman</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="ketua_lab">Nama Ketua Lab</label>
                      <input type="text" class="form-control" id="ketua_lab" value="<?=$_SESSION['nama_pj']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="nama_peminjam">Nama Peminjam</label>
                      <input type="text" class="form-control" id="nama_peminjam"
                        value="<?=$data_peminjam['nama_user']?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="nama_barang">Nama Peminjam</label>
                      <input type="text" class="form-control" id="nama_barang" value="<?=$data_barang['nama_barang']?>"
                        readonly>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="tgl_pinjam">Tanggal Pinjam</label>
                          <input name="tanggal_pinjam" type="date" class="form-control" id="tgl_pinjam" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="tgl_kembali">Tanggal Kembali</label>
                          <input name="tanggal_kembali" type="date" class="form-control" id="tgl_kembali"
                            value="<?=$datas['tanggal_kembali']?>">
                        </div>
                      </div>
                    </div>
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
<script>
var nBulan = 2;

function formatDate(date) {
  var dd = String(date.getDate()).padStart(2, '0');
  var mm = String(date.getMonth() + 1).padStart(2, '0'); // January is 0!
  var yyyy = date.getFullYear();
  return yyyy + '-' + mm + '-' + dd;
}

function setTanggal() {
  var today = new Date();
  var tgl_pinjam = formatDate(today); // 'YYYY-MM-DD'

  if (document.getElementById('tgl_pinjam')) {
    document.getElementById('tgl_pinjam').value = tgl_pinjam;
  }

  var nextDate = new Date(today);
  nextDate.setMonth(nextDate.getMonth() + nBulan);
  var tgl_kembali = formatDate(nextDate); // 'YYYY-MM-DD'

  if (document.getElementById('tgl_kembali')) {
    document.getElementById('tgl_kembali').value = tgl_kembali;
  }
}

setTimeout(setTanggal, 100);

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('tgl_pinjam').addEventListener('change', function() {
    var selectedDate = new Date(this.value);
    var nextDate = new Date(selectedDate);
    nextDate.setMonth(nextDate.getMonth() + nBulan);
    var tgl_kembali = formatDate(nextDate); // 'YYYY-MM-DD'

    if (document.getElementById('tgl_kembali')) {
      document.getElementById('tgl_kembali').value = tgl_kembali;
    }
  });
});
</script>