<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Tagsiswakeluar extends BaseController {
    
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

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/tag/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from tag_keluar;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tag;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->idtag."'".')"><i class="fas fa-pencil-alt"></i></button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idtag."'".','."'".$row->tag."'".')"><i class="fas fa-trash-alt"></i></button>'
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
    
    public function ajax_add() {
        if(session()->get("logged_pendidikan")){
            $data = array(
                'idtag' => $this->model->autokode("T","idtag","tag_keluar", 2, 7),
                'tag' => $this->request->getPost('tag'),
                'keterangan' => $this->request->getPost('keterangan'),
            );
            $simpan = $this->model->add("tag_keluar",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function show() {
        if(session()->get("logged_pendidikan")){
            $kondisi['idtag'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("tag_keluar", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_pendidikan")){
            $data = array(
                'tag' => $this->request->getPost('tag'),
                'keterangan' => $this->request->getPost('keterangan'),
            );
            $kond['idtag'] = $this->request->getPost('kode');
            $simpan = $this->model->update("tag_keluar",$data, $kond);
            if($simpan == 1){
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
        if(session()->get("logged_pendidikan")){
            $kond['idtag'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("tag_keluar",$kond);
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
