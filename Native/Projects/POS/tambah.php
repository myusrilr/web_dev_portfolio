<?php

include 'koneksi.php';

$item=$_POST['item'];
$harga=$_POST['harga'];
$quantity=$_POST['quantity'];

mysqli_query($koneksi,"UPDATE barang SET  quantity=quantity+1 WHERE 1");
header("location:index.php");
?>