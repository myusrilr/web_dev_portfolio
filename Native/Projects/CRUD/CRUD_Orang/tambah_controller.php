<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nio=$_POST['nio'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO orang VALUES('','$nama','$nio','$alamat')");

header("location:index.php");

?>