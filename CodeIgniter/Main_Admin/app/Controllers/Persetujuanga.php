<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Persetujuanga extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = 'General Affairs';
            
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
            echo view('back/ga/perijinan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            if(session()->get("logged_bos")){
                $list = $this->model->getAllQ("select * from perijinan order by created_at desc;");
            }else if(session()->get("logged_hr")){
                $iddivisi = $this->model->getAllQR("select iddivisi from jabatan where jabatan like '%HR%';")->iddivisi;
                $list = $this->model->getAllQ("select p.* from perijinan p, perijinan_note pn where p.idperijinan = pn.idperijinan and pn.iddivisi = '".$iddivisi."' order by created_at desc");
            }
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
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = $row->jenis;
                $nama = strtoupper($this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama);
                $str = '<b>'.$nama;
                $str .= '</b><br><br><b>Tanggal & Waktu :</b> <br>'.date('d M Y',strtotime($row->tanggalmulai)).' s/d '.date('d M Y',strtotime($row->tanggalselesai)).'<br>'.date('H:i',strtotime($row->waktumulai)).' - '.date('H:i',strtotime($row->waktuselesai));
                $str .= '<br><br><b>Keterangan :</b> <br>'.$row->keterangan.'<br><br> <b>Surat :</b> ';
                if($row->surat == '' || $def_surat == ''){
                    $str .= '-';
                }else{
                    $str .= '<a href="'.$def_surat.'" target="_blank">Link</a>';
                }
                $val[] = $str;
                if($row->status == "Disetujui"){
                    $ca = '<span class="badge badge-success">'.$row->status.'</span>';
                }else if($row->status == "Ditolak"){
                    $ca = '<span class="badge badge-danger">'.$row->status.'</span>';
                }else{
                    $ca = '<span class="badge badge-warning">'.$row->status.'</span>';
                }

                if($row->catatan != ''){
                    $ca .= '<br>'.$row->catatan;
                }
                $val[] = $ca;

                if(session()->get("logged_bos")){
                    $val[]= '-';
                }else{
                    $st = '<div style="text-align: center;">';
                    if($row->status == "Diajukan" || $row->status == "Diterima oleh Kepala Divisi"){
                        $st .= '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idperijinan."'".')"><i class="fas fa-check"></i></button>&nbsp;&nbsp;';
                    }
                    $st .= '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idperijinan."'".','."'".$nama."'".')"><i class="fas fa-trash-alt"></i></button></div>';
                    $val[] = $st;
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
        if(session()->get("logged_hr")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                    'catatan' => $this->request->getPost('note'),
                );
                $kond['idperijinan'] = $this->request->getPost('idperijinan');
                $update = $this->model->update("perijinan",$datap, $kond);
            }
            $data = array(
                'idperijinan' => $this->request->getPost('idperijinan'),
                'status' => $this->request->getPost('status'),
                'catatan' => $this->request->getPost('note'),
            );
            $simpan = $this->model->add("perijinan_note",$data);
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

    public function hapus() {
        if(session()->get("logged_hr")){
            $kond['idperijinan'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("perijinan",$kond);
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
