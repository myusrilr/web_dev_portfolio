<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Penggunabusdev extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_busdev")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['bidang'] = $this->model->getAllQ("SELECT * from bidang;");
            
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
            echo view('back/busdev/menu');
            echo view('back/busdev/karyawan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_busdev")){
            $data = array();
            $divisi = $this->model->getAllQR("select iddivisi from users u, jabatan j where u.idjabatan = j.idjabatan and idusers = '".session()->get("idusers")."';")->iddivisi;
            $list = $this->model->getAllQ("select * from users u, jabatan j where u.idjabatan = j.idjabatan and iddivisi = '".$divisi."' or isbusdev = 1 and idrole not in('R00004') group by idusers;");
            $no = 1;
            foreach ($list->getResult() as $row) {
                $def_foto = base_url().'/images/noimg.jpg';
                if(strlen($row->foto) > 0){
                    if(file_exists($this->modul->getPathApp().$row->foto)){
                        $def_foto = base_url().'/uploads/'.$row->foto;
                    }
                }

                $val = array();
                $val[] = $no;
                $cek_k = $this->model->getAllQR("SELECT count(idkaryawan) as jml FROM karyawan where idusers = '".$row->idusers."';")->jml;
                if($cek_k > 0){
                    $k = $this->model->getAllQR("SELECT idkaryawan, link, ktp FROM karyawan where idusers = '".$row->idusers."';");
                    $val[] = $k->idkaryawan;
                }else{
                    $val[] = '';
                }
                
                $val[] = '<img src="'.$def_foto.'" class="img-thumbnail" style="width: 120px; height: auto;">';
                $str = '<b>'.$row->nama.'</b><br>Email: '.$row->email.'<br>Whatsapp : '.$row->wa;
                $val[] = $str;
                
                if($row->idbidang == '' || $row->idbidang == 0){
                    $val[] = '-';
                }else{
                    $val[] = $this->model->getAllQR("select namabidang from bidang where idbidang = '".$row->idbidang."'")->namabidang;
                }

                $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->idusers."'".')"><i class="fas fa-edit"></i></button>'
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

    public function ganti(){
        if(session()->get("logged_busdev")){
            $kondisi['idusers'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_busdev")){
            $data = array(
                'idbidang' => $this->request->getPost('idbidang'),
            );
            $kond['idusers'] = $this->request->getPost('kode');
            $update = $this->model->update("users",$data, $kond);
            if($update == 1){
                $status = "Data berhasil tersimpan";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
