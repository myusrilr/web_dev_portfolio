<?php
namespace App\Controllers;

/**
 * Description of Homependidkan
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homependidikan extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_pendidikan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENDIDIKAN";
            
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
            
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['sesi'] = $this->model->getAllQ("select * from sesi");

            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
            echo view('back/akademik/menu');
            }
            echo view('back/akademik/content');
            echo view('back/foot');
        
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxevent() {
        if(session()->get("logged_pendidikan")){
            $eventsArr = array(); 
            // $list = $this->model->getAllQ("SELECT idjadwaldetil as kode, title, description, url, start, end, color, 'jadwal' as sumber FROM jadwal_detil 
            //     union 
            //     SELECT idlibur as kode, title, description, url, start, end, color, 'libur' as sumber FROM libur;");
            // foreach ($list->getResult() as $row) {
            //     array_push($eventsArr, $row); 
            // }

            $list = $this->model->getAllQ("SELECT idlibur as kode, title, description, url, start, end, color, 'libur' as sumber FROM libur;");
            foreach ($list->getResult() as $row) {
                array_push($eventsArr, $row); 
            }

            $list = $this->model->getAllQ("SELECT idjadwaldetil as kode, title, description, url, start, end, color, 'jadwal' as sumber FROM jadwal_detil a, jadwal b where a.idjadwal = b.idjadwal and b.status_archive = 0 order by b.idsesi;");
            foreach ($list->getResult() as $row) {
                array_push($eventsArr, $row); 
            }

            echo json_encode($eventsArr);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function showinfo() {
        if(session()->get("logged_pendidikan")){
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->model->getAllQR("select idjadwal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->idjadwal;
            // head
            $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, f.meeting_id, f.link, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar 
                from jadwal a, sesi e, zoom f, level g, periode h, pendidikankursus i  
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idpendkursus = i.idpendkursus 
                and a.idsesi = e.idsesi and a.idjadwal = '".$idjadwal."';");
            
            $pengajar = '';
            $cek_pengajar = $this->model->getAllQR("select count(*) as jml from jadwal_pengajar where idjadwal = '".$idjadwal."';")->jml;
            if($cek_pengajar > 0){
                $list_pengajar = $this->model->getAllQ("select b.nama from jadwal_pengajar a, users b where idjadwal = '".$idjadwal."' and a.idusers = b.idusers;");
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
        if(session()->get("logged_pendidikan")){
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->model->getAllQR("select idjadwal from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';")->idjadwal;
            
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idjadwal_siswa, b.nama_lengkap, b.panggilan from jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."';");
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

    public function showinfolibur() {
        if(session()->get("logged_pendidikan")){
            $idlibur = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select idlibur, title, description, url, start, DATE_ADD(end, INTERVAL -1 DAY) as end, color from libur where idlibur = '".$idlibur."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function showpindah() {
        if(session()->get("logged_pendidikan")){
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("SELECT a.idjadwal, b.idjadwaldetil, a.groupwa, a.idpendkursus, c.nama_kursus as kursus, b.start as tanggal 
                FROM jadwal a, jadwal_detil b, pendidikankursus c where a.idjadwal = b.idjadwal and a.idpendkursus = c.idpendkursus and b.idjadwaldetil = '".$idjadwaldetil."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses_pindah_jadwal() {
        if(session()->get("logged_pendidikan")){
            $tgl_pindah = $this->request->getPost('tgl_pindah');
            
            // cek apakah tanggal tersebut ada yang libur apa tidak
            $cek = $this->model->getAllQR("select count(*) as jml from libur where start <= '".$tgl_pindah."' and DATE_ADD(end, INTERVAL -1 DAY) >= '".$tgl_pindah."';")->jml;
            if($cek > 0){
                $status = "Data gagal dipindah. Terdapat hari libur";
            }else{
                $data = array(
                    'start' => $tgl_pindah,
                    'end' => $tgl_pindah
                );
                $kond['idjadwaldetil'] = $this->request->getPost('idjadwaldetil');
                $simpan = $this->model->update("jadwal_detil",$data, $kond);
                if($simpan == 1){
                    $status = "Jadwal berhasil dipindah";
                }else{
                    $status = "Jadwal gagal dipindah";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses_pindah_jadwal_multi() {
        if(session()->get("logged_pendidikan")){
            $maju_mundur = $this->request->getPost('maju_mundur_minggu');
            
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idjadwal = $this->request->getPost('idjadwal');

            
            $datahead = $this->model->getAllQR("select a.idperiode, b.jml_sesi, a.hari from jadwal a, periode b where a.idjadwal = '".$idjadwal."' and a.idperiode = b.idperiode;");
            $datadetil = $this->model->getAllQR("select idjadwaldetil, start as patokan, DATE_ADD(start, INTERVAL ".$maju_mundur." WEEK) as awal, "
                    . "day(DATE_ADD(start, INTERVAL ".$maju_mundur." WEEK)) as hari, "
                    . "month(DATE_ADD(start, INTERVAL ".$maju_mundur." WEEK)) as bulan, "
                    . "year(DATE_ADD(start, INTERVAL ".$maju_mundur." WEEK)) as tahun from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");

            // mencari jumlah kurangnya
            $sudah_dilalui = $this->model->getAllQR("SELECT count(*) as jml FROM jadwal_detil where start < '".$datadetil->patokan."' and idjadwal = '".$idjadwal."';")->jml;
            $jml_kurang = $datahead->jml_sesi - $sudah_dilalui;
            
            $data_tgl = $this->setJadwalDetil($datadetil->hari, $datadetil->bulan, $datadetil->tahun, $datahead->hari, $jml_kurang);

            // masukkan data ke dalam array untuk mengganti
            $data_idjadwaldetil = array();
            $list_data_diganti = $this->model->getAllQ("SELECT idjadwaldetil FROM jadwal_detil where start >= '".$datadetil->patokan."' and idjadwal = '".$idjadwal."';");
            foreach ($list_data_diganti->getResult() as $row) {
                array_push($data_idjadwaldetil, $row->idjadwaldetil);
            }

            for ($i = 0; $i < count($data_tgl); $i++) {
               $dataDetil = array(
                   'start' => $data_tgl[$i],
                   'end' => $data_tgl[$i]
               );
               $kond['idjadwaldetil'] = $data_idjadwaldetil[$i];
               $this->model->update("jadwal_detil", $dataDetil, $kond);
            }


            $status = "Jadwal berhasil dipindah";
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function proses_pindah_jadwal_multi_hari() {
        if(session()->get("logged_pendidikan")){
            $maju_mundur = $this->request->getPost('maju_mundur_hari');
            
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idjadwal = $this->request->getPost('idjadwal');

            
            $datahead = $this->model->getAllQR("select a.idperiode, b.jml_sesi, a.hari from jadwal a, periode b where a.idjadwal = '".$idjadwal."' and a.idperiode = b.idperiode;");
            $datadetil = $this->model->getAllQR("select idjadwaldetil, start as patokan, DATE_ADD(start, INTERVAL ".$maju_mundur." DAY) as awal, "
                    . "day(DATE_ADD(start, INTERVAL ".$maju_mundur." DAY)) as hari, "
                    . "month(DATE_ADD(start, INTERVAL ".$maju_mundur." DAY)) as bulan, "
                    . "year(DATE_ADD(start, INTERVAL ".$maju_mundur." DAY)) as tahun from jadwal_detil where idjadwaldetil = '".$idjadwaldetil."';");

            // mencari jumlah kurangnya
            $sudah_dilalui = $this->model->getAllQR("SELECT count(*) as jml FROM jadwal_detil where start < '".$datadetil->patokan."' and idjadwal = '".$idjadwal."';")->jml;
            $jml_kurang = $datahead->jml_sesi - $sudah_dilalui;
            
            $data_tgl = $this->setJadwalDetil($datadetil->hari, $datadetil->bulan, $datadetil->tahun, $datahead->hari, $jml_kurang);

            // masukkan data ke dalam array untuk mengganti
            $data_idjadwaldetil = array();
            $list_data_diganti = $this->model->getAllQ("SELECT idjadwaldetil FROM jadwal_detil where start >= '".$datadetil->patokan."' and idjadwal = '".$idjadwal."';");
            foreach ($list_data_diganti->getResult() as $row) {
                array_push($data_idjadwaldetil, $row->idjadwaldetil);
            }

            for ($i = 0; $i < count($data_tgl); $i++) {
               $dataDetil = array(
                   'start' => $data_tgl[$i],
                   'end' => $data_tgl[$i]
               );
               $kond['idjadwaldetil'] = $data_idjadwaldetil[$i];
               $this->model->update("jadwal_detil", $dataDetil, $kond);
            }


            $status = "Jadwal berhasil dipindah";
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function setJadwalDetil($periode_tgl_awal, $periode_bulan_awal, $tahun, $patokanhari, $jml_sesi) {
        $putar = true;
        $counter = 1;

        if(strlen($periode_tgl_awal) == 1){
            $periode_tgl_awal = "0". $periode_tgl_awal;
        }

        if(strlen($periode_bulan_awal) == 1){
            $periode_bulan_awal = "0". $periode_bulan_awal;
        }

        // membaca hari libur pada database
        $data = array();

        $ddate = $tahun . "-" . $periode_bulan_awal . '-' . $periode_tgl_awal;

        $date = new \DateTime($ddate);
        $week = $date->format("W");
        
        $result = $this->Start_End_Date_of_a_week( ($week-1) ,$tahun);
        $tgl_awal = $result[0];
        $tgl_akhir = $result[1];

        //$daftar = $tahun . "-" . $periode_bulan_awal . '-' . $periode_tgl_awal;
        $daftar = $tgl_awal;

        // hari libur
        $tempHariLibur = $this->getHariLibur();
        
        // potong ke dalam Array
        $hari_patokan = explode(",", $patokanhari);
        
        while ($putar) {
            
            $hari = $this->modul->namaHariTglTertentu($daftar);
            if (in_array($hari, $hari_patokan) && !in_array($daftar, $tempHariLibur)) {
                
                array_push($data, $daftar); // masukkan ke dalam array
                $tgl_plus = $this->modul->TambahTanggal($daftar, 1);
                $daftar = $tgl_plus;
                
                $counter++;
                if ($counter > $jml_sesi) {
                    $putar = false;
                }

            }else{
                $tgl_plus = $this->modul->TambahTanggal($daftar, 1);
                $daftar = $tgl_plus;

                $putar = true;
            }
        }

        return $data;
    }
    
    public function getHariLibur(){
        $arr_libur = array();
        $libur1 = $this->model->getAllQ("select idlibur, title, start, DATE_ADD(end, INTERVAL -1 DAY) as kelar, DATEDIFF(end, start) as selisih from libur;");
        foreach($libur1->getResult() as $rowlibur1){
            $tgl_libur1 = $rowlibur1->start;
            $tgl_libur2 = $rowlibur1->kelar;

            // loop tanggal libur
            for ($i=1; $i <= $rowlibur1->selisih ; $i++) { 
                array_push($arr_libur, $tgl_libur1); // masukkan ke dalam array
                $tgl_libur1 = $this->modul->TambahTanggal($tgl_libur1, 1);
            }
        }

        return $arr_libur;
    }

    public function ajaxjadwalguru(){
        if(session()->get("logged_pendidikan")){
            $idusers = $this->request->getUri()->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select date_format(c.start, '%d %M %Y') as tgl, concat(f.waktu_awal, ' - ', f.waktu_akhir) as waktu, 
                d.nama_kursus, e.level, b.hari
                from jadwal_pengajar a, jadwal b, jadwal_detil c, pendidikankursus d, level e, sesi f
                where a.idjadwal = b.idjadwal and b.idjadwal = c.idjadwal
                and b.idpendkursus = d.idpendkursus and b.idlevel = e.idlevel
                and b.idsesi = f.idsesi
                and a.idusers = '".$idusers."';");

            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl.'<br>'.$row->waktu;
                $val[] = $row->nama_kursus;
                $val[] = $row->level;
                $val[] = $row->hari;
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function listguru(){
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select idusers, email, nama, wa from users where idrole = 'R00005';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->email;
                $val[] = $row->nama;
                $val[] = $row->wa;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info" onclick="pilihguru('."'".$row->idusers."'".','."'".$row->nama."'".')">Pilih</button>'
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

    public function ajaxmodaljadwalsiswa(){
        if(session()->get("logged_pendidikan")){
            $idusers = $this->request->getUri()->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select date_format(c.start, '%d %M %Y') as tgl, concat(f.waktu_awal, ' - ', f.waktu_akhir) as waktu, d.nama_kursus, e.level, b.hari 
            from jadwal_siswa a, jadwal b, jadwal_detil c, pendidikankursus d, level e, sesi f 
            where a.idjadwal = b.idjadwal and b.idjadwal = c.idjadwal and b.idpendkursus = d.idpendkursus and b.idlevel = e.idlevel and b.idsesi = f.idsesi and a.idsiswa = '".$idusers."';");

            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl.'<br>'.$row->waktu;
                $val[] = $row->nama_kursus;
                $val[] = $row->level;
                $val[] = $row->hari;
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }

    private function Start_End_Date_of_a_week($week, $year){
        $time = strtotime("1 January ".$year, time());
        $day = date('w', $time);
        $time += ((7*$week)+1-$day)*24*3600;
        $dates[0] = date('Y-m-d', $time);
        $time += 6*24*3600;
        $dates[1] = date('Y-m-d', $time);
        return $dates;
    }

    public function listsiswa(){
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select idsiswa, nama_lengkap, jkel from siswa;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_lengkap;
                $val[] = $row->jkel;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info" onclick="pilihsiswa('."'".$row->idsiswa."'".','."'".$row->nama_lengkap."'".')">Pilih</button>'
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

    private function mingguke(){
        $ddate = "2023-07-29";
        $date = new \DateTime($ddate);
        $week = $date->format("W");
        
        $result = $this->Start_End_Date_of_a_week(($week - 1),2023);
        echo 'Starting date of the week: '. $result[0]."\n";
        echo 'End date the week: '. $result[1];

        echo '<hr>';
        // $firstday = date('l - d/m/Y', strtotime("sunday 1 week"));
        // echo "First day of this week: ", $firstday;
    }

    public function getInfoPaketWA() {
        if(session()->get("logged_pendidikan")){

            $url = "https://app.whacenter.com/api/statusDevice?device_id=".$this->modul->deviceid1();

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = curl_exec($ch); 
            curl_close($ch); 
            
            echo $output;
        }else{
            $this->modul->halaman('login');
        }
    }
}
