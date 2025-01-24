<?php
session_start();
include 'db.php';

// Ambil data dari request POST
$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$file_id = isset($_POST['file_id']) ? $_POST['file_id'] : null;
$file_type = isset($_POST['file_type']) ? $_POST['file_type'] : null;

// Debugging: Cek apakah data diterima dengan benar
if (!$email || !$password || !$file_id || !$file_type) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    exit;
}

// Ambil data pengguna dari database berdasarkan email
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Debugging: Tampilkan data pengguna yang diterima
    // echo json_encode(['debug' => $user]);

    // Cek kecocokan password menggunakan password_verify (untuk password hashed)
    if (password_verify($password, $user['password'])) {
        $user_account_type = $user['account_type']; // Akses akun pengguna

        // Skenario pengecekan berdasarkan level akun
        if ($user_account_type == 'public') {
            if ($file_type == 'public') {
                // Berkas umum, lakukan pengarsipan
                $stmt = $conn->prepare("UPDATE files SET document_status = 'archived' WHERE id = ?");
                $stmt->bind_param('i', $file_id);
                $stmt->execute();
                echo json_encode(['success' => true, 'message' => 'Berkas berhasil diarsipkan!']);
            } elseif ($file_type == 'private') {
                echo json_encode(['success' => false, 'message' => 'Maaf, akun anda bersifat umum, jadi tidak bisa mengarsipkan berkas pribadi ini!']);
            } elseif ($file_type == 'protected') {
                echo json_encode(['success' => false, 'message' => 'Maaf, akun anda bersifat umum, jadi tidak bisa mengarsipkan berkas terproteksi ini!']);
            }
        } elseif ($user_account_type == 'private') {
            if ($file_type == 'public' || $file_type == 'private') {
                $stmt = $conn->prepare("UPDATE files SET document_status = 'archived' WHERE id = ?");
                $stmt->bind_param('i', $file_id);
                $stmt->execute();
                echo json_encode(['success' => true, 'message' => 'Berkas berhasil diarsipkan!']);
            } elseif ($file_type == 'protected') {
                echo json_encode(['success' => false, 'message' => 'Maaf, akun anda tidak bisa mengarsipkan berkas terproteksi ini!']);
            }
        } elseif ($user_account_type == 'protected') {
            // Bisa mengarsipkan semua berkas
            $stmt = $conn->prepare("UPDATE files SET document_status = 'archived' WHERE id = ?");
            $stmt->bind_param('i', $file_id);
            $stmt->execute();
            echo json_encode(['success' => true, 'message' => 'Berkas berhasil diarsipkan!']);
        }
    } else {
        // Password salah
        echo json_encode(['success' => false, 'message' => 'Maaf, kata sandi anda salah!']);
    }
} else {
    // Pengguna tidak ditemukan
    echo json_encode(['success' => false, 'message' => 'Maaf, pengguna tidak ditemukan!']);
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
