<?php
class Logout extends Controller {
    public function index() {
        // Proses logout pengguna, misalnya menghapus sesi
        session_start();
        session_unset();
        session_destroy();

        // Redirect ke halaman login
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}