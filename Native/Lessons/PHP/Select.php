<?php
define("SERVER","localhost");
define("USERNAME","root");
define("PASSWORD","");
define("DATABASE","organisasi");

$conn=mysqli_connect(SERVER,USERNAME,PASSWORD,DATABASE);

if(mysqli_connect_errno()){
    echo "koneksi gagal";
}

$username="aha";
$email="ahahahaha@gmail.com";
$cek_user="SELECT * FROM user WHERE username='$username'";
$cek_email="SELECT * FROM user WHERE email='$email'";

$user_row=mysqli_num_row(mysqli_query($conn,$cek_user));
$email_row=mysqli_num_row(mysqli_query($conn,$cek_email));

// $user_row=mysqli_num_rows(mysqli_query($conn,$cek_user));
// $email_row=mysqli_num_rows(mysqli_query($conn,$cek_user));

if($user_row>0){
    echo "Username already exist <br>";
}
else{
    echo "Username granted <br>";
}

if($email_row>0){
    echo "Email already exist <br>";
}
else{
    echo "Email granted <br>";
}
?>