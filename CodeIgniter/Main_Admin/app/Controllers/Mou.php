<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Mou extends BaseController {
    
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

            echo view('front/head', $data);
            echo view('front/menu');
            echo view('front/surat/mou');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from mou where idusers='".session()->get("idusers")."' order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = '<b>Kebutuhan :</b><br>'.$row->kebutuhan.'<br><b>Detail : </b><br>'.$row->keterangan;
                if($row->link != null && $row->status == "Permintaan Disetujui"){
                    $val[] = '<a href="'.$row->link.'" target="_blank">Link</a>';
                }else{
                    $val[] = '-';
                }
                if($row->status == "Permintaan Disetujui" || $row->status == "Disetujui"){
                    if($row->status == "Disetujui"){
                        $val[] = '<span class="badge badge-info">Menunggu persetujuan Pimpinan</span>';
                    }else{
                        $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    }
                    $val[] = '-';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span><br>Catatan Revisi :'.$row->catatan;
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmou."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                    . '</div>';
                }else if($row->status == 'Diajukan'){
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    $val[] = '-';
                }else{
                    $val[] = '<span class="badge badge-info">Diproses</span>';
                    $val[] = '-';
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
            $data = array(
                'keterangan' => $this->request->getPost('keterangan'),
                'kebutuhan' => $this->request->getPost('kebutuhan'),
                'status' => "Diajukan",
                'idusers' => session()->get("idusers"),
            );
            $this->model->add("mou",$data);
            $idmou = $this->model->getAllQR("select idmou from mou order by idmou desc limit 1")->idmou;
            $datap = array(
                'idmou' => $idmou,
                'status' => "Diajukan",
            );
            $simpan = $this->model->add("mou_histori",$datap);

            $no = $this->model->getAllQR("select wa from nowag limit 1")->wa;
            $nomor = substr_replace($no,'62',0,1);
            $pesan = '*PENGAJUAN MoU*'.urlencode("\n").'*['.date("d M Y", strtotime($this->modul->TanggalSekarang())).']*'
            .urlencode("\n").'*Kebutuhan* : '.$this->request->getPost('kebutuhan');

            if($simpan == 1){
                $status = "Data berhasil terkirim";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status, "nomor" => $nomor, "pesan" => $pesan));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ganti(){
        if(session()->get("logged_karyawan")){
            $kondisi['idmou'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mou", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'keterangan' => $this->request->getPost('keterangan'),
                'kebutuhan' => $this->request->getPost('kebutuhan'),
                'status' => "Direvisi",
            );
            $kond['idmou'] = $this->request->getPost('kode');
            $this->model->update("mou",$data, $kond);
            $data = array(
                'idmou' => $this->request->getPost('kode'),
                'status' => "Direvisi",
            );
            $simpan = $this->model->add("mou_histori",$data);
            if($simpan == 1){
                $status = "Data berhasil diperbarui";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
