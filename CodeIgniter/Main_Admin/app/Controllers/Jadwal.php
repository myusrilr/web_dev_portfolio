<?php

namespace App\Controllers;

/**
 * Description of Jadwal
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Jadwal extends BaseController
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
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            $data['sesi'] = $this->model->getAllQ("select * from sesi");
            $data['kursus'] = $this->model->getAllQ("select * from pendidikankursus");

            echo view('back/head', $data);
            if (session()->get("logged_bos")) {
                echo view('back/bos/menu');
            } else {
                echo view('back/akademik/menu');
            }
            echo view('back/akademik/jadwal/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pendidikan")) {
            // menampilkan yang non archive saja
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, a.mode_belajar, a.tempat, f.meeting_id, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar   
                from jadwal a, sesi e, zoom f, level g, periode h, pendidikankursus i   
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idsesi = e.idsesi and a.idpendkursus = i.idpendkursus and a.status_archive = 0 order by a.groupwa;");
            foreach ($list->getResult() as $row) {
                // mencari jumlah siswa
                $jml_siswa = $this->model->getAllQR("select count(*) as jml from jadwal_siswa where idjadwal = '" . $row->idjadwal . "';")->jml;
                $val = array();
                $val[] = $no;
                $val[] = '<b>ROMBEL : </b>' . $row->groupwa . '<br><b>Tingkatan : </b>' . $row->level . '<br><b>Meeting ID : </b>' . $row->meeting_id . '<br><b>Mode : </b>' . $row->mode_belajar . '<br><b>Tempat : </b>' . $row->tempat . '<br><b>Jumlah Siswa : </b>' . $jml_siswa;
                $val[] = $row->nama_kursus . '<br>' . $row->tahun_ajar;
                $val[] = $row->hari . '<br>' . $row->nama_sesi . ' (' . $row->waktu_awal . ' - ' . $row->waktu_akhir . ')';
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" title="Ganti Jadwal" class="btn btn-sm btn-info" onclick="ganti(' . "'" . $row->idjadwal . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" title="Hapus Jadwal" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idjadwal . "'" . ',' . "'" . $row->groupwa . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '<button type="button" title="Guru dan Siswa" class="btn btn-sm btn-secondary" onclick="ploting(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="fas fa-users"></i></button>'
                    . '<button type="button" title="Kirim Whatsapp" class="btn btn-sm btn-success" onclick="wa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="ion ion-logo-whatsapp"></i></button>'
                    . '<button type="button" title="Naik Kelas" class="btn btn-sm btn-primary" onclick="uplevel(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="feather icon-arrow-up"></i></button>'
                    . '</div></div>
                        <br><br>
                        <div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="archivekan(' . "'" . $row->idjadwal . "'" . ',' . "'" . $row->groupwa . "'" . ')"><i class="ion ion-md-archive"></i> Archive</button>'
                    . '</div></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist_unacrhive()
    {
        if (session()->get("logged_pendidikan")) {
            // menampilkan yang non archive saja
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, a.mode_belajar, a.tempat, f.meeting_id, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar, h.nama_term, CONCAT(h.tanggal, '-', h.bulan_awal) AS tanggal_term   
                from jadwal a, sesi e, zoom f, level g, periode h, pendidikankursus i   
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idsesi = e.idsesi and a.idpendkursus = i.idpendkursus and a.status_archive = 1 order by a.groupwa;");
            foreach ($list->getResult() as $row) {
                // mencari jumlah siswa
                $jml_siswa = $this->model->getAllQR("select count(*) as jml from jadwal_siswa where idjadwal = '" . $row->idjadwal . "';")->jml;
                $val = array();
                $val[] = $no;
                $val[] = '<b>ROMBEL : </b>' . $row->groupwa . '<br><b>Tingkatan : </b>' . $row->level . '<br><b>Meeting ID : </b>' . $row->meeting_id . '<br><b>Mode : </b>' . $row->mode_belajar . '<br><b>Tempat : </b>' . $row->tempat . '<br><b>Jumlah Siswa : </b>' . $jml_siswa;
                $val[] = $row->nama_kursus . '<br>' . $row->tahun_ajar. '<br><br> <b>Term : </b><br>'. $row->nama_term.'<br><b> Start tanggal : </b>'.$row->tanggal_term;
                $val[] = $row->hari . '<br>' . $row->nama_sesi . ' (' . $row->waktu_awal . ' - ' . $row->waktu_akhir . ')';
                $val[] = '<div style="text-align:center; width:100%;">'
                        . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="raporsiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Rapor Siswa</button>'
                        . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="catatansiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Catatan Siswa</button>'
                        . '<button type="button" class="btn btn-block btn-sm btn-warning" onclick="unarchive(' . "'" . $row->idjadwal . "'" . ')">Un Archive</button>'
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

    public function ajax_add_jadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $kode = $this->model->autokode("J", "idjadwal", "jadwal", 2, 11);

            $cek_periode = $this->model->getAllQR("select count(*) as jml from periode where idperiode = '" . $this->request->getPost('periode') . "';")->jml;
            if ($cek_periode > 0) {

                // mencari tau detil dari periode tersebut
                $periode = $this->model->getAllQR("select nama_term, tanggal, bulan_awal, tahun_awal, jml_sesi from periode where idperiode = '" . $this->request->getPost('periode') . "';");

                // cek group WA  jangan sampai kembar
                $group_wa = $this->request->getPost('g_wa');
                $cek_group_wa = $this->model->getAllQR("select count(*) as jml from jadwal where groupwa = '" . $group_wa . "';")->jml;
                if ($cek_group_wa > 0) {
                    $status = "Gunakan nama group Whatsapp yang lain !!";
                } else {
                    $data = array(
                        'idjadwal' => $kode,
                        'groupwa' => $this->request->getPost('g_wa'),
                        'idsesi' => $this->request->getPost('idsesi'),
                        'idpendkursus' => $this->request->getPost('kursus'),
                        'idperiode' => $this->request->getPost('periode'),
                        'hari' => $this->request->getPost('hari'),
                        'idlevel' => $this->request->getPost('idlevel'),
                        'idzoom' => $this->request->getPost('idzoom'),
                        'mode_belajar' => $this->request->getPost('mode_belajar'),
                        'tempat' => $this->request->getPost('tempat')
                    );
                    $simpan = $this->model->add("jadwal", $data);
                    if ($simpan == 1) {
                        $color = "fc-event-info";
                        $kursus = $this->request->getPost('kursus');
                        if ($kursus == "English") {
                            $color = "fc-event-info";
                        } else if ($kursus === "Coding") {
                            $color = "fc-event-default";
                        }

                        // simpan untuk detilnya
                        $data_tgl = $this->setJadwalDetil(
                            $periode->tanggal,
                            $periode->bulan_awal,
                            $periode->tahun_awal,
                            $this->request->getPost('hari'),
                            $periode->jml_sesi
                        );

                        for ($i = 0; $i < count($data_tgl); $i++) {
                            $dataDetil = array(
                                'idjadwaldetil' => $this->model->autokode("D", "idjadwaldetil", "jadwal_detil", 2, 21),
                                'title' => $this->request->getPost('g_wa'),
                                'description' => '',
                                'url' => $this->request->getPost('zoom'),
                                'start' => $data_tgl[$i],
                                'end' => $data_tgl[$i],
                                'idjadwal' => $kode,
                                'color' => $color
                            );
                            $this->model->add("jadwal_detil", $dataDetil);
                        }

                        $mode_pindah = $this->request->getPost('mode_pindah');
                        if ($mode_pindah == "ya") {
                            $idjadwal_lama = $this->request->getPost('idjadwal_lama');
                            // masukkan guru dan siswa klo dia mode pindah kelas
                            $list_pengajar = $this->model->getAllQ("select idusers from jadwal_pengajar where idjadwal = '" . $idjadwal_lama . "';");
                            foreach ($list_pengajar->getResult() as $row_pengajar_lama) {
                                $data = array(
                                    'idpengajar' => $this->model->autokode("P", "idpengajar", "jadwal_pengajar", 2, 9),
                                    'idjadwal' => $kode,
                                    'idusers' => $row_pengajar_lama->idusers
                                );
                                $this->model->add("jadwal_pengajar", $data);
                            }

                            // masukkan siswa baru
                            $siswa = explode(",", $this->request->getPost('siswa'));
                            for ($i = 0; $i < count($siswa); $i++) {
                                $data = array(
                                    'idjadwal_siswa' => $this->model->autokode("P", "idjadwal_siswa", "jadwal_siswa", 2, 9),
                                    'idsiswa' => $siswa[$i],
                                    'idjadwal' => $kode
                                );
                                $this->model->add("jadwal_siswa", $data);
                            }

                            // syarat archive jika semua siswa lulus
                            $jml_siswa_jadwal_sebelum = $this->request->getPost('tot_siswa');
                            $jml_siswa_jadwal_sesudah = count($siswa);

                            if ($jml_siswa_jadwal_sebelum == $jml_siswa_jadwal_sesudah) {
                                // tutup dan archive kelas klo sdh tidak ditempati
                                $data_archive = array(
                                    'status_archive' => 1
                                );
                                $kond_archive['idjadwal'] = $idjadwal_lama;
                                $this->model->update("jadwal", $data_archive, $kond_archive);
                            }
                        }


                        $status = "Data tersimpan";
                    } else {
                        $status = "Data gagal tersimpan";
                    }
                }
            } else {
                $status = "Harap isi periode kursus terlebih dahulu";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_jadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $cek_periode = $this->model->getAllQR("select count(*) as jml from periode where idperiode = '" . $this->request->getPost('periode') . "';")->jml;
            if ($cek_periode > 0) {
                $abai = $this->request->getPost('abai');
                if ($abai == "Ya") {
                    $data = array(
                        'groupwa' => $this->request->getPost('g_wa'),
                        'idzoom' => $this->request->getPost('idzoom'),
                        'mode_belajar' => $this->request->getPost('mode_belajar'),
                        'tempat' => $this->request->getPost('tempat')
                    );
                    $kond['idjadwal'] = $this->request->getPost('kode');
                    $simpan = $this->model->update("jadwal", $data, $kond);
                    if ($simpan == 1) {
                        $status = "Data terupdate";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                } else {
                    $data = array(
                        'groupwa' => $this->request->getPost('g_wa'),
                        'idsesi' => $this->request->getPost('idsesi'),
                        'idpendkursus' => $this->request->getPost('kursus'),
                        'idperiode' => $this->request->getPost('periode'),
                        'hari' => $this->request->getPost('hari'),
                        'idlevel' => $this->request->getPost('idlevel'),
                        'idzoom' => $this->request->getPost('idzoom'),
                        'mode_belajar' => $this->request->getPost('mode_belajar'),
                        'tempat' => $this->request->getPost('tempat')
                    );
                    $kond['idjadwal'] = $this->request->getPost('kode');
                    $simpan = $this->model->update("jadwal", $data, $kond);
                    if ($simpan == 1) {

                        $color = "fc-event-info";
                        $kursus = $this->request->getPost('kursus');
                        if ($kursus == "English") {
                            $color = "fc-event-info";
                        } else if ($kursus === "Coding") {
                            $color = "fc-event-success";
                        }

                        // mencari tau detil dari periode tersebut
                        $periode = $this->model->getAllQR("select nama_term, tanggal, bulan_awal, tahun_awal, jml_sesi from periode where idperiode = '" . $this->request->getPost('periode') . "';");

                        // hapus sebelum disimpan
                        $kond['idjadwal'] = $this->request->getPost('kode');
                        $this->model->delete("jadwal_detil", $kond);

                        // simpan untuk detilnya
                        $data_tgl = $this->setJadwalDetil(
                            $periode->tanggal,
                            $periode->bulan_awal,
                            $periode->tahun_awal,
                            $this->request->getPost('hari'),
                            $periode->jml_sesi
                        );

                        for ($i = 0; $i < count($data_tgl); $i++) {
                            $dataDetil = array(
                                'idjadwaldetil' => $this->model->autokode("D", "idjadwaldetil", "jadwal_detil", 2, 21),
                                'title' => $this->request->getPost('g_wa'),
                                'description' => '',
                                'url' => $this->request->getPost('zoom'),
                                'start' => $data_tgl[$i],
                                'end' => $this->modul->TambahTanggal($data_tgl[$i], 1),
                                'idjadwal' => $this->request->getPost('kode'),
                                'color' => $color
                            );
                            $this->model->add("jadwal_detil", $dataDetil);
                        }

                        $status = "Data terupdate";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                }
            } else {
                $status = "Harap isi periode kursus terlebih dahulu";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapusjadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idjadwal'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("jadwal", $kond);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function getHariLibur()
    {
        $arr_libur = array();
        $libur1 = $this->model->getAllQ("select idlibur, title, start, DATE_ADD(end, INTERVAL -1 DAY) as kelar, DATEDIFF(end, start) as selisih from libur;");
        foreach ($libur1->getResult() as $rowlibur1) {
            $tgl_libur1 = $rowlibur1->start;
            $tgl_libur2 = $rowlibur1->kelar;

            // loop tanggal libur
            for ($i = 1; $i <= $rowlibur1->selisih; $i++) {
                array_push($arr_libur, $tgl_libur1); // masukkan ke dalam array
                $tgl_libur1 = $this->modul->TambahTanggal($tgl_libur1, 1);
            }
        }

        return $arr_libur;
    }

    private function setJadwalDetil($periode_tgl_awal, $periode_bulan_awal, $tahun, $patokanhari, $jml_sesi)
    {
        $putar = true;
        $counter = 1;

        if (strlen($periode_tgl_awal) == 1) {
            $periode_tgl_awal = "0" . $periode_tgl_awal;
        }

        // membaca hari libur pada database
        $data = array();
        $daftar = $tahun . "-" . $this->modul->convertBulanAngka($periode_bulan_awal) . '-' . $periode_tgl_awal;

        // hari libur
        $tempHariLibur = $this->getHariLibur();

        // potong ke dalam Array
        $hari_patokan = explode(",", $patokanhari);

        while ($putar) {

            $hari = $this->modul->namaHariTglTertentu($daftar);
            if (in_array($hari, $hari_patokan) && !in_array($daftar, $tempHariLibur)) {

                array_push($data, $daftar); // masukkan ke dalam array
                $tgl_plus = $this->modul->TambahTanggal($daftar, 1);
                $daftar = $tgl_plus;

                $counter++;
                if ($counter > $jml_sesi) {
                    $putar = false;
                }
            } else {
                $tgl_plus = $this->modul->TambahTanggal($daftar, 1);
                $daftar = $tgl_plus;

                $putar = true;
            }
        }

        return $data;
    }

    public function showperiode()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            $status = '';
            $list = $this->model->getAllQ("select idperiode, concat(nama_term, ' Tahun Ajaran : ', tahun_ajar, ', Start Kursus : ', tanggal, ' ', bulan_awal, ' ', tahun_awal) as nama_periode from periode where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {
                $status .= '<option value="' . $row->idperiode . '">' . $row->nama_periode . '</option>';
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function showperiode_edit()
    {
        if (session()->get("logged_pendidikan")) {
            $kursus = $this->request->getUri()->getSegment(3);
            $periode = $this->request->getUri()->getSegment(4);
            $status = '';
            $list = $this->model->getAllQ("select idperiode, concat(nama_term, ' Tahun Ajaran : ', tahun_ajar, ', Start Kursus : ', tanggal, ' ', bulan_awal, ' ', tahun_awal) as nama_periode from periode where idpendkursus = '" . $kursus . "';");
            foreach ($list->getResult() as $row) {
                if ($row->idperiode == $periode) {
                    $status .= '<option selected value="' . $row->idperiode . '">' . $row->nama_periode . '</option>';
                } else {
                    $status .= '<option value="' . $row->idperiode . '">' . $row->nama_periode . '</option>';
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxzoom()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array();
            $list = $this->model->getAllQ("select * from zoom");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = str_replace("\'", "'", $row->topic);
                $val[] = $row->meeting_id;
                $val[] = $row->passcode;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilihzoom(' . "'" . $row->idzoom . "'" . ',' . "'" . $row->link . "'" . ')"><i class="fas fa-check"></i></button>'
                    . '</div></div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlevel()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);

            $data = array();
            $list = $this->model->getAllQ("select * from level where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->level;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilihlevel(' . "'" . $row->idlevel . "'" . ',' . "'" . $row->level . "'" . ')"><i class="fas fa-check"></i></button>'
                    . '</div></div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function showjadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idpendkursus, f.idzoom, f.link, 
                g.idlevel, g.level, e.idsesi, e.waktu_awal, e.waktu_akhir, a.hari, a.idperiode, a.hari, a.tempat, a.mode_belajar  
                from jadwal a, sesi e, zoom f, level g 
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idsesi = e.idsesi and a.idjadwal = '" . $idjadwal . "';");
            echo json_encode(array(
                "idjadwal" => $data->idjadwal,
                "groupwa" => $data->groupwa,
                "kursus" => $data->idpendkursus,
                "id_sesi" => $data->idsesi,
                "periode" => $data->idperiode,
                "id_level" => $data->idlevel,
                "level" => $data->level,
                "hari" => $data->hari,
                "idzoom" => $data->idzoom,
                "link" => $data->link,
                "tempat" => $data->tempat,
                "mode_belajar" => $data->mode_belajar
            ));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxevent()
    {
        if (session()->get("logged_pendidikan")) {
            $eventsArr = array();
            $list = $this->model->getAllQ("SELECT idjadwaldetil, title, description,url, start, end, color FROM jadwal_detil;");
            foreach ($list->getResult() as $row) {
                array_push($eventsArr, $row);
            }
            echo json_encode($eventsArr);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ploting()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;


            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            if ($cek > 0) {
                $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idsesi, b.nama_sesi, b.waktu_awal, b.waktu_akhir, a.idpendkursus, f.nama_kursus, a.hari, a.idperiode, c.tahun_ajar, d.level, e.meeting_id 
                    from jadwal a, sesi b, periode c, level d, zoom e, pendidikankursus f  
                    where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idzoom = e.idzoom 
                    and a.idjadwal = '" . $idjadwal . "' and a.idpendkursus = f.idpendkursus;");
                $data['head'] = $head;


                echo view('back/head', $data);
                if (session()->get("logged_bos")) {
                    echo view('back/bos/menu');
                } else {
                    echo view('back/akademik/menu');
                }
                echo view('back/akademik/jadwal/ploting');
                echo view('back/foot');
            } else {
                $this->modul->halaman('jadwal');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxjadwalsiswa()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            // mencari ini level berapa
            $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idjadwal_siswa, a.idjadwaldetil, a.tgl_mulai, b.nama_lengkap, b.panggilan, b.idsiswa from jadwal_siswa a, siswa b 
                where a.idsiswa = b.idsiswa and a.idjadwal = '" . $idjadwal . "' and b.keluar = 0 and a.is_keluar = 0;");
            foreach ($list->getResult() as $row) {
                // cek apakah dia ada yang lebih tinggi levelnya
                $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml 
                from siswa a, jadwal_siswa b, jadwal c, level d
                where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                and a.idsiswa = '" . $row->idsiswa . "' and c.idlevel = d.idlevel and d.idpendkursus = '" . $datajadwal->idpendkursus . "' and d.tingkatan > '" . $datajadwal->tingkatan . "';")->jml;
                if ($cek_level_atasnya < 1) {
                    $val = array();
                    $val[] = $no;
                    $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                    // cek tanggal dia mulai les
                    // bisa saja dia start dari tengah
                    if (strlen($row->idjadwaldetil) > 0) {
                        $val[] = $row->tgl_mulai;
                    } else {
                        $val[] = $this->model->getAllQR("select date_format(b.start, '%d/%m/%Y') as tglmulai from jadwal a, jadwal_detil b where a.idjadwal = b.idjadwal and a.idjadwal = '" . $idjadwal . "' order by idjadwaldetil limit 1;")->tglmulai;
                    }

                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pindahkelas(' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->nama_lengkap . "'" . ')"><i class="feather icon-move"></i> Pindah Kelas</button>'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus_ploting_siswa(' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->nama_lengkap . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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

    public function ajaxjadwalpengajar()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            // load data
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idpengajar, b.nama from jadwal_pengajar a, users b where a.idusers = b.idusers and a.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus_ploting_pengajar(' . "'" . $row->idpengajar . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '</div></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_modal_siswa()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select *, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f from siswa where idsiswa not in(select idsiswa from jadwal_siswa where idjadwal = '".$idjadwal."');");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tgl_daftar_f;
                $val[] = $row->domisili;
                $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                $val[] = $row->jkel;
                $val[] = $row->nama_sekolah . ' (' . $row->level_sekolah . ')';
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilihsiswasementara(' . "'" . $row->idsiswa . "'" . ', ' . "'" . $row->nama_lengkap . "'" . ')"><i class="fas fa-check"></i></button>'
                    . '</div></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses_ploting_siswa()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idjadwal_siswa' => $this->model->autokode("P", "idjadwal_siswa", "jadwal_siswa", 2, 9),
                'idsiswa' => $this->request->getPost('idsiswa'),
                'idjadwal' => $this->request->getPost('idjadwal'),
                'idjadwaldetil' => $this->request->getPost('idjadwaldetil'),
                'tgl_mulai' => $this->request->getPost('tanggal')
            );
            $simpan = $this->model->add("jadwal_siswa", $data);
            if ($simpan == 1) {
                $status = "Data ploting siswa berhasil";
            } else {
                $status = "Data ploting siswa gagal";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_modal_pengajar()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            $data = array();
            $list = $this->model->getAllQ("select a.idusers, b.idkaryawan, a.nama, a.wa, a.foto from users a, karyawan b where a.idusers = b.idusers and a.status = 'Aktif' and a.idrole not in('R00004') and a.idusers not in(select idusers from jadwal_pengajar where idjadwal = '" . $idjadwal . "');");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama;
                $val[] = $row->wa;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilihguru(' . "'" . $row->idusers . "'" . ')"><i class="fas fa-check"></i></button>'
                    . '</div></div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses_ploting_pengajar()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idpengajar' => $this->model->autokode("P", "idpengajar", "jadwal_pengajar", 2, 9),
                'idjadwal' => $this->request->getUri()->getSegment(4),
                'idusers' => $this->request->getUri()->getSegment(3)
            );
            $simpan = $this->model->add("jadwal_pengajar", $data);
            if ($simpan == 1) {
                $status = "Data ploting pengajar berhasil";
            } else {
                $status = "Data ploting pengajar gagal";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus_ploting_siswa()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idjadwal_siswa'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("jadwal_siswa", $kond);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus_ploting_pengajar()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idpengajar'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("jadwal_pengajar", $kond);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_list_nomor()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            // load data
            $data = array();
            $list = $this->model->getAllQ("select b.idusers, b.nama, b.wa from jadwal_pengajar a, users b where a.idjadwal = '" . $idjadwal . "' and a.idusers = b.idusers;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->nama;
                $val[] = $row->wa;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function getlistnomor()
    {
        if (session()->get("logged_pendidikan")) {

            $result = array();

            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));

            // cek dia ada baris apa tidak
            $jml_cek = $this->model->getAllQR("select count(*) as jml from jadwal_pengajar a, users b where a.idjadwal = '" . $idjadwal . "' and a.idusers = b.idusers;")->jml;

            $list = $this->model->getAllQ("select b.idusers, b.nama, b.wa from jadwal_pengajar a, users b where a.idjadwal = '" . $idjadwal . "' and a.idusers = b.idusers;");
            foreach ($list->getResult() as $row) {
                $wa1 = str_replace("-", "", $row->wa);
                $wa2 = str_replace(" ", "", $wa1);
                $wa3 = trim($wa2);

                array_push($result, array(
                    'wa' => $wa3
                ));
            }

            echo json_encode(array("result" => json_encode($result), "jml" => $jml_cek));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function kirimpesan()
    {
        if (session()->get("logged_pendidikan")) {
            $nowa = $this->request->getPost('nowa');
            $pesan = $this->request->getPost('displayFormatJadwal');

            $hasil = $this->kirim_pesan_text($nowa, $pesan);
            echo $hasil;
        } else {
            $this->modul->halaman('login');
        }
    }

    public function displayformatjadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));

            $pesan = "";
            // membaca apa yang perlu di kirim
            $list = $this->model->getAllQ("select b.idjadwal, b.groupwa  from jadwal b, pendidikankursus d, level e, sesi f
                where b.idpendkursus = d.idpendkursus and b.idlevel = e.idlevel and b.idsesi = f.idsesi and b.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {
                $pesan .= "*" . $row->groupwa . "*\n";
                // menampilkan detilnya
                $list1 = $this->model->getAllQ("select date_format(c.start, '%d %M %Y') as tgl, concat(f.waktu_awal, ' - ', f.waktu_akhir) as waktu, d.nama_kursus, e.level, b.hari
                    from jadwal b, jadwal_detil c, pendidikankursus d, level e, sesi f
                    where b.idjadwal = c.idjadwal and b.idpendkursus = d.idpendkursus and b.idlevel = e.idlevel and b.idsesi = f.idsesi and b.idjadwal = '" . $idjadwal . "' and b.idjadwal = '" . $row->idjadwal . "';");
                foreach ($list1->getResult() as $row1) {
                    $pesan .= $row1->tgl . "\t" . $row1->waktu . "\t" . $row1->nama_kursus . "\t" . $row1->level . "\t" . $row1->hari . "\n";
                }
            }

            echo json_encode(array("displayFormatJadwal" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function uplevel()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);
            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $def_foto = base_url() . '/images/noimg.jpg';
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
                }
            }
            $data['foto_profile'] = $def_foto;


            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            if ($cek > 0) {
                $head = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idsesi, b.nama_sesi, b.waktu_awal, b.waktu_akhir, a.idpendkursus, f.nama_kursus, a.hari, a.idperiode, c.tahun_ajar, d.idlevel, d.level, e.meeting_id 
                    from jadwal a, sesi b, periode c, level d, zoom e, pendidikankursus f  
                    where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idzoom = e.idzoom 
                    and a.idjadwal = '" . $idjadwal . "' and a.idpendkursus = f.idpendkursus;");
                $data['head'] = $head;

                // menampilkan pengajar
                $str_pengajar = '';
                $pengajar = $this->model->getAllQ("select b.nama from jadwal_pengajar a, users b where a.idjadwal = '" . $idjadwal . "' and a.idusers = b.idusers;");
                foreach ($pengajar->getResult() as $rowpengajar) {
                    $str_pengajar .= $rowpengajar->nama . ', ';
                }
                $data['pengajar'] = substr($str_pengajar, 0, strlen($str_pengajar) - 2);

                $data['sesi'] = $this->model->getAll("sesi");

                $tot_siswa = 0;
                $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");
                $list = $this->model->getAllQ("select b.idsiswa, b.nama_lengkap, b.panggilan, b.jkel, b.nama_sekolah, b.nama_ortu from jadwal_siswa a, siswa b where a.idjadwal = '" . $idjadwal . "' and a.idsiswa = b.idsiswa;");
                foreach ($list->getResult() as $row) {
                    $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml  
                        from siswa a, jadwal_siswa b, jadwal c, level d
                        where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                        and a.idsiswa = '" . $row->idsiswa . "' and c.idlevel = d.idlevel and d.idpendkursus = '" . $datajadwal->idpendkursus . "' and d.tingkatan > '" . $datajadwal->tingkatan . "';")->jml;
                    if ($cek_level_atasnya < 1) {
                        $tot_siswa++;
                    }
                }
                $data['tot_siswa'] = $tot_siswa;

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/jadwal/uplevel');
                echo view('back/foot');
            } else {
                $this->modul->halaman('jadwal');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxsiswa()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            // mencari tau dia level apa
            $datajadwal = $this->model->getAllQR("select a.idlevel, b.tingkatan, a.idpendkursus from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select b.idsiswa, b.nama_lengkap, b.panggilan, b.jkel, b.nama_sekolah, b.nama_ortu from jadwal_siswa a, siswa b where a.idjadwal = '" . $idjadwal . "' and a.idsiswa = b.idsiswa;");
            foreach ($list->getResult() as $row) {

                $cek_level_atasnya = $this->model->getAllQR("select count(*) as jml 
                from siswa a, jadwal_siswa b, jadwal c, level d
                where a.idsiswa = b.idsiswa and b.idjadwal = c.idjadwal
                and a.idsiswa = '" . $row->idsiswa . "' and c.idlevel = d.idlevel and d.idpendkursus = '" . $datajadwal->idpendkursus . "' and d.tingkatan > '" . $datajadwal->tingkatan . "';")->jml;
                if ($cek_level_atasnya < 1) {
                    $val = array();
                    $val[] = $no;
                    $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                    $val[] = $row->jkel;
                    $val[] = $row->nama_sekolah;
                    $val[] = $row->nama_ortu;
                    $val[] = '<div style="text-align:center; width:100%;"><input type="checkbox" id="' . $row->idsiswa . '" name="siswa[]" value="' . $row->idsiswa . '"></div>';
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

    public function ajax_naik_level()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            $idlevel = $this->request->getUri()->getSegment(4);
            // index level
            $index_level = $this->model->getAllQR("select tingkatan from level where idlevel = '" . $idlevel . "';")->tingkatan;

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT idlevel, level FROM level where idpendkursus = '" . $idpendkursus . "' and tingkatan > '" . $index_level . "' order by tingkatan;");
            foreach ($list->getResult() as $row) {
                if ($no == 1) {
                    $val = array();
                    $val[] = '<b style="color:green;">' . $no . '</b>';
                    $val[] = '<b style="color:green;">' . $row->level . '</b>';
                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-success" onclick="pilihlevel(' . "'" . $row->idlevel . "'" . ',' . "'" . $row->level . "'" . ')">Pilih Rekomendasi</button>'
                        . '</div></div>';
                    $data[] = $val;
                } else {
                    $val = array();
                    $val[] = $no;
                    $val[] = $row->level;
                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-info" onclick="pilihlevel(' . "'" . $row->idlevel . "'" . ',' . "'" . $row->level . "'" . ')">Pilih</button>'
                        . '</div></div>';
                    $data[] = $val;
                }


                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function unarchive()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'status_archive' => 0
            );
            $kond['idjadwal'] = $this->request->getUri()->getSegment(3);
            $simpan = $this->model->update("jadwal", $data, $kond);
            if ($simpan == 1) {
                $status = "Unarchive berhasil";
            } else {
                $status = "Unarchive gagal";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function archivekan()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'status_archive' => 1
            );
            $kond['idjadwal'] = $this->request->getUri()->getSegment(3);
            $simpan = $this->model->update("jadwal", $data, $kond);
            if ($simpan == 1) {
                $status = "Archive berhasil";
            } else {
                $status = "Archive gagal";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_pindah_jadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal_siswa = $this->request->getUri()->getSegment(3);
            // mencari tau dia level apa
            $datajadwal = $this->model->getAllQR("select a.idjadwal, b.groupwa, b.idsesi, b.idpendkursus, b.idlevel from jadwal_siswa a, jadwal b where a.idjadwal_siswa = '" . $idjadwal_siswa . "' and a.idjadwal = b.idjadwal and b.status_archive = 0;");

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.*, b.nama_sesi, b.waktu_awal, b.waktu_akhir, c.nama_term from jadwal a, sesi b, periode c  
                where a.idsesi = b.idsesi and a.idpendkursus = '" . $datajadwal->idpendkursus . "' and a.idperiode = c.idperiode 
                and a.idlevel = '" . $datajadwal->idlevel . "' and a.idjadwal <> '" . $datajadwal->idjadwal . "' and a.status_archive = 0;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->groupwa;
                $val[] = $row->nama_sesi . ' ' . $row->waktu_awal . ' ' . $row->waktu_akhir;
                $val[] = $row->nama_term;
                $val[] = $row->mode_belajar . '<br>' . $row->tempat;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info" onclick="pilihjadwallain(' . "'" . $row->idjadwal . "'" . ')">Pilih</button>'
                    . '</div></div>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses_pindah_kelas()
    {
        if (session()->get("logged_pendidikan")) {
            // P0000519 - J000000072
            // bersumber dari jadwal siswa
            $idjadwal_siswa_asal = $this->request->getUri()->getSegment(3);
            // mencari idjadwal asal
            $jadwal_asal = $this->model->getAllQR("SELECT idjadwal, idsiswa FROM jadwal_siswa where idjadwal_siswa = '" . $idjadwal_siswa_asal . "';");
            // jadwal tujuan
            $idjadwal_tujuan = $this->request->getUri()->getSegment(4);

            $data = array(
                'idjadwal' => $idjadwal_tujuan
            );
            $kond['idjadwal_siswa'] = $idjadwal_siswa_asal;
            $simpan = $this->model->update("jadwal_siswa", $data, $kond);
            // $simpan = 1;
            if ($simpan == 1) {
                $nb = 1;
                $data_presensi_lama = array();
                $data_urutan = array();
                $data_catatan = array();
                
                $jml_meet = $this->model->getAllQR("SELECT count(*) as jml FROM catatan_kelas c where idjadwal = '". $jadwal_asal->idjadwal ."'")->jml;
                
                $jadwal_lama = $this->model->getAllQ("select ROW_NUMBER() OVER (ORDER BY idjadwaldetil) AS count_number, idjadwaldetil from jadwal_detil where idjadwal = '" . $jadwal_asal->idjadwal . "' limit " . $jml_meet);
                foreach ($jadwal_lama->getResult() as $rows) {
                    $cekabsen = $this->model->getAllQR("Select count(*) as jml , waktu from presensi_siswa where idjadwaldetil = '".$rows->idjadwaldetil."' and idsiswa = '".$jadwal_asal->idsiswa."'");
                    if($cekabsen->jml > 0){
                        $data_presensi_lama[$nb] = $cekabsen->waktu;
                        $data_urutan[$nb] = $rows->count_number;
                    }else{
                        $data_presensi_lama[$nb] = "";
                        $data_urutan[$nb] = "";
                    }
                    $list_catatan_lama = $this->model->getAllQR("SELECT count(*) as jml, catatan FROM catatan_siswa where idjadwaldetil = '".$rows->idjadwaldetil."' and idsiswa = '" . $jadwal_asal->idsiswa . "';");
                    if($list_catatan_lama->jml > 0){
                        $data_catatan[$nb] = $list_catatan_lama->catatan;
                    }else{
                        $data_catatan[$nb] = "";
                    }
                    $nb++;
                }

                $counter1 = 1;
                $list_jadwal_detil = $this->model->getAllQ("select ROW_NUMBER() OVER (ORDER BY idjadwaldetil) AS count_number, idjadwaldetil from jadwal_detil where idjadwal = '" . $idjadwal_tujuan . "' limit " . $jml_meet);
                foreach ($list_jadwal_detil->getResult() as $row) {
                    if($data_urutan[$counter1] == $row->count_number){
                        $cek = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '" . $jadwal_asal->idsiswa . "' and idjadwaldetil = '" . $row->idjadwaldetil . "';")->jml;
                        if ($cek < 1) {
                            $data = array(
                                'idpresensi_siswa' => date("YmdHis", strtotime($this->modul->getCurTime() . ' +' . $counter1 . ' seconds')) . $jadwal_asal->idsiswa,
                                'idjadwaldetil' => $row->idjadwaldetil,
                                'idsiswa' => $jadwal_asal->idsiswa,
                                'waktu' => $data_presensi_lama[$counter1],
                                'idjadwal' => $idjadwal_tujuan
                            );
                            $this->model->add("presensi_siswa", $data);
                        }
                        $jml_catatan = $this->model->getAllQR("select count(*) as jml from catatan_siswa where idsiswa = '" . $jadwal_asal->idsiswa . "' and idjadwaldetil = '" . $row->idjadwaldetil . "';")->jml; 
                        if($jml_catatan < 1 && $data_catatan[$counter1] !== "") {
                            $datap = array(
                                'idcatatan_siswa' => $this->model->autokode("C", "idcatatan_siswa", "catatan_siswa", 2, 11),
                                'idjadwaldetil' => $row->idjadwaldetil,
                                'idsiswa' => $jadwal_asal->idsiswa,
                                'catatan' => $data_catatan[$counter1],
                                'idjadwal' => $idjadwal_tujuan
                            );
                            $this->model->add("catatan_siswa", $datap);
                        }
                    }
                    $counter1++;
                }

                $status = "Jadwal berhasil dipindahkan";

            } else {
                $status = "Jadwal gagal dipindahkan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_tanggal_mulai()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select idjadwaldetil, date_format(start, '%d/%m/%Y') as tglmulai from jadwal_detil where idjadwal = '".$idjadwal."';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tglmulai;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info" onclick="pilihtanggalmulai(' . "'" . $row->idjadwaldetil . "'" . ',' . "'" . $row->tglmulai . "'" . ')">Pilih</button>'
                    . '</div></div>';
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
            'device_id' => $this->modul->deviceid1(),
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

    private function kirim_pesan_gambar($tlp, $pesan, $pathfile)
    {
        $url = 'https://app.whacenter.com/api/send';
        $ch = curl_init($url);

        $data = array(
            'device_id' => $this->modul->deviceid1(),
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
}
