<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nik=$_POST['nik'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO penduduk VALUES('','$nama','$nik','$alamat')");

header("location:index.php");

?>