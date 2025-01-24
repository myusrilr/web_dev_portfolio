<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Bidanglink extends BaseController {
    
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
            $data['bidangkat'] = $this->model->getAllQ("SELECT * from bidangkategori k, bidang b where k.idbidang = b.idbidang;");
            
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
                echo view('back/busdev/menu');
            }
            echo view('back/busdev/bidang/link');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_busdev")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from bidanglink order by idbidang;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $this->model->getAllQR("select namabidang from bidang where idbidang = '".$row->idbidang."'")->namabidang;
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
                if(session()->get("logged_bos")){
                    $val[] = '-';
                }else{
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idformbid."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idformbid."'".','."'".$row->namaformbid."'".')"><i class="fas fa-trash-alt"></i></button>'
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
            if($this->request->getPost('idkatbid') == ''){
                $data = array(
                    'idbidang' => $this->request->getPost('idbidang'),
                    'namaformbid' => $this->request->getPost('judul'),
                    'link' => $this->request->getPost('link'),
                    'share' => $this->request->getPost('share'),
                );
            }else{
                $data = array(
                    'idbidang' => $this->request->getPost('idbidang'),
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
                'idbidang' => $this->request->getPost('idbidang'),
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

    public function getKategori(){
        if(session()->get("logged_busdev")){
            $hasil = '<option value="" disabled selected>Pilih Kategori</option>';
            $idbidang = $this->request->getUri()->getSegment(3);
            $bidangkat = $this->model->getAllQ("SELECT * from bidangkategori k, bidang b where k.idbidang = b.idbidang and k.idbidang = '".$idbidang."';");
            foreach ($bidangkat->getResult() as $row){
                $hasil .= '<option value="'.$row->idkatbid.'">'.$row->namakatbid.'</option>';
            }
            echo json_encode(array("hasil" => $hasil));
        }else{
            $this->modul->halaman('login');
        }
    }
}
