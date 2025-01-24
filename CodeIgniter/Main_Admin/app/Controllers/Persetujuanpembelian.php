<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Persetujuanpembelian extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_ga")){
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
                echo view('back/ga/menu');
            }
            echo view('back/ga/purchase/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_ga")){
            $data = array();
            $no = 1;            
            $list = $this->model->getAllQ("select * from purchase order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $nama = $this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama;
                $val[] = date('d M Y',strtotime($row->created_at)).'<br><br><b>Pengguna</b> : <br>'.$nama;
                $val[] = $row->deskripsi;
                $val[] = '<a href="'.$row->link.'" target="_blank">Link</a>';
                if($row->status == "Disetujui"){
                    $str = '<span class="badge badge-success">'.$row->status.'</span>';
                    if($row->catatan != ''){
                        $str .= '<br><b>Catatan :</b> '.$row->catatan;
                    }
                    $val[] = $str;
                    $val[] = 'Sedang dilakukan proses pembelian';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else if($row->status == "Direvisi"){
                    $val[] = '<span class="badge badge-info">Sudah Direvisi</span><br>Catatan Revisi : '.$row->catatan;
                    if(session()->get("logged_bos")){ $val[] = '-'; }else{
                    $val[] = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idbeli."'".')"><i class="fas fa-pencil-alt"></i></button>';
                    }
                } else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">Sedang Direvisi</span>';
                    $val[] = 'Catatan : '.$row->catatan;
                }else if($row->status == "Selesai"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-secondary btn-fw" onclick="proses('."'".$row->idbeli."'".')"><i class="fas fa-sticky-note"></i></button>&nbsp;'
                    . '</div>'; 
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    if(session()->get("logged_bos")){ $val[] = '-'; }else{
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idbeli."'".')"><i class="fas fa-check"></i></button>'
                    . '</div>';}
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
        if(session()->get("logged_ga")){
            $datap = array(
                'status' => $this->request->getPost('status'),
                'catatan' => $this->request->getPost('note'),
            );
            $kond['idbeli'] = $this->request->getPost('kode');
            $update = $this->model->update("purchase",$datap, $kond);
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
    
    public function ganti(){
        if(session()->get("logged_ga")){
            $kondisi['idbeli'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("purchase", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
