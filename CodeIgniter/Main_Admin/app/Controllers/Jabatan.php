<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Jabatan extends BaseController {
    
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
            $data['divisi'] = $this->model->getAllQ("SELECT * from divisi;");
            
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
            echo view('back/hrd/menu');
            echo view('back/hrd/jabatan/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function getJabatan(){
        if(session()->get("logged_hr")){
            $hasil = '<option value="" selected>Pilih induk jabatan</option>';
            $iddivisi = $this->request->getUri()->getSegment(3);
            $jabatan = $this->model->getAllQ("SELECT * from jabatan j, divisi d where d.iddivisi = j.iddivisi and d.iddivisi = '".$iddivisi."';");
            foreach ($jabatan->getResult() as $row){
                $hasil .= '<option value="'.$row->idjabatan.'">'.$row->jabatan.' ('.$row->nama.')</option>';
            }
            echo json_encode(array("hasil" => $hasil));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_hr")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from divisi;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama;
                $jml_divisi = $this->model->getAllQR("SELECT count(*) as jml FROM jabatan where iddivisi = '".$row->iddivisi."';")->jml;
                if($jml_divisi > 0){
                    $str = '<table class="datatables-demo table table-striped table-bordered" style="width: 100%;">';
                    $str .= '<tbody>';
                    $list_jabatan = $this->model->getAllQ("select * from jabatan where iddivisi = '".$row->iddivisi."';");
                    foreach ($list_jabatan->getResult() as $row1) {
                        $str .= '<tr>';
                        if($row1->induk != ''){
                            $induk = $this->model->getAllQR("SELECT jabatan FROM jabatan where idjabatan = '".$row1->induk."';");
                            $str .= '<td>'.$row1->jabatan.' (Induk : '.$induk->jabatan.')</td>';
                        }else{
                            $str .= '<td>'.$row1->jabatan.'</td>';
                        }
                        $str .= '<td width="20%"><div style="text-align: center;">'
                            . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row1->idjabatan."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                            . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row1->idjabatan."'".','."'".$row1->jabatan."'".')"><i class="fas fa-trash-alt"></i></button>'
                            . '</div></td>';
                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                    $val[] = $str;
                }else{
                    $val[]='-';
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
        if(session()->get("logged_hr")){
            if($this->request->getPost('induk') == null){
                $data = array(
                    'idjabatan' => $this->model->autokode("J","idjabatan","jabatan", 2, 7),
                    'jabatan' => $this->request->getPost('jabatan'),
                    'iddivisi' => $this->request->getPost('iddivisi'),
                );
            }else{
                $data = array(
                    'idjabatan' => $this->model->autokode("J","idjabatan","jabatan", 2, 7),
                    'jabatan' => $this->request->getPost('jabatan'),
                    'iddivisi' => $this->request->getPost('iddivisi'),
                    'induk' => $this->request->getPost('induk'),
                );
            }
            $simpan = $this->model->add("jabatan",$data);
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
    
    public function ganti(){
        if(session()->get("logged_hr")){
            $kondisi['idjabatan'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("jabatan", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_hr")){
            if($this->request->getPost('induk') == null){
                $data = array(
                    'jabatan' => $this->request->getPost('jabatan'),
                    'iddivisi' => $this->request->getPost('iddivisi'),
                    'induk' => null,
                );
            }else{
                $data = array(
                    'jabatan' => $this->request->getPost('jabatan'),
                    'iddivisi' => $this->request->getPost('iddivisi'),
                    'induk' => $this->request->getPost('induk'),
                );
            }
            $kond['idjabatan'] = $this->request->getPost('kode');
            $update = $this->model->update("jabatan",$data, $kond);
            if($update == 1){
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
        if(session()->get("logged_hr")){
            $kond['idjabatan'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("jabatan",$kond);
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
    
    public function treeview() {
        if(session()->get("logged_hr")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            $data['divisi'] = $this->model->getAllQ("SELECT * from divisi;");
            
            // membaca foto profile
            $def_foto = base_url().'/images/noimg.jpg';
            if(strlen($data['pro']->foto) > 0){
                if(file_exists($this->modul->getPathApp().$data['pro']->foto)){
                    $def_foto = base_url().'/uploads/'.$data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;
            
            echo view('back/head', $data);
            echo view('back/hrd/menu');
            echo view('back/hrd/jabatan/treeview');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_tree_view() {
        if(session()->get("logged_hr")){
            
            $hasil = '<ul>';
            $list1 = $this->model->getAllQ("SELECT * FROM divisi order by nama;");
            foreach ($list1->getResult() as $row1) {
                $cek1 = $this->model->getAllQR("SELECT count(*) as jml FROM jabatan where iddivisi = '".$row1->iddivisi."' and induk is null;")->jml;
                if($cek1 > 0){
                    $hasil .= '<li>';
                    $hasil .= '<div class="treeview__level" data-level="A">
                                    <span class="level-title">'.$row1->nama.'</span>
                                </div>';
                    $hasil .= '<ul>';
                    $list2 = $this->model->getAllQ("SELECT idjabatan, jabatan FROM jabatan where iddivisi = '".$row1->iddivisi."' and induk is null;");
                    foreach ($list2->getResult() as $row2) {
                        $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM jabatan where iddivisi = '".$row1->iddivisi."' and induk = '".$row2->idjabatan."';")->jml;
                        if($cek2 > 0){
                            $hasil .= '<li>';
                            $hasil .= '<div class="treeview__level" data-level="B">
                                            <span class="level-title">'.$row2->jabatan.'</span>
                                        </div>';
                            $hasil .= '<ul>';
                            
                            $list3 = $this->model->getAllQ("SELECT idjabatan, jabatan FROM jabatan where iddivisi = '".$row1->iddivisi."' and induk = '".$row2->idjabatan."';");
                            foreach ($list3->getResult() as $row3) {
                                $hasil .= '<li>';
                            $hasil .= '<div class="treeview__level" data-level="C">
                                            <span class="level-title">'.$row3->jabatan.'</span>
                                        </div>';
                            $hasil .= '</li>';
                            }
                            
                            $hasil .= '</ul>';
                            $hasil .= '</li>';
                        }else{
                            $hasil .= '<li>';
                            $hasil .= '<div class="treeview__level" data-level="B">
                                            <span class="level-title">'.$row2->jabatan.'</span>
                                        </div>';
                            $hasil .= '</li>';
                        }
                    }
                    $hasil .= '</ul>';
                    $hasil .= '</li>';
                } else {
                    $hasil .= '<li>';
                    $hasil .= '<div class="treeview__level" data-level="A">
                                    <span class="level-title">'.$row1->nama.'</span>
                                </div>';
                    $hasil .= '</li>';
                }
            }

            $hasil .= '</ul>';

            $status = $hasil;
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
