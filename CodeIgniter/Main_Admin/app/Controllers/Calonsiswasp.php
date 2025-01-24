<?php

namespace App\Controllers;

/**
 * Description of Siswa
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;

class Calonsiswasp extends BaseController
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
        $idcalon = $this->request->getUri()->getSegment(3);
        if (strlen($idcalon) > 0) {

            $idcalon_asli = $this->modul->dekrip_url($idcalon);
            // mencari id pendidikan
            $idpendkursus = $this->model->getAllQR("SELECT idpendkursus FROM form_calon where idcalon = '" . $idcalon_asli . "';")->idpendkursus;

            $data['model'] = $this->model;
            $data['modul'] = $this->modul;
            $data['idcalon'] = $idcalon_asli;
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['status'] = "awal";
            $data['idcalon_enkrip'] = $this->request->getUri()->getSegment(3);
            $data['head'] = $this->model->getAllQR("select * from pendidikankursus where idpendkursus = '" . $idpendkursus . "';");

            // melihat status siswa tersebut 
            // jika masih pending maka nampil yang hanya Siswa (Awal)
            // jika diterima maka nampil -> Siswa (Awal) + Siswa (Melangkapi)
            $status = $this->model->getAllQR("select status from form_calon where idcalon = '" . $idcalon_asli . "';")->status;
            // 1 diterima
            // 0 pending
            // 2 ditolak
            if ($status == "1") {
                $data['pertanyaan'] = $this->model->getAllQ("SELECT * FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "' and diisi_oleh in('Siswa (Awal)', 'Siswa (Melangkapi)');");
                echo view('back/single_page/calon_siswa', $data);
            } else if ($status == "0") {
                $data['pertanyaan'] = $this->model->getAllQ("SELECT * FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "' and diisi_oleh in('Siswa (Awal)');");
                echo view('back/single_page/calon_siswa', $data);
            } else {
                redirect("https://leapsurabaya.sch.id/");
            }
        } else {
            redirect("https://leapsurabaya.sch.id/");
        }
    }

    public function proses()
    {
        $idcalon = $this->request->getPost('idcalon');
        if (strlen($idcalon) > 0) {
            $idcalon = $this->modul->dekrip_url($idcalon);
            $jml = $this->model->getAllQR("SELECT count(*) as jml FROM calon_detil where idpendkursus = '" . $this->request->getPost('idpendkurusus') . "' and idcalon = '" . $idcalon . "';")->jml;
            if ($jml > 0) {
                $this->prosestulisupdate($idcalon);
            } else {
                $this->prosestulis($idcalon);
            }
        } else {
            $this->modul->halaman('calonsiswasp/index/' . $idcalon);
        }
    }


    private function prosestulis($idcalon)
    {
        $idpendkursus = $this->request->getPost('idpendkurusus');

        // menampilkan semua pertanyaan dr itu
        $list = $this->model->getAllQ("SELECT idcalon_p, pertanyaan, mode FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "' and diisi_oleh in('Siswa (Awal)', 'Siswa (Melangkapi)');");
        foreach ($list->getResult() as $row) {
            $data = array(
                'idcalond' => $this->model->autokode("D", "idcalond", "calon_detil", 2, 11),
                'idpendkursus' => $idpendkursus,
                'idcalon_p' => $row->idcalon_p,
                'jawaban' => $this->request->getPost($row->idcalon_p),
                'idcalon' => $idcalon
            );
            $this->model->add("calon_detil", $data);
        }

        $this->modul->pesan_halaman('Data tersimpan', 'calonsiswasp/index/' . $this->modul->enkrip_url($idcalon));
    }

    private function prosestulisupdate($idcalon)
    {
        $idpendkursus = $this->request->getPost('idpendkurusus');
        // menampilkan semua pertanyaan dr itu
        $list = $this->model->getAllQ("SELECT idcalon_p, pertanyaan, mode FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "' and diisi_oleh in('Siswa (Awal)','Siswa (Melangkapi)');");
        foreach ($list->getResult() as $row) {
            $cek = $this->model->getAllQR("select count(*) as jml from calon_detil where idpendkursus = '" . $idpendkursus . "' and idcalon_p = '" . $row->idcalon_p . "' and idcalon = '" . $idcalon . "';")->jml;
            if ($cek > 0) {
                $data = array(
                    'jawaban' => $this->request->getPost($row->idcalon_p)
                );
                $kond['idpendkursus'] = $idpendkursus;
                $kond['idcalon_p'] = $row->idcalon_p;
                $kond['idcalon'] = $idcalon;
                $this->model->update("calon_detil", $data, $kond);
            } else {
                $data = array(
                    'idcalond' => $this->model->autokode("D", "idcalond", "calon_detil", 2, 11),
                    'idpendkursus' => $idpendkursus,
                    'idcalon_p' => $row->idcalon_p,
                    'jawaban' => $this->request->getPost($row->idcalon_p),
                    'idcalon' => $idcalon
                );
                $this->model->add("calon_detil", $data);
            }
        }

        $this->modul->pesan_halaman('Data terupdate', 'calonsiswasp/index/' . $this->modul->enkrip_url($idcalon));
    }
}
