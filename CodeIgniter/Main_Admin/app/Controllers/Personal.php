<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Personal extends BaseController {
    
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
            $data['k'] = $this->model->getAllQR("SELECT * FROM karyawan where idusers = '".session()->get("idusers")."';");;
            
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
            echo view('front/riwayat/personal');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'ktp' => $this->request->getPost('ktp'),
                'nama' => $this->request->getPost('nama'),
                'nickname' => $this->request->getPost('nickname'),
                'kota' => $this->request->getPost('kota'),
                'tgl' => $this->request->getPost('tgl'),
                'jk' => $this->request->getPost('jk'),
                'goldar' => $this->request->getPost('goldar'),
                'agama' => $this->request->getPost('agama'),
                'status' => $this->request->getPost('status'),
                'anak' => $this->request->getPost('anak'),
                'riwayat' => $this->request->getPost('riwayat'),
                'alamatktp' => $this->request->getPost('alamatktp'),
                'domisili' => $this->request->getPost('domisili'),
                'warga' => $this->request->getPost('warga'),
                'anakke' => $this->request->getPost('anakke'),
                'hobi' => $this->request->getPost('hobi'),
                'linkedin' => $this->request->getPost('akun'),
                'email' => $this->request->getPost('email'),
                'ig' => $this->request->getPost('ig'),
                'fb' => $this->request->getPost('fb'),
                'emailkantor' => $this->request->getPost('emailkantor'),
                'telp' => $this->request->getPost('telp'),
                'npwp' => $this->request->getPost('npwp'),
                'bpjskerja' => $this->request->getPost('bpjskerja'),
                'bpjssehat' => $this->request->getPost('bpjssehat'),
                'rekening' => $this->request->getPost('rekening'),
                'moda' => $this->request->getPost('moda'),
            );
            $kond['idusers'] = session()->get("idusers");
            $update = $this->model->update("karyawan",$data, $kond);
            if($update == 1){
                $status = "ok";
            }else{
                $status = "Identitas gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
