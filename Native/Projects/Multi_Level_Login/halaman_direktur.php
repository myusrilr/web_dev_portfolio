<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    session_start();


    if($_SESSION['level']==""){
        header("location:index.php?pesan=gagal")
    }


    ?>
    <h1>SELAMAT DATANG ANDA LOGIN SEBAGAI DIREKTUR</h1>
</body>
</html>