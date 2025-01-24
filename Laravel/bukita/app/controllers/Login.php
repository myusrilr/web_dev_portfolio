<?php
class Login extends Controller
{
    public function index()
    {
        $data['title'] = 'Halaman Login';
        $this->view('login/login', $data);
    }
    public function prosesLogin()
    {
        if ($row = $this->model('LoginModel')->checkLogin($_POST) > 0) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['session_login'] = 'sudah_login';
            header('location: ' . BASE_URL . '/home');
        } else {
            Flasher::setMessage('Username / Password', 'salah.', 'danger');
            header('location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
