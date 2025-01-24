<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Bidangkategori extends BaseController {
    
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
            $data['bidang'] = $this->model->getAllQ("SELECT * from bidang;");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            echo view('back/head', $data);
            echo view('back/busdev/menu');
            echo view('back/busdev/bidang/kategori');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_busdev")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from bidang;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->namabidang;
                $jml_bidang = $this->model->getAllQR("SELECT count(*) as jml FROM bidang where idbidang = '".$row->idbidang."';")->jml;
                if($jml_bidang > 0){
                    $str = '<table class="datatables-demo table table-striped table-bordered" style="width: 100%;">';
                    $str .= '<tbody>';
                    $list_bidang = $this->model->getAllQ("select * from bidangkategori where idbidang = '".$row->idbidang."';");
                    foreach ($list_bidang->getResult() as $row1) {
                        $str .= '<tr>';
                        $str .= '<td>'.$row1->namakatbid.'</td>';
                        $str .= '<td width="20%"><div style="text-align: center;">'
                            . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row1->idkatbid."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                            . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row1->idkatbid."'".','."'".$row1->namakatbid."'".')"><i class="fas fa-trash-alt"></i></button>'
                            . '</div></td>';
                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                    $val[] = $str;
                }else{
                    $val[]='-';
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
                'namakatbid' => $this->request->getPost('judul'),
                'idbidang' => $this->request->getPost('idbidang'),
            );
            $simpan = $this->model->add("bidangkategori",$data);
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
            $kondisi['idkatbid'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("bidangkategori", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_busdev")){
            $data = array(
                'namakatbid' => $this->request->getPost('judul'),
                'idbidang' => $this->request->getPost('idbidang'),
            );
            $kond['idkatbid'] = $this->request->getPost('kode');
            $update = $this->model->update("bidangkategori",$data, $kond);
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
            $kond['idkatbid'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("bidangkategori",$kond);
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
