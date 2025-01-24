<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$nio=$_POST['nio'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"UPDATE orang SET nama='$nama',nio='$nio',alamat='$alamat' WHERE id='$id' ");
header("location:index.php");


?>