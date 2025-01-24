<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Grafikabsensi extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index() {
        if (session()->get("logged_hr")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            $q = "Select (SELECT count(*) FROM absensi a where status = 'Terlambat' and year(tanggal) = year(now())) as telat, ";
            $q .= "(SELECT count(*) FROM absensi a where status = 'Tepat Waktu' and year(tanggal) = year(now())) as tepat, ";
            $q .= "(select count(*) from perijinan where jenis='Ijin' and status = 'Disetujui' and year(tanggal) = year(now())) as jmlijin, ";
            $q .= "tanggal from absensi group by month(tanggal);";
            $data['all'] = $this->model->getAllQ($q);

            $data['nickname'] = $this->model->getAllQ("select nickname from karyawan where nickname is not null order by nickname;");

            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
                echo view('back/hrd/menu');
            }
            echo view('back/hrd/absensi/grafik');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if (session()->get("logged_hr")) {
            $data = array();
            $no = 1;
            if(session()->get("logged_bos")){
                $list = $this->model->getAllQ("select * from absensi where month(tanggal) in (select month(created_at) as m from absensi_note group by month(created_at)) order by tanggal desc;");
            }else{
                $list = $this->model->getAllQ("select * from absensi order by tanggal desc;");
            }
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $this->model->getAllQR("select u.nama from users u, karyawan k where u.idusers = k.idusers and idkaryawan = '".$row->idkaryawan."'")->nama;
                $val[] = date("l, d M Y", strtotime($row->tanggal));
                $val[] = date('H:i', strtotime($row->scanmasuk));
                $val[] = date('H:i', strtotime($row->scankeluar));
                if($row->status == 'Tidak Hadir'){
                    $val[] = '<span class="badge badge-danger">Tidak Hadir</span>';
                }else if($row->status == 'Terlambat'){
                    $val[] = '<span class="badge badge-warning">Terlambat</span>';
                }else{
                    $val[] = '<span class="badge badge-success">Tepat Waktu</span>';
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
        if (session()->get("logged_hr")) {
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
        if (session()->get("logged_hr")) {
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
                            if($value[7]){
                                $stat = 'Terlambat';
                            }else if($value[4] == 'Tidak Hadir'){
                                $stat = $value[4];
                            }else{
                               $stat = 'Tepat Waktu';
                            }
                            $data_soal = array(
                               'tanggal' => date("Y-m-d",strtotime(str_replace('/', '-', $value[3]))),
                               'scanmasuk' => $value[6],
                               'scankeluar' => $value[9],
                               'status' => $stat,
                               'idkaryawan' => $idkaryawan,
                           );
                           $this->model->add("absensi", $data_soal);
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
        if(session()->get("logged_hr")){
           $data = array(
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

}
