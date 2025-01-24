<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Visual extends BaseController
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
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
            if (strlen($data['pro']->foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $data['pro']->foto)) {
                    $def_foto = base_url() . '/uploads/' . $data['pro']->foto;
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

            $tahun  = $this->modul->getTahun();
            $bulan  = $this->modul->getBulan();

            $data['tahun']  = $tahun;
            $data['bulan']  = $bulan;

            $jml_siswa = $this->model->getAllQR("select count(*) as jml from siswa;")->jml;
            $jml_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar;")->jml;
            $jml_siswa_regular = $jml_siswa - $jml_keluar;
            $data['siswa_masuk_regular'] = $jml_siswa;
            $data['siswa_keluar_regular'] = $jml_keluar;

            //$mitra_masuk = $this->model->getAllQR("select count(*) as jml from siswamitra;")->jml;
            //$mitra_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar_mitra;")->jml;
            //$jml_siswa_mitra = $mitra_masuk - $mitra_keluar;

            $jml_siswa_mitra = $this->model->getAllQR("select count(*) as jml from siswa where idmitra in(select idmitra from mitra);")->jml;

            $data['jml_siswa_regular']  = $jml_siswa_regular;
            $data['jml_siswa_mitra']  = $jml_siswa_mitra;
            $data['jml_total_siswa']  = $jml_siswa_regular + $jml_siswa_mitra;
            
            

            $data_siswa = array();
            array_push($data_siswa, (int)$jml_siswa_regular);
            array_push($data_siswa, (int)$jml_siswa_mitra);
            $data['siswa'] = json_encode($data_siswa);

            // menampilkan yang no 2
            $listno2 = $this->model->getAllQ("select b.nama, count(*) as jml
            from siswa a, provinsi b
            where a.provinsi = b.idprovinsi and a.provinsi not in('','-') group by a.provinsi order by count(*) desc limit 12;");
            $data['no2'] = $listno2;
            $data_jml_by_prov = array();
            $total_no2 = 0;
            foreach ($listno2->getResult() as $row) {
                array_push($data_jml_by_prov, (int)$row->jml);
                $total_no2 += (int)$row->jml;
            }
            $data['grapNo2'] = json_encode($data_jml_by_prov);
            $data['totalNo2'] = $total_no2;


            // menampilkan grafik
            $data_siswa_keluar = array();
            for ($i = 1; $i <= 12; $i++) {
                $nilai = $this->model->getAllQR("SELECT count(*) as jml FROM siswa_keluar where month(tanggal) = '" . $i . "';")->jml;
                array_push($data_siswa_keluar, $nilai);
            }
            $data['data_siswa_keluar'] = json_encode($data_siswa_keluar);

            $data_siswa_masuk = array();
            for ($i = 1; $i <= 12; $i++) {
                $nilai = $this->model->getAllQR("SELECT count(*) as jml FROM siswa where month(tgl_daftar) = '" . $i . "';")->jml;
                array_push($data_siswa_masuk, $nilai);
            }
            $data['data_siswa_masuk'] = json_encode($data_siswa_masuk);

            $data_nama_kursus = array();
            $data_jml_siswa_kursus = array();

            $jml_kelas = $this->model->getAllQR("SELECT count(*) as jml FROM pendidikankursus;")->jml;
            $kelas = $this->model->getAllQ("SELECT idpendkursus, nama_kursus FROM pendidikankursus;");
            foreach ($kelas->getResult() as $row) {
                // menghitung jumlah terbanyak
                $jml_siswa_per_kelas = $this->model->getAllQR("SELECT count(*) as jml FROM siswa a, jadwal b, jadwal_siswa c
                where a.keluar = 0 and b.idjadwal = c.idjadwal and c.idsiswa = a.idsiswa and year(a.tgl_daftar) = '" . $tahun . "' and b.idpendkursus = '" . $row->idpendkursus . "';")->jml;

                array_push($data_nama_kursus, $row->nama_kursus);
                array_push($data_jml_siswa_kursus, $jml_siswa_per_kelas);
            }
            $data['jml_kursus'] = $jml_kelas;
            $data['nama_kursus'] = json_encode($data_nama_kursus);
            $data['jml_siswa_kursus'] = json_encode($data_jml_siswa_kursus);

            $jml_tag = $this->model->getAllQR("SELECT count(*) as jml FROM tag_keluar;")->jml;
            $data['jml_tag'] = $jml_tag;

            $data_tag = array();
            $data_keluar_tag = array();
            $tag = $this->model->getAllQ("SELECT idtag, tag FROM tag_keluar;");
            foreach ($tag->getResult() as $row) {
                $jml_keluar = $this->model->getAllQR("SELECT count(*) as jml FROM siswa_keluar_tag a, siswa b where a.idtag = '" . $row->idtag . "' and a.idsiswa = b.idsiswa and year(b.tgl_daftar) = " . $tahun . ";")->jml;

                array_push($data_tag, $row->tag);
                array_push($data_keluar_tag, $jml_keluar);
            }
            $data['nama_tag'] = json_encode($data_tag);
            $data['jml_keluar_tag'] = json_encode($data_keluar_tag);

            $data_periode = array();
            $jml_data_periode = array();
            $counter = 0;
            $periode = $this->model->getAllQ("select idperiode, nama_term, bulan_awal, tahun_awal from periode where tahun_awal = '" . $tahun . "';");
            foreach ($periode->getResult() as $row) {
                $bulan_periode = $this->ubahBulan($row->bulan_awal);
                $tahun_periode = $row->tahun_awal;

                $jml_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar where year(tanggal) = '" . $tahun_periode . "' and month(tanggal) = '" . $bulan_periode . "';")->jml;

                // menghitung jumlah yang keluar pada periode tersebut
                array_push($data_periode, $row->nama_term);
                array_push($jml_data_periode, $jml_keluar);

                $counter++;
            }
            $data['nama_periode'] = json_encode($data_periode);
            $data['jml_keluar_periode'] = json_encode($jml_data_periode);
            $data['jml_periode'] = $counter;

            $datatahun = '';
            $start_tahun = $this->modul->getTahun();
            $end_tahun = $start_tahun - 3;
            for ($i = $start_tahun; $i >= $end_tahun; $i--) {
                if($i == $start_tahun){
                    $datatahun .= '<option selected>' . $i . '</option>';
                }else{
                    $datatahun .= '<option>' . $i . '</option>';
                }
                
            }
            $data['datatahun'] = $datatahun;

            // demografi
            $data_usia_demografi_laki = array();

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Laki-laki';")->jml;
            array_push($data_usia_demografi_laki, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Laki-laki';")->jml;
            array_push($data_usia_demografi_laki, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Laki-laki';")->jml;
            array_push($data_usia_demografi_laki, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Laki-laki';")->jml;
            array_push($data_usia_demografi_laki, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Laki-laki';")->jml;
            array_push($data_usia_demografi_laki, $jmltemp);

            $data['data_usia_demografi_laki'] = json_encode($data_usia_demografi_laki);

            $data_usia_demografi_perempuan = array();
            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Perempuan';")->jml;
            array_push($data_usia_demografi_perempuan, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Perempuan';")->jml;
            array_push($data_usia_demografi_perempuan, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Perempuan';")->jml;
            array_push($data_usia_demografi_perempuan, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Perempuan';")->jml;
            array_push($data_usia_demografi_perempuan, $jmltemp);

            $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Perempuan';")->jml;
            array_push($data_usia_demografi_perempuan, $jmltemp);

            $data['data_usia_demografi_perempuan'] = json_encode($data_usia_demografi_perempuan);

            $demografi_tingkat_perempuan = array();
            $demografi_tingkat_laki = array();
            $datatingkat = array("TK", "SD", "SMP", "SMA", "D3",  "D4", "S1", "S2");
            for ($i = 0; $i < count($datatingkat); $i++) {
                $tingkat = $datatingkat[$i];
                $jmltemp_L = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Laki-laki';")->jml;
                array_push($demografi_tingkat_laki, $jmltemp_L);

                $jmltemp_P = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Perempuan';")->jml;
                array_push($demografi_tingkat_perempuan, $jmltemp_P);
            }
            $data['demografi_tingkat_p'] = json_encode($demografi_tingkat_perempuan);
            $data['demografi_tingkat_l'] = json_encode($demografi_tingkat_laki);

            // demografi lokasi siswa
            $def_idKabkot = "";
            $def_namaKabkot = "";

            $nama_lokasi_siswa = array();
            $nama_lokasi_siswaL = array();
            $nama_lokasi_siswaP = array();

            $lokasi = $this->model->getAllQ("select * from kabupaten where idkabupaten = '3578';");
            foreach ($lokasi->getResult() as $row) {
                
                $def_idKabkot = $row->idkabupaten;
                $def_namaKabkot = $row->name;

                array_push($nama_lokasi_siswa, $row->name);

                // mencari jumlah laki
                $jml = $this->model->getAllQR("select count(*) as jml from siswa where kabupaten = '" . $row->idkabupaten . "' and jkel = 'Laki-laki';")->jml;
                array_push($nama_lokasi_siswaL, $jml);

                // mencari jumlah perempuan
                $jml = $this->model->getAllQR("select count(*) as jml from siswa where kabupaten = '" . $row->idkabupaten . "' and jkel = 'Perempuan';")->jml;
                array_push($nama_lokasi_siswaP, $jml);
            }
            $data['lokasi_siswa'] = json_encode($nama_lokasi_siswa);
            $data['lokasi_siswaL'] = json_encode($nama_lokasi_siswaL);
            $data['lokasi_siswaP'] = json_encode($nama_lokasi_siswaP);

            $data['def_idKabkot'] = $def_idKabkot;
            $data['def_namaKabkot'] = $def_namaKabkot;

            $data['prosentase_pembelian_ulang'] = $this->hitungKursusUlang();


            $kursus3 = array();
            $masuk3 = array();
            $keluar3 = array();

            $kursus = $this->model->getAllQ("SELECT idpendkursus, nama_kursus FROM pendidikankursus;");
            foreach ($kursus->getResult() as $row) {
                $masuk1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa a, jadwal_siswa b
                where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                $masuk2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswamitra a, jadwal_siswa b
                where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                $keluar1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar a, jadwal_siswa b
                where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                $keluar2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar_mitra a, jadwal_siswa b
                where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                $masuk = $masuk1 + $masuk2;
                $keluar = $keluar1 + $keluar2;

                array_push($kursus3, $row->nama_kursus);
                array_push($masuk3, $masuk);
                array_push($keluar3, $keluar);
            }
            $data['kursus3'] = json_encode($kursus3);
            $data['masuk3'] = json_encode($masuk3);
            $data['keluar3'] = json_encode($keluar3);


            $bertahan_coding = array();
            $jml_0_6 = 0;
            $jml_7_12 = 0;
            $jml_13_18 = 0;
            $jml_19_24 = 0;
            $list_bertahan_coding = $this->model->getAllQ("select b.idsiswa, b.tgl_daftar, ifnull(round(avg(TIMESTAMPDIFF(MONTH, b.tgl_daftar, now()))), 0) as lama
            from jadwal_siswa a, siswa b, jadwal c, pendidikankursus d
            where a.idsiswa = b.idsiswa and a.idjadwal = c.idjadwal and c.idpendkursus = d.idpendkursus
            and c.idpendkursus = 'K00002' group by b.idsiswa;");
            foreach ($list_bertahan_coding->getResult() as $row) {
                if($row->lama >= 0 && $row->lama <= 6){
                    $jml_0_6++;
                }else if($row->lama >= 7 && $row->lama <= 12){
                    $jml_7_12++;
                }else if($row->lama >= 13 && $row->lama <= 18){
                    $jml_13_18++;
                }else if($row->lama >= 19 && $row->lama <= 24){
                    $jml_19_24++;
                }
            }
            array_push($bertahan_coding, $jml_0_6);
            array_push($bertahan_coding, $jml_7_12);
            array_push($bertahan_coding, $jml_13_18);
            array_push($bertahan_coding, $jml_19_24);
            $data['bertahan_coding'] = json_encode($bertahan_coding);

            $bertahan_general_english = array();
            $jml_0_1 = 0;
            $jml_2_3 = 0;
            $jml_4_5 = 0;
            $jml_6_7 = 0;
            $jml_8up = 0;
            $list_bertahan_coding = $this->model->getAllQ("select b.idsiswa, b.tgl_daftar, ifnull(round(avg(TIMESTAMPDIFF(YEAR, b.tgl_daftar, now()))), 0) as lama
            from jadwal_siswa a, siswa b, jadwal c, pendidikankursus d
            where a.idsiswa = b.idsiswa and a.idjadwal = c.idjadwal and c.idpendkursus = d.idpendkursus
            and c.idpendkursus = 'K00001' group by b.idsiswa;");
            foreach ($list_bertahan_coding->getResult() as $row) {
                if($row->lama >= 0 && $row->lama <= 1){
                    $jml_0_1++;
                }else if($row->lama >= 2 && $row->lama <= 3){
                    $jml_2_3++;
                }else if($row->lama >= 4 && $row->lama <= 5){
                    $jml_4_5++;
                }else if($row->lama >= 6 && $row->lama <= 7){
                    $jml_6_7++;
                }else if($row->lama > 7){
                    $jml_8up++;
                }
            }
            array_push($bertahan_general_english, $jml_0_1);
            array_push($bertahan_general_english, $jml_2_3);
            array_push($bertahan_general_english, $jml_4_5);
            array_push($bertahan_general_english, $jml_6_7);
            array_push($bertahan_general_english, $jml_8up);
            $data['bertahan_ge'] = json_encode($bertahan_general_english);

            // total instansi kerjasama
            $data['total_instansi'] = $this->model->getAllQR("select count(*) as jml from mitra where status = 'on-going' or status = 'done';")->jml;

            $data_mitra = array();
            $mitra_laki = array();
            $mitra_perempuan = array();

            $mitra = $this->model->getAllQ("select * from mitra where status = 'on-going' or status = 'done';");
            foreach ($mitra->getResult() as $row) {
                array_push($data_mitra, $row->instansi);
                // menghitung jml laki-laki mitra
                $laki = $this->model->getAllQR("select count(*) as jml from siswa where jkel = 'Laki-laki' and idmitra = '".$row->idmitra."';")->jml;
                array_push($mitra_laki, $laki);

                // menghitung jml perempuan mitra
                $perempuan = $this->model->getAllQR("select count(*) as jml from siswa where jkel = 'Perempuan' and idmitra = '".$row->idmitra."';")->jml;
                array_push($mitra_perempuan, $perempuan);
            }
            $data['mitra'] = json_encode($data_mitra);
            $data['mitra_laki'] = json_encode($mitra_laki);
            $data['mitra_perempuan'] = json_encode($mitra_perempuan);

            // demografi B2B jumlah karyawan
            $b2b_jumlah_karyawan = array();
            $b2b_1_5 = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where jml between 1 and 5;")->jml;
            $b2b_6_25 = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where jml between 6 and 25;")->jml;
            $b2b_26_50 = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where jml between 26 and 50;")->jml;
            $b2b_51_100 = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where jml between 51 and 100;")->jml;
            $b2b_101_up = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where jml > 101;")->jml;
            
            array_push($b2b_jumlah_karyawan, $b2b_1_5);
            array_push($b2b_jumlah_karyawan, $b2b_6_25);
            array_push($b2b_jumlah_karyawan, $b2b_26_50);
            array_push($b2b_jumlah_karyawan, $b2b_51_100);
            array_push($b2b_jumlah_karyawan, $b2b_101_up);
            $data['b2b_jumlah_karyawan'] = json_encode($b2b_jumlah_karyawan);

            // demografi B2B bidang usaha
            $counter_b2b_bidang_usaha = 0;
            $nama_b2b_bidang_usaha = array();
            $jumlah_b2b_bidang_usaha = array();
            $list_b2b_bidang_usaha = $this->model->getAllQ("SELECT bidang, count(*) as jml FROM mitra where status = 'on-going' or status = 'done' group by bidang;");
            foreach ($list_b2b_bidang_usaha->getResult() as $row) {
                array_push($nama_b2b_bidang_usaha, $row->bidang);
                array_push($jumlah_b2b_bidang_usaha, $row->jml);
                $counter_b2b_bidang_usaha++;
            }
            $data['nama_b2b_bidang_usaha'] = json_encode($nama_b2b_bidang_usaha);
            $data['jumlah_b2b_bidang_usaha'] = json_encode($jumlah_b2b_bidang_usaha);
            $data['counter_b2b_bidang_usaha'] = $counter_b2b_bidang_usaha;

            // demografi B2B provinsi
            $counter_b2b_provinsi = 0;
            $nama_b2b_provinsi = array();
            $jumlah_b2b_provinsi = array();
            $list_b2b_provinsi = $this->model->getAllQ("SELECT provinsi, count(*) as jml FROM mitra where provinsi is not null and status = 'on-going' or status = 'done' group by provinsi;");
            foreach ($list_b2b_provinsi->getResult() as $row) {
                $prov = $this->model->getAllQR("SELECT nama from provinsi where idprovinsi = '".$row->provinsi."'")->nama;
                array_push($nama_b2b_provinsi, $prov);
                array_push($jumlah_b2b_provinsi, $row->jml);
                $counter_b2b_provinsi++;
            }
            $data['nama_b2b_provinsi'] = json_encode($nama_b2b_provinsi);
            $data['jumlah_b2b_provinsi'] = json_encode($jumlah_b2b_provinsi);
            $data['counter_b2b_provinsi'] = $counter_b2b_provinsi;

            // demografi B2B kabupaten kota
            $counter_b2b_kabkot = 0;
            $nama_b2b_kabkot = array();
            $jumlah_b2b_kabkot = array();
            $list_b2b_kabkot = $this->model->getAllQ("SELECT kotkab, count(*) as jml FROM mitra where kotkab is not null and status = 'on-going' or status = 'done' group by kotkab;");
            foreach ($list_b2b_kabkot->getResult() as $row) {
                $kk = $this->model->getAllQR("SELECT name from kabupaten where idkabupaten = '".$row->kotkab."'")->name;
                array_push($nama_b2b_kabkot, $kk);
                array_push($jumlah_b2b_kabkot, $row->jml);
                $counter_b2b_kabkot++;
            }
            $data['nama_b2b_kabkot'] = json_encode($nama_b2b_kabkot);
            $data['jumlah_b2b_kabkot'] = json_encode($jumlah_b2b_kabkot);
            $data['counter_b2b_kabkot'] = $counter_b2b_kabkot;

            // mencari jumlah kerjasama
            $counter_ins_lama_kerjasama = 0;
            $nama_ins_kerjasama = array();
            $jumlah_ins_kerjasama = array();
            $list_ins_kerjasama = $this->model->getAllQ("select a.idmitra, a.instansi, ifnull(sum(TIMESTAMPDIFF(MONTH, b.startdate, b.enddate)),0) AS bulan
                from mitra a
                left join mitra_note b on a.idmitra = b.idmitra
                group by a.idmitra;");
            foreach ($list_ins_kerjasama->getResult() as $row) {
                array_push($nama_ins_kerjasama, $row->instansi);
                array_push($jumlah_ins_kerjasama, $row->bulan);
                $counter_ins_lama_kerjasama++;
            }
            $data['nama_ins_kerjasama'] = json_encode($nama_ins_kerjasama);
            $data['jumlah_ins_kerjasama'] = json_encode($jumlah_ins_kerjasama);
            $data['counter_ins_lama_kerjasama'] = $counter_ins_lama_kerjasama;

            // tentang leapverse
            $jml_leapverse = $this->model->getAllQR("SELECT count(*) as jml FROM leapverse;")->jml;
            if($jml_leapverse > 0){
                $leapverse = $this->model->getAllQR("SELECT download FROM leapverse order by idleapverse desc limit 1;");

                $data['total_leapverse_download'] = $leapverse->download;
            }else{
                $data['total_leapverse_download'] = 0;
            }

            // total mitra leapverse
            $data['mitra_leapverse'] = $this->model->getAllQR("SELECT count(*) as jml FROM mitra where status = 'on-going' or status = 'done' and leapverse = 'Ya';")->jml;

            // mengetahui leapverse aktif grafik
            $tgl_leapverse_aktif = array();
            $jumlah_leapverse_aktif = array();
            $list_leapverse = $this->model->getAllQ("SELECT date_format(tgl, '%d-%m-%Y') as tgl, aktif FROM leapverse where year(tgl) = '".$tahun."' and month(tgl) = '".$bulan."' order by idleapverse asc;");
            foreach ($list_leapverse->getResult() as $row) {
                array_push($tgl_leapverse_aktif, $row->tgl);
                array_push($jumlah_leapverse_aktif, $row->aktif);
            }
            $data['tgl_leapverse_aktif'] = json_encode($tgl_leapverse_aktif);
            $data['jumlah_leapverse_aktif'] = json_encode($jumlah_leapverse_aktif);

            echo view('back/head', $data);
            if(session()->get("logged_bos")){
                echo view('back/bos/menu');
            }else if(session()->get("hr")){
                echo view('back/hrd/menu');
            }else if(session()->get("logged_busdev")){
                echo view('back/busdev/menu');
            }else if(session()->get("logged_it")){
                echo view('back/it/menu');
            }
            echo view('back/hrd/visual/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function load_jml_siswa()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan  = $this->request->getUri()->getSegment(3);
            $tahun  = $this->request->getUri()->getSegment(4);

            $qMasuk1 = "select count(*) as jml from siswa";
            $qKeluar1 = "select count(*) as jml from siswa_keluar";

            $qMasuk2 = "select count(*) as jml from siswamitra";
            $qKeluar2 = "select count(*) as jml from siswa_keluar_mitra";

            if ($bulan != "~" && $tahun != "~") {
                $qMasuk1 .= " where month(tgl_daftar) = '" . $bulan . "' and year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar1 .= " where month(tanggal) = '" . $bulan . "' and year(tanggal) = '" . $tahun . "' ";

                $qMasuk2 .= " where month(tgl_daftar) = '" . $bulan . "' and year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar2 .= " where month(tanggal) = '" . $bulan . "' and year(tanggal) = '" . $tahun . "' ";
            } else if ($bulan != "~") {
                $qMasuk1 .= " where month(tgl_daftar) = '" . $bulan . "' ";
                $qKeluar1 .= " where month(tanggal) = '" . $bulan . "' ";

                $qMasuk2 .= " where month(tgl_daftar) = '" . $bulan . "' ";
                $qKeluar2 .= " where month(tanggal) = '" . $bulan . "' ";
            } else if ($tahun != "~") {
                $qMasuk1 .= " where year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar1 .= " where year(tanggal) = '" . $tahun . "' ";

                $qMasuk2 .= " where year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar2 .= " where year(tanggal) = '" . $tahun . "' ";
            }

            $jml_siswa_regu_masuk = $this->model->getAllQR($qMasuk1)->jml;
            $jml_siswa_regu_keluar = $this->model->getAllQR($qKeluar1)->jml;
            $jml_siswa_regular = $jml_siswa_regu_masuk - $jml_siswa_regu_keluar;

            $jml_siswa_mitra_masuk = $this->model->getAllQR($qMasuk2)->jml;
            $jml_siswa_mitra_keluar = $this->model->getAllQR($qKeluar2)->jml;
            $jml_siswa_mitra = $jml_siswa_mitra_masuk - $jml_siswa_mitra_keluar;

            echo json_encode(
                array(
                    "jml_siswa_regular" => $jml_siswa_regular,
                    "jml_siswa_mitra" => $jml_siswa_mitra,
                    "jml_total_siswa" => ($jml_siswa_regular + $jml_siswa_mitra)
                )
            );
        } else {
            $this->modul->halaman('login');
        }
    }

    public function load_masuk_keluar()
    {
        if (session()->get("logged_hr")) {
            $tahun  = $this->request->getUri()->getSegment(3);

            $qMasuk1 = "select count(*) as jml from siswa";
            $qKeluar1 = "select count(*) as jml from siswa_keluar";

            $qMasuk2 = "select count(*) as jml from siswamitra";
            $qKeluar2 = "select count(*) as jml from siswa_keluar_mitra";

            if ($tahun != "~") {
                $qMasuk1 .= " where year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar1 .= " where year(tanggal) = '" . $tahun . "' ";

                $qMasuk2 .= " where year(tgl_daftar) = '" . $tahun . "' ";
                $qKeluar2 .= " where year(tanggal) = '" . $tahun . "' ";
            }

            $jml_siswa_regu_masuk = $this->model->getAllQR($qMasuk1)->jml;
            $jml_siswa_regu_keluar = $this->model->getAllQR($qKeluar1)->jml;

            $jml_siswa_mitra_masuk = $this->model->getAllQR($qMasuk2)->jml;
            $jml_siswa_mitra_keluar = $this->model->getAllQR($qKeluar2)->jml;

            $masuk = $jml_siswa_regu_masuk + $jml_siswa_mitra_masuk;
            $keluar = $jml_siswa_regu_keluar + $jml_siswa_mitra_keluar;

            echo json_encode(
                array(
                    "siswa_masuk_regular" => $jml_siswa_regu_masuk,
                    "siswa_keluar_regular" => $jml_siswa_regu_keluar,
                    "siswa_masuk_mitra" => $jml_siswa_mitra_masuk,
                    "siswa_keluar_mitra" => $jml_siswa_mitra_keluar,
                    "siswa_masuk" => $masuk,
                    "siswa_keluar" => $keluar
                )
            );
        } else {
            $this->modul->halaman('login');
        }
    }

    private function hitungKursusUlang()
    {
        $total_sebagian = 0;
        $total_siswa = 0;
        //$data = array();
        $list = $this->model->getAll("siswa");
        foreach ($list->getResult() as $row) {
            $nilai = 0;
            $list2 = $this->model->getAllQ("select b.idsiswa, a.idpendkursus
            from jadwal a, jadwal_siswa b where a.idjadwal = b.idjadwal and b.idsiswa = '" . $row->idsiswa . "'
            and a.idpendkursus in(SELECT idpendkursus FROM pendidikankursus) group by a.idpendkursus;");
            foreach ($list2->getResult() as $row1) {
                $nilai++;
            }

            if ($nilai > 1) {
                //array_push($data, array('idsiswa' => $row->idsiswa, 'jumlah' => $nilai));
                $total_sebagian++;
            }

            $total_siswa++;
        }
        return ($total_sebagian / $total_siswa) * 100;
    }

    private function ubahBulan($namaBulan)
    {
        $bulan = "0";
        if (strtolower($namaBulan) == "januari") {
            $bulan = "01";
        } else if (strtolower($namaBulan) == "februari") {
            $bulan = "02";
        } else if (strtolower($namaBulan) == "maret") {
            $bulan = "03";
        } else if (strtolower($namaBulan) == "april") {
            $bulan = "04";
        } else if (strtolower($namaBulan) == "mei") {
            $bulan = "05";
        } else if (strtolower($namaBulan) == "juni") {
            $bulan = "06";
        } else if (strtolower($namaBulan) == "juli") {
            $bulan = "07";
        } else if (strtolower($namaBulan) == "agustus") {
            $bulan = "08";
        } else if (strtolower($namaBulan) == "september") {
            $bulan = "09";
        } else if (strtolower($namaBulan) == "oktober") {
            $bulan = "10";
        } else if (strtolower($namaBulan) == "november") {
            $bulan = "11";
        } else if (strtolower($namaBulan) == "desember") {
            $bulan = "12";
        }
        return $bulan;
    }

    public function load_marker()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $result = array();
            $list = $this->model->getAllQ("select count(idsiswa) as jml, b.idkabupaten, b.name, b.lat, b.lon
            from siswa a
            join kabupaten b on a.kabupaten = b.idkabupaten
            where kabupaten not in('', '-')  group by kabupaten limit 15;");
            foreach ($list->getResult() as $row) {
                array_push($result, array(
                    'idkab' => $row->idkabupaten,
                    'nama' => $row->name,
                    'simbol' => base_url() . '/leaf/images/marker-icon.png',
                    'lat' => $row->lat,
                    'lon' => $row->lon,
                    'jmlsiswa' => $row->jml
                ));
            }

            echo json_encode($result);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function siswa_masuk_keluar()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $tahun = $this->request->getPost('tahun');

            $data_siswa_keluar = array();
            for ($i = 1; $i <= 12; $i++) {
                $q = "SELECT count(*) as jml FROM siswa_keluar where year(tanggal) = '" . $tahun . "' and month(tanggal) = '" . $i . "';";
                if ($tahun == "All") {
                    $q = "SELECT count(*) as jml FROM siswa_keluar where month(tanggal) = '" . $i . "';";
                }
                $nilai = $this->model->getAllQR($q)->jml;
                array_push($data_siswa_keluar, $nilai);
            }

            $data_siswa_masuk = array();
            for ($i = 1; $i <= 12; $i++) {
                $q = "SELECT count(*) as jml FROM siswa where year(tgl_daftar) = '" . $tahun . "' and month(tgl_daftar) = '" . $i . "';";
                if ($tahun == "All") {
                    $q = "SELECT count(*) as jml FROM siswa where month(tgl_daftar) = '" . $i . "';";
                }
                $nilai = $this->model->getAllQR($q)->jml;
                array_push($data_siswa_masuk, $nilai);
            }

            echo json_encode(array("keluar" => $data_siswa_keluar, "masuk" => $data_siswa_masuk));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function masuk_keluar_siswa_kursus()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan = $this->request->getUri()->getSegment(3);
            $tahun = $this->request->getUri()->getSegment(4);

            // $bulan = "~";
            // $tahun = "2024";

            $datamasuk = array();
            $datakeluar = array();

            $kursus = $this->model->getAllQ("SELECT idpendkursus, nama_kursus FROM pendidikankursus;");
            foreach ($kursus->getResult() as $row) {

                if ($bulan != "~" && $tahun != "~") {
                    $masuk1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and month(tgl_daftar) = '" . $bulan . "' and year(tgl_daftar) = '" . $tahun . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $masuk2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswamitra a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and month(tgl_daftar) = '" . $bulan . "' and year(tgl_daftar) = '" . $tahun . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $keluar1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar a, jadwal_siswa b
                    where month(tanggal) = '" . $bulan . "' and year(tanggal) = '" . $tahun . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $keluar2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar_mitra a, jadwal_siswa b
                    where month(tanggal) = '" . $bulan . "' and year(tanggal) = '" . $tahun . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $masuk = $masuk1 + $masuk2;
                    $keluar = $keluar1 + $keluar2;

                    array_push($datamasuk, $masuk);
                    array_push($datakeluar, $keluar);
                } else if ($bulan != "~") {
                    $masuk1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and month(tgl_daftar) = '" . $bulan . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $masuk2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswamitra a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and month(tgl_daftar) = '" . $bulan . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $keluar1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar a, jadwal_siswa b
                    where month(tanggal) = '" . $bulan . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $keluar2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar_mitra a, jadwal_siswa b
                    where month(tanggal) = '" . $bulan . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $masuk = $masuk1 + $masuk2;
                    $keluar = $keluar1 + $keluar2;

                    array_push($datamasuk, $masuk);
                    array_push($datakeluar, $keluar);
                } else if ($tahun != "~") {
                    $masuk1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and year(tgl_daftar) = '" . $tahun . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $masuk2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswamitra a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and year(tgl_daftar) = '" . $tahun . "' and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $keluar1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar a, jadwal_siswa b
                    where year(tanggal) = '" . $tahun . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $keluar2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar_mitra a, jadwal_siswa b
                    where year(tanggal) = '" . $tahun . "' and a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $masuk = $masuk1 + $masuk2;
                    $keluar = $keluar1 + $keluar2;

                    array_push($datamasuk, $masuk);
                    array_push($datakeluar, $keluar);
                } else {
                    $masuk1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $masuk2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswamitra a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $keluar1 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;
                    $keluar2 = $this->model->getAllQR("select count(distinct a.idsiswa) as jml from siswa_keluar_mitra a, jadwal_siswa b
                    where a.idsiswa = b.idsiswa and b.idjadwal in(select idjadwal from jadwal where idpendkursus = '" . $row->idpendkursus . "');")->jml;

                    $masuk = $masuk1 + $masuk2;
                    $keluar = $keluar1 + $keluar2;

                    array_push($datamasuk, $masuk);
                    array_push($datakeluar, $keluar);
                }
            }

            echo json_encode(array("keluar" => $datakeluar, "masuk" => $datamasuk));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function reload_demografi_usia(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            
            $datalaki = array();
            $dataperemupuan = array();

            $tahun = $this->request->getUri()->getSegment(3);
            if($tahun == "All"){
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jmltemp);
    
                
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jmltemp);
    
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jmltemp);

            }else{
                
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jmltemp);

                
                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 0 and 9 and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 10 and 20 and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 11 and 30 and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) between 31 and 40 and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jmltemp);

                $jmltemp = $this->model->getAllQR("select count(*) as jml from siswa 
                where IF(YEAR(tgl_lahir) > 0,YEAR(CURDATE()) - YEAR(tgl_lahir),0) > 40 and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jmltemp);
            }

            echo json_encode(array("laki" => $datalaki, "perempuan" => $dataperemupuan));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function reload_demografi_tingkat(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $tahun = $this->request->getUri()->getSegment(3);

            $dataperemupuan = array();
            $datalaki = array();

            if($tahun == "All"){
                $datatingkat = array("TK", "SD", "SMP", "SMA", "D3",  "D4", "S1", "S2");
                for ($i = 0; $i < count($datatingkat); $i++) {
                    $tingkat = $datatingkat[$i];
                    $jmltemp_L = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Laki-laki';")->jml;
                    array_push($datalaki, $jmltemp_L);
    
                    $jmltemp_P = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Perempuan';")->jml;
                    array_push($dataperemupuan, $jmltemp_P);
                }
            }else{
                $datatingkat = array("TK", "SD", "SMP", "SMA", "D3",  "D4", "S1", "S2");
                for ($i = 0; $i < count($datatingkat); $i++) {
                    $tingkat = $datatingkat[$i];
                    $jmltemp_L = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                    array_push($datalaki, $jmltemp_L);
    
                    $jmltemp_P = $this->model->getAllQR("select count(*) as jml from siswa where level_sekolah = '" . $tingkat . "' and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                    array_push($dataperemupuan, $jmltemp_P);
                }
            }
            echo json_encode(array("laki" => $datalaki, "perempuan" => $dataperemupuan));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function reload_demografi_tinggal(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            
            $tahun = $this->request->getUri()->getSegment(3);
            $idkabupaten = $this->request->getUri()->getSegment(4);

            $datalaki = array();
            $dataperemupuan = array();
            $data_lokasi = array();

            // mencari lokasi kabupaten
            $kabkot = $this->model->getAllQR("SELECT idkabupaten, name FROM kabupaten where idkabupaten = '".$idkabupaten."';");
            array_push($data_lokasi, $kabkot->name);

            if($tahun == "All"){
                // mencari jumlah laki
                $jml = $this->model->getAllQR("select count(*) as jml from siswa where kabupaten = '" . $idkabupaten . "' and jkel = 'Laki-laki';")->jml;
                array_push($datalaki, $jml);
            
                // mencari jumlah perempuan
                $jml = $this->model->getAllQR("select count(*) as jml from siswa where kabupaten = '" . $idkabupaten . "' and jkel = 'Perempuan';")->jml;
                array_push($dataperemupuan, $jml);

            }else{
                // mencari jumlah laki
                $jml = $this->model->getAllQR("select count(*) as jml from siswa 
                where kabupaten = '" . $idkabupaten . "' and jkel = 'Laki-laki' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($datalaki, $jml);
            
                // mencari jumlah perempuan
                $jml = $this->model->getAllQR("select count(*) as jml from siswa 
                where kabupaten = '" . $idkabupaten . "' and jkel = 'Perempuan' and year(tgl_daftar) = '".$tahun."';")->jml;
                array_push($dataperemupuan, $jml);
            }

            echo json_encode(array("laki" => $datalaki, "perempuan" => $dataperemupuan, "lokasi" => $data_lokasi));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function getKabkot(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAll("kabupaten");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->name;
                $val[] = '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="pilihkabkot(' . "'" . $row->idkabupaten . "'" . ',' . "'" . $row->name . "'" . ')">Pilih</button>'
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

    public function kerja_sama_ins()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan = $this->request->getUri()->getSegment(3);
            $tahun = $this->request->getUri()->getSegment(4);

            $total = 0;

            if ($bulan != "~" && $tahun != "~") {
                $total = $this->model->getAllQR("select count(*) as jml from mitra where month(created_at) = '".$bulan."' and year(created_at) = '".$tahun."';")->jml;

            } else if ($bulan != "~") {
                $total = $this->model->getAllQR("select count(*) as jml from mitra where month(created_at) = '".$bulan."';")->jml;

            } else if ($tahun != "~") {
                $total = $this->model->getAllQR("select count(*) as jml from mitra where year(created_at) = '".$tahun."';")->jml;

            } else {
                $total = $this->model->getAllQR("select count(*) as jml from mitra;")->jml;
            }

            echo json_encode(array("total" => $total));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_jumlah_siswa_mitra()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan = $this->request->getUri()->getSegment(3);
            $tahun = $this->request->getUri()->getSegment(4);

            $total = 0;

            if ($bulan != "~" && $tahun != "~") {
                $mitra_masuk = $this->model->getAllQR("select count(*) as jml from siswamitra where month(tgl_daftar) = '".$bulan."' and year(tgl_daftar) = '".$tahun."';")->jml;
                $mitra_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar_mitra where month(tanggal) = '".$bulan."' and year(tanggal) = '".$tahun."';")->jml;
                $total = $mitra_masuk - $mitra_keluar;

            } else if ($bulan != "~") {
                $mitra_masuk = $this->model->getAllQR("select count(*) as jml from siswamitra where month(tgl_daftar) = '".$bulan."';")->jml;
                $mitra_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar_mitra where month(tanggal) = '".$bulan."';")->jml;
                $total = $mitra_masuk - $mitra_keluar;

            } else if ($tahun != "~") {
                $mitra_masuk = $this->model->getAllQR("select count(*) as jml from siswamitra where year(tgl_daftar) = '".$tahun."';")->jml;
                $mitra_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar_mitra where year(tanggal) = '".$tahun."';")->jml;
                $total = $mitra_masuk - $mitra_keluar;

            } else {
                $mitra_masuk = $this->model->getAllQR("select count(*) as jml from siswamitra;")->jml;
                $mitra_keluar = $this->model->getAllQR("select count(*) as jml from siswa_keluar_mitra;")->jml;
                $total = $mitra_masuk - $mitra_keluar;
            }

            echo json_encode(array("total" => $total));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function total_siswa_mitra(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $data_mitra = array();
            $periode = $this->model->getAll("mitra");
            foreach ($periode->getResult() as $row) {
                array_push($data_mitra, $row->nama);
            }
            $data['mitra'] = json_encode($data_mitra);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function uploadFileLeapVerse(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->uploadFileExcel();
                }
            } else {
                $pesan = "File tidak ditemukan";
            }
            echo json_encode(array("status" => $pesan));
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

                        $newPath = "uploads/". $fileName;

                        $spreadSheet = $reader->load($newPath);
                        $dataexcel = $spreadSheet->getActiveSheet()->toArray();
                        
                        $this->model->deleteNK("leapverse");

                        foreach ($dataexcel as $key => $value) {
                            if ($key > 1 && isset($value[0], $value[1], $value[2]) && $value[0] !== "Date") {
                                $tgl = $value[0];
                                $pengguna_download = $value[1];
                                $pengguna_aktif = $value[2];
                                
                                $potong = explode("/", $tgl);
                                $bulan = $potong[0];
                                $tanggal = $potong[1];
                                $tahun = $potong[2];
                        
                                $data = array(
                                    'idleapverse' => $this->model->autokode("L", "idleapverse", "leapverse", 2, 7),
                                    'tgl' => $tahun . '-' . $bulan . '-' . $tanggal,
                                    'download' => $pengguna_download,
                                    'aktif' => $pengguna_aktif,
                                );
                                $this->model->add("leapverse", $data);
                            }
                        }

                        unlink($newPath);

                        $status = "File terupload";
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

    public function coba(){
        $targetDir = "uploads/Book1.xlsx";
        if (file_exists($targetDir)) {
            $ext = pathinfo($targetDir, PATHINFO_EXTENSION);
            if ($ext == "xls" || $ext == "xlsx") {
                if ($ext == "xls") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else if ($ext == "xlsx") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    
                }

                $spreadSheet = $reader->load($targetDir);
                $dataexcel = $spreadSheet->getActiveSheet()->toArray();
                
                $this->model->deleteNK("leapverse");

                foreach ($dataexcel as $key => $value) {
                    if ($key > 1) {
                        if ($value[0] <> null || $value[0] <> "" || $value[0] <> "Date") {
                            $tgl = $value[0];
                            $pengguna_download = $value[1];
                            $pengguna_aktif = $value[2];

                            
                            
                            $potong = explode("/", $tgl);
                            $bulan = $potong[0];
                            $tanggal = $potong[1];
                            $tahun = $potong[2];

                            echo $tahun.'-'.$bulan.'-'.$tanggal .' --- '. $pengguna_download. ' - ' . $pengguna_aktif . '<br>';
                        }
                    }
                }
                echo "Ya";
            }
        }else{
            echo "Tidak";
        }
    }

    public function leapverse_download(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $qcount = "SELECT count(*) as jml FROM leapverse";

            if($tahun != "~" && $bulan != "~"){
                $qcount .= " where year(tgl) = '".$tahun."' and month(tgl) = '".$bulan."' ";
            } else if($tahun != "~") {
                $qcount .= " where year(tgl) = '".$tahun."' ";
            } else if($bulan != "~") {
                $qcount .= " where month(tgl) = '".$bulan."' ";
            }

            $datajml = $this->model->getAllQR($qcount)->jml;
            if($datajml > 0){
                $q = "SELECT download FROM leapverse";

                if($tahun != "~" && $bulan != "~"){
                    $q .= " where year(tgl) = '".$tahun."' and month(tgl) = '".$bulan."' ";
                } else if($tahun != "~") {
                    $q .= " where year(tgl) = '".$tahun."' ";
                } else if($bulan != "~") {
                    $q .= " where month(tgl) = '".$bulan."' ";
                }
                $pesan = $this->model->getAllQR($q)->download;
            }else{
                $pesan = 0;
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function mitra_leapverse(){
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $tahun = $this->request->getPost('tahun');

            $q = "SELECT count(*) as jml FROM mitra where status = 'on-going' or status = 'done' and leapverse = 'Ya' ";

            if($tahun != "~"){
                $q .= " and tahun = '".$tahun."';";
            }

            $pesan = $this->model->getAllQR($q)->jml;
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function leapverse_aktif()
    {
        if (session()->get("logged_hr") || session()->get("logged_busdev") || session()->get("logged_it")) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $tgl_leapverse_aktif = array();
            $jumlah_leapverse_aktif = array();

            if ($bulan != "~" && $tahun != "~") {
                
                $list_leapverse = $this->model->getAllQ("SELECT date_format(tgl, '%d-%m-%Y') as tgl, aktif FROM leapverse where year(tgl) = '".$tahun."' and month(tgl) = '".$bulan."' order by idleapverse asc;");
                foreach ($list_leapverse->getResult() as $row) {
                    array_push($tgl_leapverse_aktif, $row->tgl);
                    array_push($jumlah_leapverse_aktif, $row->aktif);
                }

            } else {
                $list_leapverse = $this->model->getAllQ("SELECT date_format(tgl, '%d-%m-%Y') as tgl, aktif FROM leapverse order by idleapverse asc;");
                foreach ($list_leapverse->getResult() as $row) {
                    array_push($tgl_leapverse_aktif, $row->tgl);
                    array_push($jumlah_leapverse_aktif, $row->aktif);
                }
            
            }

            echo json_encode(array("tgl" => $tgl_leapverse_aktif, "jumlah" => $jumlah_leapverse_aktif));
        } else {
            $this->modul->halaman('login');
        }
    }
}