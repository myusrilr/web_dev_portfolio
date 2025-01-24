<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Lamar extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        $data['lamar'] = $this->model->getAllQR("SELECT * FROM linkform limit 1;");
            
        echo view('pelamar/index', $data);
    }

    public function submit(){
        $data = array(
            'idpelamar' => $this->model->autokode("P","idpelamar","pelamar", 2, 7),
            'email' => $this->request->getPost('email'),
            'nama' => $this->request->getPost('nama'),
            'panggilan' => $this->request->getPost('panggilan'),
            'jk' => $this->request->getPost('jk'),
            'ttl' => $this->request->getPost('ttl'),
            'domisili' => $this->request->getPost('domisili'),
            'alamat' => $this->request->getPost('alamat'),
            'wa' => $this->request->getPost('wa'),
            'ig' => $this->request->getPost('ig'),
            'fb' => $this->request->getPost('fb'),
            'linkedin' => $this->request->getPost('linkedin'),
            'laptop' => $this->request->getPost('laptop'),
            'internet' => $this->request->getPost('internet'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'rencana' => $this->request->getPost('rencana'),
            'mobilitas' => $this->request->getPost('mobilitas'),
            'wfo' => $this->request->getPost('wfo'),
            'bergabung' => $this->request->getPost('bergabung'),
            'jenis' => $this->request->getPost('jenis'),
        );
        $simpan = $this->model->add("pelamar",$data);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status));
    }

    public function submitview(){
        $data['linkform'] = $this->model->getAllQ("SELECT * FROM linkform;");

        echo view('pelamar/submit', $data);
    }

    public function coba(){
        $data['lamar'] = $this->model->getAllQR("SELECT * FROM linkform limit 1;");
            
        echo view('pelamar/coba', $data);
    }

}
