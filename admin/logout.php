<?php
session_start();
include('../config/config.php');
add_log($_SESSION['id_admin'], 'NULL', "ADMIN Logout");
session_unset();
session_destroy();
header("Location:../index.php");
exit();