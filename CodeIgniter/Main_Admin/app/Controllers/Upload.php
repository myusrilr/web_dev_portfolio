<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Upload extends BaseController {
    
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
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            $data['model'] = $this->model;
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");

            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '".session()->get("idusers")."';")->setuju;
            $data['divisi'] = $this->model->getAllQR("SELECT jabatan, d.nama as namad FROM users u, jabatan j, divisi d where idusers='".session()->get("idusers")."' and j.idjabatan = u.idjabatan and d.iddivisi = j.iddivisi;");
            
            $idkary = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".session()->get("idusers")."'")->idkaryawan;
            $data['idkaryawan'] = $idkary;
            $data['k'] = $this->model->getAllQR("SELECT * FROM karyawan where idkaryawan = '".$idkary."';");
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
            echo view('front/riwayat/menu');
            echo view('front/riwayat/upload');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_karyawan")){
            $idusers = session()->get("idusers");
            // cek password lama
            $data = array(
                'link' => $this->request->getPost('link')
            );
            $kond['idusers'] = $idusers;
            $update = $this->model->update("karyawan", $data, $kond);
            if($update == 1){
                $status = "Berhasil!";
            }else{
                $status = "Gagal";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
