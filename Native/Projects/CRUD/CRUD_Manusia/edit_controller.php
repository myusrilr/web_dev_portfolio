<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$nis=$_POST['nis'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"UPDATE manusia SET nama='$nama',nis='$nis',alamat='$alamat' WHERE id='$id' ");
header("location:index.php");


?>