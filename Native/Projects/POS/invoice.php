<?php


include 'koneksi.php';
$jumlah=$_GET['jumlah'];


$getVal="SELECT * FROM barang WHERE no=1";
$row=