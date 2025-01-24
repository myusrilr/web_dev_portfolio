<?php

namespace App\Controllers;

use App\Models\ModelSiswa;


class Siswa extends BaseController
{
	protected $model;

	public function __construct()
	{
		$this->model = new ModelSiswa();
	}

	public function hapus($id)
	{
		// Cek jika data siswa dengan id tersebut ada
		if ($this->model->find($id)) {
			// Proses hapus data
			$this->model->delete($id);

			// Set pesan sukses
			session()->setFlashdata('message', 'Data siswa berhasil dihapus');
		} else {
			// Set pesan gagal jika data tidak ditemukan
			session()->setFlashdata('message', 'Data siswa tidak ditemukan');
		}

		// Redirect kembali ke halaman daftar siswa
		return redirect()->to('/');
	}

	public function getDataSiswa($id)
{
    $siswa = $this->model->find($id);
    if ($siswa) {
        return json_encode($siswa);
    } else {
        return json_encode(['error' => 'Data siswa tidak ditemukan']);
    }
}




public function simpan()
{
    $validasi = \Config\Services::validation();
    $aturan = [
        'nama' => [
            'label' => 'Nama',
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => '{field} harus diisi',
                'min_length' => 'Minimum karakter untuk field {field} adalah 5 karakter'
            ]
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|min_length[5]|valid_email',
            'errors' => [
                'required' => '{field} harus diisi',
                'min_length' => 'Minimum karakter untuk field {field} adalah 5 karakter',
                'valid_email' => 'Email yang kamu masukkan tidak valid'
            ]
        ],
    ];

    $validasi->setRules($aturan);
    if ($validasi->withRequest($this->request)->run()) {
        $id = $this->request->getPost('id');  // Mendapatkan ID dari form input
        $nama = $this->request->getPost('nama');  // Nama baru
        $email = $this->request->getPost('email');  // Email baru

        $data = [
            'nama' => $nama,
            'email' => $email,
        ];

        if ($id) { // Jika ID ada, berarti update
            $data['id'] = $id;
            $this->model->save($data);
            $hasil['sukses'] = "Data berhasil diupdate";
        } else { // Jika ID tidak ada, berarti insert
            $this->model->insert($data);
            $hasil['sukses'] = "Data berhasil ditambahkan";
        }
        
        $hasil['error'] = false;
    } else {
        $hasil['sukses'] = false;
        $hasil['error'] = $validasi->listErrors();
    }

    return json_encode($hasil); // Mengembalikan hasil dalam format JSON
}


	public function index()
	{
		$jumlahBaris = 5;
		$katakunci = $this->request->getGet('katakunci');
		if ($katakunci) {
			$pencarian = $this->model->cari($katakunci);
		} else {
			$pencarian = $this->model;
		}
		$data['katakunci'] = $katakunci;
		$data['dataSiswa'] = $pencarian->orderBy('id', 'desc')->paginate($jumlahBaris);
		$data['pager'] = $this->model->pager;
		$data['nomor'] = ($this->request->getVar('page') == 1) ? '0' : $this->request->getVar('page');
		return view('siswa_view', $data);
	}
}
