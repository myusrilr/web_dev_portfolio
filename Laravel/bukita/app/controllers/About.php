<?php class About extends Controller
{
    public function __construct()
    {
        if ($_SESSION['session_login'] != 'sudah_login') {
            Flasher::setMessage('Login', 'Tidak ditemukan.', 'danger');
            header('location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Halaman About Me';
        $data['nama'] = 'Yusril';
        $data['alamat'] = 'Malang';
        $data['no_hp'] = '082148867999';

        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('about/index', $data);
        $this->view('templates/footer');
    }
}
