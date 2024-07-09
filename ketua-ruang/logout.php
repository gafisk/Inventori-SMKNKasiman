<?php
session_start();
include('../config/config.php');
add_log('NULL', $_SESSION['id_pj'], "Ketua Ruang Logout");
session_unset();
session_destroy();
header("Location:../index.php");
exit();