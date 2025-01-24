<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Linkbidang extends BaseController {
    
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
            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;

            $data['bidangkat'] = $this->model->getAllQ("SELECT * from bidangkategori where idbidang = '".$cek."';");
            
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
            echo view('back/busdev/menubidang');
            echo view('back/busdev/bidang/linkbidang');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_busdev")){
            $data = array();
            $no = 1;
            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;

            $list = $this->model->getAllQ("select * from bidanglink where idbidang = '".$cek."' order by idbidang;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                if($row->idkatbid > 0){
                    $val[] = $this->model->getAllQR("select namakatbid from bidangkategori where idkatbid = '".$row->idkatbid."'")->namakatbid;
                }else{
                    $val[] = '-';
                }
                if($row->share == 1){
                    $val[] = '<a href="'.$row->link.'" target="_blank">'.$row->namaformbid.'</a> <span class="badge badge-success float-right">Dibagikan</span>';
                }else{
                    $val[] = '<a href="'.$row->link.'" target="_blank">'.$row->namaformbid.'</a>';
                }
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idformbid."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idformbid."'".','."'".$row->namaformbid."'".')"><i class="fas fa-trash-alt"></i></button>'
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
        if(session()->get("logged_busdev")){
            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;
            $katbid = $this->request->getPost('idkatbid');
            if($katbid == ''){
                $data = array(
                    'idbidang' => $cek,
                    'namaformbid' => $this->request->getPost('judul'),
                    'link' => $this->request->getPost('link'),
                    'share' => $this->request->getPost('share'),
                );
            }else{
                $data = array(
                    'idbidang' => $cek,
                    'idkatbid' => $this->request->getPost('idkatbid'),
                    'namaformbid' => $this->request->getPost('judul'),
                    'link' => $this->request->getPost('link'),
                    'share' => $this->request->getPost('share'),
                );
            }
            $simpan = $this->model->add("bidanglink",$data);
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
            $kondisi['idformbid'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("bidanglink", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_busdev")){
            $data = array(
                'idkatbid' => $this->request->getPost('idkatbid'),
                'namaformbid' => $this->request->getPost('judul'),
                'link' => $this->request->getPost('link'),
                'share' => $this->request->getPost('share'),
            );
            $kond['idformbid'] = $this->request->getPost('kode');
            $update = $this->model->update("bidanglink",$data, $kond);
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
        if(session()->get("logged_busdev")){
            $kond['idformbid'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("bidanglink",$kond);
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
