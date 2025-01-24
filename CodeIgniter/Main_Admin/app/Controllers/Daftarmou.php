<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Daftarmou extends BaseController {
    
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

            echo view('back/head', $data);
            echo view('back/bos/menu');
            echo view('back/bos/persuratan/mou');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_bos")){
            $data = array();
            $no = 1;            
            $list = $this->model->getAllQ("select * from mou order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $nama = $this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama;
                $val[] = date('d M Y',strtotime($row->created_at)).'<br><br><b>Pengguna</b> : <br>'.$nama;
                $val[] = '<b>Kebutuhan :</b><br>'.$row->kebutuhan;
                if($row->link != null){
                    $val[] = '<a href="'.$row->link.'" target="_blank">Link</a>';
                }else{
                    $val[] = '-';
                }
                if($row->status == "Permintaan Disetujui" || $row->status == "Disetujui"){
                    if($row->status == "Disetujui"){
                        $val[] = '<span class="badge badge-info">Menunggu persetujuan Pimpinan</span>';
                        $val[] = '<div style="text-align: center;">'
                        .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idmou."'".')"><i class="fas fa-check"></i></button>'
                        . '</div>';
                    }else{
                        $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                        $val[] = '-';
                    }
                }else if($row->status == "Sudah Direvisi"){
                    $val[] = '<span class="badge badge-info">Sudah Direvisi</span>';
                    $val[] = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmou."'".')"><i class="fas fa-pencil-alt"></i></button>';
                } else if($row->status == "Terdapat Revisi"){
                    $val[] = '<span class="badge badge-warning">Sedang Direvisi</span>';
                    $val[] = 'Catatan Revisi : <br>'.$row->catatan;
                } else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    $val[] = '-';
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
            $datap = array(
                'status' => $this->request->getPost('status'),
                'catatan' => $this->request->getPost('note'),
            );
            $kond['idmou'] = $this->request->getPost('kode');
            $this->model->update("mou",$datap, $kond);
            $datas = array(
                'idmou' =>  $this->request->getPost('kode'),
                'status' => $this->request->getPost('status'),
                'catatan' => $this->request->getPost('note'),
            );
            $update = $this->model->add("mou_histori",$datas);
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
        if(session()->get("logged_bos")){
            $kondisi['idmou'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mou", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
