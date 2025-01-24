<?php

namespace App\Controllers;

/**
 * Description of Levelenglish
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Level extends BaseController
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

            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            $data['pro'] = $pro;
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
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
            echo view('back/akademik/menu');
            echo view('back/akademik/level/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from pendidikankursus;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_kursus;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="ganti(' . "'" . $row->idpendkursus . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idpendkursus . "'" . ',' . "'" . $row->nama_kursus . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="level(' . "'" . $this->modul->enkrip_url($row->idpendkursus) . "'" . ')">Level</button>'
                    . '<button type="button" class="btn btn-sm btn-warning" onclick="rapor(' . "'" . $this->modul->enkrip_url($row->idpendkursus) . "'" . ')"><i class="lnr lnr-license"></i> Format Rapor</button>'
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

    public function ajax_add_kursus()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idpendkursus' => $this->model->autokode("K", "idpendkursus", "pendidikankursus", 2, 7),
                'nama_kursus' => $this->request->getPost('nama'),
                'keterangan' => $this->request->getPost('keterangan')
            );
            $simpan = $this->model->add("pendidikankursus", $data);
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

    public function show_kursus()
    {
        if (session()->get("logged_pendidikan")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from pendidikankursus where idpendkursus = '" . $kode . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_kursus()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'nama_kursus' => $this->request->getPost('nama'),
                'keterangan' => $this->request->getPost('keterangan')
            );
            $kond['idpendkursus'] = $this->request->getPost('kode');
            $update = $this->model->update("pendidikankursus", $data, $kond);
            if ($update == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapuskursus()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idpendkursus'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("pendidikankursus", $kond);
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

    public function detillevel()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            $data['pro'] = $pro;
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
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

            $idkursus = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM pendidikankursus where idpendkursus = '" . $idkursus . "';")->jml;
            if ($cek > 0) {
                $head = $this->model->getAllQR("SELECT * FROM pendidikankursus where idpendkursus = '" . $idkursus . "';");
                $data['head'] = $head;

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/level/level');
                echo view('back/foot');
            } else {
                $this->modul->halaman('login');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlevel()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select * from level where idpendkursus = '" . $idpendkursus . "' order by tingkatan;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->level;
                $val[] = $row->tingkatan;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="ganti(' . "'" . $row->idlevel . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idlevel . "'" . ',' . "'" . $row->level . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="paramnilai(' . "'" . $this->modul->enkrip_url($idpendkursus) . "'" . ',' . "'" . $this->modul->enkrip_url($row->idlevel) . "'" . ')">Parameter Penilaian</button>'
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

    public function ajax_add_level()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idlevel' => $this->model->autokode("L", "idlevel", "level", 2, 7),
                'level' => $this->request->getPost('level'),
                'idpendkursus' => $this->request->getPost('idpendkursus'),
                'tingkatan' => $this->request->getPost('tingkatan')
            );
            $simpan = $this->model->add("level", $data);
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

    public function showlevel()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idlevel'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("level", $kond);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_level()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'level' => $this->request->getPost('level'),
                'tingkatan' => $this->request->getPost('tingkatan')
            );
            $kond['idlevel'] = $this->request->getPost('kode');
            $simpan = $this->model->update("level", $data, $kond);
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

    public function hapus()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idlevel'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("level", $kond);
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

    public function parameternilai()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            $data['pro'] = $pro;
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
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

            $idkursus_enkrip = $this->request->getUri()->getSegment(3);
            $idlevel_enkrip = $this->request->getUri()->getSegment(4);

            $data['idkursus_enkrip'] = $idkursus_enkrip;
            $data['idlevel_enkrip'] = $idlevel_enkrip;

            $idkursus = $this->modul->dekrip_url($idkursus_enkrip);
            $idlevel = $this->modul->dekrip_url($idlevel_enkrip);
            $cek1 = $this->model->getAllQR("SELECT count(*) as jml FROM pendidikankursus where idpendkursus = '" . $idkursus . "';")->jml;
            $cek2 = $this->model->getAllQR("SELECT count(*) as jml FROM level where idlevel = '" . $idlevel . "';")->jml;

            if ($cek1 > 0 && $cek2 > 0) {
                $head1 = $this->model->getAllQR("SELECT * FROM pendidikankursus where idpendkursus = '" . $idkursus . "';");
                $head2 = $this->model->getAllQR("SELECT * FROM level where idlevel = '" . $idlevel . "';");

                $data['head1'] = $head1;
                $data['head2'] = $head2;

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/level/parameter');
                echo view('back/foot');
            } else {
                $this->modul->halaman('login');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxparameter()
    {
        if (session()->get("logged_pendidikan")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select * from parameter_nilai where idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->parameter;
                if ($row->isnumber == "0") {
                    $val[] = "Tidak";
                } else {
                    $val[] = "Ya";
                }
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="ganti(' . "'" . $row->idp_nilai . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idp_nilai . "'" . ',' . "'" . $row->parameter . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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

    public function ajax_add_param()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idp_nilai' => $this->model->autokode("P", "idp_nilai", "parameter_nilai", 2, 7),
                'idlevel' => $this->request->getPost('idlevel'),
                'parameter' => $this->request->getPost('parameter'),
                'isnumber' => $this->request->getPost('filterInput')
            );
            $simpan = $this->model->add("parameter_nilai", $data);
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

    public function showparameter()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idp_nilai'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("parameter_nilai", $kond);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_param()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'parameter' => $this->request->getPost('parameter'),
                'isnumber' => $this->request->getPost('filterInput')
            );
            $kond['idp_nilai'] = $this->request->getPost('kode');
            $update = $this->model->update("parameter_nilai", $data, $kond);
            if ($update == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapusparameter()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idp_nilai'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("parameter_nilai", $kond);
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

    public function ajaxloadduplikasi()
    {
        if (session()->get("logged_pendidikan")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("select distinct a.idlevel, a.level from level a, parameter_nilai b where a.idlevel = b.idlevel and a.idlevel <> '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->level;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="pilih_duplikasi(' . "'" . $row->idlevel . "'" . ',' . "'" . $idlevel . "'" . ')">Pilih</button>'
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

    public function duplikasi()
    {
        if (session()->get("logged_pendidikan")) {
            // membaca data sumber
            $idlevel_sumber = $this->request->getPost('idlevel_sumber');
            $idlevel_tujuan = $this->request->getPost('idlevel_tujuan');

            $kond['idlevel'] = $idlevel_tujuan;
            $this->model->delete("parameter_nilai", $kond);

            $list = $this->model->getAllQ("select parameter, isnumber from parameter_nilai where idlevel = '" . $idlevel_sumber . "';");
            foreach ($list->getResult() as $row) {
                $data = array(
                    'idp_nilai' => $this->model->autokode("P", "idp_nilai", "parameter_nilai", 2, 7),
                    'idlevel' => $idlevel_tujuan,
                    'parameter' => $row->parameter,
                    'isnumber' => $row->isnumber
                );
                $this->model->add("parameter_nilai", $data);
            }
            $status = "Data berhasil diduplikasi";
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function backnext()
    {
        if (session()->get("logged_pendidikan")) {
            $idlevel = $this->modul->dekrip_url($this->request->getPost('idlevel'));
            $idpendkursus = $this->modul->dekrip_url($this->request->getPost('idpendkursus'));
            $mode = $this->request->getPost('mode');

            // mencari min dan max
            $min_max = $this->model->getAllQR("select min(tingkatan) as minimal, max(tingkatan) as maksimal from level where idpendkursus = '" . $idpendkursus . "';");
            $min = $min_max->minimal;
            $max = $min_max->maksimal;

            // mencari posisi level
            $cur_pos = $this->model->getAllQR("select tingkatan from level where idlevel = '" . $idlevel . "';")->tingkatan;

            $idpendkursus_param = "";
            $idlevel_param = "";

            if ($mode == "kembali") {
                $index = $cur_pos - 1;
                if ($index < $min) {
                    $status = "Batas minimal level";
                } else {
                    // mencari id level tujuan
                    $idlevel_tujuan = $this->model->getAllQR("select idlevel from level where tingkatan = '" . $index . "' and idpendkursus = '" . $idpendkursus . "';")->idlevel;

                    $status = "ok";
                    $idpendkursus_param = $this->modul->enkrip_url($idpendkursus);
                    $idlevel_param = $this->modul->enkrip_url($idlevel_tujuan);
                }
            } else if ($mode == "lanjut") {
                $index = $cur_pos + 1;
                if ($index > $max) {
                    $status = "Batas maksimal level";
                } else {
                    // mencari id level tujuan
                    $idlevel_tujuan = $this->model->getAllQR("select idlevel from level where tingkatan = '" . $index . "' and idpendkursus = '" . $idpendkursus . "';")->idlevel;

                    $status = "ok";
                    $idpendkursus_param = $this->modul->enkrip_url($idpendkursus);
                    $idlevel_param = $this->modul->enkrip_url($idlevel_tujuan);
                }
            }


            echo json_encode(array("status" => $status, "idpendkursus" => $idpendkursus_param, "idlevel" => $idlevel_param));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function formatrapor()
    {
        if (session()->get("logged_pendidikan")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca profile orang tersebut
            $def_foto = base_url() . '/images/noimg.jpg';

            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            $data['pro'] = $pro;
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
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

            $idpendkursus = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek_pendidikan = $this->model->getAllQR("select count(*) as jml from pendidikankursus where idpendkursus = '" . $idpendkursus . "';")->jml;
            if ($cek_pendidikan > 0) {
                $head = $this->model->getAllQR("select * from pendidikankursus where idpendkursus = '" . $idpendkursus . "';");
                $data['head'] = $head;

                // def template
                $data['deftemplate'] = base_url() . '/images/template_rapor.jpg';

                echo view('back/head', $data);
                echo view('back/akademik/menu');
                echo view('back/akademik/format_rapor/index');
                echo view('back/foot');
            } else {
                $this->modul->halaman('login');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxformat()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            // $idpendkursus = "K00003";

            $table = '<table class="datatables-demo table table-striped table-bordered">
                        <tbody>';
            $list = $this->model->getAllQ("SELECT idformat_rapor, title FROM format_rapor where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {

                $table .= '<tr>';
                $table .= '<td colspan="4"><b style="font-size: 16px;">' . $row->title . '</b></td>';
                $table .= '<td><div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-success" onclick="ganti(' . "'" . $row->idformat_rapor . "'" . ')"> Ganti </button>'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')"> Hapus </button>'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="display_level(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')">Level Kursus</button>'
                    . '<button type="button" class="btn btn-sm btn-info" onclick="subdetail(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')">Sub Detail</button>'
                    . '</div></div></td>';
                $table .= '</tr>';

                $list1 = $this->model->getAllQ("SELECT a.idlevel, b.level FROM format_raport_level a, level b where a.idlevel = b.idlevel and a.idformat_rapor = '" . $row->idformat_rapor . "' and a.idpendkursus = '" . $idpendkursus . "';");
                foreach ($list1->getResult() as $row1) {
                    $table .= '<tr>';
                    $table .= '<td></td>';
                    $table .= '<td colspan="4"><b>' . $row1->level . '</b></td>';
                    $table .= '</tr>';

                    $list2 = $this->model->getAllQ("SELECT idformat_rd, subtitle FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';");
                    foreach ($list2->getResult() as $row2) {
                        $table .= '<tr>';
                        $table .= '<td></td>';
                        $table .= '<td></td>';
                        $table .= '<td>' . $row2->subtitle . '</td>';
                        $table .= '<td><button type="button" class="btn btn-sm btn-info" onclick="rumusdetil(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row2->idformat_rd . "'" . ', ' . "'" . $row2->subtitle . "'" . ', ' . "'" . $row1->idlevel . "'" . ')"> Rumus </button></td>';

                        // harus di cek dia level apa
                        $rumus = '';
                        $list3 = $this->model->getAllQ("SELECT param_operator FROM format_rapor_detil_rumus where idformat_rapor = '" . $row->idformat_rapor . "' and idformat_rd = '" . $row2->idformat_rd . "' and idlevel = '" . $row1->idlevel . "';");
                        foreach ($list3->getResult() as $row3) {
                            if (substr($row3->param_operator, 0, 1) == "P") {
                                $jml_dalam = $this->model->getAllQR("SELECT count(*) as jml FROM parameter_nilai where idp_nilai = '" . $row3->param_operator . "';")->jml;
                                if ($jml_dalam > 0) {
                                    $rumus .= $this->model->getAllQR("SELECT parameter FROM parameter_nilai where idp_nilai = '" . $row3->param_operator . "';")->parameter . '&nbsp;';
                                }
                            } else {
                                $rumus .= $row3->param_operator . '&nbsp;';
                            }
                        }
                        $table .= '<td>' . $rumus . '</td>';

                        $table .= '</tr>';
                    }
                }
            }

            $table .= '</tbody></table>';
            echo json_encode(array("status" => $table));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxformat_backup()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ("SELECT idformat_rapor, title FROM format_rapor where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                // membaca sub detilnya apa saja
                $subtitle = '<table>';

                $subtitle .= '<tr>';
                $subtitle .= '<td><b>Subtitle</b></td>';
                $subtitle .= '<td><b>Aksi</b></td>';
                $subtitle .= '<td><b>Rumus</b></td>';
                $subtitle .= '</tr>';

                $list2 = $this->model->getAllQ("SELECT idformat_rd, subtitle FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';");
                foreach ($list2->getResult() as $row2) {
                    $subtitle .= '<tr>';
                    $subtitle .= '<td>' . $row2->subtitle . '</td>';
                    $subtitle .= '<td><button type="button" class="btn btn-sm btn-info" onclick="rumusdetil(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row2->idformat_rd . "'" . ', ' . "'" . $row2->subtitle . "'" . ')"> Rumus </button></td>';

                    $rumus = '';
                    $list3 = $this->model->getAllQ("SELECT param_operator FROM format_rapor_detil_rumus where idformat_rapor = '" . $row->idformat_rapor . "' and idformat_rd = '" . $row2->idformat_rd . "';");
                    foreach ($list3->getResult() as $row3) {
                        if (substr($row3->param_operator, 0, 1) == "P") {
                            $rumus .= $this->model->getAllQR("SELECT parameter FROM parameter_nilai where idp_nilai = '" . $row3->param_operator . "';")->parameter . '&nbsp;';
                        } else {
                            $rumus .= $row3->param_operator . '&nbsp;';
                        }
                    }

                    $subtitle .= '<td>' . $rumus . '</td>';
                    $subtitle .= '</tr>';
                }
                $subtitle .= '</table>';

                // menampilkan title dan subtitle
                // cek dia punya anak apa tidak
                $jml_anak = $this->model->getAllQR("SELECT count(*) as jml FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';")->jml;
                if ($jml_anak > 0) {
                    $val[] = $row->title . '<hr>' . $subtitle;
                } else {
                    // tidak punya anak
                    // menampilkan rumus anaknya
                    $nama_param = '';
                    $jml_param_head = $this->model->getAllQR("select count(b.parameter) as jml from format_rapor_rumus a, parameter_nilai b where a.idformat_rapor = '" . $row->idformat_rapor . "' and a.param_operator = b.idp_nilai;")->jml;
                    if ($jml_param_head > 0) {
                        $nama_param = $this->model->getAllQR("select b.parameter from format_rapor_rumus a, parameter_nilai b where a.idformat_rapor = '" . $row->idformat_rapor . "' and a.param_operator = b.idp_nilai;")->parameter;
                    }
                    $val[] = $row->title . '&nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary" onclick="rumushead(' . "'" . $row->idformat_rapor . "'" . ')"> Rumus </button><hr>' . $nama_param;
                }

                // membaca untuk level apa saja
                $str = '';
                $list1 = $this->model->getAllQ("SELECT a.idlevel, b.level FROM format_raport_level a, level b where a.idlevel = b.idlevel and a.idformat_rapor = '" . $row->idformat_rapor . "' and a.idpendkursus = '" . $idpendkursus . "';");
                foreach ($list1->getResult() as $row1) {
                    $str .= $row1->level . ', ';
                }
                $val[] = $str;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" class="btn btn-block btn-sm btn-info" onclick="ganti(' . "'" . $row->idformat_rapor . "'" . ')"> Ganti </button><br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-danger" onclick="hapus(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')"> Hapus </button><br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-secondary" onclick="display_level(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')">Level Kursus</button><br>'
                    . '<button type="button" class="btn btn-block btn-sm btn-secondary" onclick="subdetail(' . "'" . $row->idformat_rapor . "'" . ',' . "'" . $row->title . "'" . ')">Sub Detail</button>'
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

    public function ajax_add_format1()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idformat_rapor' => $this->model->autokode("F", "idformat_rapor", "format_rapor", 2, 7),
                'idpendkursus' => $this->request->getPost('idpendkursus'),
                'title' => $this->request->getPost('title')
            );
            $simpan = $this->model->add("format_rapor", $data);
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

    public function showformatrapor()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idformat_rapor'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("format_rapor", $kond);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_format1()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'title' => $this->request->getPost('title')
            );
            $kond['idformat_rapor'] = $this->request->getPost('idformat_rapor');
            $update = $this->model->update("format_rapor", $data, $kond);
            if ($update == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus_format1()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idformat_rapor'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("format_rapor", $kond);
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

    public function ajax_dialog_level()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            $idformat_rapor = $this->request->getUri()->getSegment(4);

            $data = array();
            $list = $this->model->getAllQ("select idlevel, level from level where idpendkursus = '" . $idpendkursus . "' order by tingkatan;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->level;
                $cek = $this->model->getAllQR("SELECT count(*) as jml FROM format_raport_level where idformat_rapor = '" . $idformat_rapor . "' and idpendkursus = '" . $idpendkursus . "' and idlevel = '" . $row->idlevel . "';")->jml;
                if ($cek > 0) {
                    $val[] = '<div style="text-align:center; width:100%;"><input type="checkbox" id="' . $row->idlevel . '" name="level[]" value="' . $row->idlevel . '" checked></div>';
                } else {
                    $val[] = '<div style="text-align:center; width:100%;"><input type="checkbox" id="' . $row->idlevel . '" name="level[]" value="' . $row->idlevel . '"></div>';
                }


                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses_pilih()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getPost('idpendkursus');
            $idformat_rapor = $this->request->getPost('idformat_rapor');
            $terpilih = $this->request->getPost('terpilih');

            $kondhapus['idformat_rapor'] = $idformat_rapor;
            $kondhapus['idpendkursus'] = $idpendkursus;
            $this->model->delete("format_raport_level", $kondhapus);

            $datalevel = explode(",", $terpilih);
            for ($i = 0; $i < count($datalevel); $i++) {
                $data = array(
                    'idformat_rl' => $this->model->autokode("L", "idformat_rl", "format_raport_level", 2, 7),
                    'idlevel' => $datalevel[$i],
                    'idpendkursus' => $idpendkursus,
                    'idformat_rapor' => $idformat_rapor
                );
                $this->model->add("format_raport_level", $data);
            }

            $status = "Data tersimpan";
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_sub_detail()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getUri()->getSegment(3);

            $data = array();
            $list = $this->model->getAllQ("SELECT idformat_rd, subtitle FROM format_rapor_detil where idformat_rapor = '" . $idformat_rapor . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->subtitle;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti_subtitle(' . "'" . $row->idformat_rd . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus_subtitle(' . "'" . $row->idformat_rd . "'" . ',' . "'" . $row->subtitle . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '</div></div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add_sub_detil()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idformat_rd' => $this->model->autokode("D", "idformat_rd", "format_rapor_detil", 2, 7),
                'idformat_rapor' => $this->request->getPost('idformat_rapor'),
                'subtitle' => $this->request->getPost('subtitle')
            );
            $simpan = $this->model->add("format_rapor_detil", $data);
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

    public function show_subtitle()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idformat_rd'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("format_rapor_detil", $kond);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_sub_detil()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idformat_rapor' => $this->request->getPost('idformat_rapor'),
                'subtitle' => $this->request->getPost('subtitle')
            );
            $kond['idformat_rd'] = $this->request->getPost('idformat_rd');
            $simpan = $this->model->update("format_rapor_detil", $data, $kond);
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

    public function hapus_subtitle()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idformat_rd'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("format_rapor_detil", $kond);
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

    public function ajax_dialog_combobox()
    {
        if (session()->get("logged_pendidikan")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);

            $str = '<option value="-">- Pilih Level -</option>';

            $data = array();
            $list = $this->model->getAllQ("select idlevel, level from level where idpendkursus = '" . $idpendkursus . "' order by tingkatan;");
            foreach ($list->getResult() as $row) {
                $str .= '<option value="' . $row->idlevel . '">' . $row->level . '</option>';
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_format_preview_rapor()
    {
        if (session()->get("logged_pendidikan")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $str = '';
            $str .= '<tr>
                        <td colspan="4" style="text-align: left;"><u>ATTENDANCE : </u></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">
                            POSSIBLE TOTAL SESSIONS
                        </td>
                        <td style="text-align: left;" id="total_sesi">
                            <!-- total sesi -->
                        </td>
                        <td style="text-align: right;">
                            SESSIONS ATTENDED&nbsp;&nbsp;&nbsp;
                        </td>
                        <td style="text-align: left;" id="total_masuk">
                            <!-- total masuk -->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left;">&nbsp;</td>
                    </tr>';

            $list = $this->model->getAllQ("SELECT a.idformat_rapor, a.idpendkursus, a.title, b.idformat_rl FROM format_rapor a, format_raport_level b WHERE a.idformat_rapor = b.idformat_rapor AND b.idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                // cek dia punya anak apa tidak
                $cek_anak = $this->model->getAllQR("SELECT count(*) as jml FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';")->jml;
                if ($cek_anak > 0) {

                    $str .= '<tr>
                                <td colspan="4" style="text-align: left;"><u>' . $row->title . ' : </u></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;">&nbsp;</td>
                            </tr>';

                    $list2 = $this->model->getAllQ("SELECT * FROM format_rapor_detil where idformat_rapor = '" . $row->idformat_rapor . "';");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<tr>
                                    <td style="text-align: left;">' . $row2->subtitle . '</td>
                                    <td style="text-align: left;">
                                        <!-- class participation -->
                                    </td>
                                    <td style="text-align: left;">
                                
                                    </td>
                                    <td style="text-align: left;">
                                
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: left;">&nbsp;</td>
                                </tr>';
                    }
                } else {

                    $str .= '<tr>
                                <td colspan="4" style="text-align: left;"><u>' . $row->title . ' : </u></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align: left;">
                                <!-- isi disini -->
                                </td>
                            </tr>';
                }
                // enter pemisah
                $str .= '<tr style="line-height: 7px;">
                            <td colspan="4" style="text-align: left;">&nbsp;</td>
                        </tr>';
            }

            $str .= '<tr>
                        <td colspan="4" style="text-align: left; height: 90px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">FINAL RESULT</td>
                        <td style="text-align: left;" id="final_result">
                            <!-- final result -->
                        </td>
                        <td style="text-align: left;">
                    
                        </td>
                        <td style="text-align: left;">
                    
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">DATE</td>
                        <td style="text-align: left;" id="curDate">
                            <!-- curDate -->
                        </td>
                        <td style="text-align: left;">
                    
                        </td>
                        <td style="text-align: left;">
                    
                        </td>
                    </tr>';

            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_param()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getUri()->getSegment(3);
            $idformat_rd = $this->request->getUri()->getSegment(4);
            $idlevel = $this->request->getUri()->getSegment(5);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idp_nilai, a.idlevel, b.level, parameter FROM parameter_nilai a, level b where a.idlevel = b.idlevel and a.idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->parameter;
                $val[] = $row->level;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih_parameter(' . "'" . $idformat_rapor . "'" . ', ' . "'" . $idformat_rd . "'" . ', ' . "'" . $row->idp_nilai . "'" . ',' . "'" . $row->parameter . "'" . ',' . "'" . $idlevel . "'" . ')">Pilih</button>'
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

    public function ajax_rumus_subtitle()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getUri()->getSegment(3);
            $idformat_rd = $this->request->getUri()->getSegment(4);
            $idlevel = $this->request->getUri()->getSegment(5);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idfrdr, param_operator FROM format_rapor_detil_rumus where idformat_rapor = '" . $idformat_rapor . "' and idformat_rd = '" . $idformat_rd . "' and idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                if (substr($row->param_operator, 0, 1) == "P") {
                    $val[] = $this->model->getAllQR("SELECT parameter FROM parameter_nilai where idp_nilai = '" . $row->param_operator . "';")->parameter;
                } else {
                    $val[] = $row->param_operator;
                }

                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus_param_sub(' . "'" . $row->idfrdr . "'" . ',' . "'" . $row->param_operator . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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

    public function pilih_parameter()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idfrdr' => $this->model->autokode("D", "idfrdr", "format_rapor_detil_rumus", 2, 8),
                'idformat_rapor' => $this->request->getPost('idformat_rapor'),
                'idformat_rd' => $this->request->getPost('idformat_rd'),
                'param_operator' => $this->request->getPost('idparam'),
                'idlevel' => $this->request->getPost('idlevel')
            );
            $simpan = $this->model->add("format_rapor_detil_rumus", $data);
            if ($simpan == 1) {
                $status = "Rumus detail tersimpan";
            } else {
                $status = "Rumus detail gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus_sub_rumus()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idfrdr'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("format_rapor_detil_rumus", $kond);
            if ($hapus == 1) {
                $status = "Rumus detail tersimpan";
            } else {
                $status = "Rumus detail gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_param_head()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getUri()->getSegment(3);

            // mencari level
            $idlevel = $this->model->getAllQR("SELECT idlevel FROM format_rapor a, format_raport_level b where a.idformat_rapor = b.idformat_rapor and a.idformat_rapor = '" . $idformat_rapor . "';")->idlevel;

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idp_nilai, parameter FROM parameter_nilai where idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $row->parameter;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="pilih_parameter_head(' . "'" . $idformat_rapor . "'" . ',' . "'" . $row->idp_nilai . "'" . ',' . "'" . $row->parameter . "'" . ')">Pilih</button>'
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

    public function pilih_parameter_head()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getPost('idformat_rapor');
            $jml = $this->model->getAllQR("select count(*) as jml from format_rapor_rumus where idformat_rapor = '" . $idformat_rapor . "';")->jml;
            if ($jml > 0) {
                $data = array(
                    'param_operator' => $this->request->getPost('idparam')
                );
                $kond['idformat_rapor'] = $idformat_rapor;
                $simpan = $this->model->update("format_rapor_rumus", $data, $kond);
                if ($simpan == 1) {
                    $status = "Rumus terupdate";
                } else {
                    $status = "Rumus gagal terupdate";
                }
            } else {
                $data = array(
                    'idfrr' => $this->model->autokode("R", "idfrr", "format_rapor_rumus", 2, 8),
                    'idformat_rapor' => $this->request->getPost('idformat_rapor'),
                    'param_operator' => $this->request->getPost('idparam')
                );
                $simpan = $this->model->add("format_rapor_rumus", $data);
                if ($simpan == 1) {
                    $status = "Rumus tersimpan";
                } else {
                    $status = "Rumus gagal tersimpan";
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function cek_avaiable_rumus()
    {
        if (session()->get("logged_pendidikan")) {
            $idformat_rapor = $this->request->getUri()->getSegment(3);
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM format_raport_level where idformat_rapor = '" . $idformat_rapor . "';")->jml;
            if ($cek > 0) {
                $status = "ada";
            } else {
                $status = "Input level terlebih dahulu";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}
