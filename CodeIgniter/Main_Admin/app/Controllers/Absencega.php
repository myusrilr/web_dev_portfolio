<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Absencega extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        if (session()->get("logged_ga")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "General Affairs";

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            echo view('back/head', $data);
            echo view('back/ga/menu');
            echo view('back/ga/absensi/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if (session()->get("logged_ga")) {
            $data = array();
            $no = 1;
            if(session()->get("logged_bos")){
                $list = $this->model->getAllQ("select * from absensi where month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at)) order by tanggal desc;");
            }else{
                $list = $this->model->getAllQ("select * from absensi order by tanggal desc;");
            }
            foreach ($list->getResult() as $row) {
                $val = array();
                if(session()->get("logged_bos")){
                    $val[] = $no;
                }else{
                    $val[] = '<input type="checkbox" name="kodeabsen" value="'.$row->idabsensi.'"></input>';
                }
                $user = $this->model->getAllQR("select u.nama from users u, karyawan k where u.idusers = k.idusers and idkaryawan = '".$row->idkaryawan."'")->nama;
                $val[] = $user;
                $val[] = date("l", strtotime($row->tanggal));
                $val[] = date("d", strtotime($row->tanggal));
                $val[] = date("M", strtotime($row->tanggal));
                $val[] = date("Y", strtotime($row->tanggal));
                if($row->note1 == ''){
                    $val[] = date('H:i', strtotime($row->scanmasuk));
                }else{
                    $val[] = date('H:i', strtotime($row->scanmasuk)).'<br>Tugas : <br>'.$row->note1;
                }
                if($row->note2 == ''){
                    $val[] = date('H:i', strtotime($row->scankeluar));
                }else{
                    $val[] = date('H:i', strtotime($row->scankeluar)).'<br>Tugas : <br>'.$row->note2;

                }
                if($row->status == 'Tidak Hadir' || $row->status == 'Alpha'){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span><br>'.$row->verifikasi;
                }else if($row->status == 'Terlambat' || $row->status == 'Ijin/Cuti' || $row->status == 'Sakit'){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span><br>'.$row->verifikasi;
                }else if($row->status == 'Libur'){
                    $val[] = '<span class="badge badge-secondary">Libur</span><br>'.$row->verifikasi;
                }else{
                    $val[] = '<span class="badge badge-success">Tepat Waktu</span><br>'.$row->verifikasi;
                }
                if(session()->get("logged_bos")){
                    $val[] = '-';
                }else{
                    if($row->verifikasi == null){
                        $val[] = '<div style="text-align: center;">'
                                . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="verif('."'".$row->idabsensi."'".')">Verifikasi Manual</button>&nbsp;'
                                . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="delet('."'".$row->idabsensi."'".','."'".$user."'".')"><i class="fas fa-trash-alt"></i></button>'
                                . '</div>';
                    }else{
                        $val[] = '<div style="text-align: center;">'
                            . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idabsensi."'".','."'".$user."'".')"><i class="fas fa-trash-alt"></i></button>'
                            . '</div>';
                    }
                }
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlistnote() {
        if (session()->get("logged_ga")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from absensi_note order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = date("l, d M Y", strtotime($row->created_at));
                $val[] = $row->catatan;
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_upload() {
        if (session()->get("logged_ga")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->upload_xls_file();
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function upload_xls_file() {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        if ($info_file['ext'] == "xls" || $info_file['ext'] == "xlsx") {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                if ($info_file['ext'] == "xls") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else if ($info_file['ext'] == "xlsx") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadSheet = $reader->load($this->modul->getPathApp() . $fileName);
                $absen = $spreadSheet->getActiveSheet()->toArray();
                $tampung = "";
                foreach ($absen as $key => $value) {
                    if ($key == 1) {
                        continue;
                    }
                    // mencari idkaryawan
                    $cek_karyawan = $this->model->getAllQR("SELECT count(*) as jml FROM karyawan where nickname = '" . $value[1] . "';")->jml;
                    if ($cek_karyawan > 0) {
                        $idkaryawan = $this->model->getAllQR("SELECT idkaryawan FROM karyawan where nickname = '" . $value[1] . "';")->idkaryawan;
                        if($value[4] != 'Libur'){
                            $cektgl = $this->model->getAllQR("Select count(*) as jml from absensi where tanggal = '".date("Y-m-d",strtotime(str_replace('/', '-', $value[3])))."' and idkaryawan = '".$idkaryawan."'")->jml;
                            if($cektgl < 1){
                                if($value[7]){
                                    $stat = 'Terlambat';
                                }else if($value[4] == 'Tidak Hadir'){
                                    $stat = 'Alpha';
                                }else{
                                   $stat = 'Tepat Waktu';
                                }
                                $data_soal = array(
                                   'tanggal' => date("Y-m-d",strtotime(str_replace('/', '-', $value[3]))),
                                   'masuk' => $value[5],
                                   'scanmasuk' => $value[6],
                                   'terlambat' => $value[7],
                                   'keluar' => $value[8],
                                   'scankeluar' => $value[9],
                                   'cepat' => $value[10],
                                   'status' => $stat,
                                   'idkaryawan' => $idkaryawan,
                               );
                               $this->model->add("absensi", $data_soal);
                            }
                       }
                    }
                }

                // unlink link excel
                unlink($this->modul->getPathApp() . $fileName);
                $status = "Data tersimpan";
            } else {
                $status = "File excel gagal terupload";
            }
        } else {
            $status = "Bukan format file excel";
        }

        return $status;
    }

    public function submitnote() {
        if(session()->get("logged_ga")){
            $data = array(
                'created_at' => $this->request->getPost('tgl'),
                'catatan' => $this->request->getPost('note'),
            );
            $simpan = $this->model->add("absensi_note",$data);
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

    public function karyawan(){
        if(session()->get("logged_ga")){
            $id = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("SELECT idabsensi, tanggal, scanmasuk, scankeluar, a.status, u.nama FROM absensi a, karyawan k, users u where a.idkaryawan = k.idkaryawan and u.idusers = k.idusers and idabsensi = '".$id."'");
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function saveverif() {
        if(session()->get("logged_ga")){
            $data = array(
                'scanmasuk' => $this->request->getPost('scanmasuk'),
                'scankeluar' => $this->request->getPost('scankeluar'),
                'verifikasi' => $this->request->getPost('verif'),
                'status' => $this->request->getPost('status'),
            );
            $kond['idabsensi'] = $this->request->getPost('kode');
            $update = $this->model->update("absensi",$data, $kond);
            if($update == 1){
                $status = "update";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        } 
    }

    public function saveverifab() {
        if(session()->get("logged_ga") || session()->get("logged_ga")){
            $data = array(
                'scanmasuk' => $this->request->getPost('scanmasuk'),
                'scankeluar' => $this->request->getPost('scankeluar'),
                'verifikasi' => $this->request->getPost('verif'),
                'status' => $this->request->getPost('status'),
            );
            $kond['idabsensi'] = $this->request->getPost('kode');
            $update = $this->model->update("absensi",$data, $kond);
            if($update == 1){
                $status = "update";
            }else{
                $status = "Data gagal terupdate";
            }
            $idkaryawan = $this->request->getPost('idkaryawan');
            $bulan = $this->request->getPost('bulan');
            $thn = $this->request->getPost('thn');
            $filter = $this->request->getPost('filter');
            echo json_encode(array("status" => $status,"idkaryawan" => $idkaryawan, "bulan" => $bulan, "thn" => $thn, "filter" => $filter));
        }else{
            $this->modul->halaman('login');
        } 
    }

    public function hapus() {
        if(session()->get("logged_ga") || session()->get("logged_ga")){
            $data = array(
                'verifikasi' => $this->request->getPost('verif'),
            );
            $kond['idabsensi'] = $this->request->getUri()->getSegment(3);
            $update = $this->model->update("absensi",$data, $kond);
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

    public function saveverifbulk() {
        if(session()->get("logged_ga")){
            $kode = explode(",", $this->request->getPost('kode'));

            $update = "";
            for ($b = 0; $b < count($kode); $b++) {
                $data = array(
                    'verifikasi' => $this->request->getPost('verif'),
                    'status' => $this->request->getPost('status'),
                );
                $kond['idabsensi'] = $kode[$b];
                $this->model->update("absensi",$data, $kond);
                $update = 1;
            }
            if($update == 1){
                $status = "update";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        } 
    }

    public function hapusall()
    {
        if (session()->get("logged_ga")) {
            $kode = explode(",", $this->request->getPost('kode'));

            $hapus = "";
            for ($b = 0; $b < count($kode); $b++) {
                $kond['idabsensi'] = $kode[$b];
                $hapus = $this->model->delete("absensi", $kond);
            }
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $this->request->getPost('kode')));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function delet()
    {
        if (session()->get("logged_ga")) {
            $kond['idabsensi'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("absensi", $kond);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

}
