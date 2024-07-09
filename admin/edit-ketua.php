<?php
session_start();
include('../config/config.php');
if (!isset($_SESSION['id_admin']) || empty($_SESSION['id_admin'])) {
  echo '<script>alert("Silahkan Login Dahulu"); window.location.href="login.php";</script>';
  exit();
}

$pj_ruang = mysqli_query($conn, "SELECT * FROM pj_ruang");
$ruang_barangs = mysqli_query($conn, "SELECT * FROM ruang_barang");
$used_ids = [];
while ($row = mysqli_fetch_assoc($pj_ruang)) {
  $used_ids[] = $row['id_ruangbarang'];
}

if (isset($_GET['edit'])) {
  $id_pj = mysqli_escape_string($conn, $_GET['edit']);
  $datas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang WHERE id_pj = '$id_pj'"));
  if (isset($_POST['submit'])) {
    $data = [
      'nama_pj' => $_POST['nama_pj'],
      'jk_pj' => $_POST['jk_pj'],
      'telp_pj' => $_POST['telp_pj'],
      'alamat_pj' => $_POST['alamat_pj'],
    ];
    $condition = [
      'id_pj' => $id_pj,
    ];
    if (!input_check($data)) {
      echo "<script>alert('Semua kolom inputan tidak boleh kosong atau berisi spasi saja!');</script>";
    } else {
      add_log($_SESSION['id_admin'], 'NULL', "Mengedit Informasi " . $datas['nama_pj']);
      update('pj_ruang', $data, $condition);
      header('location:daftar-ketua.php');
      exit();
    }
  };
};

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
              <h1 class="m-0">Edit Data Ketua Ruangan</h1>
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
                  <h3 class="card-title">Data Ketua Ruangan</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_pj">Nama Ketua Ruangan</label>
                      <input type="text" class="form-control" id="nama_pj" name="nama_pj"
                        value="<?= $datas['nama_pj'] ?>" placeholder="Nama Ketua Ruangan...">
                    </div>
                    <div class="form-group">
                      <label>Jenis Kelamin Ketua Ruangan</label>
                      <select class="form-control" name="jk_pj">
                        <option <?= ($datas['jk_pj'] == 'Laki-laki') ? "selected" : "" ?> value="Laki-laki">Laki -
                          Laki</option>
                        <option <?= ($datas['jk_pj'] == 'Perempuan') ? "selected" : "" ?> value="Perempuan">Perempuan
                        </option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="telp_pj">No Telp Ketua Ruangan</label>
                      <input type="text" name="telp_pj" class="form-control" id="telp_pj"
                        value="<?= $datas['telp_pj'] ?>" placeholder="No Telp Ketua Ruangan">
                    </div>
                    <div class="form-group">
                      <label for="alamat_pj">Alamat Ketua Ruangan</label>
                      <textarea class="form-control" name="alamat_pj" id="alamat_pj"
                        rows="3"><?= $datas['alamat_pj'] ?></textarea>
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