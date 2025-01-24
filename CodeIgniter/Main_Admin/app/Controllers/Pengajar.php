<?php
namespace App\Controllers;

/**
 * Description of Pengajar
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pengajar extends BaseController {
    
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

            $data['curdate'] = $this->modul->TanggalSekarang();

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/pengajar/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select *, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f from siswa;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl_daftar_f;
                $val[] = $row->domisili;
                $val[] = $row->nama_lengkap;
                $val[] = $row->panggilan;
                $val[] = $row->jkel;
                $val[] = $row->nama_sekolah;
                $val[] = $row->level_sekolah;
                $val[] = $row->nama_ortu;
                $val[] = $row->pekerjaan_ortu;
                $val[] = $row->tmp_lahir.', '.$row->tgl_lahir_f;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->idsiswa."'".')"><i class="fas fa-check"></i></button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idsiswa."'".','."'".$row->nama_lengkap."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div></div>';
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
        if(session()->get("logged_pendidikan")){
            $data = array(
                'idsiswa' => $this->model->autokode("S","idsiswa","siswa", 2, 7),
                'tgl_daftar' => $this->request->getPost('tgldaftar'),
                'domisili' => $this->request->getPost('domisili'),
                'nama_lengkap' => $this->request->getPost('namalengkap'),
                'panggilan' => $this->request->getPost('panggilan'),
                'jkel' => $this->request->getPost('jkel'),
                'nama_sekolah' => $this->request->getPost('sekolah'),
                'level_sekolah' => $this->request->getPost('lv_sekolah'),
                'nama_ortu' => $this->request->getPost('ortu'),
                'pekerjaan_ortu' => $this->request->getPost('pekerjaan_ortu'),
                'tmp_lahir' => $this->request->getPost('tmplahir'),
                'tgl_lahir' => $this->request->getPost('tgllahir')
            );
            $simpan = $this->model->add("siswa",$data);
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
    
    public function show() {
        if(session()->get("logged_pendidikan")){
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("siswa", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_pendidikan")){
            $data = array(
                'tgl_daftar' => $this->request->getPost('tgldaftar'),
                'domisili' => $this->request->getPost('domisili'),
                'nama_lengkap' => $this->request->getPost('namalengkap'),
                'panggilan' => $this->request->getPost('panggilan'),
                'jkel' => $this->request->getPost('jkel'),
                'nama_sekolah' => $this->request->getPost('sekolah'),
                'level_sekolah' => $this->request->getPost('lv_sekolah'),
                'nama_ortu' => $this->request->getPost('ortu'),
                'pekerjaan_ortu' => $this->request->getPost('pekerjaan_ortu'),
                'tmp_lahir' => $this->request->getPost('tmplahir'),
                'tgl_lahir' => $this->request->getPost('tgllahir')
            );
            $kond['idsiswa'] = $this->request->getPost('kode');
            $simpan = $this->model->update("siswa",$data, $kond);
            if($simpan == 1){
                $status = "ganti";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if(session()->get("logged_pendidikan")){
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("siswa",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
