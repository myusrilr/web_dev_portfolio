<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Ttd extends BaseController
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


            $data['status'] = $this->model->getAllQR("SELECT setuju FROM keluar where idusers = '" . $data['idusers'] . "';")->setuju;
            $data['divisi'] = $this->model->getAllQR("SELECT jabatan, d.nama as namad FROM users u, jabatan j, divisi d where idusers='" . $data['idusers'] . "' and j.idjabatan = u.idjabatan and d.iddivisi = j.iddivisi;");
            $data['idkaryawan'] = $this->model->getAllQR("select idkaryawan from karyawan where idusers = '" . $data['idusers'] . "'")->idkaryawan;

            $def_foto = base_url() . '/images/noimg.jpg';
            $def_ttd = base_url() . '/images/noimg.jpg';
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            if (strlen($pro->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->foto)) {
                    $def_foto = base_url() . '/uploads/' . $pro->foto;
                }
            }

            if (strlen($pro->ttd) > 0) {
                if (file_exists($this->modul->getPathApp() . $pro->ttd)) {
                    $def_ttd = base_url() . '/uploads/' . $pro->ttd;
                }
            }

            $data['pro'] = $pro;
            $data['foto_profile'] = $def_foto;
            $data['ttd'] = $def_ttd;
            $data['ttdstatus'] = $this->model->getAllQR("SELECT status FROM ttd limit 1")->status;

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
            echo view('back/pengajar/ttd/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_pengajar")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->update_file();
                }
            } else {
                $status = "File tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function update_file()
    {
        $idusers = session()->get("idusers");
        $lawas = $this->model->getAllQR("SELECT ttd FROM users where idusers = '" . $idusers . "';")->ttd;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'ttd' => $fileName
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if ($update == 1) {
                    $status = "Tanda tangan terupload";
                } else {
                    $status = "Tanda tangan gagal terupload";
                }
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }
}
