<?php
include 'connect.php';

if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    // Periksa apakah email sudah terdaftar
    $checkEmail = "SELECT * FROM main WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Alert jika email sudah terdaftar
        echo "<script>alert('Email sudah terdaftar!');
        window.location.href='signup.php'</script>";
        exit;
    } else {
        // Hitung jumlah user yang ada di tabel main dengan hak_akses 'user'
        $userCountQuery = "SELECT COUNT(*) AS user_count FROM main WHERE hak_akses='user'";
        $userCountResult = $conn->query($userCountQuery);
        $userCountRow = $userCountResult->fetch_assoc();
        $userCount = $userCountRow['user_count'] + 1; // Increment untuk user baru

        // Menambahkan nilai default 'user' pada kolom hak_akses
        $insertQuery = "INSERT INTO main(username, email, password, hak_akses) 
                        VALUES ('$username', '$email', '$password', 'user')";

        if ($conn->query($insertQuery) === TRUE) {
            // Mendapatkan ID pengguna yang baru saja ditambahkan
            $userId = $conn->insert_id;

            // Membuat nama tabel unik berdasarkan urutan user
            $tableName = 'user' . $userCount;

            // Membuat tabel baru untuk pengguna dengan default status 'belum'
            $createTableQuery = "CREATE TABLE $tableName (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255),
                tugas VARCHAR(255),
                tahapan VARCHAR(255) DEFAULT 'belum',
                waktu DATETIME,
                catatan TEXT
            )";

            if ($conn->query($createTableQuery) === TRUE) {
                echo "<script>alert('Registrasi berhasil!');
                window.location.href='index.php'</script>";
                exit();
            } else {
                echo "<script>alert('Error saat membuat tabel tugas pengguna: " . $conn->error . "');
                window.location.href='signup.php'</script>";
                exit();
            }
        } else {
            echo "<script>alert('Error: " . $conn->error . "');
            window.location.href='signup.php'</script>";
            exit();
        }
    }
}

if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM main WHERE username='$username' and password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        echo "<script>alert('Login berhasil!');
        window.location.href='homepage.php'</script>";
        exit();
    } else {
        echo "<script>alert('Not Found, Incorrect username or Password');
        window.location.href='index.php'</script>";
        exit();
    }
}
