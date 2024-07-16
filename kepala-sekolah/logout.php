<?php
session_start();
session_unset(); // Hapus semua variabel sesi
session_destroy(); // Hancurkan sesi
echo '<script>alert("Anda telah logout. Redirecting..."); window.location.href="../index.php";</script>';
exit();