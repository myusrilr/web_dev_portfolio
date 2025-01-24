<?php

namespace App\Controllers;

/**
 * Description of Homepengajar
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homepengajar extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index()
    {
        if (session()->get("logged_pengajar")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $def_foto = base_url() . '/images/noimg.jpg';
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            echo view('back/head', $data);
            echo view('back/pengajar/menu');
            echo view('back/pengajar/content');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxevent()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");

            $eventsArr = array();
            // $list = $this->model->getAllQ("SELECT a.idjadwaldetil as kode, a.title, a.description, a.url, a.start, a.end, a.color, 'jadwal' as sumber 
            //     FROM jadwal_detil a, jadwal b, jadwal_pengajar c where a.idjadwal = b.idjadwal and a.idjadwal = c.idjadwal and c.idusers = '".$idusers."'  
            //     union 
            //     SELECT idlibur as kode, title, description, url, start, end, color, 'libur' as sumber FROM libur;");
            // foreach ($list->getResult() as $row) {
            //     array_push($eventsArr, $row); 
            // }

            $list = $this->model->getAllQ("SELECT idlibur as kode, title, description, url, start, end, color, 'libur' as sumber FROM libur;");
            foreach ($list->getResult() as $row) {
                array_push($eventsArr, $row);
            }

            $list = $this->model->getAllQ("SELECT a.idjadwaldetil as kode, a.title, a.description, a.url, a.start, a.end, a.color, 'jadwal' as sumber 
            FROM jadwal_detil a, jadwal b, jadwal_pengajar c where a.idjadwal = b.idjadwal and a.idjadwal = c.idjadwal and c.idusers = '" . $idusers . "' and b.status_archive = 0 
            order by b.idsesi");
            foreach ($list->getResult() as $row) {
                array_push($eventsArr, $row);
            }

            echo json_encode($eventsArr);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function showinfolibur() {
        if(session()->get("logged_pengajar")){
            $idlibur = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select idlibur, title, description, url, date_format(start, '%d %M %Y') as start, date_format(DATE_ADD(end, INTERVAL -1 DAY), '%d %M %Y') as end, color from libur_mitra where idlibur = '".$idlibur."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function showinfo() {
        if(session()->get("logged_pengajar")){
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->model->getAllQR("select idjadwal from jadwal_detil_mitra where idjadwaldetil = '".$idjadwaldetil."';")->idjadwal;
            // head
            $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, f.meeting_id, f.link, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar 
                from jadwal_mitra a, sesi_mitra e, zoom_mitra f, levelmitra g, periode_mitra h, pendidikankursusmitra i  
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idpendkursus = i.idpendkursus 
                and a.idsesi = e.idsesi and a.idjadwal = '".$idjadwal."';");
            
            $pengajar = '';
            $cek_pengajar = $this->model->getAllQR("select count(*) as jml from jadwal_pengajar_mitra where idjadwal = '".$idjadwal."';")->jml;
            if($cek_pengajar > 0){
                $list_pengajar = $this->model->getAllQ("select b.nama from jadwal_pengajar_mitra a, users_mitra b where idjadwal = '".$idjadwal."' and a.idusers = b.idusers;");
                foreach ($list_pengajar->getResult() as $rowpengajar) {
                    $pengajar .= $rowpengajar->nama.', ';
                }
                $pengajar = substr($pengajar, 0, strlen($pengajar)-2);
            }

            echo json_encode(array(
                "kursus" => $head->nama_kursus, 
                "sesi" => $head->nama_sesi . ' (' . $head->waktu_awal . ' - ' . $head->waktu_akhir . ')', 
                "periode" => $head->tahun_ajar,
                "hari" => $head->hari,
                "level" => $head->level,
                "pengajar" => $pengajar,
                "zoom" => '<a target="_blank" href="'.$head->link.'">'.$head->meeting_id.'</a>'
            ));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxjadwalsiswa() {
        if(session()->get("logged_pengajar")){
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->model->getAllQR("select idjadwal from jadwal_detil_mitra where idjadwaldetil = '".$idjadwaldetil."';")->idjadwal;
            
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idjadwal_siswa, b.nama_lengkap, b.panggilan from jadwal_siswa_mitra a, siswamitra b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
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
