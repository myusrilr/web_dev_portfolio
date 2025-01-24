<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Persetujuanmou extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_ga")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "General Affairs";
            
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

            echo view('back/head', $data);
            echo view('back/ga/menu');
            echo view('back/ga/persuratan/mou');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_ga")){
            $data = array();
            $no = 1;            
            $list = $this->model->getAllQ("select * from mou order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $nama = $this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama;
                $val[] = date('d M Y',strtotime($row->created_at)).'<br><br><b>Pengguna</b> : <br>'.$nama;
                $val[] = '<b>Kebutuhan :</b><br>'.$row->kebutuhan.'<br><b>Detail : </b><br>'.$row->keterangan;
                if($row->link != null){
                    $val[] = '<a href="'.$row->link.'" target="_blank">Link</a>';
                }else{
                    $val[] = '-';
                }
                if($row->status == "Permintaan Disetujui" || $row->status == "Disetujui" || $row->status == "Sudah Direvisi"){
                    if($row->status == "Disetujui" || $row->status == "Sudah Direvisi"){
                        $val[] = '<span class="badge badge-info">Menunggu persetujuan Pimpinan</span>';
                    }else{
                        $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    }
                    $val[] = '-';
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else if($row->status == "Direvisi"){
                    $val[] = '<span class="badge badge-info">Sudah Direvisi</span>';
                    $val[] = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmou."'".')"><i class="fas fa-pencil-alt"></i></button>';
                } else if($row->status == "Revisi"){
                    $val[] = '<span class="badge badge-warning">Sedang Direvisi</span>';
                    $val[] = 'Catatan Revisi : <br>'.$row->catatan;
                }else if($row->status == "Terdapat Revisi"){
                    $val[] = '<span class="badge badge-warning">Terdapat Revisi</span><br>Catatan Revisi : <br>'.$row->catatan;
                    $val[] = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmou."'".')"><i class="fas fa-pencil-alt"></i></button>';
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idmou."'".')"><i class="fas fa-check"></i></button>'
                    . '</div>';
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

    public function submitnote() {
        if(session()->get("logged_ga")){
            $status = $this->request->getPost('status');
            if($status == ''){
                $datap = array(
                    'status' => "Sudah Direvisi",
                    'link' => $this->request->getPost('link'),
                );
            }else{
                $datap = array(
                    'status' => $this->request->getPost('status'),
                    'link' => $this->request->getPost('link'),
                    'catatan' => $this->request->getPost('note'),
                );
            }
            $kond['idmou'] = $this->request->getPost('kode');
            $this->model->update("mou",$datap, $kond);
            $datas = array(
                'idmou' =>  $this->request->getPost('kode'),
                'status' => $this->request->getPost('status'),
                'catatan' => $this->request->getPost('note'),
            );
            $update = $this->model->add("mou_histori",$datas);
            $wa = "no"; $nomor  = "no"; $pesan = "no";
            if($this->request->getPost('status') == "Disetujui" || $this->request->getPost('status') == "Ditolak"){
                $surat = $this->model->getAllQR("select catatan, kebutuhan, idusers, created_at from mou where idmou = '".$this->request->getPost('kode')."'");
                $no = $this->model->getAllQR("SELECT wa FROM users where idusers = '".$surat->idusers."'")->wa;
                $nomor = substr_replace(str_replace("-","",$no),'62',0,1);
                $pesan = '*PENGAJUAN MOU*'.urlencode("\n");
                if($this->request->getPost('status') == "Ditolak"){
                    $pesan .= '*STATUS DITOLAK [Tanggal : '.date("d M Y", strtotime($this->modul->TanggalSekarang())).']*'.urlencode("\n");
                }else{
                    $pesan .= '*STATUS DITERIMA [Tanggal : '.date("d M Y", strtotime($this->modul->TanggalSekarang())).']*'.urlencode("\n");
                }
                $pesan .= '*Tanggal Pengajuan : *'.date("d M Y", strtotime($surat->created_at)).urlencode("\n");
                $pesan .= '*Kebutuhan* : '.$surat->kebutuhan;
                if($this->request->getPost('status') == "Ditolak"){
                    $pesan .= urlencode("\n").'Catatan : '.$surat->catatan;
                }
                $wa = "yes";
            }
            if($update == 1){
                $status = "simpan";
            }else{    
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status, "nomor" => $nomor, "pesan" => $pesan, "wa" => $wa));    
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if(session()->get("logged_ga")){
            $kondisi['idmou'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mou", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
}
