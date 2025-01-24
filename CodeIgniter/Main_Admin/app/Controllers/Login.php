<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Login extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){     
        echo view('back/login');
    }
    
    public function proses() {
        clearstatcache();
        
        $user = strtolower(trim($this->request->getPost('email')));
        $pass = trim($this->request->getPost('pass'));
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where email = '".$user."' and status = 'Aktif';")->jml;
        if($jml > 0){
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where email = '".$user."' and pass = '".$enkrip_pass."';")->jml;
            if($jml1 > 0){
                $data = $this->model->getAllQR("select a.idusers, a.nama, a.idrole, a.email, b.nama_role, a.isteaching, a.* from users a, role b where a.idrole = b.idrole and a.email = '".$user."';");
                if($data->idrole == "R00001"){
                    // ADMIN HRD
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_hr' => TRUE,
                        'logged_karyawan' => TRUE,
                        'hr' => TRUE,
                    ]);
                    $pesan = "ok_hr";
                }else if($data->idrole == "R00004"){
                    // ADMIN PIMPINAN
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_bos' => TRUE,
                        'logged_hr' => TRUE,
                        'logged_karyawan' => TRUE,
                        'logged_busdev' => TRUE,
                        'logged_ga' => TRUE,
                        'logged_it' => TRUE,
                        'logged_pendidikan' => TRUE,
                        'bos' => TRUE,
                    ]);
                    $pesan = "ok_bos";
                }else if($data->idrole == "R00003"){
                    // ADMIN IT
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_it' => TRUE,
                        'logged_hr' => TRUE,
                        'logged_karyawan' => TRUE,
                        'it' => TRUE,
                    ]);
                    $pesan = "ok_it";
                }else if($data->idrole == "R00005"){
                    // PENGAJAR
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_pengajar' => TRUE,
                        'logged_karyawan' => TRUE,
                    ]);
                    $pesan = "ok_pengajar";
                    
                }else if($data->idrole == "R00006"){
                    // PENDIDIKAN
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_pendidikan' => TRUE,
                        'logged_karyawan' => TRUE,
                        'pd' => TRUE,
                    ]);
                    $pesan = "ok_pendidikan";
                }else if($data->idrole == "R00007"){
                    // General Affairs
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_ga' => TRUE,
                        'logged_hr' => TRUE,
                        'logged_karyawan' => TRUE,
                        'ga' => TRUE,
                    ]);
                    $pesan = "ok_ga";
                }else if($data->idrole == "R00008"){
                    // ADMIN BUSDEV
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_busdev' => TRUE,
                        'logged_karyawan' => TRUE,
                        'busdev' => TRUE,
                    ]);
                    $pesan = "ok_busdev";
                }else if($data->idrole == "R00009"){
                    // General Affairs
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_siswa' => TRUE,
                    ]);
                    $pesan = "ok_siswa";
                }else{
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_karyawan' => TRUE,
                    ]);
                    $pesan = "ok_guru";
                }
                if($data->isteaching == 1){
                    session()->set(['logged_pengajar' => TRUE,]);
                }
                if($data->ishr == 1){
                    session()->set(['logged_hr' => TRUE, 'hr' => TRUE]);
                }if($data->isit == 1){
                    session()->set(['logged_it' => TRUE, 'it' => TRUE]);
                }if($data->ispdd == 1){
                    session()->set(['logged_pendidikan' => TRUE, 'pd' => TRUE]);
                }if($data->isga == 1){
                    session()->set(['logged_ga' => TRUE, 'logged_hr' => TRUE, 'ga' => TRUE]);
                }if($data->isbusdev == 1){
                    session()->set(['logged_busdev' => TRUE, 'busdev' => TRUE]);
                }if($data->ispimpinan == 1){
                    session()->set(['logged_bos' => TRUE, 'bos' => TRUE]);
                }
                
                $data = array(
                    'idusers' => $data->idusers,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'browser' => $_SERVER['HTTP_USER_AGENT'],
                    'aktifitas' => 'Login',
                );
                $this->model->add("log",$data);
            }else{
                $pesan = "Anda tidak berhak mengakses !";
            }
        }else{
            $pesan = "Maaf, user tidak ditemukan !";
        }
        echo json_encode(array("status" => $pesan));
    }
    
    public function logout(){
        if(session()->get("idusers") != ''){
            $data = array(
                'idusers' => session()->get("idusers"),
                'ip' => $_SERVER['REMOTE_ADDR'],
                'browser' => $_SERVER['HTTP_USER_AGENT'],
                'aktifitas' => 'Logout',
            );
            $this->model->add("log",$data);

            session()->destroy();
            clearstatcache();
            
            $this->modul->halaman('login');
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
