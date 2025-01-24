<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Riwayatpekerjaan extends BaseController {
    
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
            echo view('front/riwayat/pekerjaan');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pekerjaan where idusers = '".session()->get("idusers")."'");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->namaperusahaan.' ('.$row->periode.')<br>'.$row->jabatan.'<br><b>Jobdesk :</b>'.$row->jobdesk;
                $val[] = '<div style="text-align: center;">'
                . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idpekerjaan."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idpekerjaan."'".','."'".$row->namaperusahaan."'".')"><i class="fas fa-trash-alt"></i></button>'
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
                'idpekerjaan' => $this->model->autokode("K","idpekerjaan","pekerjaan", 2, 7),
                'periode' => $this->request->getPost('periode'),
                'jabatan' => $this->request->getPost('jabatan'),
                'namaperusahaan' => $this->request->getPost('namaperusahaan'),
                'jobdesk' => $this->request->getPost('jobdesk'),
                'idusers' => $this->request->getPost('idkaryawan'),
            );
            $simpan = $this->model->add("pekerjaan",$data);
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
            $kondisi['idpekerjaan'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("pekerjaan", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'periode' => $this->request->getPost('periode'),
                'jabatan' => $this->request->getPost('jabatan'),
                'namaperusahaan' => $this->request->getPost('namaperusahaan'),
                'jobdesk' => $this->request->getPost('jobdesk'),
            );
            $kond['idpekerjaan'] = $this->request->getPost('kode');
            $update = $this->model->update("pekerjaan",$data, $kond);
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
            $kond['idpekerjaan'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("pekerjaan",$kond);
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
