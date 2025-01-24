<?php
session_start();
include 'db.php'; // Koneksi ke database

// Cek apakah form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_id = $_POST['file_id']; // ID file
    $username = $_POST['username']; // Input dari pengguna
    $password = $_POST['password']; // Input dari pengguna

    // Ambil data pengguna dari tabel users
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password (gunakan password_hash di production)
        if (password_verify($password, $user['password'])) {
            $user_account_type = $user['account_type']; // Dapatkan tipe akun pengguna

            // Ambil data file dari tabel files
            $file_stmt = $conn->prepare("SELECT * FROM files WHERE id = ?");
            $file_stmt->bind_param('i', $file_id);
            $file_stmt->execute();
            $file_result = $file_stmt->get_result();

            if ($file_result->num_rows > 0) {
                $file = $file_result->fetch_assoc();
                $file_type = $file['account_type']; // Level akses file
                $file_path = $file['file_path']; // Lokasi file yang akan dihapus

                // Cek apakah pengguna dapat menghapus file berdasarkan tipe akun mereka
                if ($user_account_type === 'public' && $file_type === 'public') {
                    // Hapus file fisik
                    if (file_exists($file_path)) {
                        unlink($file_path); // Hapus file dari direktori
                    }

                    // Update status visibilitas di database ke 'deleted'
                    $update_stmt = $conn->prepare("UPDATE files SET document_status = 'deleted' WHERE id = ?");
                    $update_stmt->bind_param('i', $file_id);
                    if ($update_stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Berkas berhasil dihapus!']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error saat mengubah status berkas.']);
                    }

                } elseif ($user_account_type === 'public' && $file_type !== 'public') {
                    echo json_encode(['success' => false, 'message' => 'Maaf, akun Anda bersifat umum dan tidak bisa menghapus berkas ini!']);
                } elseif ($user_account_type === 'private' && ($file_type === 'public' || $file_type === 'private')) {
                    // Hapus file fisik dan update status
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $update_stmt = $conn->prepare("UPDATE files SET document_status = 'deleted' WHERE id = ?");
                    $update_stmt->bind_param('i', $file_id);
                    if ($update_stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Berkas berhasil dihapus!']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error saat mengubah status berkas.']);
                    }
                } elseif ($user_account_type === 'protected') {
                    // Hapus file fisik dan update status (protected bisa hapus semua file)
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    $update_stmt = $conn->prepare("UPDATE files SET document_status = 'deleted' WHERE id = ?");
                    $update_stmt->bind_param('i', $file_id);
                    if ($update_stmt->execute()) {
                        echo json_encode(['success' => true, 'message' => 'Berkas berhasil dihapus!']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error saat mengubah status berkas.']);
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Berkas tidak ditemukan!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Maaf, kata sandi Anda salah!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Maaf, pengguna tidak ditemukan!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Metode tidak valid.']);
}

$conn->close();
