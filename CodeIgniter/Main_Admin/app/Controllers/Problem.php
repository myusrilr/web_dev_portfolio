<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Problem extends BaseController {
    
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
            echo view('front/problem/index');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from problem order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = $this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama;
                $val[] = $row->keterangan;
                if($row->status == "Proses"){
                    $val[] = '<span class="badge badge-info">'.$row->status.'</span>';
                }else if($row->status == "Terselesaikan"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span><br>Tgl : '.date("d M Y",strtotime($row->solved_at));
                }else{
                    $str = '';
                    if($row->idusers == session()->get("idusers")){
                        $str .= '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idproblem."'".','."'".$row->keterangan."'".')">
                        <i class="feather icon-x"></i></button><br><br>';
                    }
                    $str .= '<span class="badge badge-secondary">'.$row->status.'</span>';
                    
                    $val[] = $str;
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
                'keterangan' => $this->request->getPost('keterangan'),
                'status' => "Diajukan",
                'idusers' => session()->get("idusers"),
            );
            $simpan = $this->model->add("problem",$data);
            if($simpan == 1){
                $status = "Data berhasil terkirim";
            }else{
                $status = "Data gagal tersimpan";
            }
            $no = $this->model->getAllQR("select wa from nowag limit 1")->wa;
            $nomor = substr_replace($no,'62',0,1);
            $pesan = ' *['.date("d M Y").']*'.urlencode("\n").'*Masalah Infrastruktur* : '.$this->request->getPost('keterangan');
            echo json_encode(array("status" => $status, "nomor" => $nomor, "pesan" => $pesan));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ganti(){
        if(session()->get("logged_karyawan")){
            $kondisi['idmou'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mou", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'keterangan' => $this->request->getPost('keterangan'),
                'kebutuhan' => $this->request->getPost('kebutuhan'),
                'status' => "Direvisi",
            );
            $kond['idmou'] = $this->request->getPost('kode');
            $this->model->update("mou",$data, $kond);
            $data = array(
                'idmou' => $this->request->getPost('kode'),
                'status' => "Direvisi",
            );
            $simpan = $this->model->add("mou_histori",$data);
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

    public function hapus() {
        if(session()->get("logged_karyawan")){
            $kond['idproblem'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("problem",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            $no = $this->model->getAllQR("select wa from nowag limit 1")->wa;
            $nomor = substr_replace($no,'62',0,1);
            $pesan = '*DIBATALKAN*'.urlencode("\n").'*['.date("d M Y").']*'.urlencode("\n").'*Masalah Infrastruktur* : '.$this->request->getPost('keterangan');
            echo json_encode(array("status" => $status, "nomor" => $nomor, "pesan" => $pesan));
        }else{
            $this->modul->halaman('login');
        }
    }
}
