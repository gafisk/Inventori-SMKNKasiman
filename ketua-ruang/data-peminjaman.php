<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_pj']) || empty($_SESSION['id_pj'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}
$id_pj = $_SESSION['id_pj'];
$data_pj = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang using(id_ruangbarang) WHERE id_pj = '$id_pj'"));
$id_ruangbarang = $data_pj['id_ruangbarang'];

$data_peminjamans = mysqli_query($conn, "SELECT * FROM peminjaman INNER JOIN pj_ruang USING(id_pj) INNER JOIN barang USING(id_barang) INNER JOIN users USING(id_user) WHERE barang.id_ruangbarang = '$id_ruangbarang' AND status_peminjaman = 'Pinjam'");

if (isset($_GET['kembali'])) {
  $id_peminjaman = mysqli_escape_string($conn, $_GET['kembali']);
  $data_pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'"));
  $b_tgl_pinjam = $data_pinjam['tanggal_pinjam'];
  $id_barang = $data_pinjam['id_barang'];
  $update_stok = mysqli_query($conn, "UPDATE barang SET stok_barang = stok_barang + 1 WHERE id_barang = '$id_barang'");
  if ($update_stok) {
    $update_peminjaman = mysqli_query($conn, "UPDATE peminjaman SET status_peminjaman = 'Kembali' WHERE id_peminjaman = '$id_peminjaman'");
    if ($update_peminjaman) {
      $add_pengembalian = mysqli_query($conn, "INSERT INTO pengembalian (id_peminjaman, id_pj, tanggal_pinjam, tanggal_kembali) VALUES ('$id_peminjaman', '$id_pj', '$b_tgl_pinjam', NOW())");
      if ($add_pengembalian) {
        $_SESSION['sukses'] = true;
        $_SESSION['msg'] = "Berhasil Mengembalikan Barang";
        add_log('NULL', $_SESSION['id_pj'], $id_peminjaman . " Dikemebalikan");
        header('location: data-peminjaman.php');
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
          <?php if (isset($_SESSION['sukses']) && $_SESSION['sukses']) : ?>
          <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
            <strong>Sukses</strong> <?= $_SESSION['msg'] ?>.
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
            <strong>Sukses</strong> <?= $_SESSION['msg'] ?>.
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
            <strong>Gagal</strong> <?= $_SESSION['msg'] ?>.
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
                  <h3 class="card-title">Data Peminjaman</h3>
                  <a href="tambah-peminjaman.php" class="btn btn-primary ml-auto"> + Tambah Peminjaman</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="datatables" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th style="width: 11%;">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data_peminjamans as $data_p) : ?>
                      <tr>
                        <td><?= $data_p['ni_user'] ?></td>
                        <td><?= $data_p['nama_user'] ?></td>
                        <td><?= $data_p['nama_barang'] ?></td>
                        <td><?= $data_p['tanggal_pinjam'] ?></td>
                        <td><?= $data_p['tanggal_kembali'] ?></td>
                        <td>
                          <a href="?kembali=<?= $data_p['id_peminjaman'] ?>"
                            onclick="return confirm('Apakah barang sudah dikembalikan?')"
                            class="btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                          <a href="edit-peminjaman.php?edit=<?= $data_p['id_peminjaman'] ?>"
                            class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                          <a href="?hapus=<?= $data_p['id_peminjaman'] ?>" class="btn btn-sm btn-danger"><i
                              class="fas fa-trash-alt"></i></a>
                        </td>
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Identitas Peminjam</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Aksi</th>
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