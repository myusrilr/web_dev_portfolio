<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Profile extends BaseController {
    
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
                $data['alamat'] = $tersimpan->alamat;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'/images/noimg.jpg';
            }

            echo view('back/head', $data);
            echo view('back/hrd/menu');
            echo view('back/hrd/profile/index');
            echo view('back/foot');
            
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
                    $status = $this->update_file();
                }
            }else{
                $status = $this->update();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function update_file() {
        $idusers = session()->get("idusers");
        $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '".$idusers."';")->foto;
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
                    'nama' => $this->request->getPost('nama'),
                    'wa' => $this->request->getPost('wa'),
                    'minat' => $this->request->getPost('minat'),
                    'foto' => $fileName
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if($update == 1){
                    $status = "Data terupdate";
                }else{
                    $status = "Data gagal terupdate";
                }
            }else{
                $status = "File gagal terupload";
            }
            
        }
        return $status;
    }
    
    private function update() {
        $idusers = session()->get("idusers");
        $data = array(
            'nama' => $this->request->getPost('nama'),
            'wa' => $this->request->getPost('wa'),
            'minat' => $this->request->getPost('minat'),
        );
        $kond['idusers'] = $idusers;
        $update = $this->model->update("users", $data, $kond);
        if($update == 1){
            $status = "Data terupdate";
        }else{
            $status = "Data gagal terupdate";
        }
        return $status;
    }
}
