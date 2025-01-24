<?php
include 'koneksi.php';

$id=$_POST['id'];
$nama=$_POST['nama'];
$nip=$_POST['nip'];
$alamat=$_POST['alamat'];

mysqli_query($koneksi,"UPDATE pegawai SET nama='$nama',nip='$nip',alamat='$alamat' WHERE id='$id' ");
header("location:index.php");


?>