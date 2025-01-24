<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Riwayatkeluarga extends BaseController {
    
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
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['idkaryawan'] = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".session()->get("idusers")."'")->idkaryawan;
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

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/riwayat/menu');
            echo view('front/riwayat/keluarga');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from keluarga where idusers = '".session()->get("idusers")."'");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->hubungan;
                $val[] = $row->namalengkap;
                $val[] = $row->pekerjaan;
                $val[] = $row->hp;
                $val[] = '<div style="text-align: center;">'
                . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idkeluarga."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idkeluarga."'".','."'".$row->namalengkap."'".')"><i class="fas fa-trash-alt"></i></button>'
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
    
    public function ajax_add() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'idkeluarga' => $this->model->autokode("K","idkeluarga","keluarga", 2, 7),
                'hubungan' => $this->request->getPost('hubungan'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'namalengkap' => $this->request->getPost('namalengkap'),
                'hp' => $this->request->getPost('hp'),
                'idusers' => $this->request->getPost('idkaryawan'),
            );
            $simpan = $this->model->add("keluarga",$data);
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
        if(session()->get("logged_karyawan")){
            $kondisi['idkeluarga'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("keluarga", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'hubungan' => $this->request->getPost('hubungan'),
                'pekerjaan' => $this->request->getPost('pekerjaan'),
                'namalengkap' => $this->request->getPost('namalengkap'),
                'hp' => $this->request->getPost('hp'),
            );
            $kond['idkeluarga'] = $this->request->getPost('kode');
            $update = $this->model->update("keluarga",$data, $kond);
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
        if(session()->get("logged_karyawan")){
            $kond['idkeluarga'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("keluarga",$kond);
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
