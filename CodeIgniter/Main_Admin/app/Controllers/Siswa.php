<?php

namespace App\Controllers;

/**
 * Description of Siswa
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;
use App\Libraries\Datatables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Siswa extends BaseController
{

    private $model;
    private $modul;
    private $custommodel;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
        $this->custommodel = new Datatables();
    }

    public function index()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
                }
            }

            $data['pro'] = $pro;
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;
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

            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['tags'] = $this->model->getAllQ("select * from tag_keluar");
            $data['provinsi'] = $this->model->getAll("provinsi");
            $data['mitra'] = $this->model->getAll("mitra");
            $data['kelas'] = $this->model->getAllQ("select * from jadwal where status_archive = 0 order by groupwa");

            echo view('back/head', $data);
            if (session()->get("logged_bos")) {
                echo view('back/bos/menu');
            } else if (session()->get("logged_pendidikan")) {
                echo view('back/akademik/menu');
            } else if (session()->get("logged_hr")) {
                echo view('back/hrd/menu');
            } else if (session()->get("logged_siswa")) {
                echo view('back/siswa/menu');
            }
            echo view('back/akademik/siswa/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function kabupaten()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

    public function kecamatan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idkabupaten = $this->request->getPost('kabupaten');
            $status = '<option value="-">- Pilih Kecamatan -</option>';
            $list = $this->model->getAllQ("select idkecamatan, nama from kecamatan where idkabupaten = '" . $idkabupaten . "';");
            foreach ($list->getResult() as $row) {
                $status .= '<option value="' . $row->idkecamatan . '">' . $row->nama . '</option>';
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function kelurahan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idkecamatan = $this->request->getPost('kecamatan');
            $status = '<option value="-">- Pilih Kelurahan -</option>';
            $list = $this->model->getAllQ("select idkelurahan, nama from kelurahan where idkecamatan = '" . $idkecamatan . "';");
            foreach ($list->getResult() as $row) {
                $status .= '<option value="' . $row->idkelurahan . '">' . $row->nama . '</option>';
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {

            // sql query
            if ($this->request->getPost('kelas') != null) {
                $query = "select s.*, s.idmitra as kode_mitra, m.instansi as company, date_format(s.tgl_daftar, '%d %M %Y') as tgl_daftar_f, 
                        date_format(s.tgl_lahir, '%d %M %Y') as tgl_lahir_f 
                        from jadwal_siswa js
                        join siswa s on js.idsiswa = s.idsiswa
                        left join mitra m on s.idmitra = m.idmitra";
            }else{
                $query = "select s.*, s.idmitra as kode_mitra, m.instansi as company, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, 
                date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f
                    from siswa s
                    left join mitra m on s.idmitra = m.idmitra";
            }
            // $where  = array('nama_kategori' => 'Tutorial');
            $where  = null;
            // jika memakai IS NULL pada where sql
            //$isWhere = null;
            $isWhere = "keluar = 0 and lulus = 0";
            // $isWhere = " s.idmitra = m.idmitra ";

            if ($this->request->getPost('kelas') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and idjadwal = '" . $this->request->getPost('kelas') . "' ";
                } else {
                    $isWhere .= " idjadwal = '" . $this->request->getPost('kelas') . "' ";
                }
            }

            if ($this->request->getPost('noinduk') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and no_induk like '%" . $this->request->getPost('noinduk') . "%' ";
                } else {
                    $isWhere .= " no_induk like '%" . $this->request->getPost('noinduk') . "%' ";
                }
            }

            if ($this->request->getPost('nama') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and nama_lengkap like '%" . $this->request->getPost('nama') . "%' ";
                } else {
                    $isWhere .= " nama_lengkap like '%" . $this->request->getPost('nama') . "%' ";
                }
            }

            if ($this->request->getPost('panggilan') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and panggilan like '%" . $this->request->getPost('panggilan') . "%' ";
                } else {
                    $isWhere .= " panggilan like '%" . $this->request->getPost('panggilan') . "%' ";
                }
            }

            if ($this->request->getPost('tgl_daftar') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and tgl_daftar = '" . $this->request->getPost('tgl_daftar') . "' ";
                } else {
                    $isWhere .= " tgl_daftar = '" . $this->request->getPost('tgl_daftar') . "' ";
                }
            }

            if ($this->request->getPost('jkel') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and jkel = '" . $this->request->getPost('jkel') . "' ";
                } else {
                    $isWhere .= " jkel = '" . $this->request->getPost('jkel') . "' ";
                }
            }

            if ($this->request->getPost('asal_sekolah') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and nama_sekolah like '%" . $this->request->getPost('asal_sekolah') . "%' ";
                } else {
                    $isWhere .= " nama_sekolah like '%" . $this->request->getPost('asal_sekolah') . "%' ";
                }
            }

            if ($this->request->getPost('tmp_lahir') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and tmp_lahir like '%" . $this->request->getPost('tmp_lahir') . "%' ";
                } else {
                    $isWhere .= " tmp_lahir like '%" . $this->request->getPost('tmp_lahir') . "%' ";
                }
            }

            if ($this->request->getPost('tgl_lahir') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and tgl_lahir = '" . $this->request->getPost('tgl_lahir') . "' ";
                } else {
                    $isWhere .= " tgl_lahir = '" . $this->request->getPost('tgl_lahir') . "' ";
                }
            }

            if ($this->request->getPost('domisili') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and domisili like '%" . $this->request->getPost('domisili') . "%' ";
                } else {
                    $isWhere .= " domisili like '%" . $this->request->getPost('domisili') . "%' ";
                }
            }

            if ($this->request->getPost('nama_ortu') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and nama_ortu like '%" . $this->request->getPost('nama_ortu') . "%' ";
                } else {
                    $isWhere .= " nama_ortu like '%" . $this->request->getPost('nama_ortu') . "%' ";
                }
            }

            if ($this->request->getPost('perkerjaan_ortu') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and pekerjaan_ortu like '%" . $this->request->getPost('perkerjaan_ortu') . "%' ";
                } else {
                    $isWhere .= " pekerjaan_ortu like '%" . $this->request->getPost('perkerjaan_ortu') . "%' ";
                }
            }

            if ($this->request->getPost('statusdata') != null) {
                if (strlen($isWhere) > 0) {
                    $isWhere .= " and sts_pengisian like '%" . $this->request->getPost('statusdata') . "%' ";
                } else {
                    $isWhere .= " sts_pengisian like '%" . $this->request->getPost('statusdata') . "%' ";
                }
            }

            $search = array('s.idsiswa', 'no_induk', 'nama_lengkap', 'panggilan', 'tgl_daftar',  'jkel', 'nama_sekolah', 'tmp_lahir', 'tgl_lahir', 'domisili', 'nama_ortu', 'pekerjaan_ortu');
            echo $this->custommodel->BuildDatatables($query, $where, $isWhere, $search);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function enkrip()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $status = $this->modul->enkrip_url($this->request->getUri()->getSegment(3));
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $no_induk = $this->request->getPost('no_induk');
            if (strlen($no_induk) > 0) {
                $cek = $this->model->getAllQR("select count(*) as jml from siswa where no_induk = '" . $no_induk . "';")->jml;
                if ($cek > 0) {
                    $status = "Gunakan no induk yang lain";
                } else {
                    $status = $this->simpanSiswa();
                }
            } else {
                $status = $this->simpanSiswa();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function simpanSiswa()
    {
        $idmitra = $this->request->getPost('idmitra');
        $data = array(
            'idsiswa' => $this->model->autokode("S", "idsiswa", "siswa", 2, 9),
            'no_induk' => $this->request->getPost('no_induk'),
            'tgl_daftar' => $this->request->getPost('tgldaftar'),
            'domisili' => $this->request->getPost('domisili'),
            'nama_lengkap' => $this->request->getPost('namalengkap'),
            'panggilan' => $this->request->getPost('panggilan'),
            'jkel' => $this->request->getPost('jkel'),
            'nama_sekolah' => $this->request->getPost('sekolah'),
            'level_sekolah' => $this->request->getPost('lv_sekolah'),
            'nama_ortu' => $this->request->getPost('ortu'),
            'idmitra' => !empty($idmitra) ? $idmitra : null,
            'pekerjaan_ortu' => $this->request->getPost('pekerjaan_ortu'),
            'tmp_lahir' => $this->request->getPost('tmplahir'),
            'tgl_lahir' => $this->request->getPost('tgllahir'),
            'email' => $this->request->getPost('email'),
            'tlp' => $this->request->getPost('tlp'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kabupaten' => $this->request->getPost('kabupaten'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kelurahan' => $this->request->getPost('kelurahan')
        );
        $simpan = $this->model->add("siswa", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    public function show()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("siswa", $kond);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getPost('kode');
            $no_induk = $this->request->getPost('no_induk');
            if (strlen($no_induk) > 0) {
                $cek = $this->model->getAllQR("select count(*) as jml from siswa where no_induk = '" . $no_induk . "' and idsiswa <> '" . $idsiswa . "';")->jml;
                if ($cek > 0) {
                    $status = "Gunakan no induk yang lain";
                } else {
                    $status = $this->updateSiswa();
                }
            } else {
                $status = $this->updateSiswa();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function updateSiswa()
    {
        $idmitra = $this->request->getPost('idmitra');
        $data = array(
            'no_induk' => $this->request->getPost('no_induk'),
            'tgl_daftar' => $this->request->getPost('tgldaftar'),
            'domisili' => $this->request->getPost('domisili'),
            'nama_lengkap' => $this->request->getPost('namalengkap'),
            'panggilan' => $this->request->getPost('panggilan'),
            'jkel' => $this->request->getPost('jkel'),
            'nama_sekolah' => $this->request->getPost('sekolah'),
            'level_sekolah' => $this->request->getPost('lv_sekolah'),
            'nama_ortu' => $this->request->getPost('ortu'),
            'idmitra' => !empty($idmitra) ? $idmitra : null,
            'pekerjaan_ortu' => $this->request->getPost('pekerjaan_ortu'),
            'tmp_lahir' => $this->request->getPost('tmplahir'),
            'tgl_lahir' => $this->request->getPost('tgllahir'),
            'email' => $this->request->getPost('email'),
            'tlp' => $this->request->getPost('tlp'),
            'provinsi' => $this->request->getPost('provinsi'),
            'kabupaten' => $this->request->getPost('kabupaten'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kelurahan' => $this->request->getPost('kelurahan')
        );
        $kond['idsiswa'] = $this->request->getPost('kode');
        $simpan = $this->model->update("siswa", $data, $kond);
        if ($simpan == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }

    public function hapus()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("siswa", $kond);
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

    public function jadwal()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

            $data['curdate'] = $this->modul->TanggalSekarang();
            $idsiswa = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                $data['siswa'] = $this->model->getAllQR("select idsiswa, nama_lengkap, panggilan, nama_sekolah, level_sekolah, domisili, tmp_lahir, date_format(tgl_lahir, '%d %M %Y') as tgllahir from siswa where idsiswa = '" . $idsiswa . "';");
                $data['sesi'] = $this->model->getAll("sesi");

                echo view('back/head', $data);
                if (session()->get("logged_bos")) {
                    echo view('back/bos/menu');
                } else if (session()->get("logged_pendidikan")) {
                    echo view('back/akademik/menu');
                } else if (session()->get("logged_hr")) {
                    echo view('back/hrd/menu');
                }
                echo view('back/akademik/siswa/jadwal');
                echo view('back/foot');
            } else {
                $this->modul->halaman('siswa');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxjadwal()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $namasiswa = $this->model->getAllQR("select nama_lengkap from siswa where idsiswa = '" . $idsiswa . "';")->nama_lengkap;

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select a.idjadwal_siswa, a.is_keluar, b.idjadwal, b.groupwa, concat(c.waktu_awal, ' - ', c.waktu_akhir) as waktu, g.nama_kursus as kursus, concat(d.tanggal, '-', d.bulan_awal, '-', d.tahun_awal) as periode, 
                e.meeting_id, f.level, b.hari, a.is_lulus  
                from jadwal_siswa a, jadwal b, sesi c, periode d, zoom e, level f, pendidikankursus g  
                where a.idjadwal = b.idjadwal and b.idsesi = c.idsesi and b.idperiode = d.idperiode and b.idpendkursus = g.idpendkursus 
                and b.idzoom = e.idzoom and b.idlevel = f.idlevel and a.idsiswa = '" . $idsiswa . "';");
            foreach ($list->getResult() as $row) {
                // melihat jadwal guru
                $pengajar = '';
                $cek_pengajar = $this->model->getAllQR("select count(*) as jml from jadwal_pengajar where idjadwal = '" . $row->idjadwal . "';")->jml;
                if ($cek_pengajar > 0) {
                    $list_pengajar = $this->model->getAllQ("select b.nama from jadwal_pengajar a, users b where idjadwal = '" . $row->idjadwal . "' and a.idusers = b.idusers;");
                    foreach ($list_pengajar->getResult() as $rowpengajar) {
                        $pengajar .= $rowpengajar->nama . ', ';
                    }
                    $pengajar = substr($pengajar, 0, strlen($pengajar) - 2);
                }

                $val = array();
                $val[] = $no;
                $val[] = $row->groupwa . '<br>' . $row->kursus;
                $val[] = $pengajar;
                $val[] = $row->hari . '<br>' . $row->waktu;
                $val[] = $row->meeting_id;
                $val[] = $row->level;
                if ($row->is_lulus == "1") {
                    $val[] = '<span class="badge badge-success">Lulus</span>';
                    $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                        . '<button type="button" class="btn btn-sm btn-secondary" onclick="batalkanlulus(' . "'" . $idsiswa . "'" . ', ' . "'" . $namasiswa . "'" . ',' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ')">Batalkan Lulus</button>'
                        . '<button type="button" class="btn btn-sm btn-danger" onclick="hapusjadwal(' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ',' . "'" . $namasiswa . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                        . '</div></div>';
                } else {
                    if ($row->is_keluar == "1"){
                        $val[] = '<span class="badge badge-danger">Non-aktif</span>';
                        $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-sm btn-secondary" onclick="lulus(' . "'" . $idsiswa . "'" . ', ' . "'" . $namasiswa . "'" . ',' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ')">Lulus</button>'
                            . '<button type="button" class="btn btn-sm btn-danger" onclick="hapusjadwal(' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ',' . "'" . $namasiswa . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                            . '<button type="button" class="btn btn-sm btn-primary" onclick="aktifkan(' . "'" . $idsiswa . "'" . ', ' . "'" . $namasiswa . "'" . ',' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ')">Aktifkan</button>'
                            . '</div></div>';
                    }else{
                        $val[] = '<span class="badge badge-primary">Aktif</span>';
                        $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                            . '<button type="button" class="btn btn-sm btn-secondary" onclick="lulus(' . "'" . $idsiswa . "'" . ', ' . "'" . $namasiswa . "'" . ',' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ')">Lulus</button>'
                            . '<button type="button" class="btn btn-sm btn-danger" onclick="hapusjadwal(' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ',' . "'" . $namasiswa . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                            . '<button type="button" class="btn btn-sm btn-warning" onclick="nonaktif(' . "'" . $idsiswa . "'" . ', ' . "'" . $namasiswa . "'" . ',' . "'" . $row->idjadwal_siswa . "'" . ',' . "'" . $row->groupwa . "'" . ')">Nonaktif</button>'
                            . '</div></div>';
                    }
                }


                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlistjadwal()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT a.idjadwal, a.groupwa, a.hari, concat(b.waktu_awal, ' - ',b.waktu_akhir) as sesi, concat(c.tanggal, ' ', c.bulan_awal, ' ' ,c.tahun_awal) as periode, d.level, e.meeting_id 
                FROM jadwal a, sesi b, periode c, level d, zoom e 
                where a.idsesi = b.idsesi and a.idperiode = c.idperiode and a.idlevel = d.idlevel and a.idzoom = e.idzoom and idjadwal not in(select idjadwal from jadwal_siswa where idsiswa = '" . $idsiswa . "');");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->groupwa;
                $val[] = $row->hari;
                $val[] = $row->sesi;
                $val[] = $row->periode;
                $val[] = $row->level;
                $val[] = $row->meeting_id;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih(' . "'" . $row->idjadwal . "'" . ',' . "'" . $idsiswa . "'" . ')"><i class="fas fa-check"></i></button>'
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

    public function ajaxlist_histori()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from history_rapor where idsiswa = '" . $idsiswa . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->jadwal;
                $val[] = date('D, d M Y (H:i)', strtotime($row->tgl));
                $val[] = $row->status;

                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function jadwalsiswa()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);

            $data = array();
            $list = $this->model->getAllQ("SELECT a.groupwa, p.tahun_ajar
                FROM jadwal a, jadwal_siswa b, periode p
                where a.idjadwal = b.idjadwal and p.idperiode = a.idperiode and b.idsiswa = '" . $idsiswa . "'
                and a.status_archive = 0
                order by tahun_ajar desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val['groupwa'] = $row->groupwa.' ('.$row->tahun_ajar.')';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function simpanjadwalsiswa()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data = array(
                'idjadwal_siswa' => $this->model->autokode("P", "idjadwal_siswa", "jadwal_siswa", 2, 9),
                'idsiswa' => $this->request->getPost('idsiswa'),
                'idjadwal' => $this->request->getPost('idjadwal')
            );
            $simpan = $this->model->add("jadwal_siswa", $data);
            if ($simpan == 1) {
                $status = "Data tersimpan";
            } else {
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapusjadwal()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

    public function proses_upload_file()
    {
        if (session()->get("logged_karyawan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->uploadFileExcel();
                }
            } else {
                $status = "File tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function uploadFileExcel()
    {
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

                        if($value[2] != ''){
                            $spreadSheet = $reader->load($targetDir);
                            $absen = $spreadSheet->getActiveSheet()->toArray();
                            foreach ($absen as $key => $value) {
                                if ($key > 1) {

                                    if ($value[0] == null) {
                                        $no_induk = "";
                                    } else {
                                        $no_induk = $value[0];
                                    }

                                    if ($value[1] == null) {
                                        $tgl_daftar = "";
                                    } else {
                                        $tgl_daftar = $value[1];
                                    }

                                    if ($value[2] == null) {
                                        $nama = "";
                                    } else {
                                        $nama = $value[2];
                                    }

                                    if ($value[3] == null) {
                                        $panggilan = "";
                                    } else {
                                        $panggilan = $value[3];
                                    }

                                    if ($value[4] == null) {
                                        $tmpLahir = "";
                                    } else {
                                        $tmpLahir = $value[4];
                                    }

                                    if ($value[5] == null) {
                                        $tglLahir = "";
                                    } else {
                                        $tglLahir = $value[5];
                                    }

                                    if ($value[6] == null) {
                                        $nisn = "";
                                    } else {
                                        $nisn = $value[6];
                                    }

                                    if ($value[7] == null) {
                                        $nik = "";
                                    } else {
                                        $nik = $value[7];
                                    }

                                    if ($value[8] == null) {
                                        $warga = "";
                                    } else {
                                        $warga = $value[8];
                                    }

                                    if ($value[9] == null) {
                                        $agama = "";
                                    } else {
                                        $agama = $value[9];
                                    }

                                    if ($value[10] == null) {
                                        $alamat = "";
                                    } else {
                                        $alamat = $value[10];
                                    }

                                    if ($value[11] == null) {
                                        $provinsi = "";
                                    } else {
                                        $jmlp = $this->model->getAllQR("select count(*) as jml from provinsi where nama like '".rtrim($value[11])."'")->jml;
                                        if($jmlp > 0){
                                            $p = $this->model->getAllQR("select idprovinsi from provinsi where nama like '".rtrim($value[11])."'")->idprovinsi;
                                        }else{
                                            $l = $this->model->getAllQR("select idprovinsi from provinsi order by idprovinsi desc limit 1")->idprovinsi;
                                            $p1 = (int) $l;
                                            $p = $p1+1;
                                            $datapv = array(
                                                'idprovinsi' => $p,
                                                'nama' => $value[11],
                                            );
                                            $this->model->add("provinsi", $datapv);
                                        }
                                        $provinsi = $p;
                                    }

                                    if ($value[12] == null) {
                                        $kotkab = "";
                                    } else {
                                        $jmlk = $this->model->getAllQR("select count(*) as jml from kabupaten where name like '".rtrim($value[12])."'")->jml;
                                        if($jmlk > 0){
                                            $kb = $this->model->getAllQR("select idkabupaten from kabupaten where name like '".rtrim($value[12])."'")->idkabupaten;
                                        }else{
                                            $k = $this->model->getAllQR("select idkabupaten from kabupaten order by idkabupaten desc limit 1")->idkabupaten;
                                            $kb1 = (int) $k;
                                            $kb = $kb1+1;
                                            $datakt = array(
                                                'idkabupaten' => $kb,
                                                'idprovinsi' => $provinsi,
                                                'name' => $value[12],
                                            );
                                            $this->model->add("kabupaten", $datakt);
                                        }
                                        $kotkab = $kb;
                                    }

                                    if ($value[13] == null) {
                                        $kecamatan = "";
                                    } else {
                                        $jmlkc = $this->model->getAllQR("select count(*) as jml from kecamatan where nama like '".rtrim($value[13])."'")->jml;
                                        if($jmlkc > 0){
                                            $kc = $this->model->getAllQR("select idkecamatan from kecamatan where nama like '".rtrim($value[13])."'")->idkecamatan;
                                        }else{
                                            $ka = $this->model->getAllQR("select idkecamatan from kecamatan order by idkecamatan desc limit 1")->idkecamatan;
                                            $ka1 = (int) $ka;
                                            $kc = $ka1 + 1;
                                            $datakb = array(
                                                'idkecamatan' => $kc,
                                                'idkabupaten' => $kotkab,
                                                'nama' => $value[13],
                                            );
                                            $this->model->add("kecamatan", $datakb);
                                        }
                                        $kecamatan = $kc;
                                    }

                                    if ($value[14] == null) {
                                        $kelurahan = "";
                                    } else {
                                        $jmlkl = $this->model->getAllQR("select count(*) as jml from kelurahan where nama like '".rtrim($value[14])."'")->jml;
                                        if($jmlkl > 0){
                                            $kl = $this->model->getAllQR("select idkelurahan from kelurahan where nama like '".rtrim($value[14])."'")->idkelurahan;
                                        }else{
                                            $kel = $this->model->getAllQR("select idkelurahan from kelurahan order by idkelurahan desc limit 1")->idkelurahan;
                                            $ke = (int) $kel;
                                            $kl = $ke+1;
                                            $datakl = array(
                                                'idkelurahan' => $kl,
                                                'idkecamatan' => $kecamatan,
                                                'nama' => $value[14],
                                            );
                                            $this->model->add("kelurahan", $datakl);
                                        }
                                        $kelurahan = $kl;
                                    }

                                    if ($value[15] == null) {
                                        $kodepos = "";
                                    } else {
                                        $kodepos = $value[15];
                                    }

                                    if ($value[16] == null) {
                                        $rt = "";
                                    } else {
                                        $rt = $value[16];
                                    }

                                    if ($value[17] == null) {
                                        $rw = "";
                                    } else {
                                        $rw = $value[17];
                                    }

                                    if ($value[18] == null) {
                                        $sekolah = "";
                                    } else {
                                        $sekolah = $value[18];
                                    }

                                    if ($value[19] == null) {
                                        $level = "";
                                    } else {
                                        $level = $value[19];
                                    }

                                    if ($value[20] == null) {
                                        $email = "";
                                    } else {
                                        $email = $value[20];
                                    }

                                    if ($value[21] == null) {
                                        $waadmin = "";
                                    } else {
                                        $waadmin = $value[21];
                                    }

                                    if ($value[22] == null) {
                                        $wawalmur = "";
                                    } else {
                                        $wawalmur = $value[22];
                                    }

                                    if ($value[23] == null) {
                                        $wasiswa = "";
                                    } else {
                                        $wasiswa = $value[23];
                                    }

                                    if ($value[24] == null) {
                                        $stssiswa = "";
                                    } else {
                                        $stssiswa = $value[24];
                                    }

                                    if ($value[25] == null) {
                                        $info = "";
                                    } else {
                                        $info = $value[25];
                                    }

                                    if ($value[26] == null) {
                                        $rekomendasi = "";
                                    } else {
                                        $rekomendasi = $value[26];
                                    }

                                    if ($value[27] == null) {
                                        $nama_ayah = "";
                                    } else {
                                        $nama_ayah = $value[27];
                                    }

                                    if ($value[28] == null) {
                                        $pekerjaan_ayah = "";
                                    } else {
                                        $pekerjaan_ayah = $value[28];
                                    }

                                    if ($value[29] == null) {
                                        $jenjang_pendidikan_ayah = "";
                                    } else {
                                        $jenjang_pendidikan_ayah = $value[29];
                                    }

                                    if ($value[30] == null) {
                                        $penghasilan_ayah = "";
                                    } else {
                                        $penghasilan_ayah = $value[30];
                                    }

                                    if ($value[31] == null) {
                                        $nama_ibu = "";
                                    } else {
                                        $nama_ibu = $value[31];
                                    }

                                    if ($value[32] == null) {
                                        $pekerjaan_ibu = "";
                                    } else {
                                        $pekerjaan_ibu = $value[32];
                                    }

                                    if ($value[33] == null) {
                                        $jenjang_pendidikan_ibu = "";
                                    } else {
                                        $jenjang_pendidikan_ibu = $value[33];
                                    }

                                    if ($value[34] == null) {
                                        $penghasilan_ibu = "";
                                    } else {
                                        $penghasilan_ibu = $value[34];
                                    }

                                    if ($value[35] == null) {
                                        $nama_wali = "";
                                    } else {
                                        $nama_wali = $value[35];
                                    }

                                    if ($value[36] == null) {
                                        $pekerjaan_wali = "";
                                    } else {
                                        $pekerjaan_wali = $value[36];
                                    }

                                    if ($value[37] == null) {
                                        $jenjang_pendidikan_wali = "";
                                    } else {
                                        $jenjang_pendidikan_wali = $value[37];
                                    }

                                    if ($value[38] == null) {
                                        $penghasilan_wali = "";
                                    } else {
                                        $penghasilan_wali = $value[38];
                                    }
                                    if ($value[39] == null) {
                                        $kelas = "";
                                    } else {
                                        $kelas = $value[39];
                                    }
                                    if ($value[40] == null) {
                                        $sts_pengisian = "";
                                    } else {
                                        $sts_pengisian = $value[40];
                                    }
                                    if ($value[41] == null) {
                                        $idsiswa = "";
                                    } else {
                                        $idsiswa = $value[41];
                                    }
                                    if ($value[42] == null) {
                                        $aksi = "";
                                    } else {
                                        $aksi = $value[42];
                                    }
                                    if ($value[43] == null) {
                                        $jkel = "";
                                    } else {
                                        $jkel = $value[43];
                                    }

                                    // cek data apakah sudah ada didatabase apa tidak
                                    $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;

                                    if ($cek < 1) {
                                        // masukkkan ke database
                                        if($aksi == 'ADD'){
                                            $data = array(
                                                'idsiswa' => $this->model->autokode("S", "idsiswa", "siswa", 2, 9),
                                                'tgl_daftar' => $tgl_daftar,
                                                'nama_lengkap' => $nama,
                                                'domisili' => $alamat,
                                                'jkel' => $jkel,//belum ada
                                                'nama_sekolah' => $sekolah,
                                                'level_sekolah' => $level,
                                                'nama_ibu' => $nama_ibu,
                                                'pekerjaan_ortu' => $pekerjaan_ibu,
                                                'tmp_lahir' => $tmpLahir,
                                                'tgl_lahir' => $tglLahir,
                                                'no_induk' => $no_induk,
                                                'email' => $panggilan,
                                                'provinsi' => $provinsi,
                                                'kabupaten' => $kotkab,
                                                'kecamatan' => $kecamatan,
                                                'kelurahan' => $kelurahan,
                                                'nisn' => $nisn,
                                                'nik' => $nik,
                                                'kewarganegaraan' => $warga,
                                                'agama' => $agama,
                                                'rt' => $rt,
                                                'rw' => $rw,
                                                'kodepos' => $kodepos,
                                                'statussiswa' => $stssiswa,
                                                'rekomen' => $rekomendasi,
                                                'info' => $info,
                                                'nama_ayah' => $nama_ayah,
                                                'pekerjaan_ayah' => $pekerjaan_ayah,
                                                'jenjang_ayah' => $jenjang_pendidikan_ayah,
                                                'penghasilan_ayah' => $penghasilan_ayah,
                                                'penghasilan_ibu' => $penghasilan_ibu,
                                                'jenjang_ibu' => $jenjang_pendidikan_ibu,
                                                'nama_wali' => $nama_wali,
                                                'pekerjaan_wali' => $pekerjaan_wali,
                                                'jenjang_wali' => $jenjang_pendidikan_wali,
                                                'penghasilan_wali' => $penghasilan_wali,
                                                'wawalmur' => $wawalmur,
                                                'waadmin' => $waadmin,
                                                'wapeserta' => $wasiswa,
                                                'sts_pengisian' => $sts_pengisian,
                                            );
                                            $simpan = $this->model->add("siswa", $data);
                                        }
                                    } else {
                                        if($aksi == 'EDIT'){
                                            // update database
                                            $data = array(
                                                'tgl_daftar' => $tgl_daftar,
                                                'nama_lengkap' => $nama,
                                                'domisili' => $alamat,
                                                'jkel' => $jkel,//belum ada
                                                'nama_sekolah' => $sekolah,
                                                'level_sekolah' => $level,
                                                'nama_ibu' => $nama_ibu,
                                                'pekerjaan_ortu' => $pekerjaan_ibu,
                                                'tmp_lahir' => $tmpLahir,
                                                'tgl_lahir' => $tglLahir,
                                                'no_induk' => $no_induk,
                                                'email' => $panggilan,
                                                'provinsi' => $provinsi,
                                                'kabupaten' => $kotkab,
                                                'kecamatan' => $kecamatan,
                                                'kelurahan' => $kelurahan,
                                                'nisn' => $nisn,
                                                'nik' => $nik,
                                                'kewarganegaraan' => $warga,
                                                'agama' => $agama,
                                                'rt' => $rt,
                                                'rw' => $rw,
                                                'kodepos' => $kodepos,
                                                'statussiswa' => $stssiswa,
                                                'rekomen' => $rekomendasi,
                                                'info' => $info,
                                                'nama_ayah' => $nama_ayah,
                                                'pekerjaan_ayah' => $pekerjaan_ayah,
                                                'jenjang_ayah' => $jenjang_pendidikan_ayah,
                                                'penghasilan_ayah' => $penghasilan_ayah,
                                                'penghasilan_ibu' => $penghasilan_ibu,
                                                'jenjang_ibu' => $jenjang_pendidikan_ibu,
                                                'nama_wali' => $nama_wali,
                                                'pekerjaan_wali' => $pekerjaan_wali,
                                                'jenjang_wali' => $jenjang_pendidikan_wali,
                                                'penghasilan_wali' => $penghasilan_wali,
                                                'wawalmur' => $wawalmur,
                                                'waadmin' => $waadmin,
                                                'wapeserta' => $wasiswa,
                                                'sts_pengisian' => $sts_pengisian,
                                            );
                                            $kond['idsiswa'] = $idsiswa;
                                            $this->model->update("siswa", $data, $kond);
                                        }else if($aksi == 'DELETE'){
                                            $kond2['idsiswa'] = $idsiswa;
                                            $this->model->delete("siswa", $kond2);
                                        }
                                    }
                                }
                            }
                            unlink($targetDir);
                            $status = "Data berhasil diperbarui";
                        }
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

    public function exportdata()
    {
        if (session()->get("logged_karyawan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

            $sheet->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A1:AR1'); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            $sheet->getStyle('A1')->getFont()->setSize(12); // Set font size 12 untuk kolom A1

            // Buat header tabel nya pada baris ke 3
            $sheet->setCellValue('A2', "No Induk");
            $sheet->setCellValue('B2', "Tgl Daftar");
            $sheet->setCellValue('C2', "Nama Lengkap Siswa");
            $sheet->setCellValue('D2', "Panggilan Siswa");
            $sheet->setCellValue('E2', "Tempat Lahir");
            $sheet->setCellValue('F2', "Tanggal Lahir");
            $sheet->setCellValue('G2', "NISN");
            $sheet->setCellValue('H2', "NIK");
            $sheet->setCellValue('I2', "Kewarganegaraan");
            $sheet->setCellValue('J2', "Agama");
            $sheet->setCellValue('K2', "Alamat");
            $sheet->setCellValue('L2', "Provinsi");
            $sheet->setCellValue('M2', "Kota / Kabupaten");
            $sheet->setCellValue('N2', "Kecamatan");
            $sheet->setCellValue('O2', "Kelurahan");
            $sheet->setCellValue('P2', "Kodepos");
            $sheet->setCellValue('Q2', "RT");
            $sheet->setCellValue('R2', "RW");
            $sheet->setCellValue('S2', "Sekolah");
            $sheet->setCellValue('T2', "Level Pendidikan Siswa");
            $sheet->setCellValue('U2', "Email");
            $sheet->setCellValue('V2', "No Wa Administrasi");
            $sheet->setCellValue('W2', "No WAG Walimurid");
            $sheet->setCellValue('X2', "No WAG Siswa");
            $sheet->setCellValue('Y2', "Status Siswa");
            $sheet->setCellValue('Z2', "Informasi dari");
            $sheet->setCellValue('AA2', "Rekomendasi dari");
            $sheet->setCellValue('AB2', "Nama Ayah");
            $sheet->setCellValue('AC2', "Pekerjaan Ayah");
            $sheet->setCellValue('AD2', "Jenjang Pendidikan Ayah");
            $sheet->setCellValue('AE2', "Penghasilan Ayah");
            $sheet->setCellValue('AF2', "Nama Ibu");
            $sheet->setCellValue('AG2', "Pekerjaan Ibu");
            $sheet->setCellValue('AH2', "Jenjang Pendidikan Ibu");
            $sheet->setCellValue('AI2', "Penghasilan Ibu");
            $sheet->setCellValue('AJ2', "Nama Wali");
            $sheet->setCellValue('AK2', "Pekerjaan Wali");
            $sheet->setCellValue('AL2', "Jenjang Pendidikan Wali");
            $sheet->setCellValue('AM2', "Penghasilan Wali");
            $sheet->setCellValue('AN2', "Kelas");
            $sheet->setCellValue('AO2', "Status Pengisian Data");
            $sheet->setCellValue('AP2', "ID Siswa");
            $sheet->setCellValue('AQ2', "Aksi");
            $sheet->setCellValue('AR2', "Jenis Kelamin");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $sheet->getStyle('A2:AR2')->applyFromArray($style_col);

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
            $sheet->getColumnDimension('P')->setWidth(10); 
            $sheet->getColumnDimension('Q')->setWidth(10); 
            $sheet->getColumnDimension('R')->setWidth(10); 
            $sheet->getColumnDimension('S')->setWidth(30); 
            $sheet->getColumnDimension('T')->setWidth(30); 
            $sheet->getColumnDimension('U')->setWidth(30); 
            $sheet->getColumnDimension('V')->setWidth(30); 
            $sheet->getColumnDimension('W')->setWidth(30); 
            $sheet->getColumnDimension('X')->setWidth(30); 
            $sheet->getColumnDimension('Y')->setWidth(30); 
            $sheet->getColumnDimension('Z')->setWidth(30); 
            $sheet->getColumnDimension('AA')->setWidth(30); 
            $sheet->getColumnDimension('AB')->setWidth(30); 
            $sheet->getColumnDimension('AC')->setWidth(30); 
            $sheet->getColumnDimension('AD')->setWidth(30); 
            $sheet->getColumnDimension('AE')->setWidth(30); 
            $sheet->getColumnDimension('AF')->setWidth(30); 
            $sheet->getColumnDimension('AG')->setWidth(30); 
            $sheet->getColumnDimension('AH')->setWidth(30); 
            $sheet->getColumnDimension('AI')->setWidth(30); 
            $sheet->getColumnDimension('AJ')->setWidth(30); 
            $sheet->getColumnDimension('AK')->setWidth(30); 
            $sheet->getColumnDimension('AL')->setWidth(30); 
            $sheet->getColumnDimension('AM')->setWidth(30); 
            $sheet->getColumnDimension('AN')->setWidth(30); 
            $sheet->getColumnDimension('AO')->setWidth(30); 
            $sheet->getColumnDimension('AP')->setWidth(30); 
            $sheet->getColumnDimension('AQ')->setWidth(30); 
            $sheet->getColumnDimension('AR')->setWidth(30); 

            $sts_data =  $this->request->getUri()->getSegment(3);
            $baris = 3;
            if($sts_data == "semua"){
                $list = $this->model->getAllQ("select * from siswa where keluar = 0 and lulus = 0");
            }else if($sts_data == "belumlengkap"){
                $list = $this->model->getAllQ("select * from siswa where keluar = 0 and lulus = 0 and sts_pengisian = 'Belum Lengkap';");
            }else if($sts_data == "sudahlengkap"){
                $list = $this->model->getAllQ("select * from siswa where keluar = 0 and lulus = 0 and sts_pengisian = 'Sudah Lengkap';");
            }else if($sts_data == "duplikat"){
                $list = $this->model->getAllQ("SELECT * FROM siswa
                    WHERE REPLACE(nama_lengkap, ' ', '') IN (
                        SELECT REPLACE(nama_lengkap, ' ', '') AS nama_tanpa_spasi
                        FROM siswa
                        GROUP BY nama_tanpa_spasi
                        HAVING COUNT(*) > 1
                    ) and keluar = 0 and lulus = 0;");
            }
            foreach ($list->getResult() as $row) {

                $provinsi = $this->model->getAllQR("select * from provinsi where idprovinsi = '".$row->provinsi."'")->nama ?? '';
                $kotkab = $this->model->getAllQR("select * from kabupaten where idkabupaten = '".$row->kabupaten."'")->name ?? '';
                $kecamatan = $this->model->getAllQR("select * from kecamatan where idkecamatan = '".$row->kecamatan."'")->nama ?? '';
                $kelurahan = $this->model->getAllQR("select * from kelurahan where idkelurahan = '".$row->kelurahan."'")->nama ?? '';

                $list2 = $this->model->getAllQ("SELECT a.groupwa, p.tahun_ajar
                    FROM jadwal a, jadwal_siswa b, periode p
                    where a.idjadwal = b.idjadwal and p.idperiode = a.idperiode and b.idsiswa = '" . $row->idsiswa . "'
                    and a.status_archive = 0
                    order by tahun_ajar desc;");
                    $group = '';
                foreach ($list2->getResult() as $rows) {
                    $group .= $rows->groupwa.' ('.$rows->tahun_ajar.')'."\n";
                }

                $sheet->setCellValueExplicit('A' . $baris, $row->no_induk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('B' . $baris, $row->tgl_daftar);
                $sheet->setCellValue('C' . $baris, $row->nama_lengkap);
                $sheet->setCellValue('D' . $baris, $row->panggilan);
                $sheet->setCellValue('E' . $baris, $row->tmp_lahir);
                $sheet->setCellValue('F' . $baris, $row->tgl_lahir);
                // $sheet->setCellValueExplicit('F' . $baris, $row->tlp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('G' . $baris, $row->nisn, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('H' . $baris, $row->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('I' . $baris, $row->kewarganegaraan);
                $sheet->setCellValue('J' . $baris, $row->agama);
                $sheet->setCellValue('K' . $baris, $row->domisili);
                $sheet->setCellValue('L' . $baris, $provinsi);
                $sheet->setCellValue('M' . $baris, $kotkab);
                $sheet->setCellValue('N' . $baris, $kecamatan);
                $sheet->setCellValue('O' . $baris, $kelurahan);
                $sheet->setCellValueExplicit('P' . $baris, $row->kodepos, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('Q' . $baris, $row->rt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('R' . $baris, $row->rw, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('S' . $baris, $row->nama_sekolah);
                $sheet->setCellValue('T' . $baris, $row->level_sekolah);
                $sheet->setCellValue('U' . $baris, $row->email);
                $sheet->setCellValueExplicit('V' . $baris, $row->waadmin, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('W' . $baris, $row->wawalmur, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('X' . $baris, $row->wapeserta, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('Y' . $baris, $row->statussiswa);
                $sheet->setCellValue('Z' . $baris, $row->info);
                $sheet->setCellValue('AA' . $baris, $row->rekomen);
                $sheet->setCellValue('AB' . $baris, $row->nama_ayah);
                $sheet->setCellValue('AC' . $baris, $row->pekerjaan_ayah);
                $sheet->setCellValue('AD' . $baris, $row->jenjang_ayah);
                $sheet->setCellValue('AE' . $baris, $row->penghasilan_ayah);
                $sheet->setCellValue('AF' . $baris, $row->nama_ibu);
                $sheet->setCellValue('AG' . $baris, $row->pekerjaan_ortu);
                $sheet->setCellValue('AH' . $baris, $row->jenjang_ibu);
                $sheet->setCellValue('AI' . $baris, $row->penghasilan_ibu);
                $sheet->setCellValue('AJ' . $baris, $row->nama_wali);
                $sheet->setCellValue('AK' . $baris, $row->pekerjaan_wali);
                $sheet->setCellValue('AL' . $baris, $row->jenjang_wali);
                $sheet->setCellValue('AM' . $baris, $row->penghasilan_wali);
                $sheet->setCellValue('AN' . $baris, $group);
                $sheet->setCellValue('AO' . $baris, $row->sts_pengisian);
                $sheet->setCellValue('AP' . $baris, $row->sts_pengisian);
                $sheet->setCellValue('AQ' . $baris, $row->sts_pengisian);
                $sheet->setCellValue('AP' . $baris, $row->idsiswa);
                $sheet->setCellValue('AQ' . $baris, 'EDIT');
                $sheet->setCellValue('AR' . $baris, $row->jkel);

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
                $sheet->getStyle('R' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('S' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('T' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('U' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('V' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('W' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('X' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('Y' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('Z' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AA' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AB' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AC' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AD' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AE' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AF' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AG' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AH' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AI' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AJ' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AK' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AL' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AM' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AN' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AO' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AP' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AQ' . $baris)->applyFromArray($style_row);
                $sheet->getStyle('AR' . $baris)->applyFromArray($style_row);

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
                $sheet->getStyle('R' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('S' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('T' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('U' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('V' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('W' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('X' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('Y' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('Z' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AA' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AB' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AC' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AD' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AE' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AF' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AG' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AH' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AI' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AJ' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AK' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AL' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AM' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AN' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AO' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AP' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AQ' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('AR' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $sheet->getRowDimension($baris)->setRowHeight(20); // Set height tiap row
                $baris++; // Tambah 1 setiap kali looping
            }

            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $sheet->setTitle("Data Siswa");
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function shownoinduk()
    {
        if (session()->get("logged_karyawan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $tglDaftar = $this->request->getUri()->getSegment(3);
            // ambil depannya saja
            $tglInput = explode("-", $tglDaftar);
            $tahun = $tglInput[0];
            $akhir = $this->autokode("", "no_induk", "siswa", 5, 12, $tahun);
            $noInduk = $tahun . $akhir;
            echo json_encode(array("noinduk" => $noInduk));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function autokode($depan, $kolom, $table, $awal, $akhir, $tahun)
    {
        $hasil = "";
        $data = $this->model->getAllQR("select ifnull(MAX(substr(" . $kolom . "," . $awal . "," . $akhir . ")),0) + 1 as jml from " . $table . " where year(tgl_daftar) = '" . $tahun . "';");
        $panjang = strlen($data->jml);
        $pnjng_nol = ($akhir - $panjang) - $awal;
        $nol = "";
        for ($i = 1; $i <= $pnjng_nol; $i++) {
            $nol .= "0";
        }
        $hasil = $depan . $nol . $data->jml;
        return $hasil;
    }

    public function keluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data = array(
                'idsiswa_keluar' => $this->model->autokode("K", "idsiswa_keluar", "siswa_keluar", 2, 7),
                'idsiswa' => $this->request->getPost('idsiswa'),
                'alasan' => $this->request->getPost('alasan'),
                'tanggal' => $this->modul->TanggalSekarang()
            );
            $simpan = $this->model->add("siswa_keluar", $data);
            $data_tag = explode(",", $this->request->getPost('tag'));
            for ($i = 0; $i < count($data_tag); $i++) {
                if ($data_tag[$i] != "") {
                    $datap = array(
                        'idstag' => $this->model->autokode("S", "idstag", "siswa_keluar_tag", 2, 7),
                        'idsiswa' => $this->request->getPost('idsiswa'),
                        'idtag' => $data_tag[$i]
                    );
                    $this->model->add("siswa_keluar_tag", $datap);
                }
            }
            if ($simpan == 1) {
                // ubah status keluar mahasiswa
                $data1 = array(
                    'keluar' => "1"
                );
                $kond['idsiswa'] = $this->request->getPost('idsiswa');
                $update = $this->model->update("siswa", $data1, $kond);
                if ($update == 1) {
                    $status = "Data siswa keluar berhasil tersimpan";
                } else {
                    $status = "Data siswa keluar gagal tersimpan";
                }
            } else {
                $status = "Data siswa keluar gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function listkeluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
                }
            }

            $data['pro'] = $pro;
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

            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['provinsi'] = $this->model->getAll("provinsi");
            $data['mitra'] = $this->model->getAll("mitra");

            echo view('back/head', $data);
            if (session()->get("logged_pendidikan")) {
                echo view('back/akademik/menu');
            } else if (session()->get("logged_hr")) {
                echo view('back/hrd/menu');
            } else if (session()->get("logged_siswa")) {
                echo view('back/siswa/menu');
            }else if (session()->get("logged_siswa")) {
                echo view('back/siswa/menu');
            }
            echo view('back/akademik/siswa/siswa_keluar');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlistkeluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $no = 1;

            $data = array();
            $list = $this->model->getAllQ("select *, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f from siswa where keluar = 1;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->no_induk;
                $val[] = '<b>Nama : </b>' . $row->nama_lengkap . ' (' . $row->panggilan . ')
                    <br><b>Tgl Daftar : </b>' . $row->tgl_daftar_f . '
                    <br><b>Jkel : </b>' . $row->jkel . '
                    <br><b>Sekolah : </b>' . $row->nama_sekolah . ' (' . $row->level_sekolah . ')
                    <br><b>TTL : </b>' . $row->tmp_lahir . ', ' . $row->tgl_lahir_f . '
                    <br><b>Domisili : </b>' . $row->domisili;
                $val[] = $row->nama_ortu . '<br><b>Pekerjaan : </b>' . $row->pekerjaan_ortu;
                // alasan keluar
                $tb = '<table>';
                $list1 = $this->model->getAllQ("select alasan, date_format(tanggal, '%d %M %Y') as tgl from siswa_keluar where idsiswa = '" . $row->idsiswa . "';");
                foreach ($list1->getResult() as $row1) {
                    $tb .= '<tr>';
                    $tb .= '<td>' . $row1->alasan . '</td>';
                    $tb .= '<td>' . $row1->tgl . '</td>';
                    $tb .= '<tr>';
                }
                $tb .= '</table>';
                $jml = $this->model->getAllQR("select count(*) as jml from siswa_keluar_tag where idsiswa = '" . $row->idsiswa . "'")->jml;
                if ($jml > 0) {
                    $tb .= '<br> <b>Tag Alasan Keluar : </b><ul>';
                    $tag = $this->model->getAllQ("select tag from siswa_keluar_tag s, tag_keluar t where s.idtag = t.idtag and idsiswa = '" . $row->idsiswa . "'");
                    foreach ($tag->getResult() as $row2) {
                        $tb .= '<li>' . $row2->tag . '</li>';
                    }
                    $tb .= '</ul>';
                }
                $val[] = $tb;

                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" title="Edit Data" class="btn btn-sm btn-primary" onclick="ganti(' . "'" . $row->idsiswa . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" title="Batalkan Keluar" class="btn btn-sm btn-success" onclick="batalkan(' . "'" . $row->idsiswa . "'" . ',' . "'" . $row->nama_lengkap . "'" . ')"><i class="feather icon-log-in"></i></button>'
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

    public function batalkeluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data = array(
                'keluar' => "0"
            );
            $kond['idsiswa'] = $this->request->getUri()->getSegment(3);
            $update = $this->model->update("siswa", $data, $kond);
            if ($update == 1) {
                $status = "Data siswa keluar dibatalkan";
            } else {
                $status = "Data siswa keluar gagal dibatalkan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function cetakkeluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data['logo'] = "images/logoreport.jpg";
            $data['curdate'] = $this->modul->TanggalWaktu();

            $str = '';
            $no = 1;
            $list = $this->model->getAllQ("select *, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f from siswa where keluar = 1;");
            foreach ($list->getResult() as $row) {
                $str .= '<tr>';
                $str .= '<td style="text-align: left; vertical-align: middle; padding:5px;">' . $no . '</td>';
                $str .= '<td style="text-align: left; vertical-align: middle; padding:5px;">' . $row->no_induk . '</td>';
                $str .= '<td style="text-align: left; vertical-align: middle; padding:5px;"><b>Nama : </b>' . $row->nama_lengkap . ' (' . $row->panggilan . ')
                    <br><b>Tgl Daftar : </b>' . $row->tgl_daftar_f . '
                    <br><b>Jkel : </b>' . $row->jkel . '
                    <br><b>Sekolah : </b>' . $row->nama_sekolah . ' (' . $row->level_sekolah . ')
                    <br><b>TTL : </b>' . $row->tmp_lahir . ', ' . $row->tgl_lahir_f . '
                    <br><b>Domisili : </b>' . $row->domisili . '</td>';
                $str .= '<td style="text-align: left; vertical-align: middle; padding:5px;">' . $row->nama_ortu . '<br><b>Pekerjaan : </b>' . $row->pekerjaan_ortu . '</td>';
                // alasan keluar
                $sub1 = '<table>';
                $list1 = $this->model->getAllQ("select alasan, date_format(tanggal, '%d %M %Y') as tgl from siswa_keluar where idsiswa = '" . $row->idsiswa . "';");
                foreach ($list1->getResult() as $row1) {
                    $sub1 .= '<tr>';
                    $sub1 .= '<td>' . $row1->alasan . '</td>';
                    $sub1 .= '<td>' . $row1->tgl . '</td>';
                    $sub1 .= '<tr>';
                }
                $sub1 .= '</table>';

                $jml = $this->model->getAllQR("select count(*) as jml from siswa_keluar_tag where idsiswa = '" . $row->idsiswa . "'")->jml;
                if ($jml > 0) {
                    $sub1 .= '<br> <b>Tag Alasan Keluar : </b><ul>';
                    $tag = $this->model->getAllQ("select tag from siswa_keluar_tag s, tag_keluar t where s.idtag = t.idtag and idsiswa = '" . $row->idsiswa . "'");
                    foreach ($tag->getResult() as $row2) {
                        $sub1 .= '<li>' . $row2->tag . '</li>';
                    }
                    $sub1 .= '</ul>';
                }
                $str .= '<td style="text-align: left; vertical-align: middle; padding:5px;">' . $sub1 . '</td>';
                $str .= '</tr>';

                $no++;
            }

            $data['isitable'] = $str;

            $options = new Options();
            $options->setChroot(FCPATH);

            $dompdf = new Dompdf();
            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('back/akademik/siswa/pdf_siswa_keluar', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'Siswa Keluar.pdf';

            $this->response->setContentType('application/pdf');
            //$dompdf->stream($filename); // download
            $dompdf->stream($filename, array("Attachment" => 0)); // nempel
        } else {
            $this->modul->halaman('login');
        }
    }

    public function exportsiswakeluar()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {

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

            $judul = "Siswa Keluar";
            $nama_file = "siswa_keluar";

            $sheet->setCellValue('A1', $judul); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai F1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            $sheet->getStyle('A1')->getFont()->setSize(12); // Set font size 12 untuk kolom A1

            $sheet->setCellValue('A2', 'NO');
            $sheet->getStyle('A2')->applyFromArray($style_col);
            $sheet->getColumnDimension('A')->setWidth(10);

            $sheet->setCellValue('B2', 'NO INDUK');
            $sheet->getStyle('B2')->applyFromArray($style_col);
            $sheet->getColumnDimension('B')->setWidth(15);

            $sheet->setCellValue('C2', 'SISWA');
            $sheet->getStyle('C2')->applyFromArray($style_col);
            $sheet->getColumnDimension('C')->setWidth(40);

            $sheet->setCellValue('D2', 'PANGGILAN');
            $sheet->getStyle('D2')->applyFromArray($style_col);
            $sheet->getColumnDimension('D')->setWidth(25);

            $sheet->setCellValue('E2', 'TGL DAFTAR');
            $sheet->getStyle('E2')->applyFromArray($style_col);
            $sheet->getColumnDimension('E')->setWidth(15);

            $sheet->setCellValue('F2', 'JKEL');
            $sheet->getStyle('F2')->applyFromArray($style_col);
            $sheet->getColumnDimension('F')->setWidth(15);

            $sheet->setCellValue('G2', 'ORTU');
            $sheet->getStyle('G2')->applyFromArray($style_col);
            $sheet->getColumnDimension('G')->setWidth(25);

            $sheet->setCellValue('H2', 'PEKERJAAN');
            $sheet->getStyle('H2')->applyFromArray($style_col);
            $sheet->getColumnDimension('H')->setWidth(25);

            $sheet->setCellValue('I2', 'ALASAN');
            $sheet->getStyle('I2')->applyFromArray($style_col);
            $sheet->getColumnDimension('I')->setWidth(105);

            $baris = 3;
            $no = 1;
            $list = $this->model->getAllQ("select *, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, date_format(tgl_lahir, '%d %M %Y') as tgl_lahir_f from siswa where keluar = 1;");
            foreach ($list->getResult() as $row) {

                $alasan = '';
                $list1 = $this->model->getAllQ("select alasan, date_format(tanggal, '%d %M %Y') as tgl from siswa_keluar where idsiswa = '" . $row->idsiswa . "';");
                foreach ($list1->getResult() as $row1) {
                    $alasan .= $row1->alasan;
                }

                $sheet->setCellValueExplicit('A' . $baris, $no, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('B' . $baris, $row->no_induk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C' . $baris, $row->nama_lengkap, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D' . $baris, $row->panggilan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E' . $baris, $row->tgl_daftar_f, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('F' . $baris, $row->jkel, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('G' . $baris, $row->nama_ortu, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('H' . $baris, $row->pekerjaan_ortu, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('I' . $baris, $alasan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

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

                $sheet->getStyle('A' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('D' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('F' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('G' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('H' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('I' . $baris)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $sheet->getRowDimension($baris)->setRowHeight(20); // Set height tiap row
                $baris++; // Tambah 1 setiap kali looping
                $no++;
            }

            // Set orientasi kertas jadi LANDSCAPE
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $sheet->setTitle("Siswa Keluar");
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

    public function buatlulus()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwalsiswa = $this->request->getUri()->getSegment(4);

            $data = array(
                'is_lulus' => "1"
            );
            $kond['idsiswa'] = $idsiswa;
            $kond['idjadwal_siswa'] = $idjadwalsiswa;
            $update = $this->model->update("jadwal_siswa", $data, $kond);
            if ($update == 1) {
                $status = "Siswa dinyatakan lulus";
            } else {
                $status = "Siswa gagal dinyatakan lulus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function batallulus()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwalsiswa = $this->request->getUri()->getSegment(4);

            $data = array(
                'is_lulus' => "0"
            );
            $kond['idsiswa'] = $idsiswa;
            $kond['idjadwal_siswa'] = $idjadwalsiswa;
            $update = $this->model->update("jadwal_siswa", $data, $kond);
            if ($update == 1) {
                $status = "Siswa dibatalkan lulus";
            } else {
                $status = "Siswa gagal dibatalkan lulus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function nonaktif()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwalsiswa = $this->request->getUri()->getSegment(4);

            $data = array(
                'is_keluar' => "1",
                'tgl_keluar' => $this->modul->TanggalWaktu(),
            );
            $kond['idsiswa'] = $idsiswa;
            $kond['idjadwal_siswa'] = $idjadwalsiswa;
            $update = $this->model->update("jadwal_siswa", $data, $kond);
            if ($update == 1) {
                $status = "Siswa berhasil dinonaktifkan";
            } else {
                $status = "Siswa gagal dinonaktifkan ";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function aktifkan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idsiswa = $this->request->getUri()->getSegment(3);
            $idjadwalsiswa = $this->request->getUri()->getSegment(4);

            $data = array(
                'is_keluar' => "0",
                'tgl_aktif' => $this->modul->TanggalWaktu(),
            );
            $kond['idsiswa'] = $idsiswa;
            $kond['idjadwal_siswa'] = $idjadwalsiswa;
            $update = $this->model->update("jadwal_siswa", $data, $kond);
            if ($update == 1) {
                $status = "Siswa berhasil diaktifkan kembali";
            } else {
                $status = "Siswa gagal diaktifkan ";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_jadwal_lulus()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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
                    . '<button type="button" title="Ganti Jadwal" class="btn btn-sm btn-info" onclick="pilih_jadwal_lulus(' . "'" . $row->idjadwal . "'" . ',' . "'" . $row->groupwa . "'" . ')">Pilih</button>'
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

    public function ajaxlist_alumni()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $idjdwal = $this->request->getUri()->getSegment(3);

            $query = "select b.idjadwal, b.idsiswa from jadwal a, jadwal_siswa b where a.idjadwal = b.idjadwal and b.is_lulus = 1;";
            if (strlen($idjdwal) > 0) {
                $query = "select b.idjadwal, b.idsiswa from jadwal a, jadwal_siswa b where a.idjadwal = b.idjadwal and b.is_lulus = 1 and b.idjadwal = '" . $idjdwal . "';";
            }

            $data = array();
            $list = $this->model->getAllQ($query);
            foreach ($list->getResult() as $row) {
                // mencari jadwal
                $jadwal = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, a.mode_belajar, a.tempat, f.meeting_id, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar
                from jadwal a, sesi e, zoom f, level g, periode h, pendidikankursus i
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idsesi = e.idsesi and a.idpendkursus = i.idpendkursus and a.idjadwal = '" . $row->idjadwal . "';");

                // mencari data siswa
                $siswa = $this->model->getAllQR("select no_induk, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, nama_lengkap, panggilan, jkel, nama_sekolah, 
                level_sekolah, tmp_lahir, date_format(tgl_lahir, '%d %M %Y') as tglf, nama_ortu, pekerjaan_ortu, domisili  
                from siswa where idsiswa = '" . $row->idsiswa . "';");

                $val = array();
                $val[] = '<b>Rombel : </b>' . $jadwal->groupwa . '
                    <br><b>Kursus : </b>' . $jadwal->nama_kursus .
                    '<br><b>Level : </b>' . $jadwal->level .
                    '<br><b>Sesi : </b>' . $jadwal->nama_sesi;

                $val[] = '<b>No Induk : </b>' . $siswa->no_induk . '<br><b>Nama : </b>' . $siswa->nama_lengkap . ' (' . $siswa->panggilan . ')
                    <br><b>Tgl Daftar : </b>' . $siswa->tgl_daftar_f . '
                    <br><b>Jkel : </b>' . $siswa->jkel . '
                    <br><b>Sekolah : </b>' . $siswa->nama_sekolah . ' (' . $siswa->level_sekolah . ')
                    <br><b>TTL : </b>' . $siswa->tmp_lahir . ', ' . $siswa->tglf . '
                    <br><b>Domisili : </b>' . $siswa->domisili;
                $val[] = $siswa->nama_ortu . '<br><b>Pekerjaan : </b>' . $siswa->pekerjaan_ortu;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" title="Edit Data" class="btn btn-sm btn-primary" onclick="ganti(' . "'" . $row->idsiswa . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function cetakalumni()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
            $data['logo'] = "images/logoreport.jpg";
            $data['curdate'] = $this->modul->TanggalWaktu();

            $idjdwal = "";
            $str = '';
            $query = "select b.idjadwal, b.idsiswa from jadwal a, jadwal_siswa b where a.idjadwal = b.idjadwal and b.is_lulus = 1;";
            if (strlen($idjdwal) > 0) {
                $query = "select b.idjadwal, b.idsiswa from jadwal a, jadwal_siswa b where a.idjadwal = b.idjadwal and b.is_lulus = 1 and b.idjadwal = '" . $idjdwal . "';";
            }

            $list = $this->model->getAllQ($query);
            foreach ($list->getResult() as $row) {
                $str .= '<tr>';

                // mencari jadwal
                $jadwal = $this->model->getAllQR("select a.idjadwal, a.groupwa, a.idpendkursus, i.nama_kursus, a.mode_belajar, a.tempat, f.meeting_id, g.level, e.nama_sesi, e.waktu_awal, e.waktu_akhir, a.hari, h.tahun_ajar
                from jadwal a, sesi e, zoom f, level g, periode h, pendidikankursus i
                where a.idlevel = g.idlevel and a.idzoom = f.idzoom and a.idperiode = h.idperiode and a.idsesi = e.idsesi and a.idpendkursus = i.idpendkursus and a.idjadwal = '" . $row->idjadwal . "';");

                // mencari data siswa
                $siswa = $this->model->getAllQR("select no_induk, date_format(tgl_daftar, '%d %M %Y') as tgl_daftar_f, nama_lengkap, panggilan, jkel, nama_sekolah, 
                level_sekolah, tmp_lahir, date_format(tgl_lahir, '%d %M %Y') as tglf, nama_ortu, pekerjaan_ortu, domisili  
                from siswa where idsiswa = '" . $row->idsiswa . "';");

                $str .= '<td>';
                $str .= '<b>Rombel : </b>' . $jadwal->groupwa . '
                    <br><b>Kursus : </b>' . $jadwal->nama_kursus .
                    '<br><b>Level : </b>' . $jadwal->level .
                    '<br><b>Sesi : </b>' . $jadwal->nama_sesi;
                $str .= '</td>';

                $str .= '<td>';
                $str .= '<b>No Induk : </b>' . $siswa->no_induk . '<br><b>Nama : </b>' . $siswa->nama_lengkap . ' (' . $siswa->panggilan . ')
                    <br><b>Tgl Daftar : </b>' . $siswa->tgl_daftar_f . '
                    <br><b>Jkel : </b>' . $siswa->jkel . '
                    <br><b>Sekolah : </b>' . $siswa->nama_sekolah . ' (' . $siswa->level_sekolah . ')
                    <br><b>TTL : </b>' . $siswa->tmp_lahir . ', ' . $siswa->tglf . '
                    <br><b>Domisili : </b>' . $siswa->domisili;
                $str .= '</td>';

                $str .= '<td>';
                $str .= $siswa->nama_ortu . '<br><b>Pekerjaan : </b>' . $siswa->pekerjaan_ortu;
                $str .= '</td>';

                $str .= '</tr>';
            }


            $data['isitable'] = $str;

            $options = new Options();
            $options->setChroot(FCPATH);

            $dompdf = new Dompdf();
            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('back/akademik/siswa/pdf_alumni', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'Alumni.pdf';

            $this->response->setContentType('application/pdf');
            //$dompdf->stream($filename); // download
            $dompdf->stream($filename, array("Attachment" => 0)); // nempel
        } else {
            $this->modul->halaman('login');
        }
    }

    public function editing()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

            $data['curdate'] = $this->modul->TanggalSekarang();
            $idsiswa = $this->request->getUri()->getSegment(3);
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                $data['siswaall'] = $this->model->getAllQ("select * from siswa where keluar = 0 and lulus = 0 order by nama_lengkap;");
                $data['siswa'] = $this->model->getAllQR("select * from siswa where idsiswa = '" . $idsiswa . "';");
                $data['sesi'] = $this->model->getAll("sesi");
                $data['mitra'] = $this->model->getAll("mitra");
                $data['provinsi'] = $this->model->getAllQ("select * from provinsi order by nama");

                echo view('back/head', $data);
                if (session()->get("logged_bos")) {
                    echo view('back/bos/menu');
                } else if (session()->get("logged_pendidikan")) {
                    echo view('back/akademik/menu');
                } else if (session()->get("logged_hr")) {
                    echo view('back/hrd/menu');
                }else if (session()->get("logged_siswa")) {
                    echo view('back/siswa/menu');
                }
                echo view('back/akademik/siswa/editing');
                echo view('back/foot');
            } else {
                $this->modul->halaman('siswa');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function histori()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr") || session()->get("logged_siswa")) {
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

            $data['curdate'] = $this->modul->TanggalSekarang();
            $idsiswa = $this->request->getUri()->getSegment(3);
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                $data['siswaall'] = $this->model->getAllQ("select * from siswa where keluar = 0 and lulus = 0 order by nama_lengkap;");
                $data['siswa'] = $this->model->getAllQR("select * from siswa where idsiswa = '" . $idsiswa . "';");
                $data['idsiswa'] = $idsiswa;

                echo view('back/head', $data);
                if (session()->get("logged_bos")) {
                    echo view('back/bos/menu');
                } else if (session()->get("logged_pendidikan")) {
                    echo view('back/akademik/menu');
                } else if (session()->get("logged_hr")) {
                    echo view('back/hrd/menu');
                }else if (session()->get("logged_siswa")) {
                    echo view('back/siswa/menu');
                }
                echo view('back/akademik/siswa/history');
                echo view('back/foot');
            } else {
                $this->modul->halaman('siswa');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses_siswa()
    {
        $idsiswa = $this->request->getPost('idsiswa');
       
        if (strlen($idsiswa) > 0) {
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                if (isset($_FILES['file']['name'])) {
                    if(0 < $_FILES['file']['error']) {
                        $status = "Error during file upload ".$_FILES['file']['error'];
                    }else{
                        $status = $this->update_file();
                    }
                }else{
                    $status = $this->updateSiswa1();
                }
            } 
            echo json_encode(array("status" => $status,'id'=> $this->modul->enkrip_url($this->request->getPost('idsiswa'))));
        } else {
            $this->modul->halaman('registrasiulang/form/' . $idsiswa);
        }
    }

    private function updateSiswa1()
    {
        $data = array(
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tmp_lahir' => $this->request->getPost('tmp_lahir'),
            'panggilan' => $this->request->getPost('panggilan'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'nisn' => $this->request->getPost('nisn'),
            'jkel' => $this->request->getPost('jkel'),
            'nama_sekolah' => $this->request->getPost('sekolah'),
            'nik' => $this->request->getPost('nik'),
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'agama' => $this->request->getPost('agama'),
            'provinsi' => $this->request->getPost('provinsi'),
            'domisili' => $this->request->getPost('domisili'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'kabupaten' => $this->request->getPost('kabupaten'),
            'kelurahan' => $this->request->getPost('kelurahan'),
            'kodepos' => $this->request->getPost('kodepos'),
            'rt' => $this->request->getPost('rt'),
            'rw' => $this->request->getPost('rw'),
            'statussiswa' => $this->request->getPost('status'),
            'info' => $this->request->getPost('info'),
            'level_sekolah' => $this->request->getPost('level_pendidikan'),
            'rekomen' => $this->request->getPost('rekomen'),
            'idmitra' => $this->request->getPost('idmitra'),
        );
        $kond['idsiswa'] = $this->request->getPost('idsiswa');
        $simpan = $this->model->update("siswa", $data, $kond);
        if ($simpan == 1) {
            $status = "ok";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }

    private function update_file() {
        $idsiswa = $this->request->getPost('idsiswa');
        $lawas = $this->model->getAllQR("SELECT bukti FROM siswa where idsiswa = '".$idsiswa."';")->bukti;
        if(strlen($lawas) > 0){
            if(file_exists($this->modul->getPathApp().$lawas)){
                unlink($this->modul->getPathApp().$lawas);
            }
        }
            
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        
        $extFile = $info_file['ext'];
        if($extFile == "jpg" || $extFile == "jpeg" || $extFile == "png" || $extFile == "pdf"){
            if(file_exists($this->modul->getPathApp().'/'.$fileName)){
                $status = "Gunakan nama file lain";
            }else{
                $status_upload = $file->move($this->modul->getPathApp(), $fileName);
                if($status_upload){
                    $data = array(
                        'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                        'tmp_lahir' => $this->request->getPost('tmp_lahir'),
                        'panggilan' => $this->request->getPost('panggilan'),
                        'tgl_lahir' => $this->request->getPost('tgl_lahir'),
                        'nisn' => $this->request->getPost('nisn'),
                        'jkel' => $this->request->getPost('jkel'),
                        'nama_sekolah' => $this->request->getPost('sekolah'),
                        'nik' => $this->request->getPost('nik'),
                        'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
                        'agama' => $this->request->getPost('agama'),
                        'provinsi' => $this->request->getPost('provinsi'),
                        'domisili' => $this->request->getPost('domisili'),
                        'kecamatan' => $this->request->getPost('kecamatan'),
                        'kabupaten' => $this->request->getPost('kabupaten'),
                        'kelurahan' => $this->request->getPost('kelurahan'),
                        'kodepos' => $this->request->getPost('kodepos'),
                        'rt' => $this->request->getPost('rt'),
                        'rw' => $this->request->getPost('rw'),
                        'statussiswa' => $this->request->getPost('status'),
                        'info' => $this->request->getPost('info'),
                        'level_sekolah' => $this->request->getPost('level_pendidikan'),
                        'rekomen' => $this->request->getPost('rekomen'),
                        'idmitra' => $this->request->getPost('idmitra'),
                        'bukti' => $fileName
                    );
                    $kond['idsiswa'] = $this->request->getPost('idsiswa');
                    $simpan = $this->model->update("siswa", $data, $kond);
                    if ($simpan == 1) {
                        $status = "ok";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                }else{
                    $status = "File gagal terupload";
                }
            }
        }else{
            $status = "Tidak diperkenankan upload file";
        }
        return $status;
    }
}
