<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Daftarsuratkeluar extends BaseController {
    
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
            echo view('back/bos/persuratan/keluar');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_bos")){
            $data = array();
            $no = 1;            
            $list = $this->model->getAllQ("select * from suratkeluar order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $nama = $this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama;
                $val[] = date('d M Y',strtotime($row->created_at)).'<br><br><b>Pengguna</b> : <br>'.$nama;
                $val[] = $row->keterangan;
                $val[] = '<a href="'.$row->link.'" target="_blank">Link</a>';
                if($row->status == "Disetujui"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    if($row->nosurat == ''){
                        $val[] = '-';
                    }else{
                        $val[] = '<b>No. Surat Keluar : </b><br>'.$row->nosurat;
                    }
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else if($row->status == "Direvisi"){
                    $val[] = '<span class="badge badge-info">Sudah Direvisi</span>';
                    $val[] = '-';
                } else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">Sedang Direvisi</span>';
                    $val[] = '-';
                }else{
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
    
}
