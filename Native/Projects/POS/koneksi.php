<?php
$SERVER="localhost";
$USERNAME="root";
$PASSWORD="";
$DATABASE="pos";

$koneksi=mysqli_connect($SERVER,$USERNAME,$PASSWORD,$DATABASE);

if(mysqli_connect_errno()){
    echo "koneksi gagal";
}
?>