<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homekaryawan extends BaseController{
    
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
            $data['nm_role'] = "KARYAWAN";
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            $data['kary'] = $this->model->getAllQR("select * from karyawan where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['ijin'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan p where idusers = '".session()->get("idusers")."' and jenis = 'Ijin' and status = 'Disetujui' and MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            $data['lembur'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan p where idusers = '".session()->get("idusers")."' and jenis = 'Lembur' and status = 'Disetujui' and MONTH(created_at) = MONTH(CURRENT_DATE());")->jml;
            
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
            
            $ijin = 0;
            $lembur = 0;
            $jam = $this->model->getAllQ("SELECT CASE WHEN jenis = 'Lembur' THEN 'Lembur' ELSE 'Ijin' END AS jenis,
            SEC_TO_TIME(SUM((DATEDIFF(tanggalselesai, tanggalmulai) + 1) * TIME_TO_SEC(TIMEDIFF(waktuselesai, waktumulai)))) AS total_time
            FROM perijinan WHERE idusers = '".session()->get("idusers")."' AND status = 'Disetujui' GROUP BY
            CASE WHEN jenis = 'Lembur' THEN 'Lembur' ELSE 'Ijin' END;");
            
            foreach ($jam->getResult() as $rows) {
                if ($rows->jenis == 'Lembur') {
                    $lembur = $rows->total_time;
                } else {
                    $ijin = $rows->total_time;
                }
            }

            $totjam = $this->model->getAllQR("select subtime('".$lembur."','".$ijin."')as result")->result;
            $data['jam'] = $totjam;
            
            $idkaryawan = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".session()->get("idusers")."'")->idkaryawan;
            $data['tepat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status = 'Tepat Waktu' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            $data['telat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status = 'Terlambat' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            $data['hadir'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status != 'Tidak Hadir' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            $clock = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and tanggal = CURDATE()");
            if($clock->jml > 0){
                $c = $this->model->getAllQR("SELECT scanmasuk, scankeluar FROM absensi where idkaryawan = '".$idkaryawan."' and tanggal = CURDATE()");
                $data['clockin'] = $c->scanmasuk;
                $data['clockout'] = $c->scankeluar;
            }else{
                $data['clockin'] = '';
                $data['clockout'] = '';
            }

            $data['bday'] = $this->model->getAllQ("SELECT k.nama, MID(k.tgl, 4, 2) as tgl, s.foto FROM karyawan k, users s where s.idusers = k.idusers and cast(LEFT(k.tgl, 2) as SIGNED) = month(now()) and s.status = 'Aktif';"); //month(now())
            
            $data['pengumuman'] = $this->model->getAllQ("select * from pengumuman order by urutan;");
            $data['peng'] = $this->model->getAllQR("select count(*) as jml from pengumuman")->jml;
            
            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/content');
            echo view('front/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

}
