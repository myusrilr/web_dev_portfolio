<?php

include 'connect.php';

if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    // $password=md5($password);

    $checkEmail = "SELECT * From users where email='$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        echo "Email Address Already Exists !";
    } else {
        $insertQuery = "INSERT INTO users(username,email,password,repassword)
                       VALUES ('$username','$email','$password')";
        if ($conn->query($insertQuery) == TRUE) {
            header("location: index.php");
        } else {
            echo "Error:" . $conn->error;
        }
    }
}
if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $password = md5($password);

    $sql = "SELECT * FROM users WHERE username='$username' and password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        header("Location: homepage.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
