<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Perijinan extends BaseController {
    
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
            $data['kategori'] = $this->model->getAllQ("SELECT * from sopkategori;");
            
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
                $data['alamat'] = $tersimpan->alamat;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'/images/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                        $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
                
            }else{
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'/images/noimg.jpg';
            }

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/form/perijinan');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from perijinan where idusers='".session()->get("idusers")."' order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                if(strlen($row->surat) > 0){
                    if(file_exists($this->modul->getPathApp().$row->surat)){
                        $def_surat = base_url().'/uploads/'.$row->surat;
                    }else{
                        $def_surat = '';
                    }
                }

                $val[] = $no;
                $val[] = $row->jenis;
                $val[] = date('d M Y',strtotime($row->tanggalmulai)).' s/d '.date('d M Y',strtotime($row->tanggalselesai)).'<br>'.date('H:i',strtotime($row->waktumulai)).' - '.date('H:i',strtotime($row->waktuselesai));
                $val[] = $row->keterangan;
                if($row->surat == '' || $def_surat == ''){
                    $val[] = '-';
                }else{
                    $val[] = '<a href="'.$def_surat.'" target="_blank">Link</a>';
                }
                if($row->status == "Disetujui"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    $val[] = '-';
                }else if($row->status == "Ditolak" || $row->status == "Ditolak oleh Kepala Divisi"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else{
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idperijinan."'".','."'".$row->jenis."'".')"><i class="feather icon-x"></i></button>&nbsp;';
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
            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $status = $this->simpan_file();
                }
            }else{
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    private function simpan_file() {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        if(file_exists($this->modul->getPathApp().'/'.$fileName)){
            $status = "Gunakan nama file lain";
        }else{
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if($status_upload){
                $kode = $this->model->autokode("P","idperijinan","perijinan", 2, 7);
                $data = array(
                    'idperijinan' => $kode,
                    'idusers' => session()->get("idusers"),
                    'tanggalmulai' => $this->request->getPost('tanggalmulai'),
                    'tanggalselesai' => $this->request->getPost('tanggalmulai'),
                    'waktumulai' => $this->request->getPost('waktumulai'),
                    'waktuselesai' => $this->request->getPost('waktuselesai'),
                    'jenis' => $this->request->getPost('jenis'),
                    'keterangan' => $this->request->getPost('keterangan'),
                    'status' => "Diajukan",
                    'surat' => $fileName
                );
                $this->model->add("perijinan",$data);
    
                $induk = $this->model->getAllQR("SELECT induk FROM users u, jabatan j where idusers='".session()->get("idusers")."' and u.idjabatan = j.idjabatan;")->induk;
                if($induk != ''){
                    $datap = array(
                        'status' => "Diajukan",
                        'idperijinan' => $kode,
                        'idjabatan' => $induk,
                    );
                    $this->model->add("perijinan_note",$datap);
                }else{
                    $datapp = array(
                        'status' => "Diajukan",
                        'idperijinan' => $kode,
                        'iddivisi' => $this->model->getAllQR("select iddivisi from jabatan where jabatan like '%HR%';")->iddivisi,
                    );
                    $this->model->add("perijinan_note",$datapp);
                }
                $status = "Data tersimpan";
            }else{
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function simpan() {
        $kode = $this->model->autokode("P","idperijinan","perijinan", 2, 7);
        $data = array(
            'idperijinan' => $kode,
            'idusers' => session()->get("idusers"),
            'tanggalmulai' => $this->request->getPost('tanggalmulai'),
            'tanggalselesai' => $this->request->getPost('tanggalmulai'),
            'waktumulai' => $this->request->getPost('waktumulai'),
            'waktuselesai' => $this->request->getPost('waktuselesai'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => "Diajukan",
            'keterangan' => $this->request->getPost('keterangan'),
        );
        $simpan = $this->model->add("perijinan",$data);
        
        $induk = $this->model->getAllQR("SELECT induk FROM users u, jabatan j where idusers='".session()->get("idusers")."' and u.idjabatan = j.idjabatan;")->induk;
        if($induk != ''){
            $datap = array(
                'status' => "Diajukan",
                'idperijinan' => $kode,
                'idjabatan' => $induk,
            );
            $this->model->add("perijinan_note",$datap);
        }else{
            $datapp = array(
                'status' => "Diajukan",
                'idperijinan' => $kode,
                'iddivisi' => $this->model->getAllQR("select iddivisi from jabatan where jabatan like '%HR%';")->iddivisi,
            );
            $this->model->add("perijinan_note",$datapp);
        }
        if($simpan == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    public function hapus() {
        if(session()->get("logged_karyawan")){
            $id = $this->request->getUri()->getSegment(3);
            $kond['idperijinan'] = $id;
            $hapus = $this->model->delete("perijinan",$kond);
            if($hapus == 1){
                $status = "Hapus Berhasil";
            }else{
                $status = "Hapus Gagal";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
