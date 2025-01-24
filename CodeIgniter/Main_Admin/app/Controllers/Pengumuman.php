<?php
namespace App\Controllers;

/**
 * Description of Pengumuman
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pengumuman extends BaseController {
    
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
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            // membaca profile orang tersebut
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            $def_foto = base_url().'/images/noimg.jpg';
            if(strlen($pro->foto) > 0){
                if(file_exists($this->modul->getPathApp().$pro->foto)){
                    $def_foto = base_url().'/uploads/'.$pro->foto;
                }
            }
            $data['pro'] = $pro;
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
            echo view('back/hrd/menu');
            echo view('back/hrd/pengumuman/index');
            echo view('back/foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $list = $this->model->getAll("pengumuman");
            foreach ($list->getResult() as $row) {
                
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($row->gambar) > 0){
                    if(file_exists($this->modul->getPathApp().$row->gambar)){
                        $deflogo = base_url().'/uploads/'.$row->gambar;
                    }
                }
                
                $val = array();
                $val[] = $row->urutan;
                $val[] = $row->judul;
                $val[] = $row->isi;
                $val[] = '<img src="'.$deflogo.'" alt="alt" class="img-thumbnail" style="width: 200px; height: auto;"/>';
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->kode."'".')"><i class="fas fa-pencil-alt"></i></button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->kode."'".','."'".$row->judul."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div></div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if(session()->get("logged_hr")){
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_file();
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
                    'kode' => $this->model->autokode("P","kode","pengumuman", 2, 7),
                    'judul' => $this->request->getPost('judul'),
                    'urutan' => $this->request->getPost('urutan'),
                    'isi' => $this->request->getPost('pengumuman'),
                    'gambar' => $fileName
                );
                $simpan = $this->model->add("pengumuman", $data);
                if($simpan == 1){
                    $status = "Data tersimpan";
                }else{  
                    $status = "Data gagal tersimpan";
                }
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
    
    private function simpan() {
        $data = array(
            'kode' => $this->model->autokode("P","kode","pengumuman", 2, 7),
            'judul' => $this->request->getPost('judul'),
            'urutan' => $this->request->getPost('urutan'),
            'isi' => $this->request->getPost('pengumuman'),
            'gambar' => ''
        );
        $simpan = $this->model->add("pengumuman",$data);
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    public function show() {
        if(session()->get("logged_hr")){
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from pengumuman where kode = '".$kode."';");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function number() {
        if(session()->get("logged_hr")){
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select max(urutan)+1 as urutan from pengumuman;");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_hr")){
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
        $kode = $this->request->getPost('kode');
        $lawas = $this->model->getAllQR("SELECT gambar FROM pengumuman where kode = '".$kode."';")->gambar;
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
                    'judul' => $this->request->getPost('judul'),
                    'urutan' => $this->request->getPost('urutan'),
                    'isi' => $this->request->getPost('pengumuman'),
                    'gambar' => $fileName
                );
                $kond['kode'] = $kode;
                $simpan = $this->model->update("pengumuman", $data, $kond);
                if($simpan == 1){
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
        $data = array(
            'judul' => $this->request->getPost('judul'),
            'urutan' => $this->request->getPost('urutan'),
            'isi' => $this->request->getPost('pengumuman'),
        );
        $kond['kode'] = $this->request->getPost('kode');
        $simpan = $this->model->update("pengumuman", $data, $kond);
        if($simpan == 1){
            $status = "Data terupdate";
        }else{  
            $status = "Data gagal terupdate";
        }
        return $status;
    }
    
    public function hapus() {
        if(session()->get("logged_hr")){
            $kode = $this->request->getUri()->getSegment(3);
            
            $lawas = $this->model->getAllQR("SELECT gambar FROM pengumuman where kode = '".$kode."';")->gambar;
            if(strlen($lawas) > 0){
                if(file_exists($this->modul->getPathApp().$lawas)){
                    unlink($this->modul->getPathApp().$lawas);
                }
            }
        
            $kond['kode'] = $kode;
            $hapus = $this->model->delete("pengumuman",$kond);
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
