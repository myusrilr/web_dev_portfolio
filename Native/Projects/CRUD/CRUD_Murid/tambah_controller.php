<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nis=$_POST['nis'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO murid VALUES('','$nama','$nis','$alamat')");

header("location:index.php");

?>