<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Gantipass extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_karyawan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);

            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
 
            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/riwayat/menu');
            echo view('front/riwayat/gantipass');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_karyawan")){
            $idusers = session()->get("idusers");
            // cek password lama
            $lama_db = $this->model->getAllQR("SELECT pass FROM users WHERE idusers = '".$idusers."';")->pass;
            $lama = $this->modul->enkrip_pass($this->request->getPost('lama'));
            if($lama_db == $lama){
                $data = array(
                    'pass' => $this->modul->enkrip_pass($this->request->getPost('baru'))
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if($update == 1){
                    $status = "Password terupdate";
                }else{
                    $status = "Password gagal terupdate";
                }
            }else{
                $status = "Password tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
