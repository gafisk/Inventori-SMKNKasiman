<?php
$info_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pj_ruang INNER JOIN ruang_barang using(id_ruangbarang) WHERE id_pj = '$id_pj'"));
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
    <span class="brand-text font-weight-light">Ketua Ruangan</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 mb-3 d-flex">
      <div class="image mt-2">
        <img src="../assets/dist/img/users.png" class="img-circle elevation-2" alt="User Image" />
      </div>
      <div class="info">
        <a href="index.php" class="d-block"><?= $info_user['nama_pj'] ?></a>
        <small style="color: white;"><?= $info_user['nama_ruangbarang'] ?></small>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <?php include('layouts/navbar.php'); ?>
  </div>
  <!-- /.sidebar -->
</aside>