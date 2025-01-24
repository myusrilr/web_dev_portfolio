<?php

namespace App\Controllers;

/**
 * Description of Sesi
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Sesi extends BaseController
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

            $data['curtime'] = $this->modul->WaktuSekarang2();

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/sesi/index');
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
            $list = $this->model->getAllQ("select idsesi, nama_sesi, date_format(waktu_awal, '%H:%i') as waktu1, date_format(waktu_akhir, '%H:%i') as waktu2 from sesi;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama_sesi;
                $val[] = $row->waktu1 . ' - ' . $row->waktu2;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti(' . "'" . $row->idsesi . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsesi . "'" . ',' . "'" . $row->nama_sesi . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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

    public function ajax_add()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'idsesi' => $this->model->autokode("S", "idsesi", "sesi", 2, 7),
                'nama_sesi' => $this->request->getPost('nama_sesi'),
                'waktu_awal' => $this->request->getPost('waktu_awal'),
                'waktu_akhir' => $this->request->getPost('waktu_akhir')
            );
            $simpan = $this->model->add("sesi", $data);
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
        if (session()->get("logged_pendidikan")) {
            $idsesi = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select idsesi, nama_sesi, date_format(waktu_awal, '%H:%i') as waktu1, date_format(waktu_akhir, '%H:%i') as waktu2 from sesi where idsesi = '" . $idsesi . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_pendidikan")) {
            $data = array(
                'nama_sesi' => $this->request->getPost('nama_sesi'),
                'waktu_awal' => $this->request->getPost('waktu_awal'),
                'waktu_akhir' => $this->request->getPost('waktu_akhir')
            );
            $kond['idsesi'] = $this->request->getPost('kode');
            $simpan = $this->model->update("sesi", $data, $kond);
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
            $kond['idsesi'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("sesi", $kond);
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
