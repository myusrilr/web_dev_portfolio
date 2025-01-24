<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Absensi extends BaseController {
    
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
            $def_foto = base_url().'/images/noimg.jpg';
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            if(strlen($pro->foto) > 0){
                if(file_exists($this->modul->getPathApp().$pro->foto)){
                    $def_foto = base_url().'/uploads/'.$pro->foto;
                }
            }
            $data['pro'] = $pro;
            $data['foto_profile'] = $def_foto;
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            $idkaryawan = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".session()->get("idusers")."'")->idkaryawan;
            $data['tepat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status = 'Tepat Waktu' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            $data['telat'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status = 'Terlambat' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            $data['hadir'] = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) = month(now()) and status != 'Tidak Hadir' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at));");
            
            $ijin = 0; $lembur = 0;
            $jam = $this->model->getAllQ("SELECT jenis, convert(sum((DATEDIFF(tanggalselesai,tanggalmulai)+1) * TIMEDIFF(waktuselesai,waktumulai)),TIME) as jam FROM perijinan j where idusers = '".session()->get("idusers")."' and status = 'Disetujui' group by jenis;");
            foreach($jam->getResult() as $row){
                if($row->jenis == 'Lembur'){
                    $lembur = $row->jam;
                }else{
                    $ijin = $row->jam;
                }
            }

            $totjam = $this->model->getAllQR("select subtime('".$lembur."','".$ijin."')as result")->result;
            $data['jam'] = $totjam;
            
            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/absensi/index');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $idkaryawan = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".session()->get("idusers")."'")->idkaryawan;
            $list = $this->model->getAllQ("select * from absensi where idkaryawan = '".$idkaryawan."' and month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at)) order by tanggal desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date("l, d M Y", strtotime($row->tanggal));
                $val[] = date('H:i', strtotime($row->scanmasuk));
                $val[] = date('H:i', strtotime($row->scankeluar));
                if($row->status == 'Tidak Hadir'){
                    $val[] = '<span class="badge badge-danger">Tidak Hadir</span>';
                }else if($row->status == 'Terlambat'){
                    $val[] = '<span class="badge badge-warning">Terlambat</span>';
                }else{
                    $val[] = '<span class="badge badge-success">Tepat Waktu</span>';
                }
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

}
