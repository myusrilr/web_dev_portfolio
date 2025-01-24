<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pindah extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_bos")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
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
            echo view('back/bos/menu');
            echo view('back/bos/pindah/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    } 
    
    public function ajaxlist() {
        if(session()->get("logged_bos")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from hakakses order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date("d F Y", strtotime($row->created_at));
                $val[] = $this->model->getAllQR("select nama from users where idusers = '".session()->get("idusers")."'")->nama;
                $val[] = $this->model->getAllQR("select nama from divisi where iddivisi = '".$row->iddivisi."'")->nama;
                $val[] = $row->pindah;
                if($row->status == "Disetujui"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '-';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = '-';
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                        .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idhakakses."'".')"><i class="fas fa-check"></i></button></div>';
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
        if(session()->get("logged_bos")){
            $data = array(
                'status' => $this->request->getPost('status')
            );
            $kond['idhakakses'] = $this->request->getPost('kode');
            $simpan = $this->model->update("hakakses",$data, $kond);
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

}
