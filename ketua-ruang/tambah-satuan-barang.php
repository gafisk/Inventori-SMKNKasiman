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
$parent_kode_barang = mysqli_query($conn, "SELECT kode_barang, nama_barang FROM barang WHERE id_ruangbarang = '$id_ruangbarang'");

if (isset($_POST['submit'])) {
  $id_ruangbarang = $data_pj['id_ruangbarang'];
  $data1 = [
    'id_ruangbarang' => $id_ruangbarang,
    'nama' => $_POST['nama_barang'],
    'harga' => $_POST['harga_barang'],
    'status_barang' => $_POST['status_barang'],
    'spesifikasi' => $_POST['spesifikasi_barang'],
  ];

  if (!input_check($data1)) {
    echo "<script>alert('Semua kolom inputan tidak boleh kosong atau berisi spasi saja!');</script>";
  } else {
    $kode_barang = mysqli_escape_string($conn, $_POST['kode_barang']);
    $idbarang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE kode_barang = '$kode_barang'"));
    $last_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang_details WHERE kode_barang LIKE '$kode_barang%' ORDER BY kode_barang DESC LIMIT 1"));
    if (empty($last_data)) {
      $new_kode = $kode_barang . "-001";
      $data = [
        'kode_barang' => $new_kode,
        'id_ruangbarang' => $id_ruangbarang,
        'nama' => $_POST['nama_barang'],
        'harga' => $_POST['harga_barang'],
        'status_barang' => $_POST['status_barang'],
        'spesifikasi' => $_POST['spesifikasi_barang'],
      ];
      insert('barang_details', $data);
      $count_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang_details WHERE kode_barang LIKE '$kode_barang%'"));
      $query = mysqli_query($conn, "UPDATE barang SET stok_barang = '$count_data' WHERE kode_barang = '$kode_barang'");
      if ($_POST['status_barang'] === 'Baik') {
        $countbaik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_baik FROM `keadaan_barang` WHERE id_barang = '$idbarang[id_barang]'"));
        $countdata = $countbaik['jumlah_baik'] + 1;
        $queryupdstatus = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_baik = '$countdata' WHERE id_barang = '$idbarang[id_barang]'");
        add_log('NULL', $_SESSION['id_pj'], "Menambahkan Barang " . $_POST['nama_barang']);
        header('location:daftar-barang.php');
        exit();
      } else {
        $countrusak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_rusak FROM `keadaan_barang` WHERE id_barang = '$idbarang[id_barang]'"));
        $countdata = $countrusak['jumlah_rusak'] + 1;
        $queryupdstatus = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_rusak = '$countdata' WHERE id_barang = '$idbarang[id_barang]'");
        add_log('NULL', $_SESSION['id_pj'], "Menambahkan Barang " . $_POST['nama_barang']);
        header('location:daftar-barang.php');
        exit();
      }
    } else {
      $last_kode = $last_data['kode_barang'];
      $last_number = explode("-", $last_kode)[1];
      $new_number = str_pad((int)$last_number + 1, 3, "0", STR_PAD_LEFT);
      $new_kode = $kode_barang . "-" . $new_number;
      $data = [
        'kode_barang' => $new_kode,
        'id_ruangbarang' => $id_ruangbarang,
        'nama' => $_POST['nama_barang'],
        'harga' => $_POST['harga_barang'],
        'status_barang' => $_POST['status_barang'],
        'spesifikasi' => $_POST['spesifikasi_barang'],
      ];
      insert('barang_details', $data);
      $count_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang_details WHERE kode_barang LIKE '$kode_barang%'"));
      $query = mysqli_query($conn, "UPDATE barang SET stok_barang = '$count_data' WHERE kode_barang = '$kode_barang'");
      if ($_POST['status_barang'] === 'Baik') {
        $countbaik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_baik FROM `keadaan_barang` WHERE id_barang = '$idbarang[id_barang]'"));
        $countdata = $countbaik['jumlah_baik'] + 1;
        $queryupdstatus = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_baik = '$countdata' WHERE id_barang = '$idbarang[id_barang]'");
        add_log('NULL', $_SESSION['id_pj'], "Menambahkan Barang " . $_POST['nama_barang']);
        header('location:daftar-satuan-barang.php');
        exit();
      } else {
        $countrusak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT jumlah_rusak FROM `keadaan_barang` WHERE id_barang = '$idbarang[id_barang]'"));
        $countdata = $countrusak['jumlah_rusak'] + 1;
        $queryupdstatus = mysqli_query($conn, "UPDATE keadaan_barang SET jumlah_rusak = '$countdata' WHERE id_barang = '$idbarang[id_barang]'");
        add_log('NULL', $_SESSION['id_pj'], "Menambahkan Barang " . $_POST['nama_barang']);
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
              <h1 class="m-0">Tambah Satuan Barang</h1>
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
                  <h3 class="card-title">Data Satuan Barang</h3>
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
                      <label>Category Barang</label>
                      <select class="form-control" name="kode_barang">
                        <?php
                        foreach ($parent_kode_barang as $data) {
                        ?>
                          <option value="<?= $data['kode_barang'] ?>"><?= $data['kode_barang'] . " - " . $data['nama_barang'] ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nama_barang">Nama Barang</label>
                      <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                        placeholder="Nama Barang...">
                    </div>
                    <div class="form-group">
                      <label for="harga_barang">Harga Barang</label>
                      <input type="number" name="harga_barang" class="form-control" id="harga_barang"
                        placeholder="harga barang">
                    </div>
                    <div class="form-group">
                      <label>Status Barang</label>
                      <select class="form-control" name="status_barang">
                        <option value="Baik">Barang Baik</option>
                        <option value="Rusak">Barang Rusak</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="spesifikasi_barang">Spesifikasi Barang</label>
                      <textarea class="form-control" name="spesifikasi_barang" id="spesifikasi_barang" rows="5"
                        placeholder="Spesifikasi Barang..."></textarea>
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