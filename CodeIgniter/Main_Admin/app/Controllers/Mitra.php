<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Datatables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Mitra extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        if(session()->get("logged_busdev")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['bidang'] = $this->model->getAllQ("SELECT * from bidang;");
            
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

            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;
            
            $data['mitra'] = $this->model->getAll("mitra");

            echo view('back/head', $data);
            if($cek == '' || $cek == 0){
                echo view('back/busdev/menu');
            }else{
                echo view('back/busdev/menubidang');
            }
            echo view('back/busdev/mitra/index');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if(session()->get("logged_busdev")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from mitra;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->instansi;
                $val[] = $row->nama;
                $val[] = $row->tahun;
                if($row->status == 'done'){
                    $val[] = '<span class="badge badge-success">'.strtoupper($row->status ?: '').'</span>';
                }else if($row->status == 'canceled'){
                    $val[] = '<span class="badge badge-danger">'.strtoupper($row->status ?: '').'</span>';
                }else if($row->status == 'follow up'){
                    $val[] = '<span class="badge badge-info">'.strtoupper($row->status ?: '').'</span>';
                }else{
                    $val[] = '<span class="badge badge-warning">'.strtoupper($row->status ?: '').'</span>';
                }
                if($row->kemitraan == ''){
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-secondary btn-fw" onclick="move('."'".$row->idmitra."'".')"><i class="feather icon-log-in"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detail('."'".$row->idmitra."'".')"><i class="fas fa-file-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmitra."'".')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idmitra."'".','."'".$row->instansi."'".')"><i class="fas fa-trash-alt"></i></button>'
                    . '</div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detail('."'".$row->idmitra."'".')"><i class="fas fa-file-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idmitra."'".')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idmitra."'".','."'".$row->instansi."'".')"><i class="fas fa-trash-alt"></i></button>'
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
    
    public function ajax_add() {
        if(session()->get("logged_busdev")){
            $data = array(
                'idmitra' => $this->model->autokode("M","idmitra","mitra", 2, 7),
                'nama' => $this->request->getPost('nama'),
                'instansi' => $this->request->getPost('instansi'),
                'tahun' => $this->request->getPost('tahun'),
            );
            $simpan = $this->model->add("mitra",$data);
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
        if(session()->get("logged_busdev")){
            $kondisi['idmitra'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mitra", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_busdev")){
            $data = array(
                'nama' => $this->request->getPost('nama'),
                'instansi' => $this->request->getPost('instansi'),
                'tahun' => $this->request->getPost('tahun'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $update = $this->model->update("mitra",$data, $kond);
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

    public function move() {
        if(session()->get("logged_busdev")){
            $kond['idmitra'] = $this->request->getUri()->getSegment(3);
            $data = array(
                'kemitraan' => 'Ya',
            );
            $update = $this->model->update("mitra",$data, $kond);
            if($update == 1){
                $status = "Data berhasil dipindahkan";
            }else{
                $status = "Data gagal dipindahkan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if(session()->get("logged_busdev")){
            $kond['idmitra'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("mitra",$kond);
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

    public function detail(){
        if(session()->get("logged_busdev")){
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '".session()->get("idusers")."';");
            
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['bidang'] = $this->model->getAllQ("SELECT * from bidang;");
            $kode = $this->request->getUri()->getSegment(3);
            $data['mitra'] = $this->model->getAllQR("select * from mitra where idmitra = '".$kode."'");
            
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

            $data['users'] = $this->model->getAllQ("SELECT * FROM users where idusers not in ('".session()->get("idusers")."') and idrole not in ('R00004');");

            $cek = $this->model->getAllQR("select idbidang from users where idusers = '".session()->get("idusers")."'")->idbidang;
            $data['provinsi'] = $this->model->getAll("provinsi");
            
            echo view('back/head', $data);
            if($cek == '' || $cek == 0){
            echo view('back/busdev/menu');
            }else{
            echo view('back/busdev/menubidang');
            }
            echo view('back/busdev/mitra/detail');
            echo view('back/foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function addmitra() {
        if(session()->get("logged_busdev")){
            $data = array(
                'namasekolah' => $this->request->getPost('namasekolah'),
                'lokasi' => $this->request->getPost('lokasi'),
                'kepsek' => $this->request->getPost('kepsek'),
                'cp' => $this->request->getPost('cp'),
                'jenis' => $this->request->getPost('jenis'),
                'provinsi' => $this->request->getPost('provinsi'),
                'kotkab' => $this->request->getPost('kotkab'),
                'jml' => $this->request->getPost('jml'),
                'bidang' => $this->request->getPost('bidang'),
                'leapverse' => $this->request->getPost('leapverse'),
                'elsa' => $this->request->getPost('elsa'),
                'classin' => $this->request->getPost('classin'),
                'jeniskemitraan' => $this->request->getPost('jeniskemitraan'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $simpan = $this->model->update("mitra",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil tersimpan!";
            }else{
                $status = "Data gagal tersimpan!";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function adddetail() {
        if(session()->get("logged_busdev")){
            $data = array(
                'visimisi' => $this->request->getPost('visimisi'),
                'program' => $this->request->getPost('program'),
                'sdm' => $this->request->getPost('sdm'),
                'weakness' => $this->request->getPost('weakness'),
                'rekomen' => $this->request->getPost('rekomen'),
            );
            $kond['idmitra'] = $this->request->getPost('kode');
            $simpan = $this->model->update("mitra",$data, $kond);
            if($simpan == 1){
                $status = "Data berhasil tersimpan!";
            }else{
                $status = "Data gagal tersimpan!";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function submitnote() {
        if(session()->get("logged_karyawan")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                );
                $kond['idmitra'] = $this->request->getPost('idmitra');
                $update = $this->model->update("mitra",$datap, $kond);
            }
            $idmnote = $this->model->autokode("N","idmnote","mitra_note", 2, 7);
            if($this->request->getPost('status') == "on-going"){
                $data = array(
                    'idmnote' => $idmnote,
                    'idmitra' => $this->request->getPost('idmitra'),
                    'idusers' => session()->get("idusers"),
                    'status' => $this->request->getPost('status'),
                    'startdate' => $this->request->getPost('startdate'),
                    'note' => $this->request->getPost('note'),
                );
            }else if($this->request->getPost('status') == "done"){
                $startdate = $this->model->getAllQR("select * from mitra_note where idmitra = '".$this->request->getPost('idmitra')."' and status = 'on-going' order by created_at desc limit 1;")->startdate;
                $data = array(
                    'idmnote' => $idmnote,
                    'idmitra' => $this->request->getPost('idmitra'),
                    'idusers' => session()->get("idusers"),
                    'status' => $this->request->getPost('status'),
                    'startdate' => $startdate,
                    'enddate' => $this->request->getPost('enddate'),
                    'note' => $this->request->getPost('note'),
                );
            }else{
                $data = array(
                    'idmnote' => $idmnote,
                    'idmitra' => $this->request->getPost('idmitra'),
                    'idusers' => session()->get("idusers"),
                    'status' => $this->request->getPost('status'),
                    'note' => $this->request->getPost('note'),
                );
            }
            $simpan = $this->model->add("mitra_note",$data);
            $data_staff = explode(",", $this->request->getPost('staff'));
            for ($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idmusers' => $this->model->autokode("P","idmusers","mitra_users", 2, 7),
                        'idmnote' => $idmnote,
                        'idusers' => $data_staff[$i]
                    );
                    $this->model->add("mitra_users", $datap);
                }
            }
            if($simpan == 1){
                $status = "Data berhasil disimpan";
            }else{    
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function listnote() {
        if(session()->get("logged_karyawan")){
            $data = array();
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("select * from mitra_note where idmitra = '".$id."' order by created_at desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                
                $str  = date('d M Y h:i:s',strtotime($row->created_at)).'<br>';
                if($row->status == 'done'){
                    $str .= '<span class="badge badge-success">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'canceled'){
                    $str .= '<span class="badge badge-danger">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'follow up'){
                    $str .= '<span class="badge badge-info">'.strtoupper($row->status).'</span>';
                }else if($row->status == 'on-going'){
                    $str .= '<span class="badge badge-primary">On Going</span>';
                }else{
                    $str .= '<span class="badge badge-warning">'.strtoupper($row->status).'</span>';
                }
                $str  .= '<br><b>'.$this->model->getAllQR("select nama from users where idusers = '".$row->idusers."'")->nama.'</b>';
                if($row->startdate != null && $row->enddate == null){
                    $str .= '<br>Tgl mulai : '.date('d M Y',strtotime($row->startdate));
                }elseif($row->enddate != null){
                    $str .= '<br>Tgl mulai : '.date('d M Y',strtotime($row->startdate));
                    $str .= '<br>Tgl selesai : '.date('d M Y',strtotime($row->enddate));
                }
                $val[] = $str;
                $val[] = $row->note;
                $user = $this->model->getAllQ("select * from mitra_users where idmnote = '".$row->idmnote."'");
                $str2 = '';
                $n = 1;
                foreach($user->getResult() as $rows){
                    $str2 .= $n.'. '.ucwords(strtolower($this->model->getAllQR("select nama from users where idusers = '".$rows->idusers."'")->nama)).'</b><br>';
                    $n++;
                }
                $val[] = $str2;
                if($row->idusers == session()->get("idusers")){
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="edit('."'".$row->idmnote."'".')"><i class="fas fa-pencil-alt"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idmnote."'".')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div>';
                }else{
                    $val[] = '-';
                }
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }

    public function editing(){
        if(session()->get("logged_karyawan")){
            $kondisi['idmnote'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("mitra_note", $kondisi);
            $data_user = array();
            $user = $this->model->getAllQ("select idusers from mitra_users where idmnote = '".$this->request->getUri()->getSegment(3)."'");
            foreach ($user->getResult() as $row) {
                array_push($data_user, $row->idusers);
            }
            echo json_encode(array(
                "idmnote" => $data->idmnote, 
                "status" => $data->status, 
                "note" => $data->note, 
                "users" => str_replace('\\', '', $data_user)
            ));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function editnote() {
        if(session()->get("logged_karyawan")){
            if($this->request->getPost('status') != null){
                $datap = array(
                    'status' => $this->request->getPost('status'),
                );
                $kond['idmitra'] = $this->request->getPost('idmitra');
                $update = $this->model->update("mitra",$datap, $kond);
            }
            if($this->request->getPost('status') == "on-going"){
                $data = array(
                    'status' => $this->request->getPost('status'),
                    'startdate' => $this->request->getPost('startdate'),
                    'note' => $this->request->getPost('note'),
                );
            }else if($this->request->getPost('status') == "done"){
                $startdate = $this->model->getAllQR("select * from mitra_note where idmitra = '".$this->request->getPost('idmitra')."' and status = 'on-going' order by created_at desc limit 1;")->startdate;
                $data = array(
                    'status' => $this->request->getPost('status'),
                    'startdate' => $startdate,
                    'enddate' => $this->request->getPost('enddate'),
                    'note' => $this->request->getPost('note'),
                );
            }else{
                $data = array(
                    'status' => $this->request->getPost('status'),
                    'note' => $this->request->getPost('note'),
                );
            }
            $kond['idmnote'] = $this->request->getPost('idnote');
            $this->model->update("mitra_note",$data,$kond);
            $cek = $this->model->getAllQR("select count(*) as jml from mitra_users where idmnote = '".$this->request->getPost('idnote')."'")->jml;
            if($cek > 0){
                $konds['idmnote'] = $this->request->getPost('idnote');
                $this->model->delete("mitra_users",$konds);
            }
            $data_staff = explode(",", $this->request->getPost('staff'));
            for($i = 0; $i < count($data_staff); $i++) {
                if ($data_staff[$i] != "") {
                    $datap = array(
                        'idmusers' => $this->model->autokode("P","idmusers","mitra_users", 2, 7),
                        'idmnote' => $this->request->getPost('idnote'),
                        'idusers' => $data_staff[$i]
                    );
                    $simpan = $this->model->add("mitra_users", $datap);
                }
            }
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

    public function hapusnote() {
        if(session()->get("logged_karyawan")){
            $kond['idmnote'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("mitra_note",$kond);
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

    public function kabupaten()
    {
        if (session()->get("logged_karyawan")) {
            $idprovinsi = $this->request->getPost('provinsi');
            $status = '<option value="-">- Pilih Kabupaten -</option>';
            $list = $this->model->getAllQ("select idkabupaten, name from kabupaten where idprovinsi = '" . $idprovinsi . "';");
            foreach ($list->getResult() as $row) {
                $status .= '<option value="' . $row->idkabupaten . '">' . $row->name . '</option>';
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function exportdata()
    {
        if (session()->get("logged_karyawan")) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
            $style_col = [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];

            // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border right dengan garis tipis
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                ]
            ];

            $sheet->setCellValue('A1', "Daftar Kemitraan"); // Set kolom A1 dengan tulisan "Daftar Kemitraan"
            $sheet->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            $sheet->getStyle('A1')->getFont()->setSize(12); // Set font size 12 untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $sheet->setCellValue('A2', "No");
            $sheet->setCellValue('B2', "Institusi");
            $sheet->setCellValue('C2', "PIC Institusi");
            $sheet->setCellValue('D2', "Contact Number");
            $sheet->setCellValue('E2', "Jenis Kemitraan");
            $sheet->setCellValue('F2', "Tipe Institusi");
            $sheet->setCellValue('G2', "Alamat Institusi");
            $sheet->setCellValue('H2', "Provinsi");
            $sheet->setCellValue('I2', "Kota / Kabupaten");
            $sheet->setCellValue('J2', "Jumlah Karyawan");
            $sheet->setCellValue('K2', "Kategori Bidang Usaha");
            $sheet->setCellValue('L2', "Leapverse");
            $sheet->setCellValue('M2', "Elsa");
            $sheet->setCellValue('N2', "ClassIn");
            $sheet->setCellValue('O2', "Tahun Mulai");
            $sheet->setCellValue('P2', "Tahun Selesai");
            $sheet->setCellValue('Q2', "Status Kerjasama");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $sheet->getStyle('A2:Q2')->applyFromArray($style_col);

            $sheet->getColumnDimension('A')->setWidth(15); 
            $sheet->getColumnDimension('B')->setWidth(17); 
            $sheet->getColumnDimension('C')->setWidth(35); 
            $sheet->getColumnDimension('D')->setWidth(15); 
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(15); 
            $sheet->getColumnDimension('G')->setWidth(15); 
            $sheet->getColumnDimension('H')->setWidth(20); 
            $sheet->getColumnDimension('I')->setWidth(17); 
            $sheet->getColumnDimension('J')->setWidth(15); 
            $sheet->getColumnDimension('K')->setWidth(70); 
            $sheet->getColumnDimension('L')->setWidth(40);
            $sheet->getColumnDimension('M')->setWidth(40); 
            $sheet->getColumnDimension('N')->setWidth(40); 
            $sheet->getColumnDimension('O')->setWidth(40); 
            $sheet->getColumnDimension('P')->setWidth(40); 
            $sheet->getColumnDimension('Q')->setWidth(40); 

            $sts_data =  $this->request->getUri()->getSegment(3);
            $baris = 3;
            if($sts_data == "semua"){
                $list = $this->model->getAllQ("select * from mitra");
            }else{
                $list = $this->model->getAllQ("select * from mitra where idmitra = '".$sts_data."';");
            }
            $no = 1;
            foreach ($list->getResult() as $row) {
                $list2 = $this->model->getAllQ("select * from mitra_note where idmitra = '".$row->idmitra."' and status in('on-going','done') group by startdate");
                foreach($list2->getResult() as $rows){
                    $provinsi = $this->model->getAllQR("select * from provinsi where idprovinsi = '".$row->provinsi."'")->nama ?? '';
                    $kotkab = $this->model->getAllQR("select * from kabupaten where idkabupaten = '".$row->kotkab."'")->name ?? '';

                    $sheet->setCellValueExplicit('A' . $baris, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('B' . $baris, $row->instansi);
                    $sheet->setCellValue('C' . $baris, $row->kepsek);
                    $sheet->setCellValueExplicit('D' . $baris, $row->cp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('E' . $baris, $row->jeniskemitraan);
                    $sheet->setCellValue('F' . $baris, $row->bidang);
                    $sheet->setCellValue('G' . $baris, $row->lokasi);
                    $sheet->setCellValue('H' . $baris, $provinsi);
                    $sheet->setCellValue('I' . $baris, $kotkab);
                    $sheet->setCellValue('J' . $baris, $row->jml);
                    $sheet->setCellValue('K' . $baris, $row->bidang);
                    $sheet->setCellValue('L' . $baris, $row->leapverse);
                    $sheet->setCellValue('M' . $baris, $row->elsa);
                    $sheet->setCellValue('N' . $baris, $row->classin);
                    $sheet->setCellValueExplicit('O' . $baris, $rows->startdate, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('P' . $baris, $rows->enddate, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('Q' . $baris, $rows->status);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $sheet->getStyle('A' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('B' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('C' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('D' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('E' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('F' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('G' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('H' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('I' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('J' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('K' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('L' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('M' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('N' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('O' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('P' . $baris)->applyFromArray($style_row);
                    $sheet->getStyle('Q' . $baris)->applyFromArray($style_row);

                    $sheet->getStyle('A' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('D' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('E' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('F' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('G' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('H' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('I' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('J' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('K' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('L' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('M' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('N' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('O' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('P' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle('Q' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    
                    $sheet->getRowDimension($baris)->setRowHeight(20); // Set height tiap row
                    $baris++; // Tambah 1 setiap kali looping
                }
            }

            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $sheet->setTitle("Daftar Kemitraan");
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Daftar Kemitraan.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function contoh(){
        $status_awal = 0;
        $list = $this->model->getAllQ("select * from mitra");
        foreach ($list->getResult() as $row) {
            
            echo $row->nama;
            echo '<br>';

            $list2 = $this->model->getAllQ("select * from mitra_note where idmitra = '".$row->idmitra."' and status in('on-going','done')");
            foreach($list2->getResult() as $rows){
                echo $rows->status;
                echo '<br>';

                if($rows->status == "done"){

                }
            }

            echo '<hr>';
        }            
    }
}
