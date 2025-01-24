<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$nir=$_POST['nir'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"UPDATE rakyat SET nama='$nama',nir='$nir',alamat='$alamat' WHERE id='$id' ");
header("location:index.php");


?>