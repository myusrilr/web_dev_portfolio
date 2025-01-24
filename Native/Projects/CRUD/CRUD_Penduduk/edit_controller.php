<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$nik=$_POST['nik'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"UPDATE penduduk SET nama='$nama',nik='$nik',alamat='$alamat' WHERE id='$id' ");
header("location:index.php");


?>