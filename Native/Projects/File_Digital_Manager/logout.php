<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php"); // Arahkan ke halaman login setelah logout
exit();
?>
