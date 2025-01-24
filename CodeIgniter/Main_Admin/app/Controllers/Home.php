<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Home extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "HR";
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
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
            $data['part'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idjamkerja in (SELECT idjamkerja FROM jamkerja j where namajamkerja like '%part%time%')")->jml;
            $data['magang'] = $this->model->getAllQR("SELECT count(*) as jml FROM users where idjamkerja in (SELECT idjamkerja FROM jamkerja j where namajamkerja like '%magang%')")->jml;
            $data['pelamar'] = $this->model->getAllQR("SELECT count(*) as jml FROM pelamar p where MONTH(created_at) = month(current_date()) and status = 'baru';")->jml;
            
            $data['jijin'] = $this->model->getAllQR("select count(*) as jml from perijinan where jenis='Ijin' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['jlembur'] = $this->model->getAllQR("select count(*) as jml from perijinan where jenis='Lembur' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['jsakit'] = $this->model->getAllQR("select count(*) as jml from perijinan where jenis='Sakit' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['jurgent'] = $this->model->getAllQR("select count(*) as jml from perijinan where jenis='Ijin Darurat' and status = 'Disetujui' and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
        
            $data['pegawai'] = $this->model->getAllQR("SELECT count(*) as jml FROM pengajuan where MONTH(created_at) = MONTH(CURRENT_DATE()) and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['perijinan'] = $this->model->getAllQR("SELECT count(*) as jml FROM perijinan where MONTH(created_at) = MONTH(CURRENT_DATE()) and YEAR(created_at) = YEAR(CURRENT_DATE());")->jml;
            $data['resign'] = $this->model->getAllQR("SELECT count(*) as jml FROM keluar k where MONTH(created_at) = MONTH(CURRENT_DATE()) and YEAR(created_at) = YEAR(CURRENT_DATE()) and setuju = 1;")->jml;

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

            $data['pengumuman'] = $this->model->getAll("pengumuman");

            echo view('back/head', $data);
            echo view('back/hrd/menu');
            echo view('back/hrd/content');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxparam()
    {
        if(session()->get("logged_hr") || session()->get("logged_ga")){
            $filter = explode(':', $this->request->getUri()->getSegment(3));

            // if($filter[0] == "tahun"){
            //     $thn = $filter[1];
            //     $bulan = now();
            // }else if($filter[0] == "bulan"){
            //     $bulan = $filter[1];
            //     $tahun = now();
            // }else{
                $bulan = $filter[1];
                $data['bulan'] = $bulan;
                $thn = $filter[2];
                $data['tahun'] = $thn;
            // }

            //Data Hadir
            $tepat = $this->model->getAllQR("SELECT count(*) as jml from absensi where (status = 'Hadir' or status = 'Tepat Waktu') and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."';")->jml;
            $data['tepat'] = $tepat;
            $telat = $this->model->getAllQR("SELECT count(*) as jml FROM absensi where month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' and status = 'Terlambat';")->jml;
            $data['telat'] = $telat;
            $data['hadir'] = $tepat + $telat;
            
            //Data tidak hadir
            $alpha = $this->model->getAllQR("SELECT count(*) as jml from absensi where status = 'Tidak Hadir' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."';")->jml;
            $data['alpha'] = $alpha;
            $sakit = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Sakit' and month(tanggalselesai) = '".$bulan."' and month(tanggalmulai) = '".$bulan."'
            and status = 'Disetujui' and year(tanggalselesai) = '".$thn."' and year(tanggalmulai) = '".$thn."';")->jml;
            $data['sakit'] = $sakit;
            $aijin = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Ijin' and month(tanggalselesai) = '".$bulan."' and month(tanggalmulai) = '".$bulan."'
            and status = 'Disetujui' and year(tanggalselesai) = '".$thn."' and year(tanggalmulai) = '".$thn."';")->jml;
            $data['aijin'] = $aijin;
            $darijin = $this->model->getAllQR("SELECT  COALESCE(SUM(DATEDIFF(tanggalselesai,tanggalmulai)+1),0) as jml FROM perijinan where jenis = 'Ijin Darurat' and month(tanggalselesai) = '".$bulan."' and month(tanggalmulai) = '".$bulan."'
            and status = 'Disetujui' and year(tanggalselesai) = '".$thn."' and year(tanggalmulai) = '".$thn."';")->jml;
            $data['darijin'] = $darijin;
            $data['tdkhadir'] = $alpha + $sakit + $aijin + $darijin;

            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist_absen()
    {
        if(session()->get("logged_hr") || session()->get("logged_ga")){
            $filter = explode(':', $this->request->getUri()->getSegment(3));
            $bulan = $filter[1];
            $thn = $filter[2];
            if ($filter[0] == "tepat") {
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.idkaryawan, count(*) as jml from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and (a.status = 'Hadir' or a.status = 'Tepat Waktu') and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' group by k.idusers;");
            }else if ($filter[0] == "telat"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.idkaryawan, count(*) as jml from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and a.status = 'Terlambat' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' group by k.idusers;");
            }else if ($filter[0] == "alpha"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.idkaryawan, count(*) as jml from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and a.status = 'Tidak Hadir' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' group by k.idusers;");
            }

            $no = 1;
            $data = array();
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm;
                $val[] = $row->jml;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detilabsen('."'".$row->idkaryawan."'".','."'".$bulan."'".','."'".$thn."'".','."'".$filter[0]."'".')">Detail</button>&nbsp;'
                        . '</div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist_detil_absen()
    {
        if(session()->get("logged_hr") || session()->get("logged_ga")){
            $filter = explode(':', $this->request->getUri()->getSegment(3));
            $bulan = $filter[1];
            $thn = $filter[2];
            if ($filter[3] == "tepat") {
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.* from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and (a.status = 'Hadir' or a.status = 'Tepat Waktu') and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' and a.idkaryawan = '".$filter[0]."';");
            }else if ($filter[3] == "telat"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.* from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and a.status = 'Terlambat' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' and a.idkaryawan = '".$filter[0]."';");
            }else if ($filter[3] == "alpha"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, a.* from absensi a, karyawan k, users u where k.idusers = u.idusers and a.idkaryawan = k.idkaryawan
                and a.status = 'Tidak Hadir' and month(tanggal) = '".$bulan."' and year(tanggal) = '".$thn."' and a.idkaryawan = '".$filter[0]."';");
            }

            $no = 1;
            $data = array();
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm;
                $val[] = date("l, d M Y", strtotime($row->tanggal));
                $val[] = date('H:i', strtotime($row->masuk));
                $val[] = date('H:i', strtotime($row->scanmasuk));
                $val[] = date('H:i', strtotime($row->terlambat));
                $val[] = date('H:i', strtotime($row->keluar));
                $val[] = date('H:i', strtotime($row->scankeluar));
                $val[] = date('H:i', strtotime($row->cepat));
                $user = $this->model->getAllQR("select u.nama from users u, karyawan k where u.idusers = k.idusers and idkaryawan = '".$row->idkaryawan."'")->nama;
                if($row->verifikasi == null){
                    $val[] = '<div style="text-align: center;">'
                            . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="verif('."'".$row->idabsensi."'".','."'".$row->idkaryawan."'".','."'".$bulan."'".','."'".$thn."'".','."'".$filter[3]."'".')">Verifikasi Manual</button>&nbsp;'
                            . '</div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idabsensi."'".','."'".$user."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div>';
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

    public function ajaxlist_detail()
    {
        if(session()->get("logged_hr") || session()->get("logged_ga")){
            $filter = explode(':', $this->request->getUri()->getSegment(3));
            $bulan = $filter[1];
            $thn = $filter[2];
            if ($filter[0] == "ijin"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Ijin' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }else if ($filter[0] == "darijin"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Ijin Darurat' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }else if ($filter[0] == "sakit"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Sakit' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }

            $no = 1;
            $data = array();
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm;
                $val[] = date("l, d M Y", strtotime($row->tanggalmulai));
                $val[] = date("l, d M Y", strtotime($row->tanggalselesai));
                $val[] = date('H:i', strtotime($row->waktumulai));
                $val[] = date('H:i', strtotime($row->waktuselesai));
                $val[] = '';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist_ijin()
    {
        if(session()->get("logged_hr") || session()->get("logged_ga")){
            $filter = explode(':', $this->request->getUri()->getSegment(3));
            $bulan = $filter[1];
            $thn = $filter[2];
            if ($filter[0] == "ijin"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Ijin' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }else if ($filter[0] == "darijin"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Ijin Darurat' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }else if ($filter[0] == "sakit"){
                $list = $this->model->getAllQ("SELECT u.nama as nm, tanggalmulai, tanggalselesai, waktumulai, waktuselesai FROM perijinan p, users u where p.idusers = u.idusers and jenis = 'Sakit' 
                and p.status = 'Disetujui' and month(tanggalmulai) = '".$bulan."' and year(tanggalmulai) = '".$thn."'");
            }

            $no = 1;
            $data = array();
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nm;
                $val[] = date("l, d M Y", strtotime($row->tanggalmulai));
                $val[] = date("l, d M Y", strtotime($row->tanggalselesai));
                $val[] = date('H:i', strtotime($row->waktumulai));
                $val[] = date('H:i', strtotime($row->waktuselesai));
                $val[] = '';
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
