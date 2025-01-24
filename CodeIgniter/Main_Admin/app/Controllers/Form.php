<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Form extends BaseController {
    
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
           
            $data['syarat'] = $this->model->getAllQR("select * from syarat limit 1")->syarat; 

            echo view('back/head', $data);
            echo view('back/hrd/menu');
            echo view('back/hrd/pemutusan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){ 
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from form;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = '<a href="'.$row->link.'" target="_blank">'.$row->judul.'</a>';
                $val[] = '<a href="'.$row->response.'" target="_blank">Link Response</a>';
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idform."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idform."'".','."'".$row->judul."'".')"><i class="fas fa-trash-alt"></i></button>'
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
        if(session()->get("logged_hr")){
            $data = array(
                'idform' => $this->model->autokode("F","idform","form", 2, 7),
                'judul' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
                'response' => $this->request->getPost('respon'),
            );
            $simpan = $this->model->add("form",$data);
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
            $kondisi['idform'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("form", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_hr")){
            $data = array(
                'judul' => $this->request->getPost('judul'),
                'response' => $this->request->getPost('respon'),
                'link' => $this->request->getPost('link'),
            );
            $kond['idform'] = $this->request->getPost('kode');
            $update = $this->model->update("form",$data, $kond);
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
        if(session()->get("logged_hr")){
            $kond['idform'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("form",$kond);
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

    public function proses() {
        if(session()->get("logged_hr")){
            $data = array(
                'syarat' => $this->request->getPost('syarat'),
            );
            $update = $this->model->updateNK("syarat", $data);
            if($update == 1){
                $status = "Persyaratan terupdate";
            }else{
                $status = "Persyaratan gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
