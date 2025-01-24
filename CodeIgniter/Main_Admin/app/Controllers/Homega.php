<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homega extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_ga")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "General Affairs";
            
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

            $data['surattugas'] = $this->model->getAllQR("select count(*) as jml from surattugas where status = 'Diajukan';")->jml;
            $data['suratkeluar'] = $this->model->getAllQR("select count(*) as jml from suratkeluar where status = 'Diajukan';")->jml;
            $data['mou'] = $this->model->getAllQR("select count(*) as jml from mou where status = 'Diajukan' or status = 'Revisi' or status = 'Terdapat Revisi';")->jml;

            $data['isu'] = $this->model->getAllQR("select count(*) as jml from problem where status = 'Diajukan';")->jml;
            $data['beli'] = $this->model->getAllQR("select count(*) as jml from purchase where status = 'Diajukan' or status = 'Disetujui';")->jml;
            $data['pinjam'] = $this->model->getAllQR("select count(*) as jml from pinjam where status = 'Diajukan' or status = 'Disetujui';")->jml;

            $i = "SELECT (select count(*) from perijinan where jenis='Ijin' and status = 'Disetujui') as jmlijin, ";
            $i .= "(select count(*) from perijinan where jenis='Lembur' and status = 'Disetujui') as jmllembur, ";
            $i .= "(select count(*) from perijinan where jenis='Sakit' and status = 'Disetujui') as jmlsakit, ";
            $i .= "(select count(*) from perijinan where jenis='Ijin Darurat' and status = 'Disetujui') as jmlizin, ";
            $i .= "MONTHNAME(created_at) as bln from perijinan p group by month(created_at)";
            $data['jmlijin'] = $this->model->getAllQ($i);

            //Data Hadir
            $tepat = $this->model->getAllQR("SELECT count(*) as jml from absensi where (status = 'Hadir' or status = 'Tepat Waktu') and month(tanggal) = month(now()) and year(tanggal) = year(now());")->jml;
            $data['tepat'] = $tepat;
            $telat = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where month(tanggal) = month(now()) and year(tanggal) = year(now()) and status = 'Terlambat';")->jml;
            $data['telat'] = $telat;
            $data['hadir'] = $tepat + $telat;
            
            //Data tidak hadir
            $alpha = $this->model->getAllQR("SELECT count(*) as jml from absensi where status = 'Tidak Hadir' and month(tanggal) = month(now()) and year(tanggal) = year(now());")->jml;
            $data['alpha'] = $alpha;
            $sakit = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Sakit' and month(tanggalselesai) = month(now()) and month(tanggalmulai) = month(now()) and year(tanggalselesai) = year(now()) and year(tanggalmulai) = year(now())  and status = 'Disetujui';")->jml;
            $data['sakit'] = $sakit;
            $aijin = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Ijin' and month(tanggalselesai) = month(now()) and month(tanggalmulai) = month(now()) and year(tanggalselesai) = year(now()) and year(tanggalmulai) = year(now())  and status = 'Disetujui';")->jml;
            $data['aijin'] = $aijin;
            $darijin = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Ijin Darurat' and month(tanggalselesai) = month(now()) and month(tanggalmulai) = month(now()) and year(tanggalselesai) = year(now()) and year(tanggalmulai) = year(now())  and status = 'Disetujui';")->jml;
            $data['darijin'] = $darijin;
            $data['tdkhadir'] = $alpha + $sakit + $aijin;

            echo view('back/head', $data);
            echo view('back/ga/menu');
            echo view('back/ga/content');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
