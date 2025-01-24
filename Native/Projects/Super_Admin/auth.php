<?php
session_start();

include 'koneksi.php';

$username=$_POST['username'];
$password=$_POST['password'];
$level=$_POST['level'];

$data=mysqli_query($koneksi,"SELECT * FROM superadmin WHERE username='$username' and password='$password' and level='$level'");
$cek=mysqli_num_rows($data);

if($cek>0){
    $dataArray=mysqli_fetch_assoc($data);
    if($dataArray['level']=="superadmin"){
        $_SESSION['username']=$username;
        $_SESSION['level']="superadmin";
        header("location:halaman_admin.php");
    }else {
        header("location:index.php?pesan=gagal");
    }

}else{
    header("location:index.php?pesan=gagal");
}



?>