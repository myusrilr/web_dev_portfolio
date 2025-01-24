<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pengajuan extends BaseController {
    
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
                $data['alamat'] = $tersimpan->alamat;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'/images/noimg.jpg';
            }

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/form/pengajuan');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    } 
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pengajuan where idusers = '".session()->get("idusers")."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = '<b>Keperluan :</b> '.$row->keterangan.'<br><b>Jumlah : </b>'.$row->jumlah;
                $catatan = $this->model->getAllQR("Select catatan from histori_pengajuan where idpengajuan = '".$row->idpengajuan."' and status = '".$row->status."'");
                if($row->status == "Diterima"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '-';
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $catatan->catatan;
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Sudah Direvisi"){
                    $val[] = '<span class="badge badge-info">'.$row->status.'</span>';
                    $val[] = '-';
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = $catatan->catatan;
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idpengajuan."'".')"><i class="fas fa-pencil-alt"></i></button><br><br>'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    $val[] = '-';
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
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
        if(session()->get("logged_karyawan")){
            $data = array(
                'jumlah' => $this->request->getPost('jumlah'),
                'keterangan' => $this->request->getPost('keterangan'),
                'syarat' => $this->request->getPost('syarat'),
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'alur' => $this->request->getPost('alur'),
                'test' => $this->request->getPost('test'),
                'status' => "Diajukan",
                'idusers' => session()->get("idusers"),
            );
            $simpan = $this->model->add("pengajuan",$data);
            $a = $this->model->getAllQR("select idpengajuan from pengajuan order by idpengajuan desc limit 1;");
            $data = array(
                'status' => "Diajukan",
                'idpengajuan' => $a->idpengajuan,
            );
            $this->model->add("histori_pengajuan",$data);
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

    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'jumlah' => $this->request->getPost('jumlah'),
                'keterangan' => $this->request->getPost('keterangan'),
                'syarat' => $this->request->getPost('syarat'),
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'alur' => $this->request->getPost('alur'),
                'test' => $this->request->getPost('test'),
                'status' => "Sudah Direvisi",
                'idusers' => session()->get("idusers"),
            );
            $kond['idpengajuan'] = $this->request->getPost('kode');
            $simpan = $this->model->update("pengajuan",$data, $kond);
            $data = array(
                'status' => "Sudah Direvisi",
                'idpengajuan' => $this->request->getPost('kode'),
            );
            $this->model->add("histori_pengajuan",$data);
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

    public function detail(){
        if(session()->get("logged_karyawan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['model'] = $this->model;

            $kode = $this->request->getUri()->getSegment(3);
            $data['pengajuan'] = $this->model->getAllQR("SELECT * FROM pengajuan where idpengajuan = '".$kode."';");
            $data['catatan'] = $this->model->getAllQ("SELECT * FROM histori_pengajuan where idpengajuan = '".$kode."';");
            
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
            echo view('front/pengajuan/detail');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ganti(){
        if(session()->get("logged_karyawan")){
            $kondisi['idpengajuan'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("pengajuan", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function listnote() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("select * from histori_pengajuan where idpengajuan = '".$id."' order by idhistori;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = date('d M Y (H:i)',strtotime($row->created_at));
                if($row->status == "Diterima"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                }else if($row->status == "Sudah Direvisi"){
                    $val[] = '<span class="badge badge-info">'.$row->status.'</span>';
                }else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                }
                $val[] = $row->catatan;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
}
