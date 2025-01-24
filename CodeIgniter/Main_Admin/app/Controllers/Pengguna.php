<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pengguna extends BaseController {
    
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
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
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

            $data['jabatan'] = $this->model->getAllQ("SELECT idjabatan, nama, jabatan FROM divisi d, jabatan j where d.iddivisi = j.iddivisi;");
            $data['roles'] = $this->model->getAllQ("SELECT * FROM role;");
            // $data['jamkerja'] = $this->model->getAllQ("SELECT * FROM jamkerja;");

            echo view('back/head', $data);
            if(session()->get("role") == 'R00004'){
                echo view('back/bos/menu');
            }elseif(session()->get("role") == 'R00003'){
                echo view('back/it/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/users/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_hr")){
            if(0 < $_FILES['file']['error']) {
                $status = "Error during file upload ".$_FILES['file']['error'];
            }else{
                $status = $this->simpan();                
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if(session()->get("logged_hr")){
            $tahun = date("d-m-Y", strtotime($this->request->getPost('tanggal')));
            $hasil = explode(",", $this->request->getPost('hasil'));
            $ishr = 0;$isit = 0;$ispdd = 0;$isga = 0;$isbusdev = 0;$ispimpinan = 0;$ispurchase = 0;$isteaching = 0;
            for($b = 0; $b < count($hasil); $b++) {
                if($hasil[$b] == 'ishr'){ $ishr = 1; }
                if($hasil[$b] == 'isit'){ $isit = 1; }
                if($hasil[$b] == 'ispdd'){ $ispdd = 1; }
                if($hasil[$b] == 'isga'){ $isga = 1; }
                if($hasil[$b] == 'isbusdev'){ $isbusdev = 1; }
                if($hasil[$b] == 'ispimpinan'){ $ispimpinan = 1; }
                if($hasil[$b] == 'ispurchase'){ $ispurchase = 1; }
                if($hasil[$b] == 'isteaching'){ $isteaching = 1; }
            }
            $idusers = $this->model->autokode("U","idusers","users", 2, 7);
            $data = array(
                'idusers' => $idusers,
                'email' => $this->request->getPost('email'),
                'idjabatan' => $this->request->getPost('idjabatan'),
                'idrole' => $this->request->getPost('idrole'),
                'expertise' => $this->request->getPost('expertise'),
                'ispurchase' => $ispurchase,
                'isteaching' => $isteaching,
                'ishr' => $ishr,
                'isit' => $isit,
                'ispdd' => $ispdd,
                'isga' => $isga,
                'isbusdev' => $isbusdev,
                'ispimpinan' => $ispimpinan,
                'status' => $this->request->getPost('status'),
                'thnbekerja' => $this->request->getPost('tanggal'),
                'pass' => $this->modul->enkrip_pass('123'),
            );
            $this->model->add("users",$data);
            
            //membuat idkaryawan
            $urutan = substr($idusers, -3);
            $huruf = "LEAP";
            $bulan = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII'
            ];
            $pecahkan = explode('-', $this->request->getPost('tanggal'));
            if (str_contains($pecahkan[1], '0')) {
                $bul = substr($pecahkan[1], -1);
            }else{
                $bul = $pecahkan[1];
            }
            if($pecahkan[1] == 10){
                $bul = $pecahkan[1];
            }
            
            $idkar = $huruf.sprintf("%03s", $urutan).$bulan[$bul].$pecahkan[0];

            //menyimpan idkaryawan
            $datak = array(
                'idusers' => $idusers,
                'idkaryawan' => $idkar,
            );
            $this->model->add("karyawan",$datak);

            $data = array(
                'idusers' => $idusers,
                'setuju' => 0,
            );
            $simpan = $this->model->add("keluar",$data);
            if($simpan == 1){
                $status = "simpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_addE() {
        if(session()->get("logged_hr")){
            $idusers = $this->request->getPost('kode');
            $data = array(
                'expertise' => $this->request->getPost('expert'),
            );
            $kond['idusers'] = $idusers;
            $simpan = $this->model->update("users",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_hr")){
            $tahun = date("d-m-Y", strtotime($this->request->getPost('tanggal')));
            $hasil = explode(",", $this->request->getPost('hasil'));
            $ishr = 0;$isit = 0;$ispdd = 0;$isga = 0;$isbusdev = 0;$ispimpinan = 0;$ispurchase = 0;$isteaching = 0;
            for($b = 0; $b < count($hasil); $b++) {
                if($hasil[$b] == 'ishr'){ $ishr = 1; }
                if($hasil[$b] == 'isit'){ $isit = 1; }
                if($hasil[$b] == 'ispdd'){ $ispdd = 1; }
                if($hasil[$b] == 'isga'){ $isga = 1; }
                if($hasil[$b] == 'isbusdev'){ $isbusdev = 1; }
                if($hasil[$b] == 'ispimpinan'){ $ispimpinan = 1; }
                if($hasil[$b] == 'ispurchase'){ $ispurchase = 1; }
                if($hasil[$b] == 'isteaching'){ $isteaching = 1; }
            }
            $data = array(
                'email' => $this->request->getPost('email'),
                'idjabatan' => $this->request->getPost('idjabatan'),
                'idrole' => $this->request->getPost('idrole'),
                'status' => $this->request->getPost('status'),
                'ispurchase' => $ispurchase,
                'isteaching' => $isteaching,
                'expertise' => $this->request->getPost('expertise'),
                'thnbekerja' => $this->request->getPost('tanggal'),
                'ishr' => $ishr,
                'isit' => $isit,
                'ispdd' => $ispdd,
                'isga' => $isga,
                'isbusdev' => $isbusdev,
                'ispimpinan' => $ispimpinan,
            );
            $kode = $this->request->getPost('kode');

            $kond['idusers'] = $kode;
            $this->model->update("users",$data, $kond);

            //membuat idkaryawan
            $urutan = substr($kode, -3);
            $huruf = "LEAP";
            $bulan = array(
                1=> 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'
            );
            $pecahkan = explode('-', $tahun);
            if (str_contains($pecahkan[1], '0')) {
                $bul = substr($pecahkan[1], -1);
            }else{
                $bul = $pecahkan[1];
            }
            $idkar = $huruf.sprintf("%03s", $urutan).$bulan[$bul].$pecahkan[0];
            
            $datak = array(
                'idkaryawan' => $idkar,
            );
            $kond['idusers'] = $kode;
            $update = $this->model->update("karyawan", $datak, $kond);

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

    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $list = $this->model->getAllQ("select *, u.email, u.status from users u, karyawan k where u.idusers = k.idusers and idrole not in('R00004');");
            foreach ($list->getResult() as $row) {
                $def_foto = base_url().'/images/noimg.jpg';
                if(strlen($row->foto) > 0){
                    if(file_exists($this->modul->getPathApp().$row->foto)){
                        $def_foto = base_url().'/uploads/'.$row->foto;
                    }
                }

                $val = array();
                $cek_k = $this->model->getAllQR("SELECT count(idkaryawan) as jml FROM karyawan where idusers = '".$row->idusers."';")->jml;
                if($cek_k > 0){
                    $k = $this->model->getAllQR("SELECT idkaryawan, link, ktp FROM karyawan where idusers = '".$row->idusers."';");
                    $val[] = $k->idkaryawan;
                }else{
                    $val[] = '';
                }
                
                $val[] = '<img src="'.$def_foto.'" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">';
                $str = '<b>'.$row->nama.' ('.$row->nickname.')</b><br>Email: '.$row->email.'<br>Whatsapp : '.$row->wa;
                if($k->link != null){
                    $str .= '<br><a href="'.$k->link.'" target="_blank">LINK DRIVE DOKUMEN</a>';
                }
                $val[] = $str;
                
                // $cek_jk = $this->model->getAllQR("SELECT count(*) as jml FROM jamkerja where idjamkerja = '".$row->idjamkerja."';")->jml;
                // if($cek_jk > 0){
                //     $jk = $this->model->getAllQR("SELECT * FROM jamkerja where idjamkerja = '".$row->idjamkerja."';");
                //     $val[] = $jk->namajamkerja.' ('.date('H:i',strtotime($jk->jammasuk)).' - '.date('H:i',strtotime($jk->jampulang)).')';
                // }else{
                //     $val[] = '-';
                // }
                
                $val[] = $this->model->getAllQR("SELECT nama_role FROM role where idrole = '".$row->idrole."';")->nama_role;
                if($row->status == 'Aktif'){
                    $val[] = '<span class="badge badge-success">Aktif</span>';
                }else{
                    $val[] = '<span class="badge badge-danger">Non Aktif</span>';
                }
                if(session()->get("logged_bos") && $k->ktp != null){
                    $but = '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idusers."'".')">Detail</button></div>';
                }elseif($k->ktp == null){
                    if(session()->get("logged_it")){
                        $but = '<div style="text-align: center;">'
                        .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="lock('."'".$row->idusers."'".')"><i class="fa fa-fw fa-lock"></i></button>&nbsp;'
                        .'<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idusers."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        .'<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idusers."'".','."'".$row->nama."'".')"><i class="fas fa-trash-alt"></i></button>'
                        .'<br><br><span class="badge badge-warning">Data Belum Diisi</span>';
                    }else{
                        $but = '<span class="badge badge-warning">Data Belum Diisi</span>';
                    }
                }else{
                    if(session()->get("logged_it")){
                        $but = '<div style="text-align: center;">'
                        .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="lock('."'".$row->idusers."'".')"><i class="fa fa-fw fa-lock"></i></button>&nbsp;'
                        .'<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idusers."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idusers."'".','."'".$row->nama."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '<br><br><button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idusers."'".')">Detail</button></div>';
                    }else{
                        $but = '<div style="text-align: center;"><button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idusers."'".')">Detail</button></div>';
                    }
                }
                if($row->expertise != ''){
                    $but .= '<br><br><button type="button" class="btn btn-sm btn-secondary btn-fw" onclick="expertedit('."'".$row->idusers."'".')">Edit Expertise</button>'
                    .'<br>Expert : '.$row->expertise;
                }else{
                    $but .= '<br><br><button type="button" class="btn btn-sm btn-info btn-fw" onclick="expert('."'".$row->idusers."'".')">Tambah Expertise</button>';
                }
                $val[] = $but;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapus() {
        if(session()->get("logged_hr")){
            $id = $this->request->getUri()->getSegment(3);
            $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '".$id."';")->foto;
            if(strlen($lawas) > 0){
                if(file_exists($this->modul->getPathApp().$lawas)){
                    unlink($this->modul->getPathApp().$lawas);
                }
            }

            $kond['idusers'] = $id;
            $hapus = $this->model->delete("users",$kond);
            if($hapus == 1){
                $status = "Hapus Berhasil";
            }else{
                $status = "Hapus Gagal";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function reset() {
        if(session()->get("logged_hr")){
            $id = $this->request->getUri()->getSegment(3);
            $data = array(
                'pass' => $this->modul->enkrip_pass('123'),
            );
            $kond['idusers'] = $id;
            $update = $this->model->update("users",$data, $kond);
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
        if(session()->get("logged_hr")){
            $kondisi['idusers'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function detail(){
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);

            $kode = $this->request->getUri()->getSegment(3);
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".$kode."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_karyawan'] = $def_foto;

            $data['u'] = $this->model->getAllQR("SELECT * FROM karyawan where idusers = '".$kode."';");
            $data['pu'] = $this->model->getAllQR("SELECT * FROM users u, jabatan j, divisi d where idusers = '".$kode."' and j.idjabatan = u.idjabatan and j.iddivisi = d.iddivisi;");
            $data['ke'] = $this->model->getAllQ("SELECT * FROM keluarga where idusers = '".$kode."';");
            $data['pen'] = $this->model->getAllQ("SELECT * FROM pendidikan where idusers = '".$kode."';");
            $data['pe'] = $this->model->getAllQ("SELECT * FROM pekerjaan where idusers = '".$kode."';");
            $data['kursus'] = $this->model->getAllQ("SELECT * FROM kursus where idusers = '".$kode."';");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
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
            if(session()->get("role") == 'R00004'){
                echo view('back/bos/menu');
            }elseif(session()->get("role") == 'R00003'){
                echo view('back/it/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/users/detail');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
}
