<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Kemitraan extends BaseController {
    
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
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/kemitraan/index');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT m.namasekolah, m.nama, m.cp, m.idmitra, m.status
            FROM mitra m, mitra_note mn, mitra_users mu where m.idmitra = mn.idmitra 
            and mu.idmnote = mn.idmnote and mu.idusers = '".session()->get("idusers")."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->namasekolah;
                $val[] = $row->nama;
                $val[] = $row->cp;
                if($row->status == 'done'){
                    $val[] = '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'canceled'){
                    $val[] = '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'follow up'){
                    $val[] = '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else{
                    $val[] = '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detail('."'".$row->idmitra."'".')"><i class="fas fa-file-alt"></i></button>'
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
        if(session()->get("logged_karyawan")){
            $data = array(
                'idmitra' => $this->model->autokode("M","idmitra","mitra", 2, 7),
                'nama' => $this->request->getPost('nama'),
                'instansi' => $this->request->getPost('instansi'),
            );
            $simpan = $this->model->add("mitra",$data);
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
        if(session()->get("logged_karyawan")){
            $kondisi['idmitra'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mitra", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'nama' => $this->request->getPost('nama'),
                'instansi' => $this->request->getPost('instansi'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $update = $this->model->update("mitra",$data, $kond);
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
        if(session()->get("logged_karyawan")){
            $kond['idmitra'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("mitra",$kond);
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

    public function detail(){
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
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            if(strlen($foto) > 0){
                if(file_exists($this->modul->getPathApp().$foto)){
                    $def_foto = base_url().'/uploads/'.$foto;
                }
            }
            $data['foto_profile'] = $def_foto;
 
            $kode = $this->request->getUri()->getSegment(3);
            $data['mitra'] = $this->model->getAllQR("select * from mitra where idmitra = '".$kode."'");
            
            $data['users'] = $this->model->getAllQ("SELECT * FROM users where idusers not in ('".session()->get("idusers")."') and idrole not in ('R00004');");

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/kemitraan/detail');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function addmitra() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'namasekolah' => $this->request->getPost('namasekolah'),
                'lokasi' => $this->request->getPost('lokasi'),
                'kepsek' => $this->request->getPost('kepsek'),
                'cp' => $this->request->getPost('cp'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $simpan = $this->model->update("mitra",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil tersimpan!";
            }else{
                $status = "Data gagal tersimpan!";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function adddetail() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'visimisi' => $this->request->getPost('visimisi'),
                'program' => $this->request->getPost('program'),
                'sdm' => $this->request->getPost('sdm'),
                'weakness' => $this->request->getPost('weakness'),
                'rekomen' => $this->request->getPost('rekomen'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $simpan = $this->model->update("mitra",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil tersimpan!";
            }else{
                $status = "Data gagal tersimpan!";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function submitnote() {
        if(session()->get("logged_karyawan")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                );
                $kond['idmitra'] = $this->request->getPost('idmitra');
                $update = $this->model->update("mitra",$datap, $kond);
            }
            $idmnote = $this->model->autokode("N","idmnote","mitra_note", 2, 7);
            $data = array(
                'idmnote' => $idmnote,
                'idmitra' => $this->request->getPost('idmitra'),
                'idusers' => session()->get("idusers"),
                'status' => $this->request->getPost('status'),
                'note' => $this->request->getPost('note'),
            );
            $simpan = $this->model->add("mitra_note",$data);
            $data_staff = explode(",", $this->request->getPost('staff'));
            for ($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idmusers' => $this->model->autokode("P","idmusers","mitra_users", 2, 7),
                        'idmnote' => $idmnote,
                        'idusers' => $data_staff[$i]
                    );
                    $this->model->add("mitra_users", $datap);
                }
            }
            if($simpan == 1){
                $status = "Data berhasil disimpan";
            }else{    
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function listnote() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $create = $this->model->getAllQR("select created_at from mitra_note m, mitra_users u where m.idmnote = u.idmnote and m.idmitra = '".$id."' and u.idusers = '".session()->get("idusers")."'")->created_at;
            $list = $this->model->getAllQ("select * from mitra_note where idmitra = '".$id."' and created_at >= '".$create."' ORDER BY idmnote;");
            foreach ($list->getResult() as $row) {
                $val = array();
                
                $str  = date('d M Y h:i',strtotime($row->created_at)).'<br>';
                if($row->status == 'done'){
                    $str .= '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'canceled'){
                    $str .= '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'follow up'){
                    $str .= '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else{
                    $str .= '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $str  .= '<br><b>'.$this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama.'</b>';
                $val[] = $str;
                $val[] = $row->note;
                $user = $this->model->getAllQ("select * from mitra_users where idmnote = '".$row->idmnote."'");
                $str2 = '';
                $n = 1;
                foreach($user->getResult() as $rows){
                    $str2 .= $n.'. '.$this->model->getAllQR("select nama from users where idusers = '".$rows->idusers."'")->nama.'</b><br>';
                    $n++;
                }
                $val[] = $str2;
                if($row->idusers == session()->get("idusers")){
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="edit('."'".$row->idmnote."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idmnote."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div>';
                }else{
                    $val[] = '-';
                }
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function editing(){
        if(session()->get("logged_karyawan")){
            $kondisi['idmnote'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mitra_note", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function editnote() {
        if(session()->get("logged_karyawan")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                );
                $kond['idmitra'] = $this->request->getPost('idmitra');
                $update = $this->model->update("mitra",$datap, $kond);
            }
            $data = array(
                'status' => $this->request->getPost('status'),
                'note' => $this->request->getPost('note'),
            );
            $kond['idmnote'] = $this->request->getPost('idnote');
            $this->model->update("mitra_note",$data,$kond);
            $cek = $this->model->getAllQR("select count(*) as jml from mitra_users where idmnote = '".$this->request->getPost('idnote')."'")->jml;
            if($cek > 0){
                $konds['idmnote'] = $this->request->getPost('idnote');
                $this->model->delete("mitra_users",$konds);
            }
            $data_staff = explode(",", $this->request->getPost('staff'));
            for($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idmusers' => $this->model->autokode("P","idmusers","mitra_users", 2, 7),
                        'idmnote' => $this->request->getPost('idnote'),
                        'idusers' => $data_staff[$i]
                    );
                    $simpan = $this->model->add("mitra_users", $datap);
                }
            }
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{    
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapusnote() {
        if(session()->get("logged_karyawan")){
            $kond['idmnote'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("mitra_note",$kond);
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
