<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homeit extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_it")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "IT";
            
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
            
            $data['karyawan'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idrole not in ('R0004');")->jml;
            $data['wanita'] = $this->model->getAllQR("SELECT count(*) as jml FROM users u, karyawan k where idrole not in ('R0004') and u.idusers = k.idusers and jk='wanita';")->jml;
            $data['pria'] = $this->model->getAllQR("SELECT count(*) as jml FROM users u, karyawan k where idrole not in ('R0004') and u.idusers = k.idusers and jk='pria';")->jml;
            $data['full'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idjamkerja in (SELECT idjamkerja FROM jamkerja j where namajamkerja like '%fulltime%')")->jml;
            $data['pelamar'] = $this->model->getAllQR("SELECT count(*) as jml FROM pelamar p where MONTH(created_at) = month(current_date()) and status = 'baru';")->jml;
            
            $data['totijin'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan p where jenis='Ijin' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['totlembur'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan p where jenis='Lembur' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['pegawai'] = $this->model->getAllQR("SELECT count(*) as jml FROM pengajuan where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            $data['perijinan'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            $data['resign'] = $this->model->getAllQR("SELECT count(*) as jml FROM keluar k where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;

            $data['jmlijin'] = $this->model->getAllQ("SELECT (select count(*) from perijinan where jenis='Ijin' and status = 'Disetujui') as jmlijin, (select count(*) from perijinan where jenis='Lembur' and status = 'Disetujui') as jmllembur, MONTHNAME(created_at) as bln from perijinan p group by month(created_at);");

            echo view('back/head', $data);
            echo view('back/it/menu');
            echo view('back/it/content');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
