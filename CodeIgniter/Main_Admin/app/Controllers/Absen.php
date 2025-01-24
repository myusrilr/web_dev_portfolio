<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Absen extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function clockin() {
        if(session()->get("logged_karyawan")){
            $idusers = session()->get("idusers");
            $idkary = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".$idusers."';")->idkaryawan;
            // cek password lama
            $pass_db = $this->model->getAllQR("SELECT pass FROM users WHERE idusers = '".$idusers."';")->pass;
            $pass = $this->modul->enkrip_pass($this->request->getPost('password'));
            if($pass_db == $pass){
                $data = array(
                    'scanmasuk' => $this->modul->WaktuSekarang(),
                    'tanggal' => $this->modul->TanggalSekarang(),
                    'note1' => $this->request->getPost('keterangan'),
                    'idkaryawan' => $idkary,
                    'status' => 'Hadir'
                );
                $update = $this->model->add("absensi", $data);
                if($update == 1){
                    $status = "Data absen tersimpan!";
                }else{
                    $status = "Data absen gagal tersimpan";
                }
            }else{
                $status = "Password tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function cek() {
        if(session()->get("logged_karyawan")){
            $idusers = session()->get("idusers");
            $idkary = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".$idusers."';")->idkaryawan;
            $cek = $this->model->getAllQR("select * from absensi where idkaryawan = '".$idkary."' and tanggal = '".date("Y-m-d")."'")->idabsensi;
            $kondisi['idabsensi'] = $cek;
            $data = $this->model->get_by_id("absensi", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function clockout() {
        if(session()->get("logged_karyawan")){
            $idusers = session()->get("idusers");
            $idkary = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '".$idusers."';")->idkaryawan;
            // cek password lama
            $pass_db = $this->model->getAllQR("SELECT pass FROM users WHERE idusers = '".$idusers."';")->pass;
            $pass = $this->modul->enkrip_pass($this->request->getPost('password'));
            if($pass_db == $pass){
                $data = array(
                    'scankeluar' => $this->modul->WaktuSekarang(),
                    'note2' => $this->request->getPost('keterangan'),
                );
                $kond['idabsensi'] = $this->request->getPost('kode');
                $update = $this->model->update("absensi",$data, $kond);
                if($update == 1){
                    $status = "Data absen tersimpan!";
                }else{
                    $status = "Data absen gagal tersimpan";
                }
            }else{
                $status = "Password tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
