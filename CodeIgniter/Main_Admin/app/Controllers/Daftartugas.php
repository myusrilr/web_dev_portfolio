<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Daftartugas extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_bos")){
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
            
            echo view('back/head', $data);
            echo view('back/bos/menu');
            echo view('back/bos/persuratan/tugas');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_bos")){
            $data = array();
            $no = 1;            
            $list = $this->model->getAllQ("select * from surattugas order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = date('d M Y',strtotime($row->created_at));
                $val[] = '<b>Lokasi : '.$row->lokasi.'<br>Undangan dari : </b>'.$row->undangan.'<br>'.$row->acara;
                $str = '<ol>';
                $listuser = $this->model->getAllQ("select * from surattugas_users where idsurat = '".$row->idsurat."'");
                $cek = $this->model->getAllQR("select count(*) as jml from surattugas_users where idsurat = '".$row->idsurat."'")->jml;
                if($cek > 0){
                    foreach($listuser->getResult() as $row1){
                        $user = $this->model->getAllQR("select nama from users where idusers = '".$row1->idusers."'");
                        if(empty($user->nama)){
                            $name = '-';
                        }else{
                            $name = $user->nama;
                        }
                        $str .= '<li>'.$name.'</li>';
                    }
                    $str .= '</ol>';
                    $val[] = $str;
                }
                else{
                    $val[]= '-';
                }
                $val[] = $row->waktu.'<br>('.$row->jenis.')';
                if($row->status == "Disetujui"){
                    $val[] = '<span class="badge badge-success">'.$row->status.'</span>';
                    if($row->linklaporan == null){
                        $val[] = 'No surat Tugas : <b>'.$row->nosurat.'</b><br><a href="'.$row->link.'" target="_blank">Link Surat</a>';
                    }else{
                        if($row->notelaporan == null){
                            $val[] = 'No surat Tugas : <b>'.$row->nosurat.'</b><br><a href="'.$row->link.'" target="_blank">Link Surat</a><br>Laporan Kegiatan :<br><a href="'.$row->linklaporan.'" target="_blank">Link Laporan Kegiatan</a>';
                        }else{
                            $val[] = 'No surat Tugas : <b>'.$row->nosurat.'</b><br><a href="'.$row->link.'" target="_blank">Link Surat</a><br>Laporan Kegiatan :<br><a href="'.$row->linklaporan.'" target="_blank">Link Laporan Kegiatan</a>'
                            .'<br>Catatan :<br>"'.$row->notelaporan.'"';
                        }
                    }
                }else if($row->status == "Ditolak"){
                    $val[] = '<span class="badge badge-danger">'.$row->status.'</span>';
                    $val[] = $row->catatan;
                }else{
                    $val[] = '<span class="badge badge-secondary">'.$row->status.'</span>';
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
}
