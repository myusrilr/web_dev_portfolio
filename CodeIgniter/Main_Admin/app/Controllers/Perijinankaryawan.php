<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Perijinankaryawan extends BaseController {
    
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
            echo view('front/perijinan/index');
            echo view('front/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $no = 1;
            $idjabatan = $this->model->getAllQR("select idjabatan from users where idusers = '".session()->get("idusers")."';")->idjabatan;
            $list = $this->model->getAllQ("select p.* from perijinan_note pn, perijinan p where p.idperijinan = pn.idperijinan and idjabatan = '".$idjabatan."' order by created_at desc;");
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
                $val[] ='<b>'.strtoupper($this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama)
                . '</b><br><br><b>Tanggal & Waktu :</b> <br>'.date('d M Y',strtotime($row->tanggalmulai)).' s/d '
                .date('d M Y',strtotime($row->tanggalselesai)).'<br>'.date('H:i',strtotime($row->waktumulai)).' - '
                .date('H:i',strtotime($row->waktuselesai)).'<br>';
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
                }else if($row->status == "Diterima oleh Kepala Divisi"){
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = '-';
                }else{
                    $val[] = '<span class="badge badge-warning">'.$row->status.'</span>';
                    $val[] = '<div style="text-align: center;">'
                    .'<button type="button" class="btn btn-sm btn-info btn-fw" onclick="add('."'".$row->idperijinan."'".')"><i class="fas fa-check"></i></button></div>';
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
        if(session()->get("logged_karyawan")){
            $status = $this->request->getPost('status');
            if($status != null){
                $datap = array(
                    'status' => $status,
                    'catatan' => $this->request->getPost('note'),
                );
                $kond['idperijinan'] = $this->request->getPost('idperijinan');
                $update = $this->model->update("perijinan",$datap, $kond);
            }
            if($status != "Ditolak oleh Kepala Divisi"){
                $data = array(
                    'idperijinan' => $this->request->getPost('idperijinan'),
                    'status' => $this->request->getPost('status'),
                    'catatan' => $this->request->getPost('note'),
                    'iddivisi' => $this->model->getAllQR("select iddivisi from jabatan where jabatan like '%HR%';")->iddivisi,
                );
            }else{
                $data = array(
                    'idperijinan' => $this->request->getPost('idperijinan'),
                    'status' => $this->request->getPost('status'),
                    'catatan' => $this->request->getPost('note'),
                );
            }
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
}
