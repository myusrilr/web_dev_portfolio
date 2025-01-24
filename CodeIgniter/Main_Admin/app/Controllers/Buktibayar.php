<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Buktibayar extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_pendidikan")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
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

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/bukti/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from siswa where bukti != '';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_lengkap;
                $val[] = '<img src="'.base_url().'uploads/'.$row->bukti.'" width="200px" onclick="showingimg('."'".$row->idsiswa."'".')">';
                if($row->created_bukti != ''){
                    $val[] = $row->created_bukti;
                }else{
                    $val[] = '';
                }
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idsiswa."'".','."'".$row->nama_lengkap."'".')"><i class="fas fa-trash-alt"></i></button>'
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
    
    public function hapus() {
        if(session()->get("logged_pendidikan")){
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $data = array(
                'bukti' => "",
            );
            $hapus = $this->model->update("siswa",$data,$kond);
            if($hapus == 1){
                $status = "Data bukti terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function load_gambar() {
        $kode = $this->request->getUri()->getSegment(3);

        $def_foto = base_url() . '/images/noimg.jpg';
        $foto = $this->model->getAllQR("select bukti from siswa where idsiswa = '" . $kode . "';")->bukti;

        if (strlen($foto) > 0) {
            if (file_exists($this->modul->getPathApp() . $foto)) {
                $def_foto = base_url() . 'uploads/' . $foto;
            }
        }
        echo json_encode(array("foto" => $def_foto));
    }
}
