<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nim=$_POST['nis'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO manusia VALUES('','$nama','$nis','$alamat')");

header("location:index.php");

?>