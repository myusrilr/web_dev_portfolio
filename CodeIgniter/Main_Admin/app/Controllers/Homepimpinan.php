<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homepimpinan extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_bos")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
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
            $data['part'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idjamkerja in (SELECT idjamkerja FROM jamkerja j where namajamkerja like '%part%time%')")->jml;
            $data['magang'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idjamkerja in (SELECT idjamkerja FROM jamkerja j where namajamkerja like '%magang%')")->jml;
            $data['pelamar'] = $this->model->getAllQR("SELECT count(*) as jml FROM pelamar p where MONTH(created_at) = month(current_date()) and status = 'baru';")->jml;
            
            $q = "SELECT (select count(*) from perijinan where jenis='Ijin' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE())) as jmlijin, ";
            $q .= "(select count(*) from perijinan where jenis='Lembur' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE())) as jmllembur, ";
            $q .= "(select count(*) from perijinan where jenis='Sakit' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE())) as jmlsakit, ";
            $q .= "(select count(*) from perijinan where jenis='Ijin Darurat' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE())) as jmlizin ";
            $q .= "from perijinan p limit 1";
            $data['q'] = $this->model->getAllQR($q);
            $data['pegawai'] = $this->model->getAllQR("SELECT count(*) as jml FROM pengajuan where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            $data['perijinan'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            $data['resign'] = $this->model->getAllQR("SELECT count(*) as jml FROM keluar k where MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;

            $i = "SELECT (select count(*) from perijinan where jenis='Ijin' and status = 'Disetujui') as jmlijin, ";
            $i .= "(select count(*) from perijinan where jenis='Lembur' and status = 'Disetujui') as jmllembur, ";
            $i .= "(select count(*) from perijinan where jenis='Sakit' and status = 'Disetujui') as jmlsakit, ";
            $i .= "(select count(*) from perijinan where jenis='Ijin Darurat' and status = 'Disetujui') as jmlizin, ";
            $i .= "MONTHNAME(created_at) as bln from perijinan p group by month(created_at)";
            $data['jmlijin'] = $this->model->getAllQ($i);

            $data['tepat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where month(tanggal) = month(now()) and status = 'Tepat Waktu';")->jml;
            $data['telat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where month(tanggal) = month(now()) and status = 'Terlambat';")->jml;

            echo view('back/head', $data);
            echo view('back/bos/menu');
            echo view('back/bos/content');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
