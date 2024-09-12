<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="../login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];
$data_pj = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang using(id_ruangbarang) WHERE id_pj = '$id_pj'"));

if (isset($_GET['edit'])) {
  // get id barang from query string
  $id_barang = mysqli_escape_string($conn, rawurldecode($_GET['edit']));
  $data_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang_details WHERE kode_barang = '$id_barang'"));
  if (isset($_POST['submit'])) {
    $id_ruangbarang = $data_pj['id_ruangbarang'];
    $nama_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
    $harga_barang = mysqli_escape_string($conn, $_POST['harga']);
    $status_barang = mysqli_escape_string($conn, $_POST['status_barang']);
    $spesifikasi = mysqli_escape_string($conn, $_POST['spesifikasi_barang']);
    if (empty($nama_barang) || empty($harga_barang)) {
      echo "<script>alert('Kolom Inputan Data Barang Tidak Boleh Kosong!');</script>";
    } else {
      $query = mysqli_query($conn, "UPDATE barang_details SET nama = '$nama_barang', harga = '$harga_barang', spesifikasi = '$spesifikasi' WHERE kode_barang = '$id_barang'");
      if ($query) {
        $_SESSION['sukses'] = true;
        $_SESSION['msg'] = "Data Berhasil Diperbaharui";
        add_log('NULL', $_SESSION['id_pj'], "Mengedit Barang " . $id_barang);
        header('location:daftar-satuan-barang.php');
        exit();
      } else {
        $_SESSION['gagal'] = true;
        $_SESSION['msg'] = "Data Gagal Diperbaharui";
        header('location:daftar-satuan-barang.php');
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
                        placeholder="Nama Barang..." value="<?= $data_barang['nama'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="harga">Harga</label>
                      <input type="number" name="harga" class="form-control" id="harga"
                        placeholder="Harga Barang" value="<?= $data_barang['harga'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Status Barang</label>
                      <select class="form-control" name="status_barang">
                        <option <?= ($data_barang['status_barang'] == 'Baik') ? 'selected' : '' ?> value="Baik">Barang Baik</option>
                        <option <?= ($data_barang['status_barang'] == 'Rusak') ? 'selected' : '' ?> value="Rusak">Barang Rusak</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="spesifikasi_barang">Spesifikasi Barang</label>
                      <textarea class="form-control" name="spesifikasi_barang" id="spesifikasi_barang" rows="5"
                        placeholder="Spesifikasi Barang..."><?= $data_barang['spesifikasi'] ?></textarea>
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