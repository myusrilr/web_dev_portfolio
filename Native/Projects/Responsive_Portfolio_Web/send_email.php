<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);

    // Konfigurasi email
    $to = "muhammadyusril.wit@gmail.com";
    $subject = "Pesan dari " . $name;
    $body = "Nama: $name\nEmail: $email\n\nPesan:\n$message";
    $headers = "From: $email";

    // Kirim email
    if (mail($to, $subject, $body, $headers)) {
        echo "Pesan berhasil dikirim.";
    } else {
        echo "Pesan gagal dikirim.";
    }
} else {
    echo "Metode pengiriman tidak valid.";
}
?>
