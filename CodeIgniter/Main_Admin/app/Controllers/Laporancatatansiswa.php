<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporancatatansiswa extends BaseController
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
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else{
            echo view('back/akademik/menu');
            }
            echo view('back/akademik/laporan_catatan_siswa/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pendidikan")) {
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select distinct a.idsiswa, b.nama_lengkap, b.panggilan, date_format(b.tgl_lahir, '%d %M %Y') as tgllahir, b.nama_sekolah from catatan_siswa a, siswa b where a.idsiswa = b.idsiswa and b.keluar = 0;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $str = '<b>Nama Lengkap </b> : ' . $row->nama_lengkap . ' (' . $row->panggilan . ')';
                $str .= '<br><b>Tanggal Lahir </b> : ' . $row->tgllahir;
                $str .= '<br><b>Nama Sekolah </b> : ' . $row->nama_sekolah;
                $str .= '<br><b> Kelas : </b><br>';
                // menampilkan daftar kelas yang ada anak itu
                $str .= '<table>';
                $str .= '<thead><tr><th>Rombel</th><th>Level</th><th>Mode</th><th>Tempat</th><th style="text-align:center">Catatan</th></tr></thead>';
                $str .= '<tbody>';
                $list1 = $this->model->getAllQ("select b.idjadwal, b.groupwa, c.level, b.mode_belajar, b.tempat from catatan_siswa a, jadwal b, level c
                where a.idsiswa = '" . $row->idsiswa . "' and a.idjadwal = b.idjadwal and b.status_archive = 0 and b.idlevel = c.idlevel;");
                foreach ($list1->getResult() as $row1) {
                    $str .= '<tr>';
                    $str .= '<td>' . $row1->groupwa . '</td>';
                    $str .= '<td>' . $row1->level . '</td>';
                    $str .= '<td>' . $row1->mode_belajar . '</td>';
                    $str .= '<td>' . $row1->tempat . '</td>';
                    // menampilkan catatan anak tersebut
                    $str .= '<td>';
                    $str .= '<table>';
                    $str .= '<thead><tr><th>Tanggal</th><th>Catanan</th><th>ADMIN</th><th>Tgl Follow</th><th>Kesimpulan</th><th>Status</th><th>Aksi</th></tr></thead>';
                    $str .= '<tbody>';
                    $list2 = $this->model->getAllQ("select b.idjadwaldetil, a.idcatatan_siswa, date_format(b.start, '%d %M %Y') as tgl, a.catatan, c.idusers, d.nama as namaadmin, date_format(c.tanggal, '%d %M %Y') as tglFollow, c.kesimpulan, c.status_follow
                    from catatan_siswa a
                    join jadwal_detil b on a.idjadwaldetil = b.idjadwaldetil
                    left join catatan_siswa_follow_up c on a.idcatatan_siswa = c.idcatatan_siswa
                    left join users d on c.idusers = d.idusers
                    where a.idjadwal = '" . $row1->idjadwal . "' and a.idsiswa = '" . $row->idsiswa . "';");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<tr>';
                        $str .= '<td>' . $row2->tgl . '</td>';
                        $str .= '<td>' . $row2->catatan . '</td>';
                        $str .= '<td>' . $row2->namaadmin . '</td>';
                        $str .= '<td>' . $row2->tglFollow . '</td>';
                        $str .= '<td>' . $row2->kesimpulan . '</td>';
                        $str .= '<td>' . $row2->status_follow . '</td>';
                        $str .= '<td><div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-block btn-sm btn-info btn-fw" onclick="followUp(' . "'" . $row2->idjadwaldetil . "'" . ',' . "'" . $row->idsiswa . "'" . ')">Komentar</button>'
                            . '</div></div></td>';

                        $str .= '</tr>';
                    }
                    $str .= '</tbody>';
                    $str .= '</table>';
                    $str .= '</td>';
                    $str .= '</tr>';
                }
                $str .= '</tbody>';
                $str .= '</table>';
                $val[] = $str;

                $data[] = $val;
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist1()
    {
        if (session()->get("logged_pendidikan")) {
            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal 
            ,b.*, d.*
            from siswa a, jadwal b, jadwal_siswa c, level d, jadwal_pengajar e 
            where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and b.idlevel = d.idlevel and b.idjadwal = e.idjadwal and b.status_archive = 0;");
            foreach ($list->getResult() as $row) {
                $jml = $this->model->getAllQR("SELECT count(*) as jml
                    FROM jadwal_detil a
                    inner join catatan_siswa b on a.idjadwaldetil = b.idjadwaldetil
                    left join catatan_siswa_follow_up c  on b.idcatatan_siswa = c.idcatatan_siswa
                    left join users d on c.idusers = d.idusers
                    where b.idsiswa = '" . $row->idsiswa . "';")->jml;
                $val = array();
                if ($jml > 0) {
                    $val[] = $no;
                    $str = '<b>Nama Lengkap </b> : ' . $row->nama_lengkap . ' (' . $row->panggilan . ')';
                    $str .= '<br><b>Tanggal Lahir </b> : ' . $row->tgllahir;
                    $str .= '<br><b>Nama Sekolah </b> : ' . $row->nama_sekolah;
                    $str .= '<br><b> Catatan Siswa : </b><br>';
                    $str .= '<table class="table-responsive" style="width: 100%;">';
                    $str .= '<tbody>';
                    $str .= '<thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="5%">Tanggal</th>
                                    <th width="35%">Catatan Pengajar</th>
                                    <th width="10%">Admin</th>
                                    <th width="10%">Tgl FU</th>
                                    <th width="20%">Kesimpulan</th>
                                    <th width="10%">Status</th>
                                    <th style="text-align:center;" width="5%">Aksi</th>
                                </tr>
                            </thead>';
                    $list2 = $this->model->getAllQ("SELECT a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, b.catatan, c.idusers, d.nama, date_format(c.tanggal, '%d %M %Y') as tglFollow, c.kesimpulan, c.status_follow 
                    FROM jadwal_detil a 
                    inner join catatan_siswa b on a.idjadwaldetil = b.idjadwaldetil 
                    left join catatan_siswa_follow_up c  on b.idcatatan_siswa = c.idcatatan_siswa 
                    left join users d on c.idusers = d.idusers 
                    where b.idsiswa = '" . $row->idsiswa . "' and b.idjadwal = '" . $row->idjadwal . "';");
                    $noo = 1;
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<tr>';
                        $str .= '<td>' . $noo . '</td>';
                        $str .= '<td>' . $row2->tglf . '</td>';
                        $str .= '<td>' . $row2->catatan . '</td>';
                        $str .= '<td>' . $row2->nama . '</td>';
                        $str .= '<td>' . $row2->tglFollow . '</td>';
                        $str .= '<td>' . $row2->kesimpulan . '</td>';
                        $str .= '<td>' . $row2->status_follow . '</td>';
                        $str .= '<td>' . '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-block btn-sm btn-info btn-fw" onclick="followUp(' . "'" . $row2->idjadwaldetil . "'" . ',' . "'" . $row->idsiswa . "'" . ')">Komentar</button>'
                            . '</div></div>';
                        $str .= '</td>';

                        $str .= '</tr>';
                        $noo++;
                    }
                    $val[] = $str;
                    $val[] = '<b>Rombel : </b>' . $row->groupwa . '<br><b>Level : </b>' . $row->level . '<br><b>Mode : </b>' . $row->mode_belajar . '<br><b>Tempat : </b>' . $row->tempat;

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

    public function catatansiswa()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
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
                f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and a.idjadwal = '" . $idjadwal . "';");

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/laporan_pengajaran/catatan_siswa');
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
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            // menampilkan hanya yang di ajar saja

            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function showfollowup()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwaldetil = $this->request->getUri()->getSegment(3);
            $idsiswa = $this->request->getUri()->getSegment(4);
            // membaca follow up jika ada
            $idcs_follow_up = "";
            $kesimpulan = "";
            $status_follow = "";

            $cek_idcacatan = $this->model->getAllQR("select count(*) as jml from catatan_siswa where idjadwaldetil = '" . $idjadwaldetil . "' and idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek_idcacatan > 0) {
                $idcacatan = $this->model->getAllQR("select idcatatan_siswa from catatan_siswa where idjadwaldetil = '" . $idjadwaldetil . "' and idsiswa = '" . $idsiswa . "';")->idcatatan_siswa;

                $cek_baca = $this->model->getAllQR("SELECT count(*) as jml FROM catatan_siswa_follow_up where idcatatan_siswa = '" . $idcacatan . "';")->jml;
                if ($cek_baca > 0) {
                    $baca = $this->model->getAllQR("SELECT idcs_follow_up, kesimpulan, status_follow FROM catatan_siswa_follow_up where idcatatan_siswa = '" . $idcacatan . "';");
                    $idcs_follow_up = $baca->idcs_follow_up;
                    $kesimpulan = $baca->kesimpulan;
                    $status_follow = $baca->status_follow;
                } else {
                    $idcs_follow_up = "";
                    $kesimpulan = "";
                    $status_follow = "";
                }
            }

            echo json_encode(array("idsiswa" => $idsiswa, "idcs_follow_up" => $idcs_follow_up, "kesimpulan" => $kesimpulan, "status_follow" => $status_follow));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function prosesfollow()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwaldetil = $this->request->getPost('idjadwaldetil');
            $idsiswa = $this->request->getPost('idsiswa');
            // cek dulu klo belum ada laporan gak bisa di follow up
            $cek_catatan_guru = $this->model->getAllQR("SELECT count(*) as jml FROM catatan_siswa where idjadwaldetil = '" . $idjadwaldetil . "' and idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek_catatan_guru > 0) {
                // mencari catatan siswa
                $idcacatan = $this->model->getAllQR("select idcatatan_siswa from catatan_siswa where idjadwaldetil = '" . $idjadwaldetil . "' and idsiswa = '" . $idsiswa . "';")->idcatatan_siswa;

                $cek = $this->model->getAllQR("SELECT count(*) as jml FROM catatan_siswa_follow_up where idcatatan_siswa = '" . $idcacatan . "';")->jml;
                if ($cek > 0) {
                    $status = $this->update_follow($idcacatan);
                } else {
                    $status = $this->simpan_follow($idcacatan);
                }
            } else {
                $status = "Belum ada catatan dari pengajar / guru";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function simpan_follow($idcatatan_siswa)
    {
        $idusers = session()->get("idusers");
        $kesimpulan = $this->request->getPost('kesimpulan');
        $status = $this->request->getPost('status');

        $data = array(
            'idcs_follow_up' => $this->model->autokode("F", "idcs_follow_up", "catatan_siswa_follow_up", 2, 7),
            'idcatatan_siswa' => $idcatatan_siswa,
            'tanggal' => $this->modul->TanggalSekarang(),
            'idusers' => $idusers,
            'kesimpulan' => $kesimpulan,
            'status_follow' => $status
        );
        $simpan = $this->model->add("catatan_siswa_follow_up", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    private function update_follow($idcatatan_siswa)
    {
        $idusers = session()->get("idusers");
        $kesimpulan = $this->request->getPost('kesimpulan');
        $status = $this->request->getPost('status');

        $data = array(
            'idcatatan_siswa' => $idcatatan_siswa,
            'tanggal' => $this->modul->TanggalSekarang(),
            'idusers' => $idusers,
            'kesimpulan' => $kesimpulan,
            'status_follow' => $status
        );
        $kond['idcatatan_siswa'] = $idcatatan_siswa;
        $simpan = $this->model->update("catatan_siswa_follow_up", $data, $kond);
        if ($simpan == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    public function ajaxcatatankelas()
    {
        if (session()->get("logged_pendidikan")) {
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
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="komentar(' . "'" . $row->idcatatan_kelas . "'" . ')">Komentar</button>'
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

    public function showcatatankelas()
    {
        if (session()->get("logged_pendidikan")) {
            $idcatatan_kelas = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("SELECT * FROM catatan_kelas where idcatatan_kelas = '" . $idcatatan_kelas . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proseskomentarcatatan()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'materi_diskusi' => $this->request->getPost('materi_diskusi'),
                'tglcek' => $this->modul->TanggalSekarang(),
                'hasil_konfirm' => $this->request->getPost('hasil_konfirmasi')
            );
            $kond['idcatatan_kelas'] = $this->request->getPost('kode');
            $simpan = $this->model->update("catatan_kelas", $data, $kond);
            if ($simpan == 1) {
                $status = "Catatan kelas tersimpan";
            } else {
                $status = "Catatan kelas gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function raporsiswa()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
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
                f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel and a.idjadwal = '" . $idjadwal . "';");

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/laporan_pengajaran/rapor_siswa');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxraporsiswa()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal 
            from siswa a, jadwal b, jadwal_siswa c, level d, jadwal_pengajar e 
            where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and b.idlevel = d.idlevel and b.idjadwal = e.idjadwal and b.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                $val[] = $row->tgllahir;
                $val[] = $row->nama_sekolah;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="cetakrapor(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ',' . "'" . $this->modul->enkrip_url($row->idsiswa) . "'" . ')">Cetak Rapor</button>'
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

    public function cetak()
    {
        if (session()->get("logged_pendidikan")) {
            date_default_timezone_set("Asia/Jakarta");

            $data['background'] = "images/background.png";
            $data['logo'] = "images/logoreport.png";

            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $idsiswa = $this->modul->dekrip_url($this->request->getUri()->getSegment(4));

            // cek
            $cek1 = $this->model->getAllQR("select count(*) as jml from jadwal where idjadwal = '" . $idjadwal . "';")->jml;
            $cek2 = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;

            if ($cek1 > 0 && $cek2 > 0) {

                // mendapatkan data jadwal
                $jadwal = $this->model->getAllQR("select a.*, b.nama_term, b.tahun_ajar, c.level from jadwal a, periode b, level c where a.idperiode = b.idperiode and a.idlevel = c.idlevel and a.idjadwal = '" . $idjadwal . "';");
                $data['jadwal'] = $jadwal;
                // mencari data pengajar
                $pengajar = $this->model->getAllQR("select nama from jadwal a, jadwal_pengajar b, users c where a.idjadwal = b.idjadwal and b.idusers = c.idusers and a.idjadwal = '" . $idjadwal . "';");
                // mencari data siswa
                $siswa = $this->model->getAllQR("SELECT idsiswa, concat(nama_lengkap, ' (', panggilan, ')') as nama FROM siswa where idsiswa = '" . $idsiswa . "';");

                $data['pengajar'] = $pengajar;
                $data['siswa'] = $siswa;

                $options = new Options();
                $options->setChroot(FCPATH);
                $options->setDefaultFont('courier');

                // 1 .mengetahui dia kursus apa
                // 2 .mengetahui dia level apa
                // 3 .hitung rumusnya
                $kursus_level = $this->model->getAllQR("select a.idpendkursus, a.idlevel, a.idperiode, b.level from jadwal a, level b where a.idjadwal = '" . $idjadwal . "' and a.idlevel = b.idlevel;");

                $data['curDate'] = date("d-m-Y");
                $data['presensi'] = $this->model->getAllQR("SELECT count(*) as jml FROM presensi_siswa where idsiswa = '" . $idsiswa . "' and idjadwal = '" . $idjadwal . "';")->jml;
                $data['total_kursus'] = $this->model->getAllQR("select jml_sesi from periode where idperiode = '" . $kursus_level->idperiode . "';")->jml_sesi;

                if ($kursus_level->idpendkursus == "K00001") { // english mode
                    $cek_nilai = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "';")->jml;
                    if ($cek_nilai > 0) {

                        // jika level SO BALLONS WINNER GOGO
                        if ($this->mengandung(strtolower($kursus_level->level), "so") || $this->mengandung(strtolower($kursus_level->level), "ball") || $this->mengandung(strtolower($kursus_level->level), "winner") || $this->mengandung(strtolower($kursus_level->level), "gogo")) {

                            $data['class_participation'] = "";
                            $cek1 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Class participation';")->jml;
                            if ($cek1 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Class participation';")->nilai;
                                $data['class_participation'] = $nilai;
                            }

                            $data['oral'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Oral';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Oral';")->nilai;
                                $data['oral'] = $nilai;
                            }

                            $data['listening'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Listening';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Listening';")->nilai;
                                $data['listening'] = $nilai;
                            }

                            $data['writing'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Writing';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Writing';")->nilai;
                                $data['writing'] = $nilai;
                            }

                            $data['writing_and_reading'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Writing And Reading';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Writing And Reading';")->nilai;
                                $data['writing_and_reading'] = $nilai;
                            }

                            $data['ec'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'English Conversation';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'English Conversation';")->nilai;
                                $data['ec'] = $nilai;
                            }

                            $data['comment'] = "";
                            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Comment';")->jml;
                            if ($cek2 > 0) {
                                $nilai = $this->model->getAllQR("SELECT a.nilai FROM rapor a, parameter_nilai b where a.idp_nilai = b.idp_nilai and a.idjadwal = '" . $jadwal->idjadwal . "' and a.idsiswa = '" . $siswa->idsiswa . "' and b.parameter = 'Comment';")->nilai;
                                $data['comment'] = $nilai;
                            }

                            $dompdf = new Dompdf();
                            $dompdf->setOptions($options);
                            $dompdf->loadHtml(view('back/pengajar/laporan_siswa/pdf', $data));
                            $dompdf->setPaper('A4', 'landscape');
                            $dompdf->render();
                            $filename = 'RAPOR_SISWA.pdf';
                            $dompdf->stream($filename); // download
                            //$dompdf->stream($filename, array("Attachment" => 0)); // nempel

                        } else {
                            $this->modul->pesan_halaman('Format rapor belum ada', 'laporansiswapengajar');
                        }
                    } else {
                        $this->modul->halaman('laporanpengajaran');
                    }
                } else if ($kursus_level->idpendkursus == "K00002") { // Coding mode
                    $cek_nilai = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "';")->jml;
                    if ($cek_nilai > 0) {
                        $this->modul->pesan_halaman('Format rapor belum ada', 'laporansiswapengajar');
                    } else {
                        $this->modul->halaman('laporanpengajaran');
                    }
                } else {
                    $cek_nilai = $this->model->getAllQR("SELECT count(*) as jml FROM rapor where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "';")->jml;
                    if ($cek_nilai > 0) {
                        $this->modul->pesan_halaman('Format rapor belum ada', 'laporansiswapengajar');
                    } else {
                        $this->modul->halaman('laporanpengajaran');
                    }
                }
            } else {
                $this->modul->halaman('laporanpengajaran');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    private function mengandung($str, $potongan)
    {
        $status = false;
        if (str_contains($str, $potongan)) {
            $status = true;
        }
        return $status;
    }
}
