<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];
$data_pj = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang using(id_ruangbarang) WHERE id_pj = '$id_pj'"));

if (isset($_GET['edit'])) {
  $id_barang = mysqli_escape_string($conn, $_GET['edit']);
  $data_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang INNER JOIN keadaan_barang USING(id_barang) WHERE barang.id_barang = '$id_barang'"));
  if (isset($_POST['submit'])) {
    $id_ruangbarang = $data_pj['id_ruangbarang'];
    $nama_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
    $stok_barang = mysqli_escape_string($conn, $_POST['stok_barang']);
    $status_barang = mysqli_escape_string($conn, $_POST['status_barang']);
    $jumlah_baik = mysqli_escape_string($conn, $_POST['jumlah_baik']);
    $jumlah_rusak = mysqli_escape_string($conn, $_POST['jumlah_rusak']);
    if (empty($nama_barang) || empty($stok_barang) || empty($status_barang)) {
      echo "<script>alert('Kolom Inputan Data Barang Tidak Boleh Kosong!');</script>";
    } else {
      $query = mysqli_query($conn, "UPDATE barang SET nama_barang = '$nama_barang', stok_barang = '$stok_barang', status_barang = '$status_barang' WHERE id_barang = '$id_barang'");
      if ($query) {
        $update_keadaan = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_baik = '$jumlah_baik', jumlah_rusak = '$jumlah_rusak' WHERE id_barang = '$id_barang'");
        if ($update_keadaan) {
          $_SESSION['sukses'] = true;
          $_SESSION['msg'] = "Data Berhasil Diperbaharui";
          header('location:daftar-barang.php');
          exit();
        } else {
          $_SESSION['gagal'] = true;
          $_SESSION['msg'] = "Data Gagal Diperbaharui";
          header('location:daftar-barang.php');
          exit();
        }
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Data Gagal Diperbaharui";
        header('location:daftar-barang.php');
        exit();
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
              <h1 class="m-0">Edit Data Barang</h1>
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
                  <h3 class="card-title">Data Barang</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_lab">Nama Lab</label>
                      <input type="text" class="form-control" id="nama_lab" value="<?= $data_pj['nama_ruangbarang'] ?>"
                        readonly>
                    </div>
                    <div class="form-group">
                      <label for="nama_barang">Nama Barang</label>
                      <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                        placeholder="Nama Barang..." value="<?= $data_barang['nama_barang'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="stok_barang">Stok Barang</label>
                      <input type="number" name="stok_barang" class="form-control" id="stok_barang"
                        placeholder="Tahun Terbit Buku" value="<?= $data_barang['stok_barang'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Status Barang</label>
                      <select class="form-control" name="status_barang">
                        <option <?= ($data_barang['status_barang'] == 'Tetap') ? 'selected' : '' ?> value="Tetap">Barang
                          Tetap</option>
                        <option <?= ($data_barang['status_barang'] == 'Pakai') ? 'selected' : '' ?> value="Pakai">Barang
                          Habis Pakai</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="jumlah_baik">Jumlah Baik</label>
                      <input type="number" name="jumlah_baik" class="form-control" id="jumlah_baik"
                        placeholder="Jumlah Barang Baik" value="<?= $data_barang['jumlah_baik'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="jumlah_rusak">Jumlah Rusak</label>
                      <input type="number" name="jumlah_rusak" class="form-control" id="jumlah_rusak"
                        placeholder="Jumlah Barang Rusak" value="<?= $data_barang['jumlah_rusak'] ?>">
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

<script>
document.querySelector('form').addEventListener('submit', function(event) {
  var stokBarang = parseInt(document.getElementById('stok_barang').value);
  var jumlahBaik = parseInt(document.getElementById('jumlah_baik').value);
  var jumlahRusak = parseInt(document.getElementById('jumlah_rusak').value);

  if (jumlahBaik + jumlahRusak != stokBarang) {
    event.preventDefault(); // Mencegah pengiriman form
    alert('Jumlah barang baik dan rusak harus sama dengan stock barang.');
  }
});
</script>

</html>