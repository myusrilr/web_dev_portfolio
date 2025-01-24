<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Permintaan extends BaseController {
    
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/permintaan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pengajuan order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date("d M Y", strtotime($row->created_at));
                $j = $this->model->getAllQR("select * from users where idusers = '".$row->idusers."'");
                $val[] = $j->nama;
                $val[] = $this->model->getAllQR("Select d.nama as divisi from jabatan j, divisi d where d.iddivisi = j.iddivisi and j.idjabatan='".$j->idjabatan."'")->divisi;
                // $val[] = $j;
                $val[] = $row->keterangan;
                $val[] = $row->jumlah;
                if($row->status == "Diterima"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idpengajuan."'".','."'".$row->keterangan."'".')"><i class="fas fa-trash-alt"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idpengajuan."'".','."'".$row->keterangan."'".')"><i class="fas fa-trash-alt"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Sudah Direvisi"){
                    $val[] = '<span class="badge badge-info">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="add('."'".$row->idpengajuan."'".')"><i class="fas fa-check"></i></button>'
                    . '&nbsp;<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    if(session()->get("nama_role") == 'HR'){
                        $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idpengajuan."'".')"><i class="fas fa-check"></i></button>&nbsp;'
                    .'<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idpengajuan."'".','."'".$row->keterangan."'".')"><i class="fas fa-trash-alt"></i></button><br><br>'
                    . '&nbsp;<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                    }else{
                        $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpengajuan."'".')">Detail</button></div>';
                    }
                    
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
                );
                $kond['idpengajuan'] = $this->request->getPost('idpengajuan');
                $update = $this->model->update("pengajuan",$datap, $kond);
            }
            $status = $this->model->getAllQR("select status from pengajuan where idpengajuan = '".$this->request->getPost('idpengajuan')."'")->status;
            $data = array(
                'idpengajuan' => $this->request->getPost('idpengajuan'),
                'status' => $status,
                'catatan' => $this->request->getPost('note'),
            );
            $simpan = $this->model->add("histori_pengajuan",$data);
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

    public function ajax_add() {
        if(session()->get("logged_hr")){
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
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);

            $kode = $this->request->getUri()->getSegment(3);
            $data['pengajuan'] = $this->model->getAllQR("SELECT * FROM pengajuan p, users u where idpengajuan = '".$kode."' and u.idusers = p.idusers;");
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

            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/permintaan/detail');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function listnote() {
        if(session()->get("logged_hr")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("select * from histori_pengajuan where idpengajuan = '".$id."';");
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

    public function listpelamar() {
        if(session()->get("logged_hr")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("select * from pelamar where idpengajuan = '".$id."';");
            $no = 1;
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                if($row->status == 'Diterima'){
                    $val[] = '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'Ditolak'){
                    $val[] = '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'baru'){
                    $val[] = '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else{
                    $val[] = '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = $row->nama.' ('.$row->panggilan.') <br> Email : '.$row->email.'<br> No WA : '.$row->wa.' (<a href="https://wa.me/'.substr_replace($row->wa,'62',0,1).'" target="_blank">Link WA</a>)';
                $jmllink = $this->model->getAllQR("select count(*) as jml from pelamar_submit where idpelamar = '".$row->idpelamar."'")->jml;
                $val[] = '<div style="text-align: center;">'
                . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpelamar."'".')">Detail</button></div>';
                
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapus() {
        if(session()->get("logged_hr")){
            $id = $this->request->getUri()->getSegment(3);
            $kond['idpengajuan'] = $id;
            $hapus = $this->model->delete("pengajuan",$kond);
            if($hapus == 1){
                $status = "Hapus Berhasil";
            }else{
                $status = "Hapus Gagal";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
