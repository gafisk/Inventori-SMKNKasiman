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
$data_users = mysqli_query($conn, "SELECT * FROM users WHERE role_user = 'Guru' OR role_user = 'Siswa'");
$data_barangs = mysqli_query($conn, "SELECT * FROM barang WHERE id_ruangbarang = '$id_ruangbarang'");

if (isset($_POST['submit'])) {
  $id_user = mysqli_escape_string($conn, $_POST['nama_peminjam']);
  $id_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
  $tanggal_kembali = mysqli_escape_string($conn, $_POST['tanggal_kembali']);
  $status_peminjaman = 'Pinjam';
  if (empty($id_user) || empty($id_barang) || empty($tanggal_kembali)) {
    echo "<script>alert('Kolom Inputan Data Tidak Boleh Kosong!');</script>";
  } else {
    $temp_status_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status_barang FROM barang WHERE id_barang = '$id_barang'"));
    if($temp_status_barang['status_barang'] == 'Tetap'){
      $query = mysqli_query($conn, "INSERT INTO peminjaman VALUES(NULL, '$id_pj', '$id_user', '$id_barang', NOW(), '$tanggal_kembali', '$status_peminjaman')");
      if ($query) {
        $update_stok = mysqli_query($conn, "UPDATE barang SET stok_barang = stok_barang - 1 WHERE id_barang = '$id_barang'");
        if ($update_stok) {
          $_SESSION['sukses'] = true;
          $_SESSION['msg'] = 'Berhasil Menambahkan Peminjaman';
          add_log('NULL', $_SESSION['id_pj'], "Menambahkan Peminjaman ". $id_user);
          header('location:data-peminjaman.php');
          exit();
        } else {
          $_SESSION['gagal'] = true;
          $_SESSION['msg'] = 'Gagal Menambahkan Data';
          header('location:data-peminjaman.php');
          exit();
        }
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = 'Gagal Menambahkan Peminjaman';
        header('location:data-peminjaman.php');
        exit();
      }
    }else{
      $jumlah_barang_baik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM keadaan_barang WHERE id_barang = '$id_barang'"));
      if($jumlah_barang_baik['jumlah_baik'] > 0){
        $query = mysqli_query($conn, "INSERT INTO peminjaman VALUES(NULL, '$id_pj', '$id_user', '$id_barang', NOW(), '$tanggal_kembali', '$status_peminjaman')");
        if ($query) {
          $update_stok1 = mysqli_query($conn, "UPDATE barang SET stok_barang = stok_barang - 1 WHERE id_barang = '$id_barang'");
          $update_stok2 = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_baik = jumlah_baik - 1 WHERE id_barang = '$id_barang'");
          if ($update_stok1 and $update_stok2) {
            $_SESSION['sukses'] = true;
            $_SESSION['msg'] = 'Berhasil Menambahkan Peminjaman';
            add_log('NULL', $_SESSION['id_pj'], "Menambahkan Peminjaman ". $id_user);
            header('location:data-peminjaman.php');
            exit();
          } else {
            $_SESSION['gagal'] = true;
            $_SESSION['msg'] = 'Gagal Menambahkan Data';
            header('location:data-peminjaman.php');
            exit();
          }
        } else {
          $_SESSION['gagal'] = true;
          $_SESSION['msg'] = 'Gagal Menambahkan Peminjaman';
          header('location:data-peminjaman.php');
          exit();
        }
      }else{
        echo "<script>alert('Peminjaman tidak dapat dilakukan karena stok barang baik tidak ada!');</script>";
      }
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
              <h1 class="m-0">Data Peminjaman</h1>
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
                      <input type="text" class="form-control" id="ketua_lab" value="<?= $_SESSION['nama_pj'] ?>"
                        readonly>
                    </div>
                    <div class="form-group">
                      <label>Nama Peminjam</label>
                      <small class="text-muted">Identitas - Nama</small>
                      <select name="nama_peminjam" class="form-control select2bs4" style="width: 100%;">
                        <option value="">Pilih Peminjam</option>
                        <?php foreach ($data_users as $data_user) : ?>
                        <option value="<?= $data_user['id_user'] ?>"><?= $data_user['ni_user'] ?> -
                          <?= $data_user['nama_user'] ?> - <?= $data_user['role_user'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nama Barang</label>
                      <select name="nama_barang" class="form-control select2bs4" style="width: 100%;">
                        <option value="">Pilih Barang</option>
                        <?php foreach ($data_barangs as $data_barang) : ?>
                        <option value="<?= $data_barang['id_barang'] ?>"><?= $data_barang['nama_barang'] ?> -
                          <?= $data_barang['stok_barang'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="tgl_pinjam">Tanggal Pinjam</label>
                          <input name="tgl_pinjam" type="date" class="form-control" id="tgl_pinjam" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="tgl_kembali">Tanggal Kembali</label>
                          <input name="tanggal_kembali" type="date" class="form-control" id="tgl_kembali">
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