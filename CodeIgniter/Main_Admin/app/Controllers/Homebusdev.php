<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homebusdev extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_busdev")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            $data['bidang'] = $this->model->getAllQR("SELECT count(*) as jml FROM bidang;")->jml;
            $data['link'] = $this->model->getAllQR("SELECT count(*) as jml FROM bidanglink;")->jml;
            $data['leap'] = $this->model->getAllQR("SELECT count(*) as jml FROM leapprofil;")->jml;
            $data['karyawan'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idrole = 'R00008';")->jml;

            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;
            
            echo view('back/head', $data);
            if($cek == '' || $cek == 0){
                echo view('back/busdev/menu');
                echo view('back/busdev/content');
            }else{
                echo view('back/busdev/menubidang');
                echo view('back/busdev/contentbidang');
            }
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
