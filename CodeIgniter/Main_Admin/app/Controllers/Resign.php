<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Resign extends BaseController {
    
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
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
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
            if(session()->get("role") == 'R00004'){
                echo view('back/bos/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/resign/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            if(session()->get("logged_bos")){
                $list = $this->model->getAllQ("select * from keluar where kirim = 1 and status = 'Disetujui' order by created_at");
            }else{
            $list = $this->model->getAllQ("select * from keluar where kirim = 1 order by created_at");}
            foreach ($list->getResult() as $row) {
                $val = array();
                if(strlen($row->scan) > 0){
                    if(file_exists($this->modul->getPathApp().$row->scan)){
                        $def_scan = base_url().'/uploads/'.$row->scan;
                    }
                }

                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $u = $this->model->getAllQR("Select nama from users where idusers = '".$row->idusers."'");
                $val[] = $u->nama;
                $val[] = $row->alasan;
                $val[] = '<a href="'.$def_scan.'" target="_blank">Link</a>';
                if($row->status == "Disetujui"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '-';
                }else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else{
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idkeluar."'".')"><i class="fas fa-check"></i></button></div>';
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

    public function submitnote() {
        if(session()->get("logged_hr")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                    'catatan' => $this->request->getPost('note'),
                );
                $kond['idkeluar'] = $this->request->getPost('idkeluar');
                $update = $this->model->update("keluar",$datap, $kond);
            }
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
}
