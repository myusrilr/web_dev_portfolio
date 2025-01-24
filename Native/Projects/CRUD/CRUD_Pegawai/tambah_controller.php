<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nip=$_POST['nip'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO pegawai VALUES('','$nama','$nip','$alamat')");

header("location:index.php");

?>