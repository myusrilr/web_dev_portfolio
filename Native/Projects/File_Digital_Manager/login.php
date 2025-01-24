<?php
session_start();
include 'db.php'; // Hubungkan ke database

if (isset($_POST['login'])) {
    $username = $_POST['username']; // Input username (email)
    $password = $_POST['password'];

    // Pastikan account_type dikirim dalam form
    if (!isset($_POST['account_type']) || empty($_POST['account_type'])) {
        echo "<script>alert('Maaf, tipe akun tidak dipilih!');
        window.location.href='index.php';</script>";
        exit();
    }

    $account_type = $_POST['account_type']; // Ambil input account_type dari form

    // Query untuk mendapatkan data pengguna berdasarkan username (email)
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password (disarankan menggunakan password_hash di produksi)
        if ($user['password'] === $password) {
            // Verifikasi account_type
            if ($user['account_type'] === $account_type) {
                // Simpan username/email dan account_type ke dalam session
                $_SESSION['username'] = $user['username'];
                $_SESSION['account_type'] = $user['account_type'];

                // Popup alert sukses dan redirect ke dashboard
                echo "<script>alert('Selamat, anda bisa masuk dengan akun {$user['account_type']}!');
                window.location.href='dashboard.php';</script>";
                exit();
            } else {
                // Jika account_type tidak sesuai
                echo "<script>alert('Maaf, hak akses anda tidak sesuai!');
                window.location.href='index.php';</script>";
            }
        } else {
            // Jika password salah
            echo "<script>alert('Maaf, password anda salah!');
            window.location.href='index.php';</script>";
        }
    } else {
        // Jika username salah
        echo "<script>alert('Maaf, username anda salah!');
        window.location.href='index.php';</script>";
    }
}
