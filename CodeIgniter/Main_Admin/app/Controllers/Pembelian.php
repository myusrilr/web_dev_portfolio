<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pembelian extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_karyawan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['link'] = $this->model->getAllQR("select link from purchase_link")->link;

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

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/purchase/daftar');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from purchase where status = 'Disetujui' or status = 'Proses' or status = 'Selesai' order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = $row->deskripsi;
                $val[] = '<a href="'.$row->link.'" target="_blank">Link Dokumen</a>';
                if($row->status == "Proses"){
                    $str = '<span class="badge badge-info">'.$row->status.'</span>';
                    if($row->catatan != ''){
                        $str .= '<br><b>Catatan :</b> '.$row->catatan;
                    }
                    $val[] = $str;
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="proses('."'".$row->idbeli."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                    . '</div>';
                }else if($row->status == "Disetujui"){
                    $str = '<span class="badge badge-info">'.$row->status.'</span>';
                    if($row->catatan != ''){
                        $str .= '<br><b>Catatan :</b> '.$row->catatan;
                    }
                    $val[] = $str;
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idbeli."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                    . '</div>';
                }else if($row->status == "Selesai"){
                    $str = '<span class="badge badge-success">'.$row->status.'</span>';
                    if($row->catatan != ''){
                        $str .= '<br><b>Catatan :</b> '.$row->catatan;
                    }
                    $val[] = $str;
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-secondary btn-fw" onclick="proses('."'".$row->idbeli."'".')"><i class="fas fa-sticky-note"></i></button>&nbsp;'
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

    public function ajaxlistnote() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from purchase_histori where idbeli = '".$this->request->getUri()->getSegment(3)."' order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = $row->catatan;
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ganti(){
        if(session()->get("logged_karyawan")){
            $kondisi['idbeli'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("purchase", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $link = $this->model->getAllQR("select link from purchase_link")->link;
            $data = array(
                'status' => $this->request->getPost('status'),
                'linkpurchase' => $link,
            );
            $kond['idbeli'] = $this->request->getPost('kode');
            $simpan = $this->model->update("purchase",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil diperbarui";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function savelink() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'link' => $this->request->getPost('link'),
            );
            $kond['idlink'] = '1';
            $simpan = $this->model->update("purchase_link",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil diperbarui";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function done() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'status' => "Selesai",
                'done_at' => date('Y-m-d')
            );
            $kond['idbeli'] = $this->request->getUri()->getSegment(3);
            $simpan = $this->model->update("purchase",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil diperbarui";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_simpan() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'catatan' => $this->request->getPost('note'),
                'idbeli' => $this->request->getPost('kode'),
                'created_at' => $this->request->getPost('tanggal')
            );
            $simpan = $this->model->add("purchase_histori",$data);
            if($simpan == 1){
                $status = "Data berhasil tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            $id = $this->request->getPost('kode');
            echo json_encode(array("status" => $status, "id" => $id));
        }else{
            $this->modul->halaman('login');
        }
    }
}
