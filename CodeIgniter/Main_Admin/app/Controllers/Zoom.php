<?php
namespace App\Controllers;

/**
 * Description of Zoom
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Zoom extends BaseController {
    
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
            echo view('back/akademik/zoom/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from zoom");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = str_replace("\'", "'", $row->topic).'<br>'.$row->meeting_id.'<br>'.$row->passcode;
                $val[] = $row->link;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->idzoom."'".')"><i class="fas fa-pencil-alt"></i></button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idzoom."'".','."'".$row->meeting_id."'".')"><i class="fas fa-trash-alt"></i></button>'
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
                'idzoom' => $this->model->autokode("Z","idzoom","zoom", 2, 7),
                'topic' => addslashes($this->request->getPost('topic')),
                'link' => addslashes($this->request->getPost('link')),
                'meeting_id' => addslashes($this->request->getPost('meetingid')),
                'passcode' => addslashes($this->request->getPost('passcode'))
            );
            $simpan = $this->model->add("zoom",$data);
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
            $kond['idzoom'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("zoom", $kond);
            echo json_encode(array(
                "idzoom" => $data->idzoom, 
                "topic" => str_replace("\'", "'", $data->topic),
                "link" => $data->link, 
                "meeting_id" => $data->meeting_id, 
                "passcode" => $data->passcode
            ));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_pendidikan")){
            $data = array(
                'topic' => addslashes($this->request->getPost('topic')),
                'link' => addslashes($this->request->getPost('link')),
                'meeting_id' => addslashes($this->request->getPost('meetingid')),
                'passcode' => addslashes($this->request->getPost('passcode'))
            );
            $kond['idzoom'] = $this->request->getPost('kode');
            $simpan = $this->model->update("zoom",$data, $kond);
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
            $kond['idzoom'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("zoom",$kond);
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
