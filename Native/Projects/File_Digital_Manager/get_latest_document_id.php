<?php
include 'db.php'; // Koneksi ke database

// Query untuk mendapatkan document_id terakhir
$query = "SELECT document_id FROM files ORDER BY document_id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo $row['document_id']; // Mengirim document_id terakhir
} else {
    echo "D-000"; // Jika tidak ada data, mulai dari D-000
}

mysqli_close($conn); // Tutup koneksi database
?>
