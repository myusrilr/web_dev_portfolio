<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Rekruitmen extends BaseController {
    
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

            $data['permintaan'] = $this->model->getAllQ("select * from pengajuan p, users s where p.status = 'Diterima' and p.idusers = s.idusers;");
            $data['users'] = $this->model->getAllQ("SELECT * FROM users;");

            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }elseif(session()->get("logged_it")){
                echo view('back/it/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/pelamar/index'); 
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pelamar where created_at is not null order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = '<input type="checkbox" name="kodepelamar" value="'.$row->idpelamar.'"></input>';
                if($row->status == 'Diterima'){
                    $str = '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'Ditolak'){
                    $str = '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'baru'){
                    $str = '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else{
                    $str = '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $str .= '<br>'.date('d M Y',strtotime($row->created_at));
                $val[] = $str;
                $val[] = $row->jenis;
                $val[] = $row->nama.' ('.$row->panggilan.') <br> Email : '.$row->email.'<br> No WA : '.$row->wa.' (<a href="https://wa.me/'.substr_replace($row->wa,'62',0,1).'" target="_blank">Link WA</a>)';
                $user = $this->model->getAllQ("select * from pelamar_users where idpelamar = '".$row->idpelamar."'");
                $s = '<ol style="margin:0;">';
                foreach($user->getResult() as $u){
                    $p = $this->model->getAllQR("select nama from users where idusers = '".$u->idusers."'")->nama;
                    $s .= '<li>'.$p.'</li>';
                }
                $s .= '</ol>';
                $val[] = $s;
                if(session()->get("role") != 'R00003'){
                    $p = $this->model->getAllQR("select *, count(*) as jml from pengajuan p, users u where idpengajuan = '".$row->idpengajuan."' and p.idusers = u.idusers");
                    if($p->jml > 0){
                        $val[] = '<a href="'.base_url().'/permintaan/detail/'.$p->idpengajuan.'" target="_blank">'.$p->keterangan.' <br>(Diajukan oleh : '.$p->nama.')</a>';
                    }else{
                        $val[] = '-';
                    }
                }
                $jmllink = $this->model->getAllQR("select count(*) as jml from pelamar_submit where idpelamar = '".$row->idpelamar."'")->jml;
                if($row->status == 'Diterima' || $row->status == 'Ditolak' || session()->get("logged_it") || session()->get("logged_bos")){
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpelamar."'".')">Detail</button></div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idpelamar."'".')"><i class="fas fa-check"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idpelamar."'".','."'".$row->nama."'".')"><i class="fas fa-trash-alt"></i></button>'
                    . '<br><br><button type="button" class="btn btn-sm btn-primary btn-fw" onclick="detail('."'".$row->idpelamar."'".')">Detail</button></div>';
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

    public function listform() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from linkform;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->bidang;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapusform('."'".$row->idlink."'".','."'".$row->bidang."'".')"><i class="fas fa-trash-alt"></i></button></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapus() {
        if(session()->get("logged_hr")){
            $id = $this->request->getUri()->getSegment(3);
            $kond['idpelamar'] = $id;
            $hapus = $this->model->delete("pelamar",$kond);
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

    public function hapusform() {
        if(session()->get("logged_hr")){
            $id = $this->request->getUri()->getSegment(3);
            $kond['idlink'] = $id;
            $hapus = $this->model->delete("linkform",$kond);
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

    public function ganti(){
        if(session()->get("logged_hr")){
            $kondisi['idusers'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function detail(){
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);

            $kode = $this->request->getUri()->getSegment(3);
            $data['kode'] = $kode;
            $data['notes'] = $this->model->getAllQ("SELECT * FROM pelamar_note where idpelamar = '".$kode."' and link != ''");
            $data['lamar'] = $this->model->getAllQR("SELECT * FROM pelamar where idpelamar = '".$kode."';");
            
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }elseif(session()->get("logged_it")){
                echo view('back/it/menu');
            }else{
            echo view('back/hrd/menu');}
            echo view('back/hrd/pelamar/detail');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function submitnote() {
        if(session()->get("logged_hr") || session()->get("logged_bos")){
            if($this->request->getPost('status') != null){
                if($this->request->getPost('permintaan') != null){
                    $datap = array(
                        'status' => $this->request->getPost('status'),
                        'idpengajuan' => $this->request->getPost('permintaan'),
                    );
                }else{
                    $datap = array(
                        'status' => $this->request->getPost('status'),
                    );
                }
                $kond['idpelamar'] = $this->request->getPost('idpelamar');
                $update = $this->model->update("pelamar",$datap, $kond);
            }
            $status = $this->model->getAllQR("select status from pelamar where idpelamar = '".$this->request->getPost('idpelamar')."'")->status;
            $data = array(
                'idpelamar' => $this->request->getPost('idpelamar'),
                'idusers' => session()->get("idusers"),
                'status' => $status,
                'note' => $this->request->getPost('note'),
                'link' => $this->request->getPost('link'),
            );
            $simpan = $this->model->add("pelamar_note",$data);
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

    public function submitpertanyaan() {
        if(session()->get("logged_hr")){
            $status = $this->model->getAllQR("select status from pelamar where idpelamar = '".$this->request->getPost('idpelamar')."'")->status;
            $data = array(
                'idpelamar' => $this->request->getPost('idpelamar'),
                'idusers' => session()->get("idusers"),
                'status' => $status,
                'pertanyaan' => $this->request->getPost('pertanyaan'),
            );
            $simpan = $this->model->add("pelamar_note",$data);
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

    public function listnote() {
        if(session()->get("logged_hr")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("select * from pelamar_note where idpelamar = '".$id."' order by created_at;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $str  = date('d M Y',strtotime($row->created_at)).'<br>';
                if($row->status == 'Diterima'){
                    $str .= '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'Ditolak'){
                    $str .= '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'baru'){
                    $str .= '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else{
                    $str .= '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $str  .= '<br><b>'.$this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama.'</b>';
                $val[] = $str;
                $str2 = '';
                if($row->pertanyaan != ''){
                    $str2 .= '<b>Pertanyaan : </b><br>'.$row->pertanyaan;
                }
                if($row->note != ''){
                    $str2 .= '<b>Catatan : </b><br>'.$row->note;
                }
                $val[] = $str2;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="edit('."'".$row->idnote."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idnote."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function editing(){
        if(session()->get("logged_hr")){
            $kondisi['idnote'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("pelamar_note", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function hapusnote() {
        if(session()->get("logged_hr")){
            $kond['idnote'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("pelamar_note",$kond);
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

    public function proses() {
        $data = array(
            'bidang' => $this->request->getPost('bidang'),
            // 'aktif' => $this->request->getPost('aktif'),
        );
        $update = $this->model->add("linkform", $data);
        if($update == 1){
            $status = "Tersimpan";
        }else{
            $status = "Link Form gagal tersimpan";
        }
        echo json_encode(array("status" => $status));
    }

    public function load_gambar() {
        $kode = $this->request->getUri()->getSegment(3);
        $jenis = $this->request->getUri()->getSegment(4);

        $def_foto = base_url() . '/images/noimg.jpg';
        if($jenis == 'iq'){
            $foto = $this->model->getAllQR("select piciq from pelamar where idpelamar = '" . $kode . "';")->piciq;
        }else if($jenis == 'minat'){
            $foto = $this->model->getAllQR("select picminat from pelamar where idpelamar = '" . $kode . "';")->picminat;
        }else if($jenis == 'kepribadian'){
            $foto = $this->model->getAllQR("select picpribadi from pelamar where idpelamar = '" . $kode . "';")->picpribadi;
        }
        if (strlen($foto) > 0) {
            if (file_exists($this->modul->getPathApp() . $foto)) {
                $def_foto = base_url() . '/uploads/' . $foto;
            }
        }
        echo json_encode(array("foto" => $def_foto));
    }

    public function editnote() {
        if(session()->get("logged_hr")){
            $data = array(
                'note' => $this->request->getPost('note'),
                'pertanyaan' => $this->request->getPost('pertanyaan'),
            );
            $kond['idnote'] = $this->request->getPost('kode');
            $simpan = $this->model->update("pelamar_note",$data,$kond);
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

    public function submitpewawancara() {
        if(session()->get("logged_hr")){
            $hasil = explode(",", $this->request->getPost('idpelamar'));
            for ($b = 0; $b < count($hasil); $b++) {
                $cek = $this->model->getAllQR("select count(*) as jml from pelamar_users where idpelamar = '".$hasil[$b]."'")->jml;
                if($cek > 0){
                    $kond['idpelamar'] = $hasil[$b];
                    $hapus = $this->model->delete("pelamar_users",$kond);
                }
                $data_staff = explode(",", $this->request->getPost('staff'));
                for ($i = 0; $i < count($data_staff); $i++) {
                    if ($data_staff[$i] != "") {
                        $datap = array(
                            'idpelamar' => $hasil[$b],
                            'idusers' => $data_staff[$i]
                        );
                        $this->model->add("pelamar_users", $datap);
                    }
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

    public function hapususer() {
        if(session()->get("logged_hr")){
            $hasil = explode(",", $this->request->getPost('idpelamar'));
            for ($b = 0; $b < count($hasil); $b++) {
                $kond['idpelamar'] = $hasil[$b];
                $hapus = $this->model->delete("pelamar_users",$kond);
            }
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
