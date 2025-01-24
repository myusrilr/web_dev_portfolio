<?php
session_start();
include "../core/read.php";
echo "HALAMAN CEK <br>";
$username=$_POST["username"];
$password=$_POST["password"];

$read=new Read();
$cek=$read->userPassword($username,$password);
echo var_dump($cek);
if($cek==true){
    $_GET["username"]=$username;
    $_POST["status"]="granted";
    echo "user dan pass benar";
    header("location:../index.php?pesan='berhasil'");
    
    
    
}else{
    $_POST["status"]="denied";
    echo "user dan pass salah";
    header("location:index.php?pesan='gagal'");
    
}



?>