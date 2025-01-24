<?php
namespace App\Controllers;

/**
 * Description of Periode
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Periode extends BaseController {
    
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


            $tahun = $this->modul->getTahun();
            $tahun_awal = $tahun - 2;
            $tahun_akhir = $tahun + 2;
            $data['tahun'] = $tahun;
            $data['tahun_awal'] = $tahun_awal;
            $data['tahun_akhir'] = $tahun_akhir;
            $data['kursus'] = $this->model->getAllQ("select * from pendidikankursus");

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/periode/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_pendidikan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.*, b.nama_kursus from periode a, pendidikankursus b where a.idpendkursus = b.idpendkursus");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_term;
                $val[] = $row->tahun_ajar;
                $val[] = $row->tanggal.' '.$row->bulan_awal.' '.$row->tahun_awal;
                $val[] = $row->nama_kursus;
                $val[] = $row->jml_sesi;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti('."'".$row->idperiode."'".')"><i class="fas fa-pencil-alt"></i></button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idperiode."'".','."'".$row->bulan_awal."'".')"><i class="fas fa-trash-alt"></i></button>'
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
                'idperiode' => $this->model->autokode("P","idperiode","periode", 2, 7),
                'nama_term' => $this->request->getPost('term'),
                'tahun_ajar' => $this->request->getPost('tahun_ajaran'),
                'tanggal' => $this->request->getPost('tanggal'),
                'bulan_awal' => $this->request->getPost('bulan_awal'),
                'tahun_awal' => $this->request->getPost('tahun_awal'),
                'idpendkursus' => $this->request->getPost('kursus'),
                'jml_sesi' => $this->request->getPost('jml_sesi')
            );
            $simpan = $this->model->add("periode",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
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
            $kond['idperiode'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("periode", $kond);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_pendidikan")){
            $data = array(
                'nama_term' => $this->request->getPost('term'),
                'tahun_ajar' => $this->request->getPost('tahun_ajaran'),
                'tanggal' => $this->request->getPost('tanggal'),
                'bulan_awal' => $this->request->getPost('bulan_awal'),
                'tahun_awal' => $this->request->getPost('tahun_awal'),
                'idpendkursus' => $this->request->getPost('kursus'),
                'jml_sesi' => $this->request->getPost('jml_sesi')
            );
            $kond['idperiode'] = $this->request->getPost('kode');
            $simpan = $this->model->update("periode",$data, $kond);
            if($simpan == 1){
                $status = "Data terupdate";
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
            $kond['idperiode'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("periode",$kond);
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
