<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Tabungan extends BaseController {
    
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
            $data['kategori'] = $this->model->getAllQ("SELECT * from sopkategori;");
            
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
                echo view('back/hrd/menu');
            }
            echo view('back/hrd/tabungan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from users;");
            foreach ($list->getResult() as $row) {
                $val = array();
                
                $val[] = $no;
                $val[] = $row->nama;
                $val[] = $this->model->getAllQR("SELECT d.nama FROM users u, jabatan j, divisi d where j.iddivisi = d.iddivisi and u.idjabatan = j.idjabatan and idusers = '".$row->idusers."';")->nama;
                //hitung jam
                $ijin = 0;
                $lembur = 0;
                
                $jam = $this->model->getAllQ("SELECT CASE WHEN jenis = 'Lembur' THEN 'Lembur' ELSE 'Ijin' END AS jenis,
                SEC_TO_TIME(SUM((DATEDIFF(tanggalselesai, tanggalmulai) + 1) * TIME_TO_SEC(TIMEDIFF(waktuselesai, waktumulai)))) AS total_time
                FROM perijinan WHERE idusers = '".$row->idusers."' AND status = 'Disetujui' GROUP BY
                CASE WHEN jenis = 'Lembur' THEN 'Lembur' ELSE 'Ijin' END;");
                
                foreach ($jam->getResult() as $rows) {
                    if ($rows->jenis == 'Lembur') {
                        $lembur = $rows->total_time;
                    } else {
                        $ijin = $rows->total_time;
                    }
                }

                $totjam = $this->model->getAllQR("select subtime('".$lembur."','".$ijin."')as result")->result;
                if($totjam == '00:00:00'){
                    $val[] = '-';
                }else{
                    $val[] = $totjam;
                    $data[] = $val;
                    $no++;
                }
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if(session()->get("logged_hr")){
            $data = array(
                'judul' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
            );
            $simpan = $this->model->add("infrastruktur",$data);
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
    
    public function ganti(){
        if(session()->get("logged_hr")){
            $kondisi['idinfrastruktur'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("infrastruktur", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_hr")){
            $data = array(
                'judul' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
            );
            $kond['idinfrastruktur'] = $this->request->getPost('kode');
            $update = $this->model->update("infrastruktur",$data, $kond);
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
    
    public function hapus() {
        if(session()->get("logged_hr")){
            $kond['idinfrastruktur'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("infrastruktur",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
