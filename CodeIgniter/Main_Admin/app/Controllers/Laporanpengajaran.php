<?php

namespace App\Controllers;

/**
 * Description of Laporanpengajaran
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporanpengajaran extends BaseController
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

            $data['tags'] = $this->model->getAll("tag_materi_diskusi");

            echo view('back/head', $data);
            if (session()->get("logged_bos")) {
                echo view('back/bos/menu');
            } else {
                echo view('back/akademik/menu');
            }
            echo view('back/akademik/laporan_pengajaran/index');
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
            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, concat(date_format(c.waktu_awal,'%H:%i'), ' - ', date_format(c.waktu_akhir,'%H:%i')) as waktu, 
                f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus and a.status_archive = 0 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel group by a.idjadwal;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $jml = $this->model->getAllQR("select count(*) as jml FROM jadwal_detil a, catatan_kelas b where a.idjadwaldetil = b.idjadwaldetil and a.idjadwal = '" . $row->idjadwal . "';")->jml;
                $str = '<b>ROMBEL : </b>' . $row->groupwa .
                    '<br><b>Kursus / Tingkatan : </b>' . $row->kursus . ' / ' . $row->level . '<br><b>Tempat : </b>' . $row->tempat . ' (' . $row->mode_belajar . ')';
                if ($jml > 0) {
                    $str .= '<br><b> Catatan Kelas : </b><br>';
                    $str .= '<table class="table-responsive" style="width: 100%;">';
                    $str .= '<tbody>';
                    $str .= '<thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="40%">Catatan</th>
                                <th>Konfirmasi</th>
                            </tr>
                        </thead>';
                    $list2 = $this->model->getAllQ("SELECT b.idcatatan_kelas, a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, catatan, materi_diskusi, date_format(tglcek, '%d %M %Y') as tglcek, hasil_konfirm  
                    FROM jadwal_detil a, catatan_kelas b where a.idjadwaldetil = b.idjadwaldetil and a.idjadwal = '" . $row->idjadwal . "' order by a.start desc;");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<tr>';
                        $str .= '<td>' . $row2->tglf . '</td>';
                        $str .= '<td>' . $row2->catatan . '</td>';
                        $str .= '<td>' . '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="komentar(' . "'" . $row2->idcatatan_kelas . "'" . ')">Komentar</button>'
                            . '</div></div>';
                        $jml = $this->model->getAllQR("select count(*) as jml from catatan_kelas_tag where idcatatan_kelas = '" . $row2->idcatatan_kelas . "'")->jml;
                        if ($jml > 0) {
                            $str .= '<b>Tag Materi Diskusi :</b><br>';
                            $tags = $this->model->getAllQ("SELECT tag FROM catatan_kelas_tag c, tag_materi_diskusi t where c.idtagmd = t.idtagmd and idcatatan_kelas = '" . $row2->idcatatan_kelas . "'");
                            foreach ($tags->getResult() as $row3) {
                                $str .= $row3->tag . '</br>';
                            }
                            $str .= '</br>';
                        }
                        if ($row2->materi_diskusi != '') {
                            $str .= '<b>Materi Diskusi : </b><br>' . $row2->materi_diskusi;
                            $str .= '<br><br><b>Tgl Cek : </b><br>' . $row2->tglcek;
                            $str .= '<br><br><b>Hasil Konfirmasi : </b><br>' . $row2->hasil_konfirm;
                        }
                        $str .= '</td>';

                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                }
                $val[] = $str;
                $cat = '<b>Hari Waktu </b> : <br>' . $row->hari . '<br>' . $row->waktu;
                $cat .= '<br><br><b>Tahun Ajar </b> : <br>' . $row->tahun_ajar;
                // menampilkan jadwal pengajar
                $nama_pengajar = '';
                $pengajar = $this->model->getAllQ("SELECT a.idusers, b.nama FROM jadwal_pengajar a, users b where a.idjadwal = '" . $row->idjadwal . "' and a.idusers = b.idusers;");
                foreach ($pengajar->getResult() as $row1) {
                    $nama_pengajar .= $row1->nama . ',';
                }
                $cat .= '<br><br><b>Nama Pengajar : </b><br>' . substr($nama_pengajar, 0, strlen($nama_pengajar) - 1);
                $val[] = $cat;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="raporsiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Rapor Siswa</button>'
                    . '<br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="catatansiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Catatan Siswa</button>'
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
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal 
            from siswa a, jadwal b, jadwal_siswa c, level d, jadwal_pengajar e 
            where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and c.is_keluar = 0 and a.keluar = 0 and b.idlevel = d.idlevel and b.idjadwal = e.idjadwal and b.idjadwal = '" . $idjadwal . "'  group by b.idjadwal;");
            foreach ($list->getResult() as $row) {
                $jml = $this->model->getAllQR("SELECT count(*) as jml
                    FROM jadwal_detil a
                    inner join catatan_siswa b on a.idjadwaldetil = b.idjadwaldetil
                    left join catatan_siswa_follow_up c  on b.idcatatan_siswa = c.idcatatan_siswa
                    left join users d on c.idusers = d.idusers
                    where b.idsiswa = '" . $row->idsiswa . "' and b.idjadwal = '" . $row->idjadwal . "';")->jml;
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

            $idsiswa = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $idjadwal = $this->modul->dekrip_url($this->request->getUri()->getSegment(4));
            $data['idjadwalenkrip'] = $this->modul->enkrip_url($idjadwal);
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
                echo view('back/akademik/menu');
                echo view('back/akademik/laporan_pengajaran/catatan_siswa_detil');
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
        if (session()->get("logged_pendidikan")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwal = $this->request->getUri()->getSegment(4);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, b.catatan, c.idusers, d.nama, date_format(c.tanggal, '%d %M %Y') as tglFollow, c.kesimpulan, c.status_follow 
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
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-block btn-sm btn-info btn-fw" onclick="followUp(' . "'" . $row->idjadwaldetil . "'" . ')">Komentar</button>'
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
            $data_tag = array();
            $tag = $this->model->getAllQ("select idtagmd from catatan_kelas_tag where idcatatan_kelas = '" . $idcatatan_kelas . "'");
            foreach ($tag->getResult() as $row) {
                array_push($data_tag, $row->idtagmd);
            }
            echo json_encode(array(
                "idcatatan_kelas" => $data->idcatatan_kelas,
                "catatan" => $data->catatan,
                "materi_diskusi" => $data->materi_diskusi,
                "hasil_konfirmasi" => $data->hasil_konfirm,
                "tags" => str_replace('\\', '', $data_tag)
            ));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proseskomentarcatatan()
    {
        if (session()->get("logged_pendidikan")) {
            $hasil = explode(",", $this->request->getPost('tag'));
            $cek = $this->model->getAllQR("select count(*) as jml from catatan_kelas_tag where idcatatan_kelas = '" . $this->request->getPost('kode') . "'")->jml;
            if ($cek > 0) {
                $kond['idcatatan_kelas'] = $this->request->getPost('kode');
                $hapus = $this->model->delete("catatan_kelas_tag", $kond);
            }
            for ($b = 0; $b < count($hasil); $b++) {
                $datap = array(
                    'idcatatantag' => $this->model->autokode("N", "idcatatantag", "catatan_kelas_tag", 2, 7),
                    'idtagmd' => $hasil[$b],
                    'idcatatan_kelas' => $this->request->getPost('kode')
                );
                $this->model->add("catatan_kelas_tag", $datap);
            }
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

                $data['background'] = base_url() . "/images/background.jpg";
                $data['logo_report'] = base_url() . "/images/logoreport.jpg";

                $data['idjadwalenkrip'] = $this->request->getUri()->getSegment(3);

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
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal, a.email
                from siswa a, jadwal b, jadwal_siswa c, level d
                where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and b.idlevel = d.idlevel and b.idjadwal = '" . $idjadwal . "' and a.keluar = 0 and c.is_keluar = 0 ;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = '<input type="checkbox" id="'.$row->idsiswa.'" name="type" value="'.$row->idsiswa.'" />';
                $val[] = $no;
                $val[] = $row->nama_lengkap . ' (' . $row->panggilan . ')';
                $val[] = $row->email;
                $val[] = $row->tgllahir;
                $val[] = $row->nama_sekolah;
                $jml =  $this->model->getAllQR("select count(*) as jml from history_rapor where idsiswa = '".$row->idsiswa."' and idjadwal = '".$row->idjadwal."'")->jml;
                if($jml > 0){
                    $rapor = $this->model->getAllQR("select tgl from history_rapor where idsiswa = '".$row->idsiswa."' and idjadwal = '".$row->idjadwal."'")->tgl;
                    $val[] = date("D, d M Y (H:i)",strtotime($rapor));
                }else{
                    $val[] = '-';
                }
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info" onclick="preview(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ',' . "'" . $this->modul->enkrip_url($row->idsiswa) . "'" . ')">Preview</button>'
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

    public function getValueRapor()
    {
        if (session()->get("logged_pendidikan")) {
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
                    $display_param = round($hasil) . '';
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


        $str .= '
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

    public function tangkapBase64()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->modul->dekrip_url($this->request->getPost('idjadwal'));
            $idsiswa = $this->modul->dekrip_url($this->request->getPost('idsiswa'));

            $image = $this->request->getPost('database64');
            $image = explode(";", $image)[1];
            $image = explode(",", $image)[1];
            $image = str_replace(" ", "+", $image);
            $image = base64_decode($image);
            $path = "images/" . $idjadwal . '_' . $idsiswa . '_' . $this->modul->getCurTime() . ".jpg";
            file_put_contents($path, $image);

            $status = "oke";
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function kirim_email_single_sub()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('idsiswa');

            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM jadwal_siswa where idjadwal = '" . $idjadwal . "' and idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                // mencari email siswa
                $siswa = $this->model->getAllQR("select nama_lengkap, email from siswa where idsiswa = '" . $idsiswa . "';");
                if (strlen($siswa->email) > 0) {
                    $email = $siswa->email;
                    //$email = "rampapraditya@gmail.com";
                    $hasil = $this->proseskirimemail($email, "Rapor Siswa", $this->pesan($idjadwal, $idsiswa));
                    if ($hasil == 1) {
                        $status = "email terkirim";

                        $data = array(
                            'idhistori' => $this->model->autokode("H", "idhistori", "history_rapor", 2, 7),
                            'idsiswa' => $idsiswa,
                            'idjadwal' => $$idjadwal,
                            'jadwal' => $this->model->getAllQR("select groupwa from jadwal where idjadwal = '".$idjadwal."'")->groupwa,
                            'status' => 'Terkirim',
                        );
                        $this->model->add("history_rapor", $data);
                    } else {
                        $status = "email gagal terkirim";
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

    public function kirim_email_single()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->modul->dekrip_url($this->request->getPost('idjadwal'));
            $idsiswa = $this->modul->dekrip_url($this->request->getPost('idsiswa'));

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

                        $data = array(
                            'idhistori' => $this->model->autokode("H", "idhistori", "history_rapor", 2, 7),
                            'idsiswa' => $idsiswa,
                            'idjadwal' => $$idjadwal,
                            'jadwal' => $this->model->getAllQR("select groupwa from jadwal where idjadwal = '".$idjadwal."'")->groupwa,
                            'tgl' => date('d-m-Y h:i:s'),
                            'status' => 'Terkirim',
                        );
                        $this->model->add("history_rapor", $data);
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
        $email->setCC("admin2@leapsurabaya.sch.id");
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
                $cekstart = $this->model->getAllQR("select start, count(*) as jml from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';");
                if($cekstart->jml == ''){
                    $idjadwaldetil_siswa = $this->model->getAllQR("select idjadwaldetil from jadwal_detil where idjadwal = '" . $idjadwal . "' limit 1;")->idjadwaldetil;
                    $tanggal_patok_awal = $this->model->getAllQR("select start from jadwal_detil where idjadwaldetil = '" . $idjadwaldetil_siswa . "';")->start;
                }else{
                    $tanggal_patok_awal = $cekstart->start;
                }
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
                        .dialogbody1 {
                            background: url(' . $background . ');
                            -webkit-background-size: cover;
                            -moz-background-size: cover;
                            -o-background-size: cover;
                            background-size: 100% 100%;
                            margin-top: 0cm;
                            margin-left: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            height: 780px;
                        }

                        .column1 {
                            float: left;
                            width: 50%;
                            padding: 15px;
                            padding-left: 45px;
                            height: 300px;
                        }
                    
                        .column2 {
                            float: left;
                            width: 50%;
                            padding: 15px;
                            height: 300px;
                        }
                    
                        .row:after {
                            content: "";
                            display: table;
                            clear: both;
                        }

                    </style>
                </head>
                <body>
                    <div class="row dialogbody1">
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
                            <table id="tb_kanan" border="0" style="width: 90%; margin-top: 60px; margin-right: 20px; font-size: 11px;">
                            '.$this->modelRaporByLevel($idjadwal, $idsiswa, $jadwal->idlevel, $curDate, $total_kursus, $presensi, $final_result, $pengajar, $ttd).'
                            </table>
                        </div>
                    </div>
                </body>
            </html>';
        } else {

            $html = '<html><head></head><body></body></html>';
        }

        return $html;
    }

    public function get_siswa_from_jadwal()
    {
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getPost('idjadwal');

            $data = array();
            $list = $this->model->getAllQ("select a.idsiswa, a.nama_lengkap, a.panggilan, date_format(a.tgl_lahir, '%d %M %Y') as tgllahir, a.nama_sekolah, b.idjadwal
                from siswa a, jadwal b, jadwal_siswa c, level d
                where a.idsiswa = c.idsiswa and b.idjadwal = c.idjadwal and b.idlevel = d.idlevel and b.idjadwal = '" . $idjadwal . "';");
            foreach ($list->getResult() as $row) {

                array_push($data, array(
                    'idsiswa' => $row->idsiswa,
                    'namasiswa' => $row->nama_lengkap
                ));
            }
            echo json_encode(array("status" => json_encode($data)));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxparam()
    {
        if (session()->get("logged_pendidikan")) {
            $tgl = explode(':', $this->request->getUri()->getSegment(3));

            $no = 1;
            $data = array();
            if ($tgl[0] == "tgl") {
                $query = "SELECT a.idjadwal FROM jadwal_detil a, catatan_kelas b 
                where a.idjadwaldetil = b.idjadwaldetil and a.start between '" . $tgl[1] . "' and '" . $tgl[2] . "' 
                group by a.idjadwal";
            } else if ($tgl[0] == "tag") {
                $query = "SELECT a.idjadwal FROM jadwal_detil a, catatan_kelas b, catatan_kelas_tag c
                where a.idjadwaldetil = b.idjadwaldetil and b.idcatatan_kelas = c.idcatatan_kelas 
                and c.idtagmd = '" . $tgl[1] . "' group by a.idjadwal";
            } else if ($tgl[0] == "filter") {
                $query = "SELECT a.idjadwal FROM jadwal_detil a, catatan_kelas b, catatan_kelas_tag c
                where a.idjadwaldetil = b.idjadwaldetil and a.start between '" . $tgl[2] . "' and '" . $tgl[3] . "' 
                and b.idcatatan_kelas = c.idcatatan_kelas and c.idtagmd = '" . $tgl[1] . "' group by a.idjadwal";
            }

            $list = $this->model->getAllQ("select a.idjadwal, a.groupwa, concat(date_format(c.waktu_awal,'%H:%i'), ' - ', date_format(c.waktu_akhir,'%H:%i')) as waktu, 
                f.nama_kursus as kursus, d.tahun_ajar, a.hari, e.level, mode_belajar, tempat 
                from jadwal a, jadwal_pengajar b, sesi c, periode d, level e, pendidikankursus f  
                where a.idsesi = c.idsesi and a.idpendkursus = f.idpendkursus and a.status_archive = 0 
                and a.idperiode = d.idperiode and a.idjadwal = b.idjadwal and a.idlevel = e.idlevel 
                and a.idjadwal in (" . $query . ") ;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $jml = $this->model->getAllQR("select count(*) as jml FROM jadwal_detil a, catatan_kelas b where a.idjadwaldetil = b.idjadwaldetil and a.idjadwal = '" . $row->idjadwal . "';")->jml;
                $str = '<b>ROMBEL : </b>' . $row->groupwa .
                    '<br><b>Kursus / Tingkatan : </b>' . $row->kursus . ' / ' . $row->level . '<br><b>Tempat : </b>' . $row->tempat . ' (' . $row->mode_belajar . ')';
                if ($jml > 0) {
                    $str .= '<br><b> Catatan Kelas : </b><br>';
                    $str .= '<table class="table-responsive" style="width: 100%;">';
                    $str .= '<tbody>';
                    $str .= '<thead>
                            <tr>
                                <th width="10%">Tanggal</th>
                                <th width="40%">Catatan</th>
                                <th>Konfirmasi</th>
                            </tr>
                        </thead>';
                    if ($tgl[0] == "tgl") {
                        $list2 = $this->model->getAllQ("SELECT b.idcatatan_kelas, a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, catatan, materi_diskusi, date_format(tglcek, '%d %M %Y') as tglcek, hasil_konfirm  
                    FROM jadwal_detil a, catatan_kelas b where a.idjadwaldetil = b.idjadwaldetil and a.idjadwal = '" . $row->idjadwal . "' 
                    and a.start between '" . $tgl[1] . "' and '" . $tgl[2] . "' order by a.start desc;");
                    } else if ($tgl[0] == "tag") {
                        $list2 = $this->model->getAllQ("SELECT b.idcatatan_kelas, a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, catatan, materi_diskusi, date_format(tglcek, '%d %M %Y') as tglcek, hasil_konfirm  
                    FROM jadwal_detil a, catatan_kelas b, catatan_kelas_tag c where a.idjadwaldetil = b.idjadwaldetil and b.idcatatan_kelas = c.idcatatan_kelas and a.idjadwal = '" . $row->idjadwal . "' and c.idtagmd = '" . $tgl[1] . "'");
                    } else if ($tgl[0] == "filter") {
                        $list2 = $this->model->getAllQ("SELECT b.idcatatan_kelas, a.idjadwaldetil, date_format(a.start, '%d %M %Y') as tglf, catatan, materi_diskusi, date_format(tglcek, '%d %M %Y') as tglcek, hasil_konfirm  
                    FROM jadwal_detil a, catatan_kelas b, catatan_kelas_tag c where a.idjadwaldetil = b.idjadwaldetil and b.idcatatan_kelas = c.idcatatan_kelas 
                    and a.start between '" . $tgl[2] . "' and '" . $tgl[3] . "' and a.idjadwal = '" . $row->idjadwal . "' and c.idtagmd = '" . $tgl[1] . "'");
                    }
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<tr>';
                        $str .= '<td>' . $row2->tglf . '</td>';
                        $str .= '<td>' . $row2->catatan . '</td>';
                        $str .= '<td>' . '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="komentar(' . "'" . $row2->idcatatan_kelas . "'" . ')">Komentar</button>'
                            . '</div></div>';
                        $jml = $this->model->getAllQR("select count(*) as jml from catatan_kelas_tag where idcatatan_kelas = '" . $row2->idcatatan_kelas . "'")->jml;
                        if ($jml > 0) {
                            $str .= '<b>Tag Materi Diskusi :</b><br>';
                            $tags = $this->model->getAllQ("SELECT tag FROM catatan_kelas_tag c, tag_materi_diskusi t where c.idtagmd = t.idtagmd and idcatatan_kelas = '" . $row2->idcatatan_kelas . "'");
                            foreach ($tags->getResult() as $row3) {
                                $str .= $row3->tag . '</br>';
                            }
                            $str .= '</br>';
                        }
                        if ($row2->materi_diskusi != '') {
                            $str .= '<b>Materi Diskusi : </b><br>' . $row2->materi_diskusi;
                            $str .= '<br><br><b>Tgl Cek : </b><br>' . $row2->tglcek;
                            $str .= '<br><br><b>Hasil Konfirmasi : </b><br>' . $row2->hasil_konfirm;
                        }
                        $str .= '</td>';

                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                }
                $val[] = $str;
                $cat = '<b>Hari Waktu </b> : <br>' . $row->hari . '<br>' . $row->waktu;
                $cat .= '<br><br><b>Tahun Ajar </b> : <br>' . $row->tahun_ajar;
                // menampilkan jadwal pengajar
                $nama_pengajar = '';
                $pengajar = $this->model->getAllQ("SELECT a.idusers, b.nama FROM jadwal_pengajar a, users b where a.idjadwal = '" . $row->idjadwal . "' and a.idusers = b.idusers;");
                foreach ($pengajar->getResult() as $row1) {
                    $nama_pengajar .= $row1->nama . ',';
                }
                $cat .= '<br><br><b>Nama Pengajar : </b><br>' . substr($nama_pengajar, 0, strlen($nama_pengajar) - 1);
                $val[] = $cat;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="raporsiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Rapor Siswa</button>'
                    . '<br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-primary btn-fw" onclick="catatansiswa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')">Catatan Siswa</button>'
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

    public function alternatif(){
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

                $data['background'] = base_url() . "/images/background.jpg";
                $data['logo_report'] = base_url() . "/images/logoreport.jpg";

                $data['idjadwalenkrip'] = $this->request->getUri()->getSegment(3);

                $data['listsiswa'] = $this->model->getAllQ("SELECT a.idsiswa, b.nama_lengkap, b.email FROM jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."';");

                $data['model'] = $this->model;

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/laporan_pengajaran/alternatif');
                echo view('back/foot');
            } else {
                $this->modul->halaman('laporansiswapengajar');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function getDataSiswa(){
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getUri()->getSegment(3);
            $users = $this->request->getPost('users');
            
            $idsiswa = array();
            $nama = array();
            $email = array();
            $rapor = array();

            $list = $this->model->getAllQ("SELECT a.idsiswa, b.nama_lengkap, b.email FROM jadwal_siswa a, siswa b where a.idsiswa = b.idsiswa and a.idjadwal = '".$idjadwal."' and a.idsiswa in(".$users.");");
            foreach ($list->getResult() as $row) {
                array_push($idsiswa, $row->idsiswa);
                array_push($nama, $row->nama_lengkap);
                array_push($email, $row->email);

                $html = $this->pesan($idjadwal, $row->idsiswa);
                array_push($rapor, $html);
            }
            echo json_encode(array(
                "idsiswa" => $idsiswa,
                "nama" => $nama,
                "email" => $email,
                "rapor" => $rapor
            ));
        }else{
            $this->modul->halaman('login');
        }
    }

    public function simpangambar(){
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('id');
            $image = $this->request->getPost('image');
            $nama = $this->request->getPost('nama');

            $namasis = $this->model->getAllQR("select nama_lengkap from siswa where idsiswa = '".$idsiswa."'")->nama_lengkap;
            $image = explode(";", $image)[1];
            $image = explode(",", $image)[1];
            $image = str_replace(" ", "+", $image);
            $image = base64_decode($image);
            file_put_contents($this->modul->getPathApp().'rapor/'.str_replace(' ', '_', $namasis).".jpeg", $image);

            $list = $this->model->getAllQ("SELECT path FROM file_rapor_siswa where idjadwal = '".$idjadwal."' and idsiswa = '".$idsiswa."';");
            foreach ($list->getResult() as $row) {
                if(strlen($row->path) > 0){
                    if(file_exists($this->modul->getPathApp().$row->path)){
                        unlink($this->modul->getPathApp().$row->path);
                    }
                }
            }

            $kond['idjadwal'] = $idjadwal;
            $kond['idsiswa'] = $idsiswa;
            $this->model->delete("file_rapor_siswa",$kond);

            $data = array(
                'idfile' => $this->model->autokode("F","idfile","file_rapor_siswa", 2, 7),
                'idjadwal' => $idjadwal,
                'idsiswa' => $idsiswa,
                'path' => $this->modul->getPathApp().'rapor/'.str_replace(' ', '_', $namasis).".jpeg"
            );
            $this->model->add("file_rapor_siswa",$data);

            echo json_encode(array("status" => "Oke"));
        }else{
            $this->modul->halaman('login');
        }
    }

    private function proseskirimemail1($to, $subject, $message, $path)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setCC("admin2@leapsurabaya.sch.id");
        $email->setFrom('info@leapsurabaya.sch.id', 'Rapor Siswa');
        $email->attach($path);

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            $status = "Email Berhasil Terkirim";
        } else {
            $status = "Email Gagal Terkirim";
        }
        return $status;
    }

    public function kirimemail(){
        if (session()->get("logged_pendidikan")) {
            $idjadwal = $this->request->getPost('idjadwal');
            $idsiswa = $this->request->getPost('id');
            $nama = $this->request->getPost('nama');
            $email = $this->request->getPost('email');
            $level = $this->model->getAllQR("select b.level from jadwal a, level b where a.idlevel = b.idlevel and a.idjadwal = '".$idjadwal."';")->level;
            $path = $this->model->getAllQR("SELECT path FROM file_rapor_siswa where idjadwal = '".$idjadwal."' and idsiswa = '".$idsiswa."';")->path;
            $program = $this->model->getAllQR("select nama_kursus from jadwal a, level b, pendidikankursus p where a.idlevel = b.idlevel and p.idpendkursus = a.idpendkursus and a.idjadwal = '".$idjadwal."';")->nama_kursus;
            
            $pesan = '<h3>Selamat siang, </h3>
            <p>Berikut kami kirimkan Laporan Pembelajaran untuk:<br>
            Nama : ' . $nama . '<br>
            Program : '. $program .'<br>
            Level : ' . $level . '
            </p>   
            <p>Selamat telah menyelesaikan keseluruhan materi dan aktivitas di level ini dengan baik.</p>
            <p>Terima kasih,<br>Salam LKP LEAP English & Digital Class Surabaya</p>';

            if(strlen($email) > 0){
                $status = $this->proseskirimemail1($email, "Rapor Siswa", $pesan, base_url().'/'.$path);
                if($status = "Email Berhasil Terkirim"){
                    $data = array(
                        'idhistori' => $this->model->autokode("H", "idhistori", "history_rapor", 2, 7),
                        'idsiswa' => $idsiswa,
                        'idjadwal' => $idjadwal,
                        'jadwal' => $this->model->getAllQR("select groupwa from jadwal where idjadwal = '".$idjadwal."'")->groupwa,
                        'status' => 'Terkirim',
                    );
                    $this->model->add("history_rapor", $data);
                }
            }
            
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}
