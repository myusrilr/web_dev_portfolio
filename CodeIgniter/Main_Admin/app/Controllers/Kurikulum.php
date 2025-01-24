<?php

namespace App\Controllers;

/**
 * Description of Homepengajar
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Kurikulum extends BaseController
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

            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

            echo view('back/head', $data);
            echo view('back/pengajar/menu');
            echo view('back/pengajar/kurikulum/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_pengajar")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAll("pendidikankursus");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_kursus;
                $val[] = $row->keterangan;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="pilih(' . "'" . $this->modul->enkrip_url($row->idpendkursus) . "'" . ')">Pilih</button>'
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

    public function level()
    {
        if (session()->get("logged_pengajar")) {
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

            $idpendkursus = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("SELECT count(*) as jml FROM pendidikankursus where idpendkursus = '" . $idpendkursus . "';")->jml;
            if ($cek > 0) {
                $data['idpendkursus'] = $idpendkursus;

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/kurikulum/level');
                echo view('back/foot');
            } else {
                $this->modul->halaman('kurikulum');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlevel()
    {
        if (session()->get("logged_pengajar")) {
            $kode = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from level where idpendkursus = '" . $kode . "' order by tingkatan;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->level;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="pilih(' . "'" . $this->modul->enkrip_url($row->idlevel) . "'" . ')">Pilih</button>'
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

    public function kurikulum()
    {
        if (session()->get("logged_pengajar")) {
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

            $idlevel = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from level where idlevel = '" . $idlevel . "';")->jml;
            if ($cek > 0) {
                $datalevel = $this->model->getAllQR("select a.idpendkursus, b.nama_kursus, a.level from level a, pendidikankursus b where a.idpendkursus = b.idpendkursus and a.idlevel = '" . $idlevel . "';");
                $data['idpendkursus'] = $this->modul->enkrip_url($datalevel->idpendkursus);
                $data['nm_kursus'] = $datalevel->nama_kursus;
                $data['idlevel'] = $idlevel;
                $data['nm_level'] = $datalevel->level;

                echo view('back/head', $data);
                echo view('back/pengajar/menu');
                echo view('back/pengajar/kurikulum/kurikulum');
                echo view('back/foot');
            } else {
                $this->modul->halaman('kurikulum');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxkurikulum()
    {
        if (session()->get("logged_pengajar")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $str = '';
            $list = $this->model->getAllQ("SELECT idkurikulum, judul FROM kurikulum where idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $str .= '<div class="ui-bordered p-2 mb-2">
                            <div class="kanban-board-actions btn-group float-right ml-2">
                                <button type="button" class="btn btn-default btn-xs btn-round icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="ganti(' . "'" . $row->idkurikulum . "'" . ')">Ganti</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="hapus(' . "'" . $row->idkurikulum . "'" . ',' . "'" . $row->judul . "'" . ')">Hapus</a>
                                </div>
                            </div>
                            ' . $row->judul . '
                        </div>';
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxtema()
    {
        if (session()->get("logged_pengajar")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $str = '';
            $list = $this->model->getAllQ("SELECT idkurikulum, judul FROM kurikulum where idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $str .= '<div class="card border-info mb-3">
                        <h6 class="card-header text-center">' . $row->judul . '</h6>
                        <div class="kanban-box px-2 pt-2">';
                $list1 = $this->model->getAllQ("SELECT idkur_det, menu FROM kurikulum_detil where idkurikulum = '" . $row->idkurikulum . "';");
                foreach ($list1->getResult() as $row1) {
                    $str .= '<div class="ui-bordered p-2 mb-2">
                                <div class="kanban-board-actions btn-group float-right ml-2">
                                    <button type="button" class="btn btn-default btn-xs btn-round icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="gantitema(' . "'" . $row1->idkur_det . "'" . ')">Ganti</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="hapustema(' . "'" . $row1->idkur_det . "'" . ')">Hapus</a>
                                    </div>
                                </div>
                                ' . $row1->menu . '
                            </div>';
                }
                $str .= '</div>
                        <div class="card-footer text-center py-2">
                            <a href="javascript:void(0)" onclick="addtema(' . "'" . $row->idkurikulum . "'" . ',' . "'" . $row->judul . "'" . ');"><i class="ion ion-md-add"></i>&nbsp; Tambah Tema</a>
                        </div>
                        
                    </div>';
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'idkurikulum' => $this->model->autokode("K", "idkurikulum", "kurikulum", 2, 7),
                'idlevel' => $this->request->getPost('idlevel'),
                'judul' => $this->request->getPost('judul')
            );
            $simpan = $this->model->add("kurikulum", $data);
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

    public function show()
    {
        if (session()->get("logged_pengajar")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from kurikulum where idkurikulum = '" . $kode . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'idlevel' => $this->request->getPost('idlevel'),
                'judul' => $this->request->getPost('judul')
            );
            $kond['idkurikulum'] = $this->request->getPost('kode');
            $simpan = $this->model->update("kurikulum", $data, $kond);
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
        if (session()->get("logged_pengajar")) {
            $kond['idkurikulum'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("kurikulum", $kond);
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

    public function ajax_add_tema()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'idkur_det' => $this->model->autokode("D", "idkur_det", "kurikulum_detil", 2, 7),
                'menu' => $this->request->getPost('menu'),
                'idkurikulum' => $this->request->getPost('idkurikulum')
            );
            $simpan = $this->model->add("kurikulum_detil", $data);
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

    public function showtema()
    {
        if (session()->get("logged_pengajar")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from kurikulum_detil where idkur_det = '" . $kode . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_tema()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'menu' => $this->request->getPost('menu'),
                'idkurikulum' => $this->request->getPost('idkurikulum')
            );
            $kond['idkur_det'] = $this->request->getPost('kode');
            $simpan = $this->model->update("kurikulum_detil", $data, $kond);
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

    public function hapustema()
    {
        if (session()->get("logged_pengajar")) {
            $kond['idkur_det'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("kurikulum_detil", $kond);
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

    public function ajaxkompetensi()
    {
        if (session()->get("logged_pengajar")) {
            $idlevel = $this->request->getUri()->getSegment(3);

            $str = '';
            $list = $this->model->getAllQ("SELECT idkurikulum, judul FROM kurikulum where idlevel = '" . $idlevel . "';");
            foreach ($list->getResult() as $row) {
                $list1 = $this->model->getAllQ("SELECT idkur_det, menu FROM kurikulum_detil where idkurikulum = '" . $row->idkurikulum . "';");
                foreach ($list1->getResult() as $row1) {
                    $str .= '<div class="card border-info mb-3">';
                    $str .= '<h6 class="card-header">' . $row1->menu . '</h6>';

                    $str .= '<div class="kanban-box px-2 pt-2">';
                    $list2 = $this->model->getAllQ("SELECT idkur_det_sub, kompetensi FROM kurikulum_detil_sub where idkur_det = '" . $row1->idkur_det . "';");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<div class="ui-bordered p-2 mb-2">';
                        $str .= '<div class="kanban-board-actions btn-group float-right ml-2">';
                        $str .= '<button type="button" class="btn btn-default btn-xs btn-round icon-btn borderless md-btn-flat hide-arrow dropdown-toggle" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>';
                        $str .= '<div class="dropdown-menu dropdown-menu-right">';
                        $str .= '<a class="dropdown-item" href="javascript:void(0)" onclick="gantikompetensi(' . "'" . $row2->idkur_det_sub . "'" . ')">Ganti</a>';
                        $str .= '<a class="dropdown-item" href="javascript:void(0)" onclick="hapuskompetensi(' . "'" . $row2->idkur_det_sub . "'" . ')">Hapus</a>';
                        $str .= '</div>';
                        $str .= '</div>';
                        $str .= $row2->kompetensi;
                        $str .= '</div>';
                    }
                    $str .= '</div>';

                    $str .= '<div class="card-footer text-center py-2">';
                    $str .= '<a href="javascript:void(0)" onclick="addkompetensi(' . "'" . $row1->idkur_det . "'" . ');"><i class="ion ion-md-add"></i>&nbsp; Tambah Kompetensi</a>';
                    $str .= '</div>';

                    $str .= '</div>';
                }
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add_kompetensi()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'idkur_det_sub' => $this->model->autokode("S", "idkur_det_sub", "kurikulum_detil_sub", 2, 7),
                'kompetensi' => $this->request->getPost('kompetensi'),
                'idkur_det' => $this->request->getPost('idkur_det')
            );
            $simpan = $this->model->add("kurikulum_detil_sub", $data);
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

    public function showkompetensi()
    {
        if (session()->get("logged_pengajar")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from kurikulum_detil_sub where idkur_det_sub = '" . $kode . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_kompetensi()
    {
        if (session()->get("logged_pengajar")) {
            $data = array(
                'kompetensi' => $this->request->getPost('kompetensi'),
                'idkur_det' => $this->request->getPost('idkur_det')
            );
            $kond['idkur_det_sub'] = $this->request->getPost('kode');
            $simpan = $this->model->update("kurikulum_detil_sub", $data, $kond);
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

    public function hapuskurikulum()
    {
        if (session()->get("logged_pengajar")) {
            $kond['idkur_det_sub'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("kurikulum_detil_sub", $kond);
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
}
