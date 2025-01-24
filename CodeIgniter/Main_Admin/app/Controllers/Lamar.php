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
        $id = $this->modul->enkrip_random_id(uniqid().$this->modul->getCurTime());
        $this->modul->halaman('lamar/mulai/'.$id);
    }

    public function mulai(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $cek = $this->model->getAllQR("select count(*) as jml from pelamar where idpelamar = '".$kode."'")->jml;
        if($cek > 0){
            $hasil = $this->model->getAllQR("select email, jenis from pelamar where idpelamar = '".$kode."'");
            $data['email'] = $hasil->email;
            $data['jenis'] = $hasil->jenis;
        }else{
            $data['email'] = '';
            $data['jenis'] = '';
        }
        
        $data['lamar'] = $this->model->getAllQ("SELECT * FROM linkform;");
        echo view('pelamar/index', $data);
    }

    public function submitone(){
        $kode = $this->request->getPost('kode');
        $jml = $this->model->getAllQR("select count(*) as jml from pelamar where idpelamar = '".$kode."'")->jml;
        if($jml > 0){
            $data = array(
                'email' => $this->request->getPost('email'),
                'jenis' => $this->request->getPost('jenis'),
            );
            $kond['idpelamar'] = $kode;
            $simpan = $this->model->update("pelamar",$data, $kond);
        }else{
            $data = array(
                'idpelamar' => $kode,
                'email' => $this->request->getPost('email'),
                'jenis' => $this->request->getPost('jenis'),
            );
            $simpan = $this->model->add("pelamar",$data);
        }
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function form2(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");
        echo view('pelamar/index2', $data);
    }

    public function submittwo(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'nama' => $this->request->getPost('nama'),
            'panggilan' => $this->request->getPost('panggilan'),
            'jk' => $this->request->getPost('jk'),
            'ttl' => $this->request->getPost('ttl'),
            'domisili' => $this->request->getPost('domisili'),
            'alamat' => $this->request->getPost('alamat'),
            'wa' => $this->request->getPost('wa'),
            'fb' => $this->request->getPost('fb'),
            'ig' => $this->request->getPost('ig'),
            'linkedin' => $this->request->getPost('linkedin'),
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function form3(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/index3', $data);
    }

    public function submitthree(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'work' => $this->request->getPost('work'),
            'ppdk' => $this->request->getPost('ppdk'),
            'pengalaman' => $this->request->getPost('pengalaman'),
            'wawasan' => $this->request->getPost('wawasan'),
            'sehat' => $this->request->getPost('sehat'),
            'statusnikah' => $this->request->getPost('statusnikah'),
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function form4(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/index4', $data);
    }

    public function submitfour(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'toefl' => $this->request->getPost('toefl'),
            'app' => $this->request->getPost('app'),
            'ajar' => $this->request->getPost('ajar'),
            'laptop' => $this->request->getPost('laptop'),
            'gunalaptop' => $this->request->getPost('gunalaptop'),
            'apps' => $this->request->getPost('apps'),
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function form5(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/index5', $data);
    }

    public function submitfive(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'kegiatan' => $this->request->getPost('kegiatan'),
            'rencana' => $this->request->getPost('rencana'),
            'info' => $this->request->getPost('info'),
            'internet' => $this->request->getPost('internet'),
            'mobilitas' => $this->request->getPost('mobilitas'),
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function form6(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/index6', $data);
    }

    public function submitsix(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'gaji' => $this->request->getPost('gaji'),
            'link' => $this->request->getPost('link'),
            'resign' => $this->request->getPost('resign'),
            'wfo' => $this->request->getPost('wfo'),
            'bergabung' => $this->request->getPost('bergabung'),
            'created_at' => date('Y-m-d h:i:s'),
            'status' => 'baru',
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok";
        }else{
            $status = "Data gagal tersimpan";
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function submitview(){
        $data['code'] = $this->request->getUri()->getSegment(3);

        echo view('pelamar/submit', $data);
    }

    public function testiq(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/testiq', $data);
    }

    public function submitiq() {
        $kode = $this->request->getPost('kode');
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                $status = "Error during file upload " . $_FILES['file']['error'];
            } else {
                $status = $this->update();
            }
        } else {
            $status = $this->update_tanpa();
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function update(){
        $kode = $this->request->getPost('kode');

        $lawas = $this->model->getAllQR("SELECT piciq FROM pelamar where idpelamar = '" . $this->request->getPost('kode') . "';")->piciq;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'hasiliq' => $this->request->getPost('hasil'),
                    'piciq' => $fileName
                );
                $kond['idpelamar'] = $kode;
                $simpan = $this->model->update("pelamar",$data, $kond);
                $status = "ok";
            } else {
                $status = "File gagal diupload";
            }
        }
        return $status;
    }

    public function update_tanpa(){
        $kode = $this->request->getPost('kode');
        $data = array(
            'hasiliq' => $this->request->getPost('hasil'),
        );
        $kond['idpelamar'] = $kode;
        $simpan = $this->model->update("pelamar",$data, $kond);
        if($simpan == 1){
            $status = "ok_tanpa";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    public function testminat(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/testminat', $data);
    }

    public function submitminat() {
        $kode = $this->request->getPost('kode');
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                $status = "Error during file upload " . $_FILES['file']['error'];
            } else {
                $status = $this->update_minat();
            }
        } else {
            $status = $this->update_tanpa2();
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function update_minat(){
        $kode = $this->request->getPost('kode');

        $lawas = $this->model->getAllQR("SELECT picminat FROM pelamar where idpelamar = '" . $this->request->getPost('kode') . "';")->picminat;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'picminat' => $fileName
                );
                $kond['idpelamar'] = $kode;
                $simpan = $this->model->update("pelamar",$data, $kond);
                $status = "ok";
            } else {
                $status = "File gagal diupload";
            }
        }
        return $status;
    }

    public function update_tanpa2(){
        $status = "ok_tanpa";
        return $status;
    }

    public function testkepribadian(){
        $kode = $this->modul->dekrip_random_id($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;
        $data['code'] = $this->request->getUri()->getSegment(3);

        $data['p'] = $this->model->getAllQR("select * from pelamar where idpelamar = '".$kode."'");

        echo view('pelamar/testpribadi', $data);
    }

    public function submitpribadi() {
        $kode = $this->request->getPost('kode');
        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                $status = "Error during file upload " . $_FILES['file']['error'];
            } else {
                $status = $this->update_pribadi();
            }
        } else {
            $status = $this->update_tanpa3();
        }
        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_random_id($kode)));
    }

    public function update_pribadi(){
        $kode = $this->request->getPost('kode');

        $lawas = $this->model->getAllQR("SELECT picpribadi FROM pelamar where idpelamar = '" . $this->request->getPost('kode') . "';")->picpribadi;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'picpribadi' => $fileName
                );
                $kond['idpelamar'] = $kode;
                $simpan = $this->model->update("pelamar",$data, $kond);
                $status = "ok";
            } else {
                $status = "File gagal diupload";
            }
        }
        return $status;
    }

    public function update_tanpa3(){
        $status = "ok_tanpa";
        return $status;
    }

    public function done(){
        $data['code'] = $this->request->getUri()->getSegment(3);

        echo view('pelamar/submitdone', $data);
    }

}
