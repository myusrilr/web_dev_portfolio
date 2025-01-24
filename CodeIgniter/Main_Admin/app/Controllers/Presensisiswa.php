<?php
namespace App\Controllers;

/**
 * Description of Presensisiswa
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Presensisiswa extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_pengajar")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

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
            echo view('back/pengajar/menu');
            echo view('back/pengajar/presensi/index');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pengajar")){
            $idusers = session()->get("idusers");
            
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ',c.waktu_akhir) as sesi, a.idpendkursus, g.nama_kursus, 
                concat(d.tanggal, '-', d.bulan_awal, '-', d.tahun_awal) as periode, a.hari, e.idlevel, e.level, f.meeting_id 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, zoom f, pendidikankursus g  
                where a.idjadwal = b.idjadwal and a.idsesi = c.idsesi and a.idperiode = d.idperiode and a.status_archive = 0 
                and a.idlevel = e.idlevel and a.idzoom = f.idzoom and a.idpendkursus = g.idpendkursus and b.idusers =  '".$idusers."';");
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
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih('."'".$this->modul->enkrip_url($row->idjadwal)."'".')"><i class="fas fa-check"></i></button>'
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
    
    public function detil() {
        if(session()->get("logged_pengajar")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

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
                
                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/presensi/detil');
                echo view('back/foot');
            }else{
                $this->modul->halaman('presensisiswa');
            }
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxdetil() {
        if(session()->get("logged_pengajar")){
            $idjadwal = $this->request->getUri()->getSegment(3);
            
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT idjadwaldetil, date_format(start, '%d %M %Y') as tgl FROM jadwal_detil where idjadwal = '".$idjadwal."';");
            foreach ($list->getResult() as $row) {
                $ja = $this->model->getAllQR("select count(*) as jml, idlevel from jadwal where idpendkursus = 'K00005' and idjadwal = '".$idjadwal."'");
                $jml_kurikulum = $this->model->getAllQR("select count(*) as jml from kurikulum_kelas where idjadwaldetil = '".$row->idjadwaldetil."'")->jml;

                $val = array();
                $str = "Pertemuan - " . $no;
                if($ja->jml > 0){
                    if($jml_kurikulum > 0){
                        $str .= "<br>Materi : ";
                        $df = $this->model->getAllQ("SELECT kompetensi FROM kurikulum_kelas k, kurikulum_detil_sub kd where k.idkur_det_sub = kd.idkur_det_sub and k.idjadwaldetil = '".$row->idjadwaldetil."'");
                        $str .= "<br><ol>";
                        foreach($df->getResult() as $rows){
                            $str .= '<li>'.str_replace("<p>","",str_replace("</p>","",$rows->kompetensi)).'</li>';
                        }
                        $str .= "</ol>";
                    }
                }
                $val[] = $str;
                $val[] = $row->tgl;
                if($ja->jml > 0){
                    $str = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">';
                    if($jml_kurikulum > 0){
                        $str .= '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="materiedit('."'".$row->idjadwaldetil."'".','."'".$ja->idlevel."'".')"><i class="feather icon-clipboard"></i></button>';
                    }else{
                        $str .= '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="materi('."'".$row->idjadwaldetil."'".','."'".$ja->idlevel."'".')"><i class="feather icon-clipboard"></i></button>';
                    }
                    $str .= '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilihapk('."'".$this->modul->enkrip_url($row->idjadwaldetil)."'".')"><i class="fas fa-check"></i></button>';
                    $str .= '</div></div>';

                    $val[] = $str;
                }else{
                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih('."'".$this->modul->enkrip_url($row->idjadwaldetil)."'".')"><i class="fas fa-check"></i></button>'
                    . '</div></div>';
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
    
    public function siswa() {
        if(session()->get("logged_pengajar")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

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
            
            $idjadwaldetil = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->jml;
            if($cek > 0){
                $data['idjadwaldetil'] = $idjadwaldetil;
                // sub head
                $subhead = $this->model->getAllQR("select *, date_format(start, '%d %M %Y') as tglawal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");
                $no = 1;
                $d = $this->model->getAllQ("SELECT * FROM jadwal_detil j where title = '".$subhead->title."';");
                foreach($d->getResult() as $row){
                    if($row->idjadwaldetil == $subhead->idjadwaldetil){
                        $data['ptm'] = "Pertemuan ke - ".$no;
                    }
                    $no++;
                }
                
                $data['subhead'] = $subhead;
                // mendapatkan data jadwal
                $jadwal = $this->model->getAllQR("select idjadwal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");
                $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(b.waktu_awal, ' - ',b.waktu_akhir) as sesi, a.idpendkursus, f.nama_kursus as kursus, 
                    concat(c.tanggal,'-',c.bulan_awal, '-', c.tahun_awal) as periode, a.hari, d.level, e.meeting_id 
                    from jadwal a, sesi b, periode c, level d, zoom e, pendidikankursus f  
                    where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idpendkursus = f.idpendkursus 
                    and a.idzoom = e.idzoom and a.idjadwal = '".$jadwal->idjadwal."';");
                $data['head'] = $head;
                $data['idjadwalenkrip'] = $this->modul->enkrip_url($head->idjadwal);
                
                $cek = $this->model->getAllQR("select count(*) as jml from catatan_kelas where idjadwaldetil = '".$idjadwaldetil."';")->jml;
                if($cek > 0){
                    $data['catatan'] = $this->model->getAllQR("select catatan from catatan_kelas where idjadwaldetil = '".$idjadwaldetil."';")->catatan;
                }else{
                    $data['catatan'] = "";
                }

                $data['tags'] = $this->model->getAll("tag_materi_diskusi");
                $jml = $this->model->getAllQR("select count(*) as jml from catatan_kelas where idjadwaldetil = '".$subhead->idjadwaldetil."'")->jml;
                $v = '';
                if($jml > 0){
                    $ck = $this->model->getAllQR("select idcatatan_kelas from catatan_kelas where idjadwaldetil = '".$subhead->idjadwaldetil."'")->idcatatan_kelas;
                    $v = $this->model->getAllQ("SELECT idtagmd FROM catatan_kelas_tag c where idcatatan_kelas = '".$ck."'");
                }
                $data['isitag'] = $v;
                
                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/presensi/siswa');
                echo view('back/foot');
            }else{
                $this->modul->halaman('presensisiswa');
            }
        }else{
            $this->modul->halaman('login');
        }
    }

    public function siswaapk() {
        if(session()->get("logged_pengajar")){
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
            
            $idjadwaldetil = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->jml;
            if($cek > 0){
                $data['idjadwaldetil'] = $idjadwaldetil;
                // sub head
                $subhead = $this->model->getAllQR("select *, date_format(start, '%d %M %Y') as tglawal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");
                $no = 1;
                $d = $this->model->getAllQ("SELECT * FROM jadwal_detil j where title = '".$subhead->title."';");
                foreach($d->getResult() as $row){
                    if($row->idjadwaldetil == $subhead->idjadwaldetil){
                        $data['ptm'] = "Pertemuan ke - ".$no;
                    }
                    $no++;
                }
                
                $data['subhead'] = $subhead;
                // mendapatkan data jadwal
                $jadwal = $this->model->getAllQR("select idjadwal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");
                $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(b.waktu_awal, ' - ',b.waktu_akhir) as sesi, a.idpendkursus, f.nama_kursus as kursus, 
                    concat(c.tanggal,'-',c.bulan_awal, '-', c.tahun_awal) as periode, a.hari, d.level, e.meeting_id 
                    from jadwal a, sesi b, periode c, level d, zoom e, pendidikankursus f  
                    where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idpendkursus = f.idpendkursus 
                    and a.idzoom = e.idzoom and a.idjadwal = '".$jadwal->idjadwal."';");
                $data['head'] = $head;
                $data['idjadwalenkrip'] = $this->modul->enkrip_url($head->idjadwal);
                
                $cek = $this->model->getAllQR("select count(*) as jml from catatan_kelas where idjadwaldetil = '".$idjadwaldetil."';")->jml;
                if($cek > 0){
                    $data['catatan'] = $this->model->getAllQR("select catatan from catatan_kelas where idjadwaldetil = '".$idjadwaldetil."';")->catatan;
                }else{
                    $data['catatan'] = "";
                }

                $data['siswa'] = $this->model->getAllQ("SELECT a.idsiswa, b.nama_lengkap, b.level_sekolah, a.idjadwaldetil FROM jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$head->idjadwal."' and b.keluar = 0 and a.is_keluar = 0;"); 
                
                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/presensi/siswakur');
                echo view('back/foot');
            }else{
                $this->modul->halaman('presensisiswa');
            }
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlistsiswa() {
        if(session()->get("logged_pengajar")){
            $idjadwal = $this->request->getUri()->getSegment(3);
            $idjadwaldetil = $this->request->getUri()->getSegment(4);
            // mencari tanggal start jadwal ini
            $tgl_start = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '".$idjadwal."' order by idjadwaldetil limit 1;")->start;
            // mencari ini tanggal brp
            $tgl_terpilih = $this->model->getAllQR("SELECT start FROM jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->start;

            $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '".$idjadwal."' and a.idlevel = b.idlevel;");
            
            $data = array();
            $list = $this->model->getAllQ("SELECT a.idsiswa, b.nama_lengkap, b.level_sekolah, a.idjadwaldetil FROM jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."' and b.keluar = 0 and a.is_keluar = 0;");
            foreach ($list->getResult() as $row) {

                $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml 
                from siswa a, jadwal_siswa b, jadwal c, level d
                where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                and a.idsiswa = '".$row->idsiswa."' and c.idlevel = d.idlevel and d.idpendkursus = '".$datajadwal->idpendkursus."' and d.tingkatan > '".$datajadwal->tingkatan."';")->jml;
                if($cek_level_atasnya < 1){

                    // mencari siswa itu ada start pada tanggal berapa
                    if(strlen($row->idjadwaldetil) > 0){
                        $cekstart = $this->model->getAllQR("select start, count(*) as jml from jadwal_detil where idjadwaldetil = '" . $row->idjadwaldetil . "';");
                        if($cekstart->jml == ''){
                            $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_detil where idjadwal = '" . $idjadwal . "' limit 1;")->idjadwaldetil;
                            $tgl_start_siswa = $this->model->getAllQR("select start from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';")->start;
                        }else{
                            $tgl_start_siswa = $this->model->getAllQR("SELECT start FROM jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->start;
                        }
                    }else{
                        $tgl_start_siswa = $tgl_start;
                    }

                    if($tgl_start_siswa <= $tgl_terpilih){
                        $val = array();
                        $val[] = $row->nama_lengkap;
                        // cek presensi
                        $cek_waktu = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '".$row->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';")->jml;
                        if($cek_waktu > 0){
                            $waktu = $this->model->getAllQR("SELECT date_format(waktu, '%d %M %Y %H:%i:%s') as waktu FROM presensi_siswa where idsiswa = '".$row->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';");
                            $val[] = $waktu->waktu;
                            $val[] = '<div style="text-align:center;"><input id="'.$row->idsiswa.'" type="checkbox" checked onchange="absen('."'".$row->idsiswa."'".','."'".$idjadwal."'".')""></div>';
                        }else{
                            $val[] = '';
                            $val[] = '<div style="text-align:center;"><input id="'.$row->idsiswa.'" type="checkbox" onchange="absen('."'".$row->idsiswa."'".','."'".$idjadwal."'".')""></div>';
                        }
                        
                        // cek catatan siswa
                        $cek_catatan = $this->model->getAllQR("SELECT count(*) as jml FROM catatan_siswa where idsiswa = '".$row->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';")->jml;
                        if($cek_catatan > 0){
                            $catatan = $this->model->getAllQR("SELECT catatan FROM catatan_siswa where idsiswa = '".$row->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';");
                            $val[] = $catatan->catatan;
                        }else{
                            $val[] = '';
                        }
                        // tombol aksi
                        $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                                . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="catatan('."'".$row->idsiswa."'".','."'".$row->nama_lengkap."'".')">Catatan Siswa</button>'
                                . '</div></div>';
                        
                        $data[] = $val;
                    }

                }
                
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlistkomp() {
        if(session()->get("logged_pengajar")){
            $idjadwal = $this->request->getUri()->getSegment(3);
            $idjadwaldetil = $this->request->getUri()->getSegment(4);

            $data = array();
            $list = $this->model->getAllQ("SELECT idkur_kel, kompetensi FROM kurikulum_kelas l, kurikulum_detil_sub k where l.idkur_det_sub = k.idkur_det_sub and idjadwaldetil = '".$idjadwaldetil."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = str_replace("<p>","",str_replace("</p>","",$row->kompetensi));
                $siswa = $this->model->getAllQ("SELECT a.idsiswa FROM jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."' and b.keluar = 0 and a.is_keluar = 0;"); 
                foreach($siswa->getResult() as $row2){
                    // cek presensi
                    $cek_waktu = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '".$row2->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."' and idkur_kel = '".$row->idkur_kel."';")->jml;
                    if($cek_waktu > 0){
                        $waktu = $this->model->getAllQR("SELECT date_format(waktu, '%d %M %Y %H:%i:%s') as waktu FROM presensi_siswa where idsiswa = '".$row2->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';");
                        $val[] = '<div style="text-align:center;"><input id="'.$row2->idsiswa.'" type="checkbox" checked onchange="absenkur('."'".$row2->idsiswa."'".','."'".$idjadwal."'".','."'".$row->idkur_kel."'".')""></div><br>'.$waktu->waktu;
                    }else{
                        $val[] = '<div style="text-align:center;"><input id="'.$row2->idsiswa.'" type="checkbox" onchange="absenkur('."'".$row2->idsiswa."'".','."'".$idjadwal."'".','."'".$row->idkur_kel."'".')""></div>';
                    }
                }

                $data[] = $val;  
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function prosespresensi() {
        if(session()->get("logged_pengajar")){
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '"
                    .$this->request->getPost('idsiswa')."' and idjadwaldetil = '".$this->request->getPost('idjadwaldetil')."';")->jml;
            if($cek > 0){
                $kond['idsiswa'] = $this->request->getPost('idsiswa');
                $kond['idjadwaldetil'] = $this->request->getPost('idjadwaldetil');
                $hapus = $this->model->delete("presensi_siswa", $kond);
                if($hapus == 1){
                    $status = "Presensi dibatalkan";
                }else{
                    $status = "Presensi gagal dibatalkan";
                }
            }else{
                $data = array(
                    'idpresensi_siswa' => $this->modul->getCurTime().$this->request->getPost('idsiswa'),
                    'idjadwaldetil' => $this->request->getPost('idjadwaldetil'),
                    'idsiswa' => $this->request->getPost('idsiswa'),
                    'waktu' => $this->modul->TanggalWaktu(),
                    'idjadwal' => $this->request->getPost('idjadwal')
                );
                $simpan = $this->model->add("presensi_siswa",$data);
                if($simpan == 1){
                    $status = "Presensi tersimpan";
                }else{
                    $status = "Presensi gagal tersimpan";
                }
            }
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function prosespresensikur() {
        if(session()->get("logged_pengajar")){
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '"
                    .$this->request->getPost('idsiswa')."' and idjadwaldetil = '".$this->request->getPost('idjadwaldetil')."'
                    and idkur_kel = '".$this->request->getPost('idkur_kel')."';")->jml;
            if($cek > 0){
                $kond['idsiswa'] = $this->request->getPost('idsiswa');
                $kond['idjadwaldetil'] = $this->request->getPost('idjadwaldetil');
                $kond['idkur_kel'] = $this->request->getPost('idkur_kel');
                $hapus = $this->model->delete("presensi_siswa", $kond);
                if($hapus == 1){
                    $status = "Presensi dibatalkan";
                }else{
                    $status = "Presensi gagal dibatalkan";
                }
            }else{
                $data = array(
                    'idpresensi_siswa' => $this->modul->getCurTime().$this->request->getPost('idsiswa'),
                    'idjadwaldetil' => $this->request->getPost('idjadwaldetil'),
                    'idsiswa' => $this->request->getPost('idsiswa'),
                    'waktu' => $this->modul->TanggalWaktu(),
                    'idjadwal' => $this->request->getPost('idjadwal'),
                    'idkur_kel' => $this->request->getPost('idkur_kel'),
                );
                $simpan = $this->model->add("presensi_siswa",$data);
                if($simpan == 1){
                    $status = "Presensi tersimpan";
                }else{
                    $status = "Presensi gagal tersimpan";
                }
            }
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses_catatan() {
        if(session()->get("logged_pengajar")){
            $cek = $this->model->getAllQR("select count(*) as jml from catatan_kelas where idjadwaldetil = '".$this->request->getPost('idjadwaldetil')."';")->jml;
            if($cek > 0){
                $data = array(
                    'catatan' => $this->request->getPost('catatan')
                );
                $kond['idjadwal'] = $this->request->getPost('idjadwal');
                $kond['idjadwaldetil'] = $this->request->getPost('idjadwaldetil');
                $ganti = $this->model->update("catatan_kelas", $data, $kond);
                if($ganti == 1){
                    $status = "Catatan diperbarui";
                }else{
                    $status = "Catatan gagal diperbarui";
                }
                $kode = $this->model->getAllQR("select idcatatan_kelas from catatan_kelas where idjadwaldetil = '".$this->request->getPost('idjadwaldetil')."';")->idcatatan_kelas;
            }else{
                $kode = $this->model->autokode("C","idcatatan_kelas","catatan_kelas", 2, 7);
                $data = array(
                    'idcatatan_kelas' => $kode,
                    'idjadwal' => $this->request->getPost('idjadwal'),
                    'idjadwaldetil' => $this->request->getPost('idjadwaldetil'),
                    'catatan' => $this->request->getPost('catatan')
                );
                $simpan = $this->model->add("catatan_kelas",$data);
                if($simpan == 1){
                    $status = "Catatan tersimpan";
                }else{
                    $status = "Catatan gagal tersimpan";
                }
            }
            
            if($this->request->getPost('tag') != null){
                $cek = $this->model->getAllQR("select count(*) as jml from catatan_kelas_tag where idcatatan_kelas = '" . $kode . "'")->jml;
                if ($cek > 0) {
                    $kon['idcatatan_kelas'] = $kode;
                    $hapus = $this->model->delete("catatan_kelas_tag", $kon);
                }
                $hasil = explode(",", $this->request->getPost('tag'));
                for ($b = 0; $b < count($hasil); $b++) {
                    $datap = array(
                        'idcatatantag' => $this->model->autokode("N", "idcatatantag", "catatan_kelas_tag", 2, 7),
                        'idtagmd' => $hasil[$b],
                        'idcatatan_kelas' => $kode
                    );
                    $this->model->add("catatan_kelas_tag", $datap);
                }
            }
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses_maju_mundur() {
        if(session()->get("logged_pengajar")){
            $mode = $this->request->getPost('mode');
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idjadwal = $this->request->getPost('idjadwal');
            
            $data = array();
            $list = $this->model->getAllQ("SELECT idjadwaldetil FROM jadwal_detil where idjadwal = '".$idjadwal."';");
            foreach ($list->getResult() as $row) {
                array_push($data, $row->idjadwaldetil);
            }
            
            $counter = -1;
            for($i=0; $i<count($data); $i++){
                if($data[$i] == $idjadwaldetil){
                    $counter = $i;
                    break;
                }
            }
            
            if($mode == "maju"){
                $index = $counter + 1;
            }else if($mode == "mundur"){
                $index = $counter - 1;
            }
            
            if($index < 0){
                $status = "Telah mencapai batas";
                $link = "";
            }else if($index >= count($data)){
                $status = "Telah mencapai batas";
                $link = "";
            }else{
                $status = "ok";
                $link = base_url().'/presensisiswa/siswa/'.$this->modul->enkrip_url($data[$index]);
            }
            
            
            echo json_encode(array("status" => $status, "link" => $link));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function prosescatatan() {
        if(session()->get("logged_pengajar")){
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('idsiswa');
            $catatan = $this->request->getPost('catatan');
            
            $cek = $this->model->getAllQR("select count(*) as jml from catatan_siswa where idjadwal = '".$idjadwal."' and idjadwaldetil = '".$idjadwaldetil."' and idsiswa = '".$idsiswa."';")->jml;
            if($cek > 0){
                $data = array(
                    'catatan' => $catatan
                );
                $kond['idjadwal'] = $idjadwal;
                $kond['idjadwaldetil'] = $idjadwaldetil;
                $kond['idsiswa'] = $idsiswa;
                $update = $this->model->update("catatan_siswa",$data, $kond);
                if($update == 1){
                    $status = "Catatan siswa tersimpan";
                }else{
                    $status = "Catatan siswa gagal tersimpan";
                }
            }else{
                $data = array(
                    'idcatatan_siswa' => $this->model->autokode("C","idcatatan_siswa","catatan_siswa", 2, 11),
                    'idjadwal' => $idjadwal,
                    'idjadwaldetil' => $idjadwaldetil,
                    'idsiswa' => $idsiswa,
                    'catatan' => $catatan
                );
                $simpan = $this->model->add("catatan_siswa",$data);
                if($simpan == 1){
                    $status = "Catatan siswa tersimpan";
                }else{
                    $status = "Catatan siswa gagal tersimpan";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function showcatatansiswa() {
        if(session()->get("logged_pengajar")){
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('idsiswa');
            
            $cek = $this->model->getAllQR("select count(*) as jml from catatan_siswa where idjadwal = '".$idjadwal."' and idjadwaldetil = '".$idjadwaldetil."' and idsiswa = '".$idsiswa."';")->jml;
            if($cek > 0){
                $status = $this->model->getAllQR("select catatan from catatan_siswa where idjadwal = '".$idjadwal."' and idjadwaldetil = '".$idjadwaldetil."' and idsiswa = '".$idsiswa."';")->catatan;
            }else{
                $status = "";
            }
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxtgl() {
        if(session()->get("logged_pengajar")){
            $idjadwal = $this->request->getUri()->getSegment(3);
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT idjadwaldetil, date_format(start, '%d %M %Y') as tgl FROM jadwal_detil where idjadwal = '".$idjadwal."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = "Pertemuan - " . $no .' ('.$row->tgl.')';
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="jumpto('."'".$this->modul->enkrip_url($row->idjadwaldetil)."'".')"><i class="fas fa-check"></i></button>'
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

    public function checkall(){
        if(session()->get("logged_pengajar")){
            $idjadwal = $this->request->getPost('idjadwal');
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            
            // menampilkan siswa
            $list_siswa = $this->model->getAllQ("select idsiswa from jadwal_siswa where idjadwal = '".$idjadwal."';");
            foreach ($list_siswa->getResult() as $row) {
                $cek = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '"
                        .$row->idsiswa."' and idjadwaldetil = '".$idjadwaldetil."';")->jml;
                if($cek > 0){
                    $data = array(
                        'waktu' => $this->modul->TanggalWaktu()
                    );
                    $kond['idsiswa'] = $row->idsiswa;
                    $kond['idjadwaldetil'] = $idjadwaldetil;
                    $kond['idjadwal'] = $idjadwal;
                    $this->model->update("presensi_siswa",$data,$kond);
                    
                }else{
                    $data = array(
                        'idpresensi_siswa' => $this->modul->getCurTime().$row->idsiswa,
                        'idjadwaldetil' => $idjadwaldetil,
                        'idsiswa' => $row->idsiswa,
                        'waktu' => $this->modul->TanggalWaktu(),
                        'idjadwal' => $idjadwal
                    );
                    $this->model->add("presensi_siswa",$data);
                    
                }
            }

            $status = "Presensi tersimpan";
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function preview(){
        if(session()->get("logged_pengajar")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

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
                echo view('back/pengajar/menu');
                echo view('back/pengajar/presensi/preview');
                echo view('back/foot');
            }else{
                $this->modul->halaman('presensisiswa');
            }
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlevel() {
        if (session()->get("logged_pengajar")) {
            $data = array();
            $kode = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("SELECT * FROM kurikulum u where u.idlevel = '".$kode."'");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->judul;
                $str = '<table style="width: 100%;">';
                $str .= '<thead>
                        <tr>
                            <th>Tema</th>
                            <th>Kompetensi</th>
                        </tr>
                    </thead>';
                $str .= '<tbody>';
                $list2 = $this->model->getAllQ("select * from kurikulum_detil where idkurikulum = '".$row->idkurikulum."'");
                foreach($list2->getResult() as $rows){
                    $str .= '<tr><td>'.$rows->menu;
                    $str .= '</td>';
                    $list3 = $this->model->getAllQ("select * from kurikulum_detil_sub where idkur_det = '".$rows->idkur_det."'");
                    $str .= '<td><table style="width: 100%;">';
                    foreach($list3->getResult() as $row2){
                        $str .= '<tr><td>'.$row2->kompetensi.'</td>';
                        $str .= '<td><div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                                    . '<input type="checkbox" name="kodebadan" value="'.$row2->idkur_det_sub.'"></input>'
                                    . '</div></div></td></tr>';
                    }
                    $str .= '</td></tr>';
                    $str .= '</tbody></table>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlevel2() {
        if (session()->get("logged_pengajar")) {
            $data = array();
            $kode = explode(",", $this->request->getUri()->getSegment(3));
            $list = $this->model->getAllQ("SELECT * FROM kurikulum u where u.idlevel = '".$kode[0]."'");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->judul;
                $str = '<table style="width: 100%;">';
                $str .= '<thead>
                        <tr>
                            <th>Tema</th>
                            <th>Kompetensi</th>
                        </tr>
                    </thead>';
                $str .= '<tbody>';
                $list2 = $this->model->getAllQ("select * from kurikulum_detil where idkurikulum = '".$row->idkurikulum."'");
                foreach($list2->getResult() as $rows){
                    $str .= '<tr><td>'.$rows->menu;
                    $str .= '</td>';
                    $list3 = $this->model->getAllQ("select * from kurikulum_detil_sub where idkur_det = '".$rows->idkur_det."'");
                    $str .= '<td><table style="width: 100%;">';
                    foreach($list3->getResult() as $row2){
                        $str .= '<tr><td>'.$row2->kompetensi.'</td><td>';
                        $cek = $this->model->getAllQR("select count(*) as jml from kurikulum_kelas where idkur_det_sub = '".$row2->idkur_det_sub."' and idjadwaldetil = '".$kode[1]."';")->jml;
                        if($cek > 0){
                            $str .= '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                                    . '<input type="checkbox" name="kodebadan" value="'.$row2->idkur_det_sub.'" checked></input>'
                                    . '</div></div>';
                        }else{
                            $str .= '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                                    . '<input type="checkbox" name="kodebadan" value="'.$row2->idkur_det_sub.'"></input>'
                                    . '</div></div>';
                        }
                        $str .= '</td></tr>';
                    }
                    $str .= '</td></tr>';
                    $str .= '</tbody></table>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if(session()->get("logged_pengajar")){
            $hasil = explode(",", $this->request->getPost('hasil'));
            for($b = 0; $b < count($hasil); $b++) {
                $datap = array(
                    'idkur_kel' => $this->model->autokode("K","idkur_kel","kurikulum_kelas", 2, 7),
                    'idkur_det_sub' => $hasil[$b],
                    'idjadwaldetil' => $this->request->getPost('kode'),
                );
                $simpan = $this->model->add("kurikulum_kelas",$datap);
            }
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_pengajar")){
            $cek = $this->model->getAllQR("select count(*) as jml from kurikulum_kelas where idjadwaldetil = '".$this->request->getPost('kode')."'")->jml;
            if($cek > 0){
                $d = $this->model->getAllQ("select idkur_kel from kurikulum_kelas where idjadwaldetil = '".$this->request->getPost('kode')."'");
                foreach($d->getResult() as $row){
                    $kondh['idkur_kel'] = $row->idkur_kel;
                    $this->model->delete("kurikulum_kelas",$kondh);
                }
            }
            $hasil = explode(",", $this->request->getPost('hasil'));
            for($b = 0; $b < count($hasil); $b++) {
                $datap = array(
                    'idkur_kel' => $this->model->autokode("K","idkur_kel","kurikulum_kelas", 2, 7),
                    'idkur_det_sub' => $hasil[$b],
                    'idjadwaldetil' => $this->request->getPost('kode'),
                );
                $update = $this->model->add("kurikulum_kelas",$datap);
            }
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ganti(){
        if(session()->get("logged_pengajar")){
            $kondisi['idjadwaldetil'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("kurikulum_kelas", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
