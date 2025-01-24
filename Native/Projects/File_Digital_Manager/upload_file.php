<?php
session_start();
include 'db.php';  // Koneksi ke database

// Cek apakah form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Ambil data dari form modal unggah
    $document_id = $_POST['document_id']; // Ambil dari input hidden
    $file_name = $_POST['file_name'];
    $account_type = $_POST['account_type']; // Public, Private, Protected

    // Ambil data file yang di-upload
    $file = $_FILES['file'];
    $file_type = $file['type']; // MIME type
    $file_size = $file['size']; // Size dalam byte
    $file_tmp_name = $file['tmp_name']; // Temporary location
    $file_error = $file['error']; // Error saat upload
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Dapatkan ekstensi file

    // Tentukan folder tujuan penyimpanan file
    $upload_dir = 'Assets/Uploads/';
    $file_path = $upload_dir . basename($file['name']); // Lokasi simpan file

    // Dapatkan username pengguna dari session
    if (isset($_SESSION['username'])) {
        $uploaded_by = $_SESSION['username'];
    } else {
        die('Error: Pengguna tidak terautentikasi.');
    }

    // Tentukan status dokumen (saat ini dianggap terlihat)
    $document_status = 'viewed';

    // Dapatkan waktu sekarang sebagai waktu unggah
    $upload_time = date('Y-m-d H:i:s');

    // Validasi input
    if (empty($file_name) || empty($document_id) || empty($account_type) || $file_error !== 0) {
        die('Error: Semua field harus diisi dengan benar.');
    }

    // Batasan ukuran file (25 MB)
    if ($file_size > 25 * 1024 * 1024) {
        die('Error: Ukuran file terlalu besar. Maksimum 25 MB.');
    }

    // Pindahkan file yang diunggah ke direktori tujuan
    if (move_uploaded_file($file_tmp_name, $file_path)) {
        // Siapkan pernyataan SQL untuk memasukkan data ke dalam tabel files
        $stmt = $conn->prepare("INSERT INTO files (document_id, file_name, file_type, file_size, uploaded_by, account_type, document_status, file_path) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameter ke dalam query SQL
        $stmt->bind_param('sssiisss', $document_id, $file_name, $file_type, $file_size, $uploaded_by, $account_type, $document_status, $file_path);

        // Eksekusi query dan cek apakah berhasil
        if ($stmt->execute()) {
            // Berhasil memasukkan data ke dalam tabel files, kembali ke dashboard
            header("Location: dashboard.php?upload_success=1");
        } else {
            // Gagal memasukkan data ke dalam tabel files
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Gagal memindahkan file
        echo "Error: File gagal diunggah.";
    }
} else {
    echo "Error: Metode pengiriman tidak valid.";
}

// Tutup koneksi ke database
$conn->close();
?>
