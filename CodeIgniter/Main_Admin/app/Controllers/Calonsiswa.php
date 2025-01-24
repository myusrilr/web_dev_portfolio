<?php

namespace App\Controllers;

/**
 * Description of Siswa
 *
 * @author RAMPA
 */

use App\Models\Mcustom;
use App\Libraries\Modul;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Calonsiswa extends BaseController
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
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;

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

            $data['kursus'] = $this->model->getAllQ("select * from pendidikankursus;");

            echo view('back/head', $data);
            if (session()->get("logged_pendidikan")) {
                echo view('back/akademik/menu');
            } else if (session()->get("logged_hr")) {
                echo view('back/hrd/menu');
            }
            echo view('back/akademik/calon_siswa/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function catatan_admin()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;

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

            $data['kursus'] = $this->model->getAllQ("select * from pendidikankursus;");

            echo view('back/head', $data);
            if (session()->get("logged_pendidikan")) {
                echo view('back/akademik/menu');
            } else if (session()->get("logged_hr")) {
                echo view('back/hrd/menu');
            }
            echo view('back/akademik/calon_siswa/catatan_admin');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }


    public function ajaxlist()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idpend = $this->request->getUri()->getSegment(3);

            if ($idpend == "all") {
                $query = "SELECT a.*, b.nama_kursus 
                          FROM form_calon a 
                          LEFT JOIN pendidikankursus b 
                          ON a.idpendkursus = b.idpendkursus 
                          ORDER BY a.idcalon DESC;";
            } else {
                $query = "SELECT a.*, b.nama_kursus 
                          FROM form_calon a 
                          LEFT JOIN pendidikankursus b 
                          ON a.idpendkursus = b.idpendkursus 
                          WHERE a.idpendkursus = '" . $idpend . "' 
                          ORDER BY a.idcalon DESC;";
            }

            $no = 1;
            $data = array();
            $list = $this->model->getAllQ($query);
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->fullName;
                $val[] = $row->phone1;
                $val[] = $row->email;
                $val[] = $row->nama_kursus;
                $status = '';
                if ($row->status == "1") {
                    $status = '<span class="badge badge-success">Diterima</span>';
                } else if ($row->status == "0") {
                    $status = '<span class="badge badge-warning">Pending</span>';
                } else if ($row->status == "2") {
                    $status = '<span class="badge badge-danger">Ditolak</span>';
                }
                $val[] = $status;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" title="Kirim WA kepada calon" class="btn btn-block btn-sm btn-success" style="color:black;" onclick="kirimwa(' . "'" . $row->phone1 . "'" . ', ' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="ion ion-logo-whatsapp"></i>&nbsp;&nbsp;Kirim WA</button>'
                    . '<button type="button" title="Lengkapi Calon Siswa (Ekstern)" class="btn btn-block btn-sm btn-secondary"  style="onclick="lengkapiekstern(' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="fas fa-link"></i>&nbsp;&nbsp;Lengkapi ( Ekstern )</button>'
                    . '<button type="button" title="Tulis mandiri" class="btn btn-block btn-sm btn-primary" onclick="tulismandiri(' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;&nbsp;Tulis Mandiri </button>'
                    . '<button type="button" title="Opsi penerimaan" class="btn btn-block btn-sm btn-secondary" onclick="opsiterima(' . "'" . $row->idcalon . "'" . ', ' . "'" . $row->fullName . "'" . ')"><i class="feather icon-check"></i>&nbsp;&nbsp;&nbsp;Opsi Terima </button>'
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

    public function terima()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                "status" => 1
            );
            $kond['idcalon'] = $this->request->getUri()->getSegment(3);

            $update = $this->model->update("form_calon", $data, $kond);

            if ($update) {
                // Jika berhasil update, masukkan ke siswa
                $this->simpanSiswa();
                $status = "Calon diterima";
            } else {
                $status = "Calon gagal diterima";
            }

            // Mengembalikan respons JSON
            echo json_encode(array("status" => $status));
        } else {
            // Jika sesi tidak valid, arahkan ke halaman login
            $this->modul->halaman('login');
        }
    }


    public function tolak()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            // Data yang akan diperbarui
            $data = array(
                "status" => 2
            );

            // Ambil segment URI ketiga sebagai ID calon
            $kond['idcalon'] = $this->request->getUri()->getSegment(3);

            // Lakukan update menggunakan model Mcustom
            $update = $this->model->update("form_calon", $data, $kond);

            // Cek hasil update
            if ($update) {
                // Jika berhasil update, lakukan tindakan lain (misal hapus pending)
                $this->del_pending();

                $status = "Calon ditolak";
            } else {
                $status = "Calon gagal ditolak";
            }

            // Mengembalikan respons JSON
            echo json_encode(array("status" => $status));
        } else {
            // Jika sesi tidak valid, arahkan ke halaman login
            $this->modul->halaman('login');
        }
    }


    public function pending()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            // Data yang akan diperbarui
            $data = array(
                "status" => 0
            );

            // Ambil segment URI ketiga sebagai ID calon
            $kond['idcalon'] = $this->request->getUri()->getSegment(3);

            // Lakukan update menggunakan model Mcustom
            $update = $this->model->update("form_calon", $data, $kond);

            // Cek hasil update
            if ($update) {
                // Jika berhasil update, lakukan tindakan lain (misal hapus pending)
                $this->del_pending();

                $status = "Pending tersimpan";
            } else {
                $status = "Pending gagal tersimpan";
            }

            // Mengembalikan respons JSON
            echo json_encode(array("status" => $status));
        } else {
            // Jika sesi tidak valid, arahkan ke halaman login
            $this->modul->halaman('login');
        }
    }


    private function simpanSiswa()
    {
        $idcalon = $this->request->getUri()->getSegment(3);
        $calon = $this->model->getAllQR("
        SELECT a.*, b.nama_kursus 
        FROM form_calon a
        JOIN pendidikankursus b ON a.idpendkursus = b.idpendkursus
        WHERE a.idcalon = '" . $idcalon . "';
    ");

        if (!$calon) {
            return false; // Tangani jika data calon tidak ditemukan
        }

        $data = array(
            'idsiswa' => $this->model->autokode("S", "idsiswa", "siswa", 2, 9),
            'no_induk' => '',
            'tgl_daftar' => $this->modul->TanggalSekarang(),
            'domisili' => '',
            'nama_lengkap' => $calon->fullName,
            'panggilan' => $calon->nickName ?? '',
            'jkel' => $calon->gender ?? '',
            'nama_sekolah' => $calon->schoolName ?? '',
            'level_sekolah' => $calon->classLevel ?? '',
            'nama_ortu' => '',
            'pekerjaan_ortu' => '',
            'tmp_lahir' => '',
            'tgl_lahir' => $this->modul->TanggalSekarang(),
            'email' => $calon->email,
            'tlp' => $calon->phone1,
            'idcalon' => $idcalon
        );

        $simpan = $this->model->add("siswa", $data);
        return $simpan;
    }


    private function del_pending()
    {
        $idcalon = $this->request->getUri()->getSegment(3);
        $cek_siswa = $this->model->getAllQR("select count(*) as jml from siswa where idcalon = '" . $idcalon . "';")->jml;
        if ($cek_siswa > 0) {
            $siswa = $this->model->getAllQR("select * from siswa where idcalon = '" . $idcalon . "';");
            $kond['idsiswa'] = $siswa->idsiswa;
            $this->model->delete("siswa", $kond);
        }
    }

    public function cetak()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            date_default_timezone_set("Asia/Jakarta");

            $data['tglcetak'] = date("d M Y");

            $idpend = $this->request->getUri()->getSegment(3);

            if ($idpend == "all") {
                $query = "SELECT a.*, b.nama_kursus FROM calon a, pendidikankursus b where a.idpendkursus = b.idpendkursus order by idcalon desc;";
                $data['mode'] = $idpend;
            } else {
                $query = "SELECT a.*, b.nama_kursus FROM calon a, pendidikankursus b where a.idpendkursus = b.idpendkursus and a.idpendkursus = '" . $idpend . "' order by idcalon desc;";
                $data['mode'] = $this->model->getAllQR("select nama_kursus from pendidikankursus where idpendkursus = '" . $idpend . "';")->nama_kursus;
            }
            $data['list'] = $this->model->getAllQ($query);

            $options = new Options();
            $options->setChroot(FCPATH);
            $options->setDefaultFont('courier');

            $dompdf = new Dompdf();
            $dompdf->setOptions($options);
            $dompdf->loadHtml(view('back/akademik/calon_siswa/pdf', $data));
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'CALON_SISWA.pdf';

            $this->response->setContentType('application/pdf');
            //$dompdf->stream($filename); // download
            $dompdf->stream($filename, array("Attachment" => 0)); // nempel
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxrombel()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idcalon = $this->request->getUri()->getSegment(3);
            // menampilkan dia pilih kelas apa
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
                    . '<button type="button" class="btn btn-sm btn-info" onclick="ganti(' . "'" . $row->idjadwal . "'" . ')"><i class="fas fa-pencil-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapus(' . "'" . $row->idjadwal . "'" . ',' . "'" . $row->groupwa . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-secondary" onclick="ploting(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="fas fa-users"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-success" onclick="wa(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="ion ion-logo-whatsapp"></i></button>'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="uplevel(' . "'" . $this->modul->enkrip_url($row->idjadwal) . "'" . ')"><i class="feather icon-arrow-up"></i></button>'
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

    public function calon()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;

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

            $idpendkursus = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->getAllQR("select count(*) as jml from pendidikankursus where idpendkursus = '" . $idpendkursus . "';")->jml;
            if ($cek > 0) {

                $data['head'] = $this->model->getAllQR("select * from pendidikankursus where idpendkursus = '" . $idpendkursus . "';");
                $data['pertanyaan'] = $this->model->getAllQ("SELECT * FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "';");

                echo view('back/head', $data);
                if (session()->get("logged_pendidikan")) {
                    echo view('back/akademik/menu');
                } else if (session()->get("logged_hr")) {
                    echo view('back/hrd/menu');
                }
                echo view('back/akademik/calon_siswa/calon');
                echo view('back/foot');
            } else {
                $this->modul->halaman('calonsiswa');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxcalon()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idcalon, fullName, phone1, email, status FROM form_calon where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->fullName;
                $val[] = $row->phone1;
                $val[] = $row->email;
                $status = '';
                if ($row->status == "1") {
                    $status = '<span class="badge badge-success">Diterima</span>';
                } else if ($row->status == "0") {
                    $status = '<span class="badge badge-warning">Pending</span>';
                } else if ($row->status == "2") {
                    $status = '<span class="badge badge-danger">Ditolak</span>';
                }
                $val[] = $status;
                $val[] = '<div style="text-align:center; width:100%;">'
                    . '<button type="button" title="Kirim WA kepada calon" class="btn btn-block btn-sm btn-success" style="color:black; width:10vw;" onclick="kirimwa(' . "'" . $row->phone1 . "'" . ', ' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="ion ion-logo-whatsapp"></i>&nbsp;&nbsp;Kirim WA</button>'
                    . '<button type="button" title="Lengkapi Calon Siswa (Ekstern)" class="btn btn-block btn-sm btn-secondary" style="width:10vw; onclick="lengkapiekstern(' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="fas fa-link"></i>&nbsp;&nbsp;Lengkapi ( Ekstern )</button>'
                    . '<button type="button" title="Lengkapi Calon Siswa (Intern)" class="btn btn-block btn-sm btn-secondary" style="width:10vw; onclick="tulismandiri(' . "'" . $this->modul->enkrip_url($row->idcalon) . "'" . ')"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Lengkapi ( Intern )</button>'
                    . '<button type="button" title="Ganti Calon Siswa" class="btn btn-sm btn-block btn-info" style="width:10vw; onclick="ganti(' . "'" . $row->idcalon . "'" . ')"><i class="fas fa-pencil-alt"></i> Ganti Calon</button>'
                    . '<button type="button" title="Hapus Calon Siswa" class="btn btn-sm btn-block btn-danger" style="width:10vw; onclick="hapus(' . "'" . $row->idcalon . "'" . ',' . "'" . $no . "'" . ')"><i class="fas fa-trash-alt"> Hapus Calon </i></button>'
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

    public function ajax_add_calon()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'idcalon' => $this->model->autokode("C", "idcalon", "calon", 2, 10),
                'idpendkursus' => $this->request->getPost('idpendkursus'),
                'tlp' => $this->request->getPost('tlp_calon'),
                'email' => $this->request->getPost('email_calon'),
                'nama' => $this->request->getPost('nama_calon')
            );
            $simpan = $this->model->add("calon", $data);
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

    public function showcalonsiswa()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = $this->model->getAllQR("select * from calon where idcalon = '" . $kode . "';");
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit_calon()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'idcalon' => $this->model->autokode("C", "idcalon", "calon", 2, 10),
                'tlp' => $this->request->getPost('tlp_calon'),
                'email' => $this->request->getPost('email_calon'),
                'nama' => $this->request->getPost('nama_calon')
            );
            $kond['idcalon'] = $this->request->getPost('kode_calon');
            $update = $this->model->update("calon", $data, $kond);
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

    public function hapus()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $kond['idcalon'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("calon", $kond);
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

    public function ajax_add_pertanyaan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'idcalon_p' => $this->model->autokode("P", "idcalon_p", "calon_pertanyaan", 2, 11),
                'idpendkursus' => $this->request->getPost('idpendkursus'),
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'mode' => $this->request->getPost('mode')
            );
            $simpan = $this->model->add("calon_pertanyaan", $data);
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

    public function load_pertanyaan()
    {
        $status = ''; // Inisialisasi variabel dengan nilai default

        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idpendkursus = $this->request->getUri()->getSegment(3);
            $str = '';
            $list = $this->model->getAllQ("SELECT * FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "' order by urutan, idcalon_p;");
            foreach ($list->getResult() as $row) {
                $str .= '<div class="form-group row">';
                $str .= '<div class="col-sm-2">';
                $str .= '<div class="input-group mb-3">
                    <button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus_pertanyaan(' . "'" . $row->idcalon_p . "'" . ',' . "'" . $row->pertanyaan . "'" . ')"><i class="fas fa-trash-alt"></i></button>';
                if ($row->mode == "radio") {
                    $str .= '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detil_pertanyaan(' . "'" . $row->idcalon_p . "'" . ',' . "'" . $row->pertanyaan . "'" . ')"><i class="fas fa-check"> Jawaban</i></button>';
                } else if ($row->mode == "select") {
                    $str .= '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="detil_pertanyaan(' . "'" . $row->idcalon_p . "'" . ',' . "'" . $row->pertanyaan . "'" . ')"><i class="fas fa-check"> Jawaban</i></button>';
                }
                $str .= '</div></div>';
                $str .= '<div class="col-sm-1">';
                $str .= '<input title="Urutan pertanyaan" type="text" class="form-control" onkeypress="return hanyaAngka(event, false);" placeholder="Urutan" autocomplete="off" value="' . $row->urutan . '" style="text-align:center;" onfocusout="simpan_urutan(' . "'" . $row->idcalon_p . "'" . ', this);">';
                $str .= '</div>';
                $str .= '<div class="col-sm-2">';
                $str .= '<select title="Diisi Pada Saat / Oleh" class="form-control" onchange="pindah_input_saat(' . "'" . $row->idcalon_p . "'" . ', this);">';
                if ($row->diisi_oleh == "Siswa") {
                    $str .= '<option selected>Siswa</option>';
                    $str .= '<option>Admin dan Siswa</option>';
                    $str .= '<option>Admin</option>';
                } else if ($row->diisi_oleh == "Siswa (Melangkapi)") {
                    $str .= '<option>Siswa</option>';
                    $str .= '<option selected>Admin dan Siswa</option>';
                    $str .= '<option>Admin</option>';
                } else if ($row->diisi_oleh == "Admin") {
                    $str .= '<option>Siswa</option>';
                    $str .= '<option>Admin dan Siswa</option>';
                    $str .= '<option selected>Admin</option>';
                } else {
                    $str .= '<option>Siswa</option>';
                    $str .= '<option>Admin dan Siswa</option>';
                    $str .= '<option>Admin</option>';
                }
                $str .= '</select>';
                $str .= '</div>';
                $str .= '<div class="col-sm-3">';
                $str .= '<label class="col-form-label" style="margin-left:10px;">' . $row->pertanyaan . '</label>';
                $str .= '</div>';
                $str .= '<div class="col-sm-2">';
                $str .= '<select title="Pilih Tabel Rujukan" class="form-control" onchange="pilih_table_rujukan(' . "'" . $row->idcalon_p . "'" . ', this);">';
                if ($row->target_tb == "Tanpa Table") {
                    $str .= '<option selected>Tanpa Table</option>';
                    $str .= '<option>Provinsi</option>';
                    $str .= '<option>Kabupaten / Kota</option>';
                    $str .= '<option>Kecamatan</option>';
                    $str .= '<option>Kelurahan</option>';
                } else if ($row->target_tb == "Kabupaten / Kota") {
                    $str .= '<option selected>Tanpa Table</option>';
                    $str .= '<option>Provinsi</option>';
                    $str .= '<option>Kabupaten / Kota</option>';
                    $str .= '<option>Kecamatan</option>';
                    $str .= '<option>Kelurahan</option>';
                } else {
                    $str .= '<option selected>Tanpa Table</option>';
                    $str .= '<option>Provinsi</option>';
                    $str .= '<option>Kabupaten / Kota</option>';
                    $str .= '<option>Kecamatan</option>';
                    $str .= '<option>Kelurahan</option>';
                }

                $str .= '</select>';
                $str .= '</div>';
                $str .= '<div class="col-sm-2">';
                if ($row->mode == "text") {
                    $str .= '<input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="text" class="form-control" placeholder="Type Here" autocomplete="off">';
                } else if ($row->mode == "radio") {
                    $list2 = $this->model->getAllQ("SELECT idcalon_pd, idcalon_p, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p  = '" . $row->idcalon_p . "';");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="' . $row2->idcalon_pd . '" name="' . $row->idcalon_p . '" value="Laki-laki">
                                <span class="form-check-label">' . $row2->pertanyaan_detil . '</span>
                            </label>';
                    }
                } else if ($row->mode == "checkbox") {
                    $list2 = $this->model->getAllQ("SELECT idcalon_pd, idcalon_p, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p  = '" . $row->idcalon_p . "';");
                    foreach ($list2->getResult() as $row2) {
                        $str .= '<label class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="' . $row2->idcalon_pd . '" name="' . $row->idcalon_p . '[]" value="' . $row2->pertanyaan_detil . '">
                                <span class="form-check-label">' . $row2->pertanyaan_detil . '</span>
                            </label>';
                    }
                } else if ($row->mode == "select") {
                    $str .= '<select id="' . $row->idcalon_p . '" class="form-control">';
                    $list2 = $this->model->getAllQ("SELECT idcalon_pd, idcalon_p, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p  = '" . $row->idcalon_p . "';");
                    foreach ($list2->getResult() as $row2) {
                        if ($row->target_tb == "Provinsi") {
                            // membaca dari table rujukan
                            $ket = $this->model->getAllQR("SELECT nama FROM provinsi where idprovinsi = '" . $row2->pertanyaan_detil . "';")->nama;
                            $str .= '<option value="' . $row2->idcalon_pd . '">' . $ket . '</option>';
                        } else if ($row->target_tb == "Kabupaten / Kota") {
                            // membaca dari table rujukan
                            $ket = $this->model->getAllQR("SELECT name FROM kabupaten where idkabupaten = '" . $row2->pertanyaan_detil . "';")->name;
                            $str .= '<option value="' . $row2->idcalon_pd . '">' . $ket . '</option>';
                        } else if ($row->target_tb == "Kecamatan") {
                            // membaca dari table rujukan
                            $ket = $this->model->getAllQR("SELECT nama FROM kecamatan where idkecamatan = '" . $row2->pertanyaan_detil . "';")->nama;
                            $str .= '<option value="' . $row2->idcalon_pd . '">' . $ket . '</option>';
                        } else if ($row->target_tb == "Kelurahan") {
                            // membaca dari table rujukan
                            $ket = $this->model->getAllQR("SELECT nama FROM kelurahan where idkelurahan = '" . $row2->pertanyaan_detil . "';")->nama;
                            $str .= '<option value="' . $row2->idcalon_pd . '">' . $ket . '</option>';
                        } else {
                            $str .= '<option value="' . $row2->idcalon_pd . '">' . $row2->pertanyaan_detil . '</option>';
                        }
                    }
                    $str .= '</select>';
                } else if ($row->mode == "date") {
                    $str .= '<input id="' . $row->idcalon_p . '" name="' . $row->idcalon_p . '" type="date" class="form-control" placeholder="Type Here" autocomplete="off">';
                }
                $str .= '</div>';
                $str .= '</div>';
            }
            $status = $str;
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }


    public function hapus_pertanyaan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idcalon_p = $this->request->getUri()->getSegment(3);
            // cek apakah dia sdh tersimpan pada calon
            $cek = $this->model->getAllQR("select count(*) as jml from calon_detil where idcalon_p = '" . $idcalon_p . "';")->jml;
            if ($cek > 0) {
                // menampilkan calin siswa pemakai pertanyaan
                $nama = '';
                $listcalon = $this->model->getAllQ("select a.idcalon, b.nama from calon_detil a, calon b where a.idcalon = b.idcalon and a.idcalon_p = '" . $idcalon_p . "';");
                foreach ($listcalon->getResult() as $row) {
                    $nama .= $row->nama . ', ';
                }

                $nama = substr(trim($nama), 0, strlen(trim($nama)) - 1);
                $status = "Data pertanyaan gagal dihapus karena digunakan pada calon siswa " . $nama;
            } else {
                $kond['idcalon_p'] = $idcalon_p;
                $hapus = $this->model->delete("calon_pertanyaan", $kond);
                if ($hapus == 1) {
                    $status = "Data terhapus";
                } else {
                    $status = "Data gagal terhapus";
                }
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add_pertanyaan_detil()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                'idcalon_p' => $this->request->getPost('idcalon_p_detil'),
                'pertanyaan_detil' => $this->request->getPost('pertanyaan_detil')
            );
            $simpan = $this->model->add("calon_pertanyaan_detil", $data);
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

    public function ajax_opsi()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idcalon_p = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT idcalon_pd, idcalon_p, pertanyaan_detil FROM calon_pertanyaan_detil where idcalon_p  = '" . $idcalon_p . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->pertanyaan_detil;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-danger" onclick="hapusopsi(' . "'" . $row->idcalon_pd . "'" . ',' . "'" . $no . "'" . ')"><i class="fas fa-trash-alt"></i></button>'
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

    public function hapusopsi()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $kond['idcalon_pd'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("calon_pertanyaan_detil", $kond);
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

    public function tulis($idcalon)
    {
        // Mengambil data dari tabel 'form_calon' berdasarkan 'idcalon'
        $formData = $this->model->get_by_id('form_calon', ['idcalon' => $idcalon]);

        // Pastikan data ditemukan
        if (!$formData) {
            return redirect()->to('/error')->with('message', 'Data tidak ditemukan.');
        }

        // Kirim data ke view
        return view('back/akademik/calon_siswa/tulismandiri_add', ['form' => $formData]);
    }

    public function tulismandiri()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $data['model'] = $this->model;
            $data['modul'] = $this->modul;

            // Membaca profil pengguna
            $default_foto = base_url() . '/images/noimg.jpg';
            $pro = $this->model->get_by_id('users', ['idusers' => session()->get("idusers")]);
            if (!empty($pro->foto) && file_exists($this->modul->getPathApp() . $pro->foto)) {
                $default_foto = base_url() . '/uploads/' . $pro->foto;
            }

            $data['pro'] = $pro;
            $data['foto_profile'] = $default_foto;

            $idcalon = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
            $cek = $this->model->select_count('form_calon', 'idcalon', ['idcalon' => $idcalon]);

            if ($cek > 0) {
                // Data formulir ditemukan
                $data['head'] = $this->model->get_by_id('form_calon', ['idcalon' => $idcalon]);
                $data['head']->nama_kursus = $this->model->get_by_id('pendidikankursus', ['idpendkursus' => $data['head']->idpendkursus])->nama_kursus;

                $data['curdate'] = $this->modul->TanggalSekarang();

                // Ambil data fullName dari tabel form_calon
                $formCalonData = $this->model->get_by_id('form_calon', ['idcalon' => $idcalon]);
                if ($formCalonData) {
                    $data['formData'] = [
                        'fullName' => $formCalonData->fullName,
                        'nickName' => $formCalonData->nickName,
                        'gender' => $formCalonData->gender,
                        'schoolName' => $formCalonData->schoolName,
                        'classLevel' => $formCalonData->classLevel,
                        'curriculum' => $formCalonData->curriculum,
                        'exp' => $formCalonData->exp,
                        'diagnostic' => $formCalonData->diagnostic,
                        'recom' => $formCalonData->recom,
                        'info' => $formCalonData->info,
                        'phone1' => $formCalonData->phone1,
                        'phone2' => $formCalonData->phone2,
                        'email' => $formCalonData->email,
                        'class_options' => $formCalonData->class_options,
                        'purpose' => $formCalonData->purpose,
                        'domicile' => $formCalonData->domicile,
                    ];
                }

                // Jika ada data dikirim melalui POST
                if ($this->request->getMethod() === 'post') {
                    $formData = $this->request->getPost(); // Ambil semua data dari form
                    $formData['idcalon'] = $idcalon;

                    // Update `$formData` ke `$data` untuk dikirimkan ke view
                    $data['formData'] = array_merge($data['formData'], $formData);

                    // Cek apakah data calon sudah ada
                    $cek_detil = $this->model->select_count('form_calon', 'idcalon', [
                        'idcalon' => $idcalon,
                        'idpendkursus' => $data['head']->idpendkursus
                    ]);

                    if ($cek_detil > 0) {
                        // Update data jika sudah ada
                        $this->model->update('form_calon', $formData, [
                            'idcalon' => $idcalon,
                            'idpendkursus' => $data['head']->idpendkursus
                        ]);
                    } else {
                        // Tambahkan data baru
                        $this->model->add('form_calon', $formData);
                    }

                    // Kirimkan data ke view edit
                    return view('back/akademik/calon_siswa/tulismandiri_edit', $data);
                }

                echo view('back/head', $data);
                if (session()->get("logged_pendidikan")) {
                    echo view('back/akademik/menu');
                } else if (session()->get("logged_hr")) {
                    echo view('back/hrd/menu');
                }

                // Cek mode untuk menentukan tampilan (tambah atau edit)
                $cek_mode = $this->model->select_count('form_calon', 'idcalon', [
                    'idcalon' => $idcalon,
                    'idpendkursus' => $data['head']->idpendkursus
                ]);

                if ($cek_mode > 0) {
                    echo view('back/akademik/calon_siswa/tulismandiri_edit', $data);
                } else {
                    echo view('back/akademik/calon_siswa/tulismandiri_add', $data);
                }

                echo view('back/foot');
            } else {
                $this->modul->halaman('calonsiswa');
            }
        } else {
            $this->modul->halaman('login');
        }
    }






    public function prosestulis()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idpendkursus = $this->request->getPost('idpendkurusus');
            $idcalon = $this->request->getPost('idcalon');

            // menampilkan semua pertanyaan dr itu
            $list = $this->model->getAllQ("SELECT idcalon_p, pertanyaan, mode FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "';");
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

            $this->modul->pesan_halaman('Data tersimpan', 'calonsiswa');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function prosestulisupdate()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $idpendkursus = $this->request->getPost('idpendkurusus');
            $idcalon = $this->request->getPost('idcalon');

            // menampilkan semua pertanyaan dr itu
            $list = $this->model->getAllQ("SELECT idcalon_p, pertanyaan, mode FROM calon_pertanyaan where idpendkursus = '" . $idpendkursus . "';");
            foreach ($list->getResult() as $row) {
                $data = array(
                    'jawaban' => $this->request->getPost($row->idcalon_p)
                );
                $kond['idpendkursus'] = $idpendkursus;
                $kond['idcalon_p'] = $row->idcalon_p;
                $kond['idcalon'] = $idcalon;
                $this->model->update("calon_detil", $data, $kond);
            }

            $this->modul->pesan_halaman('Data tersimpan', 'calonsiswa');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function simpan_urutan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'urutan' => $this->request->getPost('nilai')
            );
            $kond['idcalon_p'] = $this->request->getPost('id');
            $update = $this->model->update("calon_pertanyaan", $data, $kond);
            if ($update == 1) {
                $status = "Urutan terupdate";
            } else {
                $status = "Urutan gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function simpan_input_pada_saat()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {
            $data = array(
                'diisi_oleh' => $this->request->getPost('nilai')
            );
            $kond['idcalon_p'] = $this->request->getPost('id');
            $update = $this->model->update("calon_pertanyaan", $data, $kond);
            if ($update == 1) {
                $status = "Posisi input terupdate";
            } else {
                $status = "Posisi input gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function simpan_table_rujukan()
    {
        if (session()->get("logged_pendidikan") || session()->get("logged_hr")) {


            if ($this->request->getPost('nilai') == "Tanpa Table") {
                $data = array(
                    'mode' => "text",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $status = "Posisi input terupdate";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            } else if ($this->request->getPost('nilai') == "Checkbox") {
                // Handle checkbox input
                $data = array(
                    'mode' => "checkbox",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $list = $this->model->getAllQ("SELECT idcheckbox, label FROM checkbox_options;");
                    foreach ($list->getResult() as $row) {
                        $data = array(
                            'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                            'idcalon_p' => $this->request->getPost('id'),
                            'pertanyaan_detil' => $row->label
                        );
                        $this->model->add("calon_pertanyaan_detil", $data);
                    }
                    $status = "Posisi input terupdate dengan mode checkbox";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            } else if ($this->request->getPost('nilai') == "Provinsi") {
                $data = array(
                    'mode' => "select",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $list = $this->model->getAllQ("SELECT idprovinsi, nama FROM provinsi;");
                    foreach ($list->getResult() as $row) {
                        $data = array(
                            'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                            'idcalon_p' => $this->request->getPost('id'),
                            'pertanyaan_detil' => $row->idprovinsi
                        );
                        $this->model->add("calon_pertanyaan_detil", $data);
                    }
                    $status = "Posisi input terupdate";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            } else if ($this->request->getPost('nilai') == "Kabupaten / Kota") {
                $data = array(
                    'mode' => "select",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $list = $this->model->getAllQ("SELECT idkabupaten, name FROM kabupaten;");
                    foreach ($list->getResult() as $row) {
                        $data = array(
                            'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                            'idcalon_p' => $this->request->getPost('id'),
                            'pertanyaan_detil' => $row->idkabupaten
                        );
                        $this->model->add("calon_pertanyaan_detil", $data);
                    }
                    $status = "Posisi input terupdate";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            } else if ($this->request->getPost('nilai') == "Kecamatan") {
                $data = array(
                    'mode' => "select",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $list = $this->model->getAllQ("SELECT idkecamatan, nama FROM kecamatan;");
                    foreach ($list->getResult() as $row) {
                        $data = array(
                            'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                            'idcalon_p' => $this->request->getPost('id'),
                            'pertanyaan_detil' => $row->idkecamatan
                        );
                        $this->model->add("calon_pertanyaan_detil", $data);
                    }
                    $status = "Posisi input terupdate";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            } else if ($this->request->getPost('nilai') == "Kelurahan") {
                $data = array(
                    'mode' => "select",
                    'target_tb' => $this->request->getPost('nilai')
                );
                $kond['idcalon_p'] = $this->request->getPost('id');
                $update = $this->model->update("calon_pertanyaan", $data, $kond);
                if ($update == 1) {
                    $list = $this->model->getAllQ("SELECT idkelurahan, nama FROM kelurahan;");
                    foreach ($list->getResult() as $row) {
                        $data = array(
                            'idcalon_pd' => $this->model->autokode("D", "idcalon_pd", "calon_pertanyaan_detil", 2, 11),
                            'idcalon_p' => $this->request->getPost('id'),
                            'pertanyaan_detil' => $row->idkelurahan
                        );
                        $this->model->add("calon_pertanyaan_detil", $data);
                    }
                    $status = "Posisi input terupdate";
                } else {
                    $status = "Posisi input gagal terupdate";
                }
            }

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}
