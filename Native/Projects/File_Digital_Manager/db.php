<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'digital_file_manager';

// Membuat koneksi ke database
$conn = new mysqli($server, $username, $password, $database);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
