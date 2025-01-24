<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Registrasiulang extends BaseController
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

        echo view('back/single_page/search');
    }

    public function thanks()
    {
        echo view('back/single_page/thanks');
    }

    public function verifikasi_email()
    {
        // Ambil data dari request
        $email = $this->request->getPost('email');
        $idsiswa = $this->request->getPost('idsiswa');

        // Validasi data dari database
        $kondisi = ['email' => $email]; // Perbaiki nama kolom
        $data = $this->model->get_by_id('siswa', $kondisi);

        if ($data) {
            // Jika data ditemukan, kirim respons sukses
            return $this->response->setJSON(['status' => 'ok', 'idsiswa' => $idsiswa]);
        } else {
            // Jika data tidak ditemukan, kirim respons gagal
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email tidak sesuai']);
        }
    }


    public function register($idsiswa)
    {
        // Ambil data siswa berdasarkan email
        $idsiswa_asli = $this->modul->dekrip_url($idsiswa);

        $kondisi = ['idsiswa' => $idsiswa_asli];
        $data['siswa'] = $this->model->get_by_id('siswa', $kondisi);

        $data['provinsi'] = $this->model->getAll("provinsi");

        if (!$data['siswa']) {
            return redirect()->to('/error');
        }

        // Tampilkan halaman register
        return view('back/single_page/register', $data);
    }







    public function form()
    {
        $idsiswa = $this->request->getUri()->getSegment(3);
        if (strlen($idsiswa) > 0) {

            $idsiswa_asli = $this->modul->dekrip_url($idsiswa);

            $data['model'] = $this->model;
            $data['modul'] = $this->modul;
            $data['siswa'] = $this->model->getAllQR("select * from siswa where idsiswa = '" . $idsiswa_asli . "'");
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['status'] = "awal";
            $data['idsiswa_enkrip'] = $this->request->getUri()->getSegment(3);
            $data['provinsi'] = $this->model->getAll("provinsi");
            // melihat status siswa tersebut 
            // jika masih pending maka nampil yang hanya Siswa (Awal)
            // jika diterima maka nampil -> Siswa (Awal) + Siswa (Melangkapi)
            // 1 diterima
            // 0 pending
            // 2 ditolak
            echo view('back/single_page/register', $data);
        } else {
            redirect("https://leapsurabaya.sch.id/");
        }
    }

    public function new()
    {
        $idsiswa = $this->model->autokode("S", "idsiswa", "siswa", 2, 9);
        $idsiswa_asli = $this->modul->dekrip_url($idsiswa);

        $data = array(
            'idsiswa' => $idsiswa,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
        );

        $simpan = $this->model->add("siswa", $data);
        if ($simpan == 1) {
            $status = "ok";
        } else {
            $status = "Gagal";
        }

        echo json_encode(array("status" => $status, 'id' => $this->modul->enkrip_url($idsiswa)));
    }

    public function proses()
    {
        $idsiswa = $this->request->getPost('idsiswa');

        if (strlen($idsiswa) > 0) {
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                if (isset($_FILES['file']['name'])) {
                    if (0 < $_FILES['file']['error']) {
                        $status = "Error during file upload " . $_FILES['file']['error'];
                    } else {
                        $status = $this->update_file();
                    }
                } else {
                    $status = $this->updateSiswa();
                }
            }
            echo json_encode(array("status" => $status, 'id' => $this->modul->enkrip_url($this->request->getPost('idsiswa'))));
        } else {
            $this->modul->halaman('registrasiulang/form/' . $idsiswa);
        }
    }

    private function updateSiswa()
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

    private function update_file()
    {
        $idsiswa = $this->request->getPost('idsiswa');
        $lawas = $this->model->getAllQR("SELECT bukti FROM siswa where idsiswa = '" . $idsiswa . "';")->bukti;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        $extFile = $info_file['ext'];
        if ($extFile == "jpg" || $extFile == "jpeg" || $extFile == "png" || $extFile == "pdf") {
            if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
                $status = "Gunakan nama file lain";
            } else {
                $status_upload = $file->move($this->modul->getPathApp(), $fileName);
                if ($status_upload) {
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
                        'bukti' => $fileName
                    );
                    $kond['idsiswa'] = $this->request->getPost('idsiswa');
                    $simpan = $this->model->update("siswa", $data, $kond);
                    if ($simpan == 1) {
                        $status = "ok";
                    } else {
                        $status = "Data gagal terupdate";
                    }
                } else {
                    $status = "File gagal terupload";
                }
            }
        } else {
            $status = "Tidak diperkenankan upload file";
        }
        return $status;
    }

    public function proses2()
    {
        $idsiswa = $this->request->getPost('idsiswa');
        if (strlen($idsiswa) > 0) {
            $cek = $this->model->getAllQR("select count(*) as jml from siswa where idsiswa = '" . $idsiswa . "';")->jml;
            if ($cek > 0) {
                $status = $this->updateSiswa2();
            }
            echo json_encode(array("status" => $status, 'id' => $this->modul->enkrip_url($this->request->getPost('idsiswa'))));
        } else {
            $this->modul->halaman('registrasiulang/form/' . $idsiswa);
        }
    }

    private function updateSiswa2()
    {
        $data = array(
            'nama_ayah' => $this->request->getPost('nama_ayah'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'jenjang_ayah' => $this->request->getPost('jenjang_ayah'),
            'penghasilan_ayah' => $this->request->getPost('penghasilan_ayah'),
            'nama_ibu' => $this->request->getPost('nama_ibu'),
            'pekerjaan_ortu' => $this->request->getPost('pekerjaan_ibu'),
            'penghasilan_ibu' => $this->request->getPost('penghasilan_ibu'),
            'jenjang_ibu' => $this->request->getPost('jenjang_ibu'),
            'nama_wali' => $this->request->getPost('nama_wali'),
            'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
            'jenjang_wali' => $this->request->getPost('jenjang_wali'),
            'penghasilan_wali' => $this->request->getPost('penghasilan_wali'),
            'email' => $this->request->getPost('email'),
            'wawalmur' => $this->request->getPost('wawalmur'),
            'waadmin' => $this->request->getPost('waadmin'),
            'wapeserta' => $this->request->getPost('wapeserta'),
            'sts_pengisian' => 'Sudah Lengkap',
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

    public function kabupaten()
    {
        $idprovinsi = $this->request->getPost('provinsi');
        $status = '<option value="-">- Pilih Kabupaten -</option>';
        $list = $this->model->getAllQ("select idkabupaten, name from kabupaten where idprovinsi = '" . $idprovinsi . "';");
        foreach ($list->getResult() as $row) {
            $status .= '<option value="' . $row->idkabupaten . '">' . $row->name . '</option>';
        }
        echo json_encode(array("status" => $status));
    }

    public function kecamatan()
    {
        $idkabupaten = $this->request->getPost('kabupaten');
        $status = '<option value="-">- Pilih Kecamatan -</option>';
        $list = $this->model->getAllQ("select idkecamatan, nama from kecamatan where idkabupaten = '" . $idkabupaten . "';");
        foreach ($list->getResult() as $row) {
            $status .= '<option value="' . $row->idkecamatan . '">' . $row->nama . '</option>';
        }
        echo json_encode(array("status" => $status));
    }

    public function kelurahan()
    {
        $idkecamatan = $this->request->getPost('kecamatan');
        $status = '<option value="-">- Pilih Kelurahan -</option>';
        $list = $this->model->getAllQ("select idkelurahan, nama from kelurahan where idkecamatan = '" . $idkecamatan . "';");
        foreach ($list->getResult() as $row) {
            $status .= '<option value="' . $row->idkelurahan . '">' . $row->nama . '</option>';
        }
        echo json_encode(array("status" => $status));
    }

    public function cari()
    {
        $nama = rtrim($this->request->getPost('nama_lengkap'));
        $searchTerms = explode(" ", $nama);
        $jml = $this->model->getAllQR("select count(*) as jml from siswa where nama_lengkap like '%" . $nama . "%';")->jml;

        if ($jml > 0) {
            $status = '<tr>
                    <th>Nama Siswa</th>
                    <th>Aksi</th>
                </tr>';
            $list = $this->model->getAllQ("select idsiswa, nama_lengkap from siswa where nama_lengkap like '%" . $nama . "%';");
            foreach ($list->getResult() as $row) {
                $status .= '<tr>';
                $status .= '<td>' . $row->nama_lengkap . '</td>';
                $status .= '<td><a href="#" onclick="bukaModal(' . "'" . $this->modul->enkrip_url($row->idsiswa) . "'" . ')"><i class="fas fa-link"></i>&nbsp;&nbsp;Lengkapi Data</a>
                        </td>';
                $status .= '</tr>';
            }
        } else {
            $status = 'Data siswa tidak ditemukan.';
            $status .= '<br><a href="#" onclick="buatbaru(' . "'" . $nama . "'" . ')">BUAT BARU</a>';
        }

        echo json_encode(array("status" => $status));
    }


    public function form2()
    {
        $idsiswa = $this->request->getUri()->getSegment(3);
        if (strlen($idsiswa) > 0) {

            $idsiswa_asli = $this->modul->dekrip_url($idsiswa);

            $data['model'] = $this->model;
            $data['modul'] = $this->modul;
            $data['siswa'] = $this->model->getAllQR("select * from siswa where idsiswa = '" . $idsiswa_asli . "'");
            $data['curdate'] = $this->modul->TanggalSekarang();
            $data['status'] = "awal";
            $data['idsiswa_enkrip'] = $this->request->getUri()->getSegment(3);

            echo view('back/single_page/register2', $data);
        } else {
            redirect("https://leapsurabaya.sch.id/");
        }
    }
}
