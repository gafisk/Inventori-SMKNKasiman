<?php
include('config/config.php');
if (isset($_POST['submit'])) {
    $id = mysqli_escape_string($conn, $_POST['identitas']);
    $datas = mysqli_query($conn, "SELECT COALESCE(pengembalian.tanggal_kembali, '-') AS tanggal_serah, 
       peminjaman.*, 
       users.*, 
       pj_ruang.*, 
       barang.*, 
       ruang_barang.*
FROM peminjaman
INNER JOIN users ON peminjaman.id_user = users.id_user
INNER JOIN pj_ruang ON peminjaman.id_pj = pj_ruang.id_pj
INNER JOIN barang ON peminjaman.id_barang = barang.id_barang
INNER JOIN ruang_barang ON pj_ruang.id_ruangbarang = ruang_barang.id_ruangbarang
LEFT JOIN pengembalian ON peminjaman.id_peminjaman = pengembalian.id_peminjaman
WHERE users.ni_user = '$id'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Inventori SMKN Kasiman</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicon -->
  <link href="assets_index/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="assets_index/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="assets_index/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar Start -->
  <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-lg-5">
      <a href="index.php" class="navbar-brand ml-lg-6">
        <h1 class="m-0 display-5 text-uppercase text-primary">SMKN KASIMAN</h1>
      </a>
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between px-lg-6" id="navbarCollapse">
        <div class="navbar-nav m-auto py-0">
          <a href="#" class="nav-item nav-link active">Home</a>
          <a href="#peminjaman" class="nav-item nav-link">Cek Peminjaman</a>
          <a href="#footer" class="nav-item nav-link">Contact</a>
        </div>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->


  <!-- Header Start -->
  <div class="jumbotron jumbotron-fluid mb-5">
    <div class="container text-center py-5">
      <h1 class="text-primary mb-4">INVENTORI</h1>
      <h1 class="text-white display-3 mb-5">SMKN KASIMAN</h1>
      <div class="mx-auto" style="width: 100%; max-width: 600px;">
        <form method="POST" action="">
          <div class="input-group">
            <input type="text" name="identitas" class="form-control border-light" style="padding: 30px;"
              placeholder="Nomor Identitas">
            <div class="input-group-append">
              <input type="submit" name="submit" class="btn btn-primary px-3" value="Cek Peminjaman"></input>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Header End -->

  <!-- Team Start -->
  <div class="container-fluid pt-5" id="peminjaman">
    <div class="container">
      <div class="text-center pb-2">
        <h1 class="mb-4">Cek Peminjaman</h1>
      </div>
      <div class="row">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Identitas</th>
                <th scope="col">Nama Peminjam</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Nama Tempat</th>
                <th scope="col">Tanggal Pinjam</th>
                <th scope="col">Jatuh Tempo</th>
                <th scope="col">Tanggal Serah</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($datas)) : ?>
              <tr>
                <td colspan="9">Data tidak ada</td>
              </tr>
              <?php else : ?>
              <?php $no = 1; ?>
              <?php foreach ($datas as $data) : ?>
              <tr>
                <th scope="row"><?= $no ?></th>
                <td><?= $data['ni_user'] ?></td>
                <td><?= $data['nama_user'] ?></td>
                <td><?= $data['nama_barang'] ?></td>
                <td><?= $data['nama_ruangbarang'] ?></td>
                <td><?= $data['tanggal_pinjam'] ?></td>
                <td><?= $data['tanggal_kembali'] ?></td>
                <td><?= $data['tanggal_serah'] ?></td>
                <td><?= $data['status_peminjaman'] ?></td>
              </tr>
              <?php $no += 1; ?>
              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Team End -->

  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-white mt-5 py-5 px-sm-3 px-md-5" id="footer">
    <div class="row pt-5">
      <div class="col-lg-7 col-md-12">
        <div class="row">
          <div class="col-md-12 mb-5">
            <h3 class="text-primary mb-4">Contact</h3>
            <p><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
            <p><i class="fa fa-phone-alt mr-2"></i>+62 856 4811 4 354 </p>
            <p><i class="fa fa-envelope mr-2"></i>humas@smknkasiman.sch.id</p>
            <div class="d-flex justify-content-start mt-4">
              <a class="btn btn-outline-light btn-social mr-2" href="http://smknkasiman.sch.id/"><i
                  class="fas fa-globe"></i></a>
              <!-- <a class="btn btn-outline-light btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
              <a class="btn btn-outline-light btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
              <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-instagram"></i></a> -->
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-lg-5 col-md-12 mb-5">
        <h3 class="text-primary mb-4">Newsletter</h3>
        <p>Rebum labore lorem dolores kasd est, et ipsum amet et at kasd, ipsum sea tempor magna tempor. Accu
          kasd sed ea duo ipsum. Dolor duo eirmod sea justo no lorem est diam</p>
        <div class="w-100">
          <div class="input-group">
            <input type="text" class="form-control border-light" style="padding: 30px;"
              placeholder="Your Email Address">
            <div class="input-group-append">
              <button class="btn btn-primary px-4">Sign Up</button>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5"
    style="border-color: #3E3E4E !important;">
    <div class="row">
      <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
        <p class="m-0 text-white">&copy; <a href="#">SMKN Kasiman</a>. All Rights Reserved. | BETA
          <!-- Designed by <a href="https://htmlcodex.com">HTML Codex</a>
          <br>Distributed By: <a href="https://themewagon.com" target="_blank">ThemeWagon</a> -->
        </p>
      </div>
    </div>
  </div>
  <!-- Footer End -->


  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="assets_index/lib/easing/easing.min.js"></script>
  <script src="assets_index/lib/waypoints/waypoints.min.js"></script>
  <script src="assets_index/lib/counterup/counterup.min.js"></script>
  <script src="assets_index/lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Contact Javascript File -->
  <script src="assets_index/mail/jqBootstrapValidation.min.js"></script>
  <script src="assets_index/mail/contact.js"></script>

  <!-- Template Javascript -->
  <script src="assets_index/js/main.js"></script>
</body>

</html>