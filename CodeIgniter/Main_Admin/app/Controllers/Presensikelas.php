<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Presensikelas extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_pengajar") || session()->get("logged_pendidikan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $def_foto = base_url().'/images/noimg.jpg';
            if(strlen($data['pro']->foto) > 0){
                if(file_exists($this->modul->getPathApp().$data['pro']->foto)){
                    $def_foto = base_url().'/uploads/'.$data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['logo'] = base_url().'/images/noimg.jpg';
            }
            
            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
            echo view('back/akademik/menu');
            }
            echo view('back/akademik/presensi/index');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pengajar") || session()->get("logged_pendidikan")){
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ',c.waktu_akhir) as sesi, a.idpendkursus, g.nama_kursus, 
                concat(d.tanggal, '-', d.bulan_awal, '-', d.tahun_awal) as periode, a.hari, e.level, f.meeting_id 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, zoom f, pendidikankursus g  
                where a.idjadwal = b.idjadwal and a.idsesi = c.idsesi and a.idperiode = d.idperiode and a.status_archive = 0 
                and a.idlevel = e.idlevel and a.idzoom = f.idzoom and a.idpendkursus = g.idpendkursus;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->groupwa;
                $val[] = $row->sesi;
                $val[] = $row->nama_kursus;
                $val[] = $row->periode;
                $val[] = $row->hari;
                $val[] = $row->level;
                $val[] = $row->meeting_id;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih('."'".$this->modul->enkrip_url($row->idjadwal)."'".')"><i class="ion ion-md-calendar"></i></button>'
                        . '</div></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function preview(){
        if(session()->get("logged_pengajar") || session()->get("logged_pendidikan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $def_foto = base_url().'/images/noimg.jpg';
            if(strlen($data['pro']->foto) > 0){
                if(file_exists($this->modul->getPathApp().$data['pro']->foto)){
                    $def_foto = base_url().'/uploads/'.$data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['logo'] = base_url().'/images/noimg.jpg';
            }
            
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '".$idjadwal."';")->jml;
            if($cek > 0){
                $data['idjadwal'] = $idjadwal;
                $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(b.waktu_awal, ' - ',b.waktu_akhir) as sesi, a.idpendkursus, f.nama_kursus, 
                    concat(c.tanggal, '-' ,c.bulan_awal, '-', c.tahun_awal) as periode, a.hari, d.level, e.meeting_id 
                    from jadwal a, sesi b, periode c, level d, zoom e, pendidikankursus f  
                    where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idpendkursus = f.idpendkursus 
                    and a.idzoom = e.idzoom and a.idjadwal = '".$idjadwal."';");
                $data['head'] = $head;
                $data['idjadwalenkrip'] = $this->modul->enkrip_url($head->idjadwal);
                
                // head table
                $data['tgl_head'] = $this->model->getAllQ("SELECT idjadwaldetil, date_format(start, '%d/%m/%y') as tgl FROM jadwal_detil where idjadwal = '".$idjadwal."';");
                // data siswa
                $data['siswa'] = $this->model->getAllQ("select a.idsiswa, b.nama_lengkap from jadwal_siswa a, siswa b where a.idjadwal = '".$idjadwal."' and a.idsiswa = b.idsiswa and b.keluar = 0 and a.is_keluar = 0;");

                $data['model'] = $this->model;
                $data['modul'] = $this->modul;
                
                echo view('back/head', $data);
                if(session()->get("logged_bos")){
                    echo view('back/bos/menu');
                }else{
                echo view('back/akademik/menu');
                }
                echo view('back/akademik/presensi/preview');
                echo view('back/foot');
            }else{
                $this->modul->halaman('presensisiswa');
            }
        }else{
            $this->modul->halaman('login');
        }
    }

    
}
