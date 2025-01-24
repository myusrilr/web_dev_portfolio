<?php

namespace App\Controllers;

/**
 * Description of Laporansiswapengajar
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporansiswapengajar extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index()
    {
        if (session()->get("logged_pengajar")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            echo view('back/head', $data);
            echo view('back/pengajar/menu');
            echo view('back/pengajar/laporan_siswa/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ', c.waktu_akhir) as waktu, 
                f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus and a.status_archive = 0 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and b.idusers = '" . $idusers . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = '<b>Rombel : </b>' . $row->groupwa . '<br><b>Level : </b>' . $row->level . '<br><b>Mode : </b>' . $row->mode_belajar . '<br><b>Tempat : </b>' . $row->tempat;
                $val[] = '<b>Waktu : </b>' . $row->waktu . '<br><b>Hari : </b>' . $row->hari;
                $val[] = $row->kursus;
                $val[] = $row->tahun_ajar;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="raporsiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Rapor Siswa</button>'
                    . '<br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="catatansiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Catatan Siswa</button>'
                    . '<br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="catatankelas(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Catatan Kelas</button>'
                    . '</div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function raporsiswa()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");
            $data['idusers'] = $idusers;
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            $data['background'] = base_url() . "/images/background.jpg";
            $data['logo_report'] = base_url() . "/images/logoreport.jpg";

            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek_head = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            if ($cek_head > 0) {

                $data['head'] = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ', c.waktu_akhir) as waktu, 
                    f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                    from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f 
                    where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus 
                    and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and b.idusers = '" . $idusers . "' and a.idjadwal = '" . $idjadwal . "';");

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/laporan_siswa/rapor_siswa');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxsiswa()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            // mengetahui ini level apa
            $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");
            $idlevel = $datajadwal->idlevel;

            // mencari tangal patokan awal dan akhir default
            $tanggal_patok_awal = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil asc limit 1;")->start;
            $tanggal_patok_akhir = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil desc limit 1;")->start;

            $jml_sesi = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT a.idsiswa, concat(b.nama_lengkap, ' (',b.panggilan, ')') as nama FROM jadwal_siswa a, siswa b where a.idjadwal = '" . $idjadwal . "' and a.idsiswa = b.idsiswa and b.keluar = 0 and a.is_keluar = 0;");
            foreach ($list->getResult() as $row) {

                $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml 
                from siswa a, jadwal_siswa b, jadwal c, level d
                where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                and a.idsiswa = '" . $row->idsiswa . "' and c.idlevel = d.idlevel and d.idpendkursus = '" . $datajadwal->idpendkursus . "' and d.tingkatan > '" . $datajadwal->tingkatan . "';")->jml;
                if ($cek_level_atasnya < 1) {

                    // mencari start masuk tiap siswa
                    $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_siswa a, jadwal b where a.idsiswa = '" . $row->idsiswa . "' and a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "';")->idjadwaldetil;
                    if (strlen($idjadwaldetil_siswa) > 0) {
                        $cekstart = $this->model->getAllQR("select start, count(*) as jml from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';");
                        if($cekstart->jml == ''){
                            $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_detil where idjadwal = '" . $idjadwal . "' limit 1;")->idjadwaldetil;
                            $tanggal_patok_awal = $this->model->getAllQR("select start from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';")->start;
                        }else{
                            $tanggal_patok_awal = $cekstart->start;
                        }
                        $jml_sesi = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;
                    }

                    $val = array();
                    $val[] = $no;

                    // melihat total attendence
                    $jml_presensi = $this->model->getAllQR("SELECT count(*) as jml_presensi FROM presensi_siswa where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $row->idsiswa . "';")->jml_presensi;
                    $presentase = round(($jml_presensi/$jml_sesi)* 100 ).'%';

                    $tambahsesi = $this->model->getAllQR("select count(*) as jml from jadwal_siswa where tambahan_sesi != '' and idsiswa = '" . $row->idsiswa . "' and idjadwal = '" . $idjadwal . "';")->jml;
                    if($tambahsesi > 0){
                        $jml_presensi = (75 / 100) * $jml_sesi;
                        $presentase = 75 .'% - Tambahan sesi';
                    }
                    $str = $row->nama . '<hr><b>Sesi : </b>' . $jml_sesi . '<br><b>Kehadiran : </b>' . round($jml_presensi).' <b>('. $presentase.')</b>';
                    if(round(($jml_presensi/$jml_sesi)* 100 ) < 75 || $tambahsesi > 0){
                        $str .= '<br><button type="button" class="btn btn-sm btn-info btn-fw" onclick="tambahsesi(' . "'" . $idjadwal . "'" . ',' . "'" . $row->idsiswa . "'" . ')">Tambahan Sesi</button>';
                    }
                    $val[] = $str;

                    // menampilkan data parameter penilaian
                    $tb_penilaian = '<table style="width:100%;">';
                    $q_param = $this->model->getAllQ("SELECT idp_nilai, parameter FROM parameter_nilai where idlevel = '" . $idlevel . "';");
                    foreach ($q_param->getResult() as $rowparam) {
                        // cek apa sdh dinilai apa belum
                        $cek_nilai = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $row->idsiswa . "' and idp_nilai = '" . $rowparam->idp_nilai . "';")->jml;
                        if ($cek_nilai > 0) {
                            $nilai = $this->model->getAllQR("SELECT nilai FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $row->idsiswa . "' and idp_nilai = '" . $rowparam->idp_nilai . "';")->nilai;
                            $tb_penilaian .= '<tr>';
                            $tb_penilaian .= '<td>' . $rowparam->parameter . '</td>';
                            $tb_penilaian .= '<td>&nbsp; : &nbsp;</td>';
                            $tb_penilaian .= '<td>' . $nilai . '</td>';
                            $tb_penilaian .= '</tr>';
                        } else {
                            $tb_penilaian .= '<tr>';
                            $tb_penilaian .= '<td>' . $rowparam->parameter . '</td>';
                            $tb_penilaian .= '<td>&nbsp; : &nbsp;</td>';
                            $tb_penilaian .= '<td></td>';
                            $tb_penilaian .= '</tr>';
                        }
                    }
                    $tb_penilaian .= '</table>';
                    $val[] = $tb_penilaian;

                    $val[] = '<div style="text-align:center; width:100%;">'
                        . '<button type="button" class="btn btn-sm btn-primary btn-block" onclick="show(' . "'" . $idjadwal . "'" . ',' . "'" . $row->idsiswa . "'" . ')"><i class="fas fa-pencil-alt"></i> Input Penilaian</button>'
                        . '<br><br>'
                        . '<button type="button" class="btn btn-sm btn-secondary btn-block" onclick="cetak(' . "'" . $this->modul->enkrip_url($idjadwal) . "'" . ',' . "'" . $this->modul->enkrip_url($row->idsiswa) . "'" . ')"><i class="fas fa-print"></i> Preview Rapor</button>'
                        . '</div>';
                    $data[] = $val;

                    $no++;
                }
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function show()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            $idsiswa = $this->request->getUri()->getSegment(4);

            $status = '';
            // mendapatkan level
            $idlevel = $this->model->getAllQR("select idlevel from jadwal where idjadwal = '" . $idjadwal . "';")->idlevel;
            $param = $this->model->getAllQ("SELECT idp_nilai, parameter, isnumber FROM parameter_nilai where idlevel = '" . $idlevel . "' order by idp_nilai;");
            foreach ($param->getResult() as $row) {
                $status .= '<div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">' . $row->parameter . '</label>';
                // cek status
                $cek = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row->idp_nilai . "';")->jml;
                if ($cek > 0) {
                    $nilai = $this->model->getAllQR("SELECT nilai FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row->idp_nilai . "';")->nilai;

                    if ($row->isnumber == "1") {
                        $status .= '<input type="text" id="' . $row->idp_nilai . '" name="' . $row->idp_nilai . '" class="form-control" placeholder="' . $row->parameter . '" autocomplete="off" value="' . $nilai . '" onkeypress="return hanyaAngka(event,false);">';
                    } else {
                        $status .= '<input type="text" id="' . $row->idp_nilai . '" name="' . $row->idp_nilai . '" class="form-control" placeholder="' . $row->parameter . '" autocomplete="off" value="' . $nilai . '">';
                    }
                } else {
                    if ($row->isnumber == "1") {
                        $status .= '<input type="text" id="' . $row->idp_nilai . '" name="' . $row->idp_nilai . '" class="form-control" placeholder="' . $row->parameter . '" autocomplete="off" onkeypress="return hanyaAngka(event,false);">';
                    } else {
                        $status .= '<input type="text" id="' . $row->idp_nilai . '" name="' . $row->idp_nilai . '" class="form-control" placeholder="' . $row->parameter . '" autocomplete="off">';
                    }
                }
                $status .= '</div></div>';
            }

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function tambahsesi()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            $idsiswa = $this->request->getUri()->getSegment(4);

            $data = $this->model->getAllQR("select tambahan_sesi, tambahan_ket from jadwal_siswa where idsiswa = '" . $idsiswa . "' and idjadwal = '".$idjadwal."';");
            
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function prosesupdate()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'tambahan_sesi' => $this->request->getPost('sesi'),
                'tambahan_ket' => $this->request->getPost('catatan')
            );
            $kond['idjadwal'] = $this->request->getPost('idjadwall');
            $kond['idsiswa'] = $this->request->getPost('idsiswaa');
            $simpan = $this->model->update("jadwal_siswa", $data, $kond);
            if ($simpan == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('idsiswa');
            $idlevel = $this->model->getAllQR("select idlevel from jadwal where idjadwal = '" . $idjadwal . "';")->idlevel;

            $param = $this->model->getAllQ("SELECT idp_nilai, parameter FROM parameter_nilai where idlevel = '" . $idlevel . "' order by idp_nilai;");
            foreach ($param->getResult() as $row) {
                $cek = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row->idp_nilai . "';")->jml;
                if ($cek > 0) {
                    $this->update($idjadwal, $idsiswa, $row->idp_nilai, $this->request->getPost($row->idp_nilai));
                } else {
                    $this->simpan($idjadwal, $idsiswa, $row->idp_nilai, $this->request->getPost($row->idp_nilai));
                }
            }
            $status = "Penilaian tersimpan";
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function getValueRapor()
    {
        if (session()->get("logged_pengajar")) {
            date_default_timezone_set("Asia/Jakarta");
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $idsiswa = $this->modul->dekrip_url($this->request->getUri()->getSegment(4));

            // cek
            $cek1 = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            $cek2 = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;

            $background = base_url() . "/images/background.jpg";
            $logo_report = base_url() . "/images/logoreport.jpg";
            $curDate = date("d-m-Y");
            $status = "tidak_oke";
            $nama_siswa = "";
            $level_siswa = "";
            $nama_guru = "";
            $term = "";
            $final_result = "";
            $total_kursus = 0;
            $presensi = 0;
            $str_format = "";

            if ($cek1 > 0 && $cek2 > 0) {

                // mencari tangal patokan awal dan akhir default
                $tanggal_patok_awal = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil asc limit 1;")->start;
                $tanggal_patok_akhir = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil desc limit 1;")->start;

                $total_kursus = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;

                // mencari start masuk tiap siswa
                $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_siswa a, jadwal b where a.idsiswa = '" . $idsiswa . "' and a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "';")->idjadwaldetil;
                if (strlen($idjadwaldetil_siswa) > 0) {
                    $tanggal_patok_awal = $this->model->getAllQR("select start from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';")->start;
                    $total_kursus = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;
                }

                $jadwal = $this->model->getAllQR("select a.*, b.idperiode, b.nama_term, b.tahun_ajar, c.level, c.tingkatan from jadwal a, periode b, level c where a.idperiode = b.idperiode and a.idlevel = c.idlevel and a.idjadwal = '" . $idjadwal . "';");
                $nama_kursus = $this->model->getAllQR("select nama_kursus from pendidikankursus where idpendkursus = '" . $jadwal->idpendkursus . "';")->nama_kursus;

                $ttd = array();

                $pengajar = '';
                $list_pengajar = $this->model->getAllQ("select c.idusers, nama, c.ttd from jadwal a, jadwal_pengajar b, users c where a.idjadwal = b.idjadwal and b.idusers = c.idusers and a.idjadwal = '" . $idjadwal . "';");
                foreach ($list_pengajar->getResult() as $rowpengajar) {
                    $pengajar .= $rowpengajar->nama . ', ';

                    $ttdstatus = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;
                
                    if($ttdstatus == "Ya"){
                        $ttdpengajar = $this->model->getAllQR("SELECT ttd FROM ttd limit 1")->ttd;
                    }else{
                        $ttdpengajar = $rowpengajar->ttd;
                    }
                    // membaca tanda tangan
                    $def_ttd = base_url() . '/images/noimg.jpg';
                    if (strlen($ttdpengajar) > 0) {
                        if (file_exists($this->modul->getPathApp() . $ttdpengajar)) {
                            $def_ttd = base_url() . '/uploads/' . $ttdpengajar;
                        }
                    }

                    array_push($ttd, $def_ttd);
                }

                $pengajar = substr($pengajar, 0, strlen($pengajar) - 2);
                $siswa = $this->model->getAllQR("SELECT idsiswa, concat(nama_lengkap, ' (', panggilan, ')') as nama FROM siswa where idsiswa = '" . $idsiswa . "';");

                $status = "oke";
                $nama_siswa = $siswa->nama;
                $level_siswa = $jadwal->level;
                $nama_guru = $pengajar;
                $term = $jadwal->nama_term;

                // mencari nilai kelanjutan
                $final_result = "Finish";
                $tingkatan = ($jadwal->tingkatan) + 1;
                $cek_tingkatan = $this->model->getAllQR("select count(*) as jml from level where idpendkursus = '" . $jadwal->idpendkursus . "' and tingkatan = '" . $tingkatan . "';")->jml;
                if ($cek_tingkatan > 0) {
                    $next_level = $this->model->getAllQR("select level from level where idpendkursus = '" . $jadwal->idpendkursus . "' and tingkatan = '" . $tingkatan . "';")->level;
                    $final_result = "Pass To " . $next_level;
                }

                $presensi = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '" . $idsiswa . "' and idjadwal = '" . $idjadwal . "';")->jml;

                $str_format = $this->modelRaporByLevel($idjadwal, $idsiswa, $jadwal->idlevel, $curDate, $total_kursus, $presensi, $final_result, $pengajar, $ttd);
            }

            echo json_encode(array(
                "status" => $status,
                "logo" => $logo_report,
                "background" => $background,
                "nama_siswa" => $nama_siswa,
                "level_siswa" => $level_siswa,
                "nama_guru" => $nama_guru,
                "term" => $term,
                "strFormat" => $str_format,
                "nama_kursus" => $nama_kursus
            ));
        } else {
            $this->modul->halaman('login');
        }
    }


    private function modelRaporByLevel($idjadwal, $idsiswa, $idlevel, $curDate, $total_kursus, $presensi, $final_result, $pengajar, $ttd)
    {
        //cek tambah sesi
        $tambahsesi = $this->model->getAllQR("select count(*) as jml, tambahan_sesi from jadwal_siswa where tambahan_sesi != '' and idsiswa = '" . $idsiswa . "' and idjadwal = '" . $idjadwal . "';");
        if($tambahsesi->jml > 0){
            $presensi = round((75 / 100) * $total_kursus);
        }

        $str = '';
        $str .= '<tr>
                    <td colspan="4">
                        <table border="0" style="width:100%;">
                                <tr>
                                    <td colspan="2" style="text-align: left;"><u>ATTENDANCE : </u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">
                                        POSSIBLE TOTAL SESSIONS&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $total_kursus . '
                                    </td>
                                    <td style="text-align: right;">
                                        SESSIONS ATTENDED&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $presensi .'
                                    </td>
                                </tr>';
                                if($tambahsesi->jml > 0){
                                    $str .= '<tr>
                                        <td colspan="2" style="text-align: left;">The student has attended '.$tambahsesi->tambahan_sesi.' sessions to meet the minimum 75% attendance requirement.</td>
                                    </tr>';
                                }
                                $str .= '<tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                        </table>
                    </td>
                </tr>';

        $list = $this->model->getAllQ("SELECT a.idformat_rapor, a.idpendkursus, a.title, b.idformat_rl FROM format_rapor a, format_raport_level b WHERE a.idformat_rapor = b.idformat_rapor AND b.idlevel = '" . $idlevel . "' order by idformat_rapor;");
        foreach ($list->getResult() as $row) {
            $str .= '<tr>
                        <td colspan="4" style="text-align: left;"><u>' . $row->title . ' : </u></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left;">&nbsp;</td>
                    </tr>';
            $list2 = $this->model->getAllQ("SELECT * FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';");
            foreach ($list2->getResult() as $row2) {

                $datatemp = array();
                $list_param = $this->model->getAllQ("SELECT param_operator FROM format_rapor_detil_rumus WHERE idformat_rapor = '" . $row->idformat_rapor . "' and idformat_rd = '" . $row2->idformat_rd . "' and idlevel = '" . $idlevel . "';");
                foreach ($list_param->getResult() as $row3) {
                    if (substr($row3->param_operator, 0, 1) == "P") {
                        $cek_display_param = $this->model->getAllQR("select count(*) as jml from rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row3->param_operator . "';")->jml;
                        if ($cek_display_param > 0) {
                            $temp = $this->model->getAllQR("select nilai from rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row3->param_operator . "';")->nilai;
                            array_push($datatemp, $temp);
                        } else {
                            array_push($datatemp, "");
                        }
                    } else {
                        $temp = $row3->param_operator;
                        array_push($datatemp, $temp);
                    }
                }

                $display_param = '';
                if (count($datatemp) > 1) {
                    $hasil = 0;
                    $str_dalam = '';
                    for ($i = 0; $i < count($datatemp); $i++) {
                        $str_dalam .= $datatemp[$i];
                    }
                    try {
                        $hasil = eval('return ' . trim($str_dalam) . ';');
                    } catch (\Throwable $th) {
                        $hasil = 0;
                    }
                    $display_param = $hasil . '';
                } else if (count($datatemp) > 0) {
                    $display_param = $datatemp[0] . '';
                } else {
                    $display_param = '';
                }
                $str .= '<tr>
                            <td style="text-align: left; width: 30%;">' . $row2->subtitle . '</td>
                            <td style="text-align: left;">' . $display_param . '</td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: left;"></td>
                        </tr>
                        <tr style="line-height: 7px;">
                            <td colspan="4" style="text-align: left;">&nbsp;</td>
                        </tr>';
            }
        }


        $str .= '<!--<tr>
                    <td colspan="4" style="text-align: left;">&nbsp;</td>
                </tr>
                
                <tr>
                    <td style="text-align: left;">FINAL RESULT</td>
                    <td style="text-align: left;" id="final_result">' . $final_result . '</td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: left;"></td>
                </tr>
                -->
                <tr>
                    <td style="text-align: left;">DATE</td>
                    <td style="text-align: left;">' . $curDate . '</td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: left;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table border="0" style="width:100%;">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; width : 200px;">
                                        <div style="text-align: center;">
                                            <img src="' . $ttd[0] . '" alt="" class="img-thumbnails" style="width: 100px; height: auto;">
                                        </div>
                                    </td>
                                </tr>
                        </table>
                    </td>
                </tr>';
        return $str;
    }

    public function catatansiswa()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");
            $data['idusers'] = $idusers;
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek_head = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            if ($cek_head > 0) {
                $data['head'] = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ', c.waktu_akhir) as waktu, 
                a.idpendkursus, f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f 
                where a.idsesi = c.idsesi  and a.idpendkursus = f.idpendkursus 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and b.idusers = '" . $idusers . "' and a.idjadwal = '" . $idjadwal . "';");

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/laporan_siswa/catatan_siswa');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxcatatansiswa()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");
            $idjadwal = $this->request->getUri()->getSegment(3);
            // mencari ini level berapa
            $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");

            // menampilkan hanya yang di ajar saja
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal 
            from siswa a, jadwal b, jadwal_siswa c, level d, jadwal_pengajar e 
            where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and c.is_keluar = 0 and a.keluar = 0 and b.idlevel = d.idlevel and b.idjadwal = e.idjadwal and e.idusers = '" . $idusers . "' and b.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {

                $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml 
                from siswa a, jadwal_siswa b, jadwal c, level d
                where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                and a.idsiswa = '" . $row->idsiswa . "' and c.idlevel = d.idlevel and d.idpendkursus = '" . $datajadwal->idpendkursus . "' and d.tingkatan > '" . $datajadwal->tingkatan . "';")->jml;
                if ($cek_level_atasnya < 1) {
                    $val = array();
                    $val[] = $no;
                    $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                    $val[] = $row->tgllahir;
                    $val[] = $row->nama_sekolah;
                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detil(' . "'" . $this->modul->enkrip_url($row->idsiswa) . "'" . ',' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Pilih</button>'
                        . '</div></div>';
                    $data[] = $val;

                    $no++;
                }
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function detilcatatansiswa()
    {
        if (session()->get("logged_pengajar")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            $idsiswa = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(4));
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                $head = $this->model->getAllQR("select a.idsiswa, a.nama_lengkap, a.panggilan, b.idjadwal, b.groupwa, b.hari, d.level 
                    from siswa a, jadwal b, jadwal_siswa c, level d 
                    where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and b.idlevel = d.idlevel and a.idsiswa = '" . $idsiswa . "' and b.idjadwal = '" . $idjadwal . "';");
                $data['head'] = $head;

                // mencari data pengajar
                $nama_pengajar = "";
                $list_pengajar = $this->model->getAllQ("SELECT a.idusers, b.nama FROM jadwal_pengajar a, users b where a.idjadwal = '" . $idjadwal . "' and a.idusers = b.idusers;");
                foreach ($list_pengajar->getResult() as $row) {
                    $nama_pengajar .= $row->nama . ',';
                }
                $data['nama_pengajar'] = substr($nama_pengajar, 0, strlen($nama_pengajar) - 1);

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/laporan_siswa/catatan_siswa_detil');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxcatatansiswapertanggal()
    {
        if (session()->get("logged_pengajar")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->request->getUri()->getSegment(4);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT date_format(a.start, '%d %M %Y') as tglf, b.catatan, c.idusers, d.nama, date_format(c.tanggal, '%d %M %Y') as tglFollow, c.kesimpulan, c.status_follow 
                FROM jadwal_detil a 
                inner join catatan_siswa b on a.idjadwaldetil = b.idjadwaldetil 
                left join catatan_siswa_follow_up c  on b.idcatatan_siswa = c.idcatatan_siswa 
                left join users d on c.idusers = d.idusers 
                where b.idsiswa = '" . $idsiswa . "' and b.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tglf;
                $val[] = $row->catatan;
                $val[] = $row->nama;
                $val[] = $row->tglFollow;
                $val[] = $row->kesimpulan;
                $val[] = $row->status_follow;
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function catatankelas()
    {
        if (session()->get("logged_pengajar")) {
            $idusers = session()->get("idusers");
            $data['idusers'] = $idusers;
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = "PENGAJAR";
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek_head = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            if ($cek_head > 0) {
                $data['head'] = $this->model->getAllQR("select a.idjadwal, a.groupwa, concat(c.waktu_awal, ' - ', c.waktu_akhir) as waktu, 
                a.idpendkursus, f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and b.idusers = '" . $idusers . "' and a.idjadwal = '" . $idjadwal . "';");

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/laporan_siswa/catatan_kelas');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxcatatankelas()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT b.idcatatan_kelas, a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, catatan, materi_diskusi, date_format(tglcek, '%d %M %Y') as tglcek, hasil_konfirm  
            FROM jadwal_detil a, catatan_kelas b where a.idjadwaldetil = b.idjadwaldetil and a.idjadwal = '" . $idjadwal . "' order by a.start;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tglf;
                $val[] = $row->catatan;
                $val[] = $row->materi_diskusi;
                $val[] = $row->tglcek;
                $val[] = $row->hasil_konfirm;
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    private function kirim_pesan_text($tlp, $pesan)
    {
        $url = 'https://app.whacenter.com/api/send';
        $ch = curl_init($url);

        $data = array(
            'device_id' => $this->modul->deviceid2(),
            'number' => $tlp,
            'message' => $pesan
        );
        $payload = $data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private function kirim_pesan_gambar1($tlp, $pesan, $pathfile)
    {
        $url = 'https://app.whacenter.com/api/send';
        $ch = curl_init($url);

        $data1 = file_get_contents($pathfile);
        $img_base64 =  base64_encode($data1);
        $img_base64 = urlencode($img_base64);

        $data = array(
            'device_id' => $this->modul->deviceid2(),
            'number' => $tlp,
            'message' => $pesan,
            'file' => $img_base64
        );
        $payload = $data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private function kirim_pesan_gambar($tlp, $pesan, $pathfile)
    {
        $url = 'https://app.whacenter.com/api/send';
        $ch = curl_init($url);

        $data = array(
            'device_id' => $this->modul->deviceid2(),
            'number' => $tlp,
            'message' => $pesan,
            'file' => $pathfile
        );
        $payload = $data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function tangkapBase64()
    {
        if (session()->get("logged_pengajar")) {
            $nama = str_replace(" ", "_", trim($this->request->getPost('nama')));
            $img = $this->request->getPost('database64');
            $idsiswa = $this->modul->dekrip_url($this->request->getPost('idsiswa'));
            $idjadwal = $this->modul->dekrip_url($this->request->getPost('idjadwal'));

            $lawas = $this->model->getAllQR("SELECT file_rapor FROM jadwal_siswa WHERE idsiswa = '" . $idsiswa . "' AND idjadwal = '" . $idjadwal . "';")->file_rapor;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }

            $img = explode(";", $img)[1];
            $img = explode(",", $img)[1];
            $img = base64_decode($img);

            $path = "uploads/" . $nama . ".jpeg";
            $hasil = file_put_contents($path, $img);
            if ($hasil) {
                // masukkan data ke dalam database
                $data = array(
                    'file_rapor' => $nama . ".jpeg",
                    'pesan_rapor' => $this->request->getPost('pesan')
                );
                $kond['idsiswa'] = $idsiswa;
                $kond['idjadwal'] = $idjadwal;
                $update = $this->model->update("jadwal_siswa", $data, $kond);
                if ($update == 1) {
                    $status = "oke";
                } else {
                    $status = "File gagal ditulis";
                }
            } else {
                $status = "File gagal ditulis";
            }

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function kirim_rapor_email()
    {
        if (session()->get("logged_pengajar")) {
            $idsiswa = $this->modul->dekrip_url($this->request->getPost('idsiswa'));
            $idjadwal = $this->modul->dekrip_url($this->request->getPost('idjadwal'));

            // cek pada table jadwal siswa
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM jadwal_siswa where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                // mencari email siswa
                $siswa = $this->model->getAllQR("select nama_lengkap, email from siswa where idsiswa = '" . $idsiswa . "';");
                if (strlen($siswa->email) > 0) {
                    $email = $siswa->email;
                    //$email = "rampapraditya@gmail.com";
                    $hasil = $this->proseskirimemail($email, "Rapor Siswa", $this->pesan($idjadwal, $idsiswa));
                    if ($hasil == 1) {
                        $status = "Email terkirim";
                    } else {
                        $status = "Email gagal terkirim";
                    }
                } else {
                    $status = "Tidak ditemukan alamat email pada siswa " . $siswa->email;
                }
            } else {
                $status = "Data jadwal siswa tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function proseskirimemail($to, $subject, $message)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@leapsurabaya.sch.id', 'Rapor Siswa');

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            $status = 1;
        } else {
            $status = 0;
        }
        return $status;
    }

    private function pesan($idjadwal, $idsiswa)
    {
        date_default_timezone_set("Asia/Jakarta");

        $cek1 = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
        $cek2 = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;

        $background = base_url() . "/images/background.jpg";
        $logo_report = base_url() . "/images/logoreport.jpg";
        $curDate = date("d-m-Y");
        $nama_siswa = "";
        $level_siswa = "";
        $nama_guru = "";
        $term = "";
        $final_result = "";
        $total_kursus = 0;
        $presensi = 0;

        if ($cek1 > 0 && $cek2 > 0) {

            // mencari tangal patokan awal dan akhir default
            $tanggal_patok_awal = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil asc limit 1;")->start;
            $tanggal_patok_akhir = $this->model->getAllQR("select b.start from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by b.idjadwaldetil desc limit 1;")->start;

            $total_kursus = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;

            // mencari start masuk tiap siswa
            $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_siswa a, jadwal b where a.idsiswa = '" . $idsiswa . "' and a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "';")->idjadwaldetil;
            if (strlen($idjadwaldetil_siswa) > 0) {
                $tanggal_patok_awal = $this->model->getAllQR("select start from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';")->start;
                $total_kursus = $this->model->getAllQR("select count(*) as jml from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' and (b.start between '" . $tanggal_patok_awal . "' and '" . $tanggal_patok_akhir . "');")->jml;
            }

            $jadwal = $this->model->getAllQR("select a.*, b.idperiode, b.nama_term, b.tahun_ajar, c.level, c.tingkatan from jadwal a, periode b, level c where a.idperiode = b.idperiode and a.idlevel = c.idlevel and a.idjadwal = '" . $idjadwal . "';");
            $nama_kursus = $this->model->getAllQR("select nama_kursus from pendidikankursus where idpendkursus = '" . $jadwal->idpendkursus . "';")->nama_kursus;

            $ttd = array();

            $pengajar = '';
            $list_pengajar = $this->model->getAllQ("select c.idusers, nama, c.ttd from jadwal a, jadwal_pengajar b, users c where a.idjadwal = b.idjadwal and b.idusers = c.idusers and a.idjadwal = '" . $idjadwal . "';");
            foreach ($list_pengajar->getResult() as $rowpengajar) {
                $pengajar .= $rowpengajar->nama . ', ';

                $ttdstatus = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;
                
                if($ttdstatus == "Ya"){
                    $ttdpengajar = $this->model->getAllQR("SELECT ttd FROM ttd limit 1")->ttd;
                }else{
                    $ttdpengajar = $rowpengajar->ttd;
                }
                // membaca tanda tangan
                $def_ttd = base_url() . '/images/noimg.jpg';
                if (strlen($ttdpengajar) > 0) {
                    if (file_exists($this->modul->getPathApp() . $ttdpengajar)) {
                        $def_ttd = base_url() . '/uploads/' . $ttdpengajar;
                    }
                }

                array_push($ttd, $def_ttd);
            }

            $pengajar = substr($pengajar, 0, strlen($pengajar) - 2);
            $siswa = $this->model->getAllQR("SELECT idsiswa, concat(nama_lengkap, ' (', panggilan, ')') as nama FROM siswa where idsiswa = '" . $idsiswa . "';");

            $nama_siswa = $siswa->nama;
            $level_siswa = $jadwal->level;
            $nama_guru = $pengajar;
            $term = $jadwal->nama_term;

            // mencari nilai kelanjutan
            $final_result = "Finish";
            $tingkatan = ($jadwal->tingkatan) + 1;
            $cek_tingkatan = $this->model->getAllQR("select count(*) as jml from level where idpendkursus = '" . $jadwal->idpendkursus . "' and tingkatan = '" . $tingkatan . "';")->jml;
            if ($cek_tingkatan > 0) {
                $next_level = $this->model->getAllQR("select level from level where idpendkursus = '" . $jadwal->idpendkursus . "' and tingkatan = '" . $tingkatan . "';")->level;
                $final_result = "Pass To " . $next_level;
            }

            $presensi = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '" . $idsiswa . "' and idjadwal = '" . $idjadwal . "';")->jml;

            $background = base_url() . "/images/background.jpg";
            $logo_report = base_url() . "/images/logoreport.jpg";

            $html = '
            <html>
                <head>
                    <style type="text/css">

                        * {
                            box-sizing: border-box;
                        }
                        body {
                            font-family: Verdana, Geneva, sans-serif
                        }
                
                        h3 {
                            color:#4C628D
                        }
                
                        p {
                            font-weight:bold
                        }

                        .dialogbody {
                            background: url(' . $background . ');
                            -webkit-background-size: cover;
                            -moz-background-size: cover;
                            -o-background-size: cover;
                            background-size: 100% 100%;
                            margin-top: 0cm;
                            margin-left: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            height: 842px;
                            width: 983px;
                            border-width:0.8px;
                            border-style:solid;
                            border-color:black;
                        }

                        .column1 {
                            float: left;
                            width: 50%;
                            padding: 15px;
                            height: 842px;
                        }
                    
                        .column2 {
                            float: left;
                            width: 50%;
                            padding: 15px;
                            height: 842px;
                        }
                    
                        .row:after {
                            content: "";
                            display: table;
                            clear: both;
                        }

                    </style>
                </head>
                <body>
                
                    <h3>Selamat siang, </h3>
                    <p>Berikut kami kirimkan E-Rapor/E-Sertifikat General English untuk:<br>
                    Nama : ' . $nama_siswa . '<br>
                    Level : ' . $level_siswa . '
                    </p>   
                    <p>Selamat telah menyelesaikan keseluruhan materi dan aktivitas di level ini dengan baik.</p>
                    <p>Terima kasih,<br>Salam LKP LEAP English & Digital Class Surabaya</p>


                    <div id="dialogbody" class="dialogbody">
                        <div class="row">
                            <div class="column1">
                                <table border="0" style="width: 90%; margin-top: 20px; margin-right: 20px; margin-left: 20px; font-size: 12px;">
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <img id="logoreport" src="' . $logo_report . '" alt="logo" style="width: 200px; height: auto;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; font-size: 18px;">ACCREDITATION LEVEL B</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Operational Licence : 421.9 / 41 / A / IO-SP / 436.7.15 / 2022</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Nilek : 05209.1.0593 / 09</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">NPSN : K0560112</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Rungkut Asri Tengah VII / 51, Surabaya 60293</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Phone : (031) 870 5464 - 0813 3538 1619</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">www.leapsurabaya.sch.id</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; font-size: 18px;"><u>OUR VISION</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <p style="margin-left: 30px; margin-right: 30px;">LEAP vision\'s is to become a sustainable and professional educational institution that prioritizes equality, quality, and ease of access to learning through the synergy of human roles, technology, and community collaboration to create a positive educational environment for educators and learners</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr style="border: 1px solid black;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; font-size: 18px;"><u>STUDENT PROGRESS REPORT</u></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left; width: 100px;">&nbsp;&nbsp;NAME</td>
                                        <td style="text-align: left;" id="nama_siswa">&nbsp;&nbsp;' . $nama_siswa . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">&nbsp;&nbsp;LEVEL</td>
                                        <td style="text-align: left;" id="level_siswa">&nbsp;&nbsp;' . $level_siswa . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">&nbsp;&nbsp;TEACHER</td>
                                        <td style="text-align: left;" id="nama_guru">&nbsp;&nbsp;' . $nama_guru . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">&nbsp;&nbsp;TERM</td>
                                        <td style="text-align: left;" id="term">&nbsp;&nbsp;' . $term . '</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="column2">
                                <table border="0" style="width: 90%; margin-top: 30px; margin-right: 20px; font-size: 11px;">
                                    <tr>
                                        <td colspan="4">
                                            <table border="0" style="width:100%; font-size: 11px;">
                                                <tr>
                                                    <td colspan="2" style="text-align: left;"><u>ATTENDANCE : </u></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                                </tr>
                                                <tr>    
                                                    <td style="text-align: left;">
                                                        POSSIBLE TOTAL SESSIONS&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $total_kursus . '
                                                    </td>
                                                    <td style="text-align: right;">
                                                        SESSIONS ATTENDED&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $presensi . '
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>';
            $list = $this->model->getAllQ("SELECT a.idformat_rapor, a.idpendkursus, a.title, b.idformat_rl FROM format_rapor a, format_raport_level b WHERE a.idformat_rapor = b.idformat_rapor AND b.idlevel = '" . $jadwal->idlevel . "' order by idformat_rapor;");
            foreach ($list->getResult() as $row) {
                $html .= '<tr>
                            <td colspan="4" style="text-align: left;"><u>' . $row->title . ' : </u></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: left;">&nbsp;</td>
                        </tr>';
                $list2 = $this->model->getAllQ("SELECT * FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';");
                foreach ($list2->getResult() as $row2) {

                    $datatemp = array();
                    $list_param = $this->model->getAllQ("SELECT param_operator FROM format_rapor_detil_rumus WHERE idformat_rapor = '" . $row->idformat_rapor . "' and idformat_rd = '" . $row2->idformat_rd . "' and idlevel = '" . $jadwal->idlevel . "';");
                    foreach ($list_param->getResult() as $row3) {
                        if (substr($row3->param_operator, 0, 1) == "P") {
                            $cek_display_param = $this->model->getAllQR("select count(*) as jml from rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row3->param_operator . "';")->jml;
                            if ($cek_display_param > 0) {
                                $temp = $this->model->getAllQR("select nilai from rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row3->param_operator . "';")->nilai;
                                array_push($datatemp, $temp);
                            } else {
                                array_push($datatemp, "");
                            }
                        } else {
                            $temp = $row3->param_operator;
                            array_push($datatemp, $temp);
                        }
                    }

                    $display_param = '';
                    if (count($datatemp) > 1) {
                        $hasil = 0;
                        $str_dalam = '';
                        for ($i = 0; $i < count($datatemp); $i++) {
                            $str_dalam .= $datatemp[$i];
                        }
                        try {
                            $hasil = eval('return ' . trim($str_dalam) . ';');
                        } catch (\Throwable $th) {
                            $hasil = 0;
                        }
                        $display_param = $hasil . '';
                    } else if (count($datatemp) > 0) {
                        $display_param = $datatemp[0] . '';
                    } else {
                        $display_param = '';
                    }
                    $html .= '<tr>
                                <td style="text-align: left;">' . $row2->subtitle . '</td>
                                <td style="text-align: left;">' . $display_param . '</td>
                                <td style="text-align: left;"></td>
                                <td style="text-align: left;"></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;">&nbsp;</td>
                            </tr>';
                }
            }

            $html .= '
                <tr>
                    <td style="text-align: left;">DATE</td>
                    <td style="text-align: left;">' . $curDate . '</td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: left;"></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table border="0" style="width:100%; font-size:11px;">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; width : 200px;">
                                        <div style="text-align: center;">
                                            <img src="' . $ttd[0] . '" alt="" class="img-thumbnails" style="width: 70px; height: auto;">
                                        </div>
                                    </td>
                                </tr>
                        </table>
                    </td>
                </tr>';
            $html .= '</table></div></div></div></body></html>';
        } else {

            $html = '<html><head></head><body></body></html>';
        }

        return $html;
    }

    private function tangkapbasecoba()
    {
        // Get the incoming image data
        $image = $_POST["image"];

        // Remove image/jpeg from left side of image data
        // and get the remaining part
        $image = explode(";", $image)[1];

        // Remove base64 from left side of image data
        // and get the remaining part
        $image = explode(",", $image)[1];

        // Replace all spaces with plus sign (helpful for larger images)
        $image = str_replace(" ", "+", $image);

        // Convert back from base64
        $image = base64_decode($image);

        // Save the image as filename.jpeg
        $path = "images/" . $this->modul->getCurTime() . ".jpg";
        file_put_contents($path, $image);

        $status = "oke";
        echo $status;
    }

    public function exportdata()
    {
        if (session()->get("logged_pengajar")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            // mencari level terlebih dahulu
            $datajadwal = $this->model->getAllQR("select a.idlevel, b.level, b.tingkatan, a.idpendkursus, a.groupwa from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");
            $idlevel = $datajadwal->idlevel;
            $nama_level = $datajadwal->level;
            $nama_rombel = $datajadwal->groupwa;

            // mencari parameter penilaian
            $jml_param = $this->model->getAllQR("SELECT count(*) as jml FROM parameter_nilai where idlevel = '" . $idlevel . "';")->jml;

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

            $alfabet = $this->alfa($jml_param);
            $max_alfa = $alfabet[$jml_param - 1];

            $judul = "Rombel : " . $nama_rombel . " Level : " .  strtoupper($nama_level);
            $nama_file = "Rombel_" . $nama_rombel . " Level_" .  strtoupper($nama_level);

            $sheet->setCellValue('A1', $judul); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A1:' . $max_alfa . '1'); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            $sheet->getStyle('A1')->getFont()->setSize(12); // Set font size 12 untuk kolom A1

            $sheet->setCellValue('A2', 'ID');
            $sheet->getStyle('A2')->applyFromArray($style_col);
            $sheet->getColumnDimension('A')->setWidth(45);

            $sheet->setCellValue('B2', 'NAMA');
            $sheet->getStyle('B2')->applyFromArray($style_col);
            $sheet->getColumnDimension('B')->setWidth(65);

            // Buat header tabel nya pada baris ke 3
            $i = 67; // kita start pada huruf B
            $listparam = $this->model->getAllQ("SELECT * FROM parameter_nilai where idlevel = '" . $idlevel . "';");
            foreach ($listparam->getResult() as $row) {
                $Letter = chr($i);
                if ($row->isnumber == "1") {
                    $sheet->setCellValue($Letter . '2', $row->parameter . ' (Input Angka) ');
                    $sheet->getStyle($Letter . '2')->applyFromArray($style_col);
                    $sheet->getColumnDimension($Letter)->setWidth(strlen($row->parameter) + 25);
                } else {
                    $sheet->setCellValue($Letter . '2', $row->parameter);
                    $sheet->getStyle($Letter . '2')->applyFromArray($style_col);
                    $sheet->getColumnDimension($Letter)->setWidth(strlen($row->parameter) + 10);
                }

                $i++;
            }

            $baris = 3;
            $list = $this->model->getAllQ("SELECT c.idsiswa, concat(c.nama_lengkap, ' ( ',  c.panggilan, ' ) ') as nama FROM jadwal a, jadwal_siswa b, siswa c where a.idjadwal = b.idjadwal and b.idsiswa = c.idsiswa and a.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {

                $sheet->setCellValueExplicit('A' . $baris, $this->modul->enkrip_url($row->idsiswa), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $baris, $row->nama, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('B' . $baris)->applyFromArray($style_row);

                $sheet->getStyle('A' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


                $i = 67; // kita start pada huruf B
                foreach ($listparam->getResult() as $row) {
                    $Letter = chr($i);
                    $sheet->setCellValueExplicit($Letter . $baris, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->getStyle($Letter . $baris)->applyFromArray($style_row);
                    $sheet->getStyle($Letter . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $i++;
                }

                $sheet->getRowDimension($baris)->setRowHeight(20); // Set height tiap row
                $baris++; // Tambah 1 setiap kali looping
            }

            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $sheet->setTitle("Nilai Siswa");
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } else {
            $this->modul->halaman('login');
        }
    }

    private function alfa($jumlah)
    {
        $data = array();
        $awal = 65;
        $akhir = ($awal + $jumlah) + 2;
        for ($i = 65; $i <= $akhir; $i++) {
            $Letter = chr($i);
            array_push($data, $Letter);
        }
        return $data;
    }

    public function proses_upload_file()
    {
        if (session()->get("logged_pengajar")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $idjadwal = $this->request->getPost('idjadwal_rapor');
                    $status = $this->uploadFileExcel($idjadwal);
                }
            } else {
                $status = "File tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function uploadFileExcel($idjadwal)
    {
        $idlevel = $this->model->getAllQR("select idlevel from jadwal where idjadwal = '" . $idjadwal . "';")->idlevel;

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {

                $targetDir = FCPATH . "uploads/" . $fileName;
                if (file_exists($targetDir)) {
                    $ext = pathinfo($targetDir, PATHINFO_EXTENSION);
                    if ($ext == "xls" || $ext == "xlsx") {
                        if ($ext == "xls") {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        } else if ($ext == "xlsx") {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }

                        $spreadSheet = $reader->load($targetDir);
                        $dataexcel = $spreadSheet->getActiveSheet()->toArray();
                        foreach ($dataexcel as $key => $value) {
                            if ($key > 1) {

                                if ($value[0] == null) {
                                    $idsiswa = "";
                                } else {
                                    $idsiswa = $this->modul->dekrip_url($value[0]);
                                }

                                if ($value[1] == null) {
                                    $namasiswa = "";
                                } else {
                                    $namasiswa = $value[1];
                                }

                                // membaca paramter penilaian
                                $index_kolom = 2;
                                $listparameter = $this->model->getAllQ("select idp_nilai, parameter, isnumber from parameter_nilai where idlevel = '" . $idlevel . "';");
                                foreach ($listparameter->getResult() as $row) {
                                    if ($value[$index_kolom] != null) {
                                        // cek sdh pernah tersimpan apa belum
                                        $cek_rapor = $this->model->getAllQR("select count(*) as jml from rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "' and idp_nilai = '" . $row->idp_nilai . "';")->jml;
                                        if ($cek_rapor > 0) {
                                            $this->update($idjadwal, $idsiswa, $row->idp_nilai, $value[$index_kolom]);
                                        } else {
                                            $this->simpan($idjadwal, $idsiswa, $row->idp_nilai, $value[$index_kolom]);
                                        }
                                    }
                                    $index_kolom++;
                                }
                            }
                        }

                        unlink($targetDir);

                        $status = "File terupload";
                    } else {
                        $status = "Bukan format file excel";
                    }
                } else {
                    $status = "File tidak ditemukan";
                }
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function simpan($idjadwal, $idsiswa, $key, $nilai)
    {
        $data = array(
            'idrapor' => $this->model->autokode("R", "idrapor", "rapor", 2, 8),
            'idjadwal' => $idjadwal,
            'idsiswa' => $idsiswa,
            'tanggal' => $this->modul->TanggalWaktu(),
            'idp_nilai' => $key,
            'nilai' => $nilai
        );
        $simpan = $this->model->add("rapor", $data);
        return $simpan;
    }

    private function update($idjadwal, $idsiswa, $key, $nilai)
    {
        $data = array(
            'tanggal' => $this->modul->TanggalWaktu(),
            'nilai' => $nilai
        );
        $kond['idjadwal'] = $idjadwal;
        $kond['idsiswa'] = $idsiswa;
        $kond['idp_nilai'] = $key;
        $update = $this->model->update("rapor", $data, $kond);
        return $update;
    }
}
