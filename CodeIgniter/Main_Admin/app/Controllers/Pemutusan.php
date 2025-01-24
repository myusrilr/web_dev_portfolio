<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pemutusan extends BaseController {
    
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
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            $data['alasan'] = $this->model->getAllQR("SELECT * FROM keluar where idusers = '".session()->get("idusers")."';");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;

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

            $data['linkform'] = $this->model->getAllQ("select * from form");

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/form/pemutusan');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function syarat(){
        if(session()->get("logged_karyawan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            $data['syarat'] = $this->model->getAllQR("select syarat from syarat limit 1")->syarat;
            
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
            echo view('front/form/syarat');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_add() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'setuju' => 1,
            );
            $kond['idusers'] = session()->get("idusers");
            $update = $this->model->update("keluar",$data, $kond);
            if($update == 1){
                $status = "simpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function proses() {
        if(session()->get("logged_karyawan")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $scan = $this->model->getAllQR("SELECT scan FROM keluar where idusers = '".session()->get("idusers")."';")->scan;
                    if($scan == null){
                        $status = $this->update_file();
                    }else{
                        $status = $this->simpan_file();
                    }
                }
            }else{
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    private function simpan_file() {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if($status_upload){
                $data = array(
                    'alasan' => $this->request->getPost('alasan'),
                    'scan' => $fileName,
                );
                $kond['idusers'] = session()->get("idusers");
                $this->model->update("keluar",$data, $kond);
                $status = "Data tersimpan";
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function simpan() {
        $data = array(
            'alasan' => $this->request->getPost('alasan'),
        );
        $kond['idusers'] = session()->get("idusers");
        $simpan = $this->model->update("keluar",$data, $kond);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    private function update_file() {
        // hapus file lama
        $lawas = $this->model->getAllQR("SELECT scan FROM keluar where idusers='".session()->get("idusers")."';")->scan;
        if(strlen($lawas) > 0){
            if(file_exists($this->modul->getPathApp().$lawas)){
                unlink($this->modul->getPathApp().$lawas);
            }
        }
            
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if($status_upload){
                $data = array(
                    'alasan' => $this->request->getPost('alasan'),
                    'scan' => $fileName,
                );
                $kond['idusers'] = session()->get("idusers");
                $update = $this->model->update("keluar",$data, $kond);
                if($update == 1){
                    $status = "sukses";
                }else{
                    $status = "gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    public function kirim() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'kirim' => 1,
                'status' => 'Diajukan',
            );
            $kond['idusers'] = session()->get("idusers");
            $update = $this->model->update("keluar",$data, $kond);
            if($update == 1){
                $status = "sukses";
            }else{
                $status = "gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function batalkan() {
        if(session()->get("logged_karyawan")){
            $scan = $this->model->getAllQR("SELECT scan FROM keluar where idusers = '".session()->get("idusers")."';")->scan;
            if($scan != null){
                $lawas = $this->model->getAllQR("SELECT scan FROM keluar where idusers='".session()->get("idusers")."';")->scan;
                if(strlen($lawas) > 0){
                    if(file_exists($this->modul->getPathApp().$lawas)){
                        unlink($this->modul->getPathApp().$lawas);
                    }
                }
            }
            $data = array(
                'kirim' => null,
                'setuju' => null,
                'alasan' => null,
                'scan' => null,
                'status' => null,
            );
            $kond['idusers'] = session()->get("idusers");
            $update = $this->model->update("keluar",$data, $kond);
            if($update == 1){
                $status = "sukses";
            }else{
                $status = "gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
