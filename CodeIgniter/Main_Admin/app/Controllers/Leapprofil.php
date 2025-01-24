<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Leapprofil extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_busdev")){
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

            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;
            
            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else if($cek == '' || $cek == 0){
                echo view('back/busdev/menu');
            }else{
                echo view('back/busdev/menubidang');
            }
            echo view('back/busdev/profil/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlistt() {
        if(session()->get("logged_busdev")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from leapprofil;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = '<a href="'.$row->link.'" target="_blank">'.$row->judul.'</a>';
                if(session()->get("logged_bos")){
                    $val[] = '-';
                }else{
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idleap."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idleap."'".','."'".$row->judul."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div>';
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
    
    public function ajax_add() {
        if(session()->get("logged_busdev")){
            $data = array(
                'judul' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
            );
            $simpan = $this->model->add("leapprofil",$data);
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
        if(session()->get("logged_busdev")){
            $kondisi['idleap'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("leapprofil", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_busdev")){
            $data = array(
                'judul' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
            );
            $kond['idleap'] = $this->request->getPost('kode');
            $update = $this->model->update("leapprofil",$data, $kond);
            if($update == 1){
                $status = "update";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if(session()->get("logged_busdev")){
            $kond['idleap'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("leapprofil",$kond);
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
