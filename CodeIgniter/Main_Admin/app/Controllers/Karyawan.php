<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Karyawan extends BaseController {
    
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
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;
            $data['pu'] = $this->model->getAllQ("SELECT u.nama, u.expertise, foto, jabatan, d.nama as divisi, minat,idusers FROM users u, jabatan j, divisi d where j.idjabatan = u.idjabatan and j.iddivisi = d.iddivisi and u.minat is not null and u.nama is not null and u.status = 'Aktif';");
            
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
            echo view('front/karyawan/index');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

}
