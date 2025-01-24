<?php
include 'koneksi.php';

$id=$_GET['id'];

mysqli_query($koneksi,"DELETE FROM pekerja WHERE id=$id");
header("location:index.php");

?>