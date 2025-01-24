<?php

namespace App\Controllers;

/**
 * Description of Libur
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Libur extends BaseController
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
            $pro = $this->model->getAllQR("SELECT * FROM users where idusers = '" . $data['idusers'] . "';");
            $def_foto = base_url() . '/images/noimg.jpg';
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

            echo view('back/head', $data);
            echo view('back/akademik/menu');
            echo view('back/akademik/libur/index');
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
            $list = $this->model->getAllQ("select idlibur, title, description, url, date_format(start, '%d %M %Y') as mulai, date_format(DATE_ADD(end, INTERVAL -1 DAY), '%d %M %Y') as kelar from libur;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->title;
                $val[] = $row->description;
                $val[] = $row->url;
                $val[] = $row->mulai . ' - ' . $row->kelar;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="ganti(' . "'" . $row->idlibur . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idlibur . "'" . ',' . "'" . $row->title . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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
            // sebelum masukkan libur cek dulu di calendar ada acara apa tidak
            // kalau ada acara wajib digeser ke tanggal lain
            $tgl_awal = $this->request->getPost('tglawal');
            $tgl_akhir = $this->request->getPost('tglakhir');
            $cek = $this->model->getAllQR("select count(*) as jml from jadwal_detil where (start between '" . $tgl_awal . "' and '" . $tgl_akhir . "') or (end between '" . $tgl_awal . "' and '" . $tgl_akhir . "');")->jml;
            if ($cek > 0) {
                $status = "Data gagal tersimpan. Terdapat jadwal pada tanggal tersebut";
            } else {
                $data = array(
                    'idlibur' => $this->model->autokode("L", "idlibur", "libur", 2, 7),
                    'title' => $this->request->getPost('judul'),
                    'description' => $this->request->getPost('deskripsi'),
                    'url' => $this->request->getPost('url'),
                    'start' => $this->request->getPost('tglawal'),
                    'end' => $this->modul->TambahTanggal($this->request->getPost('tglakhir'), 1),
                    'color' => 'fc-event-default'
                );
                $simpan = $this->model->add("libur", $data);
                if ($simpan == 1) {
                    $status = "Data tersimpan";
                } else {
                    $status = "Data gagal tersimpan";
                }
            }

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function show()
    {
        if (session()->get("logged_pendidikan")) {
            $idlibur = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select idlibur, title, description, url, start, DATE_ADD(end, INTERVAL -1 DAY) as kelar from libur where idlibur = '" . $idlibur . "';");
            echo json_encode(array(
                "idlibur" => $data->idlibur,
                "title" => $data->title,
                "description" => $data->description,
                "url" => $data->url,
                "start" => $data->start,
                "end" => $data->kelar
            ));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_pendidikan")) {
            $tgl_awal = $this->request->getPost('tglawal');
            $tgl_awal_plus_one = date('Y-m-d', strtotime($tgl_awal . ' +1 day'));
            $tgl_akhir = $this->request->getPost('tglakhir');
            $cek = $this->model->getAllQR("SELECT count(*) as jml
            FROM jadwal_detil jd
            INNER JOIN jadwal j ON jd.idjadwal = j.idjadwal
            WHERE (jd.start BETWEEN '" . $tgl_awal_plus_one . "' and '" . $tgl_akhir . "' OR jd.end BETWEEN '" . $tgl_awal_plus_one . "' and '" . $tgl_akhir . "')
            AND j.status_archive <> 1;")->jml;
            if ($cek > 0) {
                $status = "Data gagal tersimpan. Terdapat jadwal pada tanggal tersebut";
            } else {
                $data = array(
                    'title' => $this->request->getPost('judul'),
                    'description' => $this->request->getPost('deskripsi'),
                    'url' => $this->request->getPost('url'),
                    'start' => $this->request->getPost('tglawal'),
                    'end' => $this->modul->TambahTanggal($this->request->getPost('tglakhir'), 1),
                    'color' => 'fc-event-default'
                );
                $kond['idlibur'] = $this->request->getPost('kode');
                $simpan = $this->model->update("libur", $data, $kond);
                if ($simpan == 1) {
                    $status = "Data terupdate";
                } else {
                    $status = "Data gagal terupdate";
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus()
    {
        if (session()->get("logged_pendidikan")) {
            $kond['idlibur'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("libur", $kond);
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
