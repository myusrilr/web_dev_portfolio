<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Surattugas extends BaseController {
    
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

            $data['users'] = $this->model->getAllQ("SELECT * FROM users;");
            
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
            echo view('front/surat/tugas');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT t.* FROM surattugas_users s, surattugas t where s.idsurat = t.idsurat and s.idusers = '".session()->get("idusers")."' or t.idusers = '".session()->get("idusers")."' group by t.idsurat order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $str = '';
                if($row->status == "Disetujui"){
                    if($row->notelaporan == ''){
                        $str = '<span class="badge badge-info">'.$row->status.'</span>';
                    }else{
                        $str = '<span class="badge badge-success">Laporan sudah Diisi</span>';
                        if($row->ket == "Disosialisasikan"){
                            $str .= ' - <span class="badge badge-success">Disosialisasikan</span>';
                        }else if($row->ket == "Tidak Disosialisasikan"){
                            $str .= ' - <span class="badge badge-danger">Tidak Disosialisasikan</span>';
                        }
                    }
                    
                }else if($row->status == "Diajukan"){
                    $str .= '<span class="badge badge-warning">'.$row->status.'</span>';
                }else if($row->status == "Dibatalkan" || $row->status == "Ditolak"){
                    $str .= '<span class="badge badge-danger">'.$row->status.'</span>';
                }
                $str .= '<br><b>Lokasi : '.$row->lokasi.'('.$row->jenis.')<br>Undangan dari : </b>'.$row->undangan.'<br>'.$row->acara;
                $val[] = $str;
                $str = '<ol>';
                $listuser = $this->model->getAllQ("select * from surattugas_users where idsurat = '".$row->idsurat."'");
                foreach($listuser->getResult() as $row1){
                    $jml = $this->model->getAllQR("select count(*) as jml from users where idusers = '".$row1->idusers."'")->jml;
                    if($jml > 0){
                        $str .= '<li>'.$this->model->getAllQR("select nama from users where idusers = '".$row1->idusers."'")->nama.'</li>';
                    }
                }
                $str .= '</ol>';
                $val[] = $str;
                $val[] = $row->waktu;
                if($row->status == "Disetujui"){
                    $ca = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idsurat."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;';
                    $ca .= '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="cancel('."'".$row->idsurat."'".','."'".str_replace(['"',"'"], "",$row->acara)."'".')"><i class="ion ion-md-close-circle"></i></button>&nbsp;';
                    if($row->notelaporan == null){
                        $ca .= '<br>No surat Tugas : <b>'.$row->nosurat.'</b><br><a href="'.$row->link.'" target="_blank">Link Surat</a><br><button type="button" class="btn btn-info" onclick="add('.$row->idsurat.');">LAPORAN KEGIATAN</button>';
                    }else{
                        $ca .= '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="updateket('."'".$row->idsurat."'".')"><i class="fas fa-chalkboard-teacher"></i></button>';
                        $ca .= '<br>No surat Tugas : <b>'.$row->nosurat.'</b><br><a href="'.$row->link.'" target="_blank">Link Surat</a><br>Laporan Kegiatan :<br><a href="'.$row->linklaporan.'" target="_blank">Link Laporan Kegiatan</a>'
                            .'<br>Catatan :<br>"'.$row->notelaporan.'"';
                    }
                    if($row->catatan != ''){
                        $ca .= '<br>Catatan : '.$row->catatan;
                    }                
                }else if($row->status == "Ditolak"){
                    $ca = 'Alasan Ditolak : '.$row->catatan;
                }else if($row->status == "Dibatalkan"){
                    $ca = 'Alasan Dibatalkan : '.$row->notebatal;
                }else{
                    $ca = '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idsurat."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idsurat."'".','."'".str_replace(['"',"'"], "",$row->acara)."'".')"><i class="feather icon-x"></i></button>';
                    if($row->catatan != ''){
                        $ca .= '<br>Catatan : '.$row->catatan;
                    }
                }
                $val[] = $ca;
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
                'acara' => $this->request->getPost('acara'),
                'undangan' => $this->request->getPost('undangan'),
                'waktu' => $this->request->getPost('tgl'),
                'lokasi' => $this->request->getPost('lokasi'),
                'jenis' => $this->request->getPost('jenis'),
                'status' => "Diajukan",
                'idusers' => session()->get("idusers"),
            );
            $this->model->add("surattugas",$data);
            $getid = $this->model->getAllQR("select idsurat from surattugas order by idsurat desc limit 1;")->idsurat;
            $data_staff = explode(",", $this->request->getPost('staff'));
            for ($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idsurat' => $getid,
                        'idusers' => $data_staff[$i]
                    );
                    $this->model->add("surattugas_users", $datap);
                }
                $simpan = 1;
            }

            $no = $this->model->getAllQR("select wa from nowag limit 1")->wa;
            $nomor = substr_replace($no,'62',0,1);
            $pesan = '*PENGAJUAN SURAT TUGAS*'.urlencode("\n").'*['.date("d M Y", strtotime( $this->modul->TanggalSekarang())).']*'.urlencode("\n")
            .'*Acara* : '.$this->request->getPost('acara')
            .urlencode("\n").'*Undangan dari* : '.$this->request->getPost('undangan');
            
            if($simpan == 1){
                $status = "Simpan";
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
            $kondisi['idsurat'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("surattugas", $kondisi);
            $data_user = array();
            $kode = $this->request->getUri()->getSegment(3);
            $user = $this->model->getAllQ("select idusers from surattugas_users where idsurat = '".$kode."'");
            foreach ($user->getResult() as $row) {
                array_push($data_user, $row->idusers);
            }
            echo json_encode(array(
                "idsurat" => $data->idsurat, 
                "acara" => $data->acara, 
                "undangan" => $data->undangan, 
                "lokasi" => $data->lokasi, 
                "jenis" => $data->jenis, 
                "waktu" => $data->waktu, 
                "users" => str_replace('\\', '', $data_user)
            ));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function gantimodal(){
        if(session()->get("logged_karyawan")){
            $kondisi['idsurat'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("surattugas", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function gantiket(){
        if(session()->get("logged_karyawan")){
            $kondisi['idsurat'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("surattugas", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit() {
        if(session()->get("logged_karyawan")){
            $datap = array(
                'acara' => $this->request->getPost('acara'),
                'undangan' => $this->request->getPost('undangan'),
                'waktu' => $this->request->getPost('tgl'),
                'lokasi' => $this->request->getPost('lokasi'),
                'jenis' => $this->request->getPost('jenis'),
                'idusers' => session()->get("idusers"),
            );
            $kond['idsurat'] = $this->request->getPost('kode');
            $this->model->update("surattugas",$datap, $kond);
            $getid = $this->request->getPost('kode');
            $hapus = $this->model->delete("surattugas_users",$kond);
            $data_staff = explode(",", $this->request->getPost('staff'));
            for ($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idsurat' => $getid,
                        'idusers' => $data_staff[$i]
                    );
                    $this->model->add("surattugas_users", $datap);
                }
                $simpan = 1;
            }
            
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

    public function batal() {
        if(session()->get("logged_karyawan")){
            $datap = array(
                'status' => "Dibatalkan",
            );
            $kond['idsurat'] = $this->request->getUri()->getSegment(3);
            $simpan = $this->model->update("surattugas",$datap, $kond);
            
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

    public function laporan() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'notelaporan' => $this->request->getPost('notelaporan'),
            );
            $kond['idsurat'] = $this->request->getPost('kode');
            $update = $this->model->update("surattugas",$data, $kond);
            if($update == 1){
                $status = "Data terkirim";
            }else{
                $status = "Data gagal terkirim";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ketsos() {
        if(session()->get("logged_karyawan")){
            $data = array(
                'ket' => $this->request->getPost('sos'),
            );
            $kond['idsurat'] = $this->request->getPost('kode');
            $update = $this->model->update("surattugas",$data, $kond);
            if($update == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapus() {
        if(session()->get("logged_karyawan")){
            $kond['idsurat'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("surattugas",$kond);
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
