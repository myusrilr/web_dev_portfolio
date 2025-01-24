<?php
include 'koneksi.php';

$nama=$_POST['nama'];
$nir=$_POST['nir'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"INSERT INTO rakyat VALUES('','$nama','$nir','$alamat')");

header("location:index.php");

?>