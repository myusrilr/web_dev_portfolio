<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$status=$_POST['status'];
$level=$_POST['level'];

mysqli_query($koneksi,"UPDATE user SET nama='$nama',status='$status',level='$level' WHERE id='$id' ");
header("location:halaman_admin.php");


?>