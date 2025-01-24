<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registrasi Ulang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <style>
        .back {
            background: url('<?php echo base_url() ?>singlepage/images/bgcalon.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: 100% 100%;
        }
    </style>
</head>

<body>
    <div class="wrapper back">
        <div class="inner">
            <form action="<?php echo base_url() ?>registrasiulang/proses" method="post">
                <h3>Registrasi Ulang</h3>
                <input type="hidden" id="idsiswa" name="idsiswa" value="<?php echo $siswa->idsiswa; ?>">
                <h2 style="margin-top: -30px;">2. DATA AYAH</h2>
                <hr>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nama Lengkap Ayah<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="nama_ayah" name="nama_ayah" type="text" value="<?php echo $siswa->nama_ayah; ?>" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Pekerjaan Ayah<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control">
                                <option value="-" disable>- Pilih Pekerjaan -</option>
                                <option value="belum_tidak_bekerja" <?php if($siswa->pekerjaan_ayah == "belum_tidak_bekerja"){ echo 'selected'; }?>>Belum/Tidak Bekerja</option>
                                <option value="aparatur_pejabat_negara" <?php if($siswa->pekerjaan_ayah == "aparatur_pejabat_negara"){ echo 'selected'; }?>>Aparatur/Pejabat Negara</option>
                                <option value="tenaga_pengajar" <?php if($siswa->pekerjaan_ayah == "tenaga_pengajar"){ echo 'selected'; }?>>Tenaga Pengajar</option>
                                <option value="wiraswasta" <?php if($siswa->pekerjaan_ayah == "wiraswasta"){ echo 'selected'; }?>>Wiraswasta</option>
                                <option value="pertanian_peternakan" <?php if($siswa->pekerjaan_ayah == "pertanian_peternakan"){ echo 'selected'; }?>>Pertanian/Peternakan</option>
                                <option value="nelayan" <?php if($siswa->pekerjaan_ayah == "nelayan"){ echo 'selected'; }?>>Nelayan</option>
                                <option value="agama_kepercayaan" <?php if($siswa->pekerjaan_ayah == "agama_kepercayaan"){ echo 'selected'; }?>>Agama dan Kepercayaan</option>
                                <option value="pelajar_mahasiswa" <?php if($siswa->pekerjaan_ayah == "pelajar_mahasiswa"){ echo 'selected'; }?>>Pelajar/Mahasiswa</option>
                                <option value="tenaga_kesehatan" <?php if($siswa->pekerjaan_ayah == "tenaga_kesehatan"){ echo 'selected'; }?>>Tenaga Kesehatan</option>
                                <option value="pensiunan" <?php if($siswa->pekerjaan_ayah == "pensiunan"){ echo 'selected'; }?>>Pensiunan</option>
                                <option value="pegawai_swasta" <?php if($siswa->pekerjaan_ayah == "pegawai_swasta"){ echo 'selected'; }?>>Pegawai Swasta</option>
                                <option value="lainnya" <?php if($siswa->pekerjaan_ayah == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Jenjang Pendidikan Ayah</label>
                        <div class="form-holder">
                            <select name="jenjang_ayah" id="jenjang_ayah" class="form-control">
                                <option value="-" disable>- Pilih Jenjang Pendidikan -</option>
                                <option value="tidak_sekolah" <?php if($siswa->jenjang_ayah == "tidak_sekolah"){ echo 'selected'; }?>>Tidak sekolah</option>
                                <option value="paud" <?php if($siswa->jenjang_ayah == "paud"){ echo 'selected'; }?>>PAUD</option>
                                <option value="tk_sederajat" <?php if($siswa->jenjang_ayah == "tk_sederajat"){ echo 'selected'; }?>>TK / sederajat</option>
                                <option value="putus_sd" <?php if($siswa->jenjang_ayah == "putus_sd"){ echo 'selected'; }?>>Putus SD</option>
                                <option value="sd_sederajat" <?php if($siswa->jenjang_ayah == "sd_sederajat"){ echo 'selected'; }?>>SD / sederajat</option>
                                <option value="smp_sederajat" <?php if($siswa->jenjang_ayah == "smp_sederajat"){ echo 'selected'; }?>>SMP / sederajat</option>
                                <option value="sma_sederajat" <?php if($siswa->jenjang_ayah == "sma_sederajat"){ echo 'selected'; }?>>SMA / sederajat</option>
                                <option value="paket_a" <?php if($siswa->jenjang_ayah == "paket_a"){ echo 'selected'; }?>>Paket A</option>
                                <option value="paket_b" <?php if($siswa->jenjang_ayah == "paket_b"){ echo 'selected'; }?>>Paket B</option>
                                <option value="paket_c" <?php if($siswa->jenjang_ayah == "paket_c"){ echo 'selected'; }?>>Paket C</option>
                                <option value="d1" <?php if($siswa->jenjang_ayah == "d1"){ echo 'selected'; }?>>D1</option>
                                <option value="d2" <?php if($siswa->jenjang_ayah == "d2"){ echo 'selected'; }?>>D2</option>
                                <option value="d3" <?php if($siswa->jenjang_ayah == "d3"){ echo 'selected'; }?>>D3</option>
                                <option value="d4" <?php if($siswa->jenjang_ayah == "d4"){ echo 'selected'; }?>>D4</option>
                                <option value="s1" <?php if($siswa->jenjang_ayah == "s1"){ echo 'selected'; }?>>S1</option>
                                <option value="s2" <?php if($siswa->jenjang_ayah == "s2"){ echo 'selected'; }?>>S2</option>
                                <option value="s3" <?php if($siswa->jenjang_ayah == "s3"){ echo 'selected'; }?>>S3</option>
                                <option value="non_formal" <?php if($siswa->jenjang_ayah == "non_formal"){ echo 'selected'; }?>>Non formal</option>
                                <option value="informal" <?php if($siswa->jenjang_ayah == "informal"){ echo 'selected'; }?>>Informal</option>
                                <option value="lainnya" <?php if($siswa->jenjang_ayah == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Penghasilan Ayah</label>
                        <div class="form-holder">
                            <select name="penghasilan_ayah" id="penghasilan_ayah" class="form-control">
                                <option value="-" disable>- Pilih Rentang Penghasilan -</option>
                                <option value="kurang_1jt" <?php if($siswa->penghasilan_ayah == "kurang_1jt"){ echo 'selected'; }?>>&lt 1.000.000</option>
                                <option value="1jt_3jt" <?php if($siswa->penghasilan_ayah == "1jt_3jt"){ echo 'selected'; }?>>1.000.000 - 3.000.000</option>
                                <option value="3jt_5jt" <?php if($siswa->penghasilan_ayah == "3jt_5jt"){ echo 'selected'; }?>>3.000.000 - 5.000.000</option>
                                <option value="lebih_5jt" <?php if($siswa->penghasilan_ayah == "lebih_5jt"){ echo 'selected'; }?>>&gt 5.000.000</option>
                            </select>
                        </div>
                    </div>                    
                </div>
                <h2>3. DATA IBU</h2>
                <hr>
                <div class="form-group">
                <!-- IBU -->
                    <div class="form-wrapper">
                        <label>Nama Lengkap Ibu<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="nama_ibu" name="nama_ibu" type="text" value="<?php echo $siswa->nama_ibu; ?>" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Pekerjaan ibu<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <select name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control">
                                <option value="-" disable>- Pilih Pekerjaan -</option>
                                <option value="belum_tidak_bekerja" <?php if($siswa->pekerjaan_ortu == "belum_tidak_bekerja"){ echo 'selected'; }?>>Belum/Tidak Bekerja</option>
                                <option value="aparatur_pejabat_negara" <?php if($siswa->pekerjaan_ortu == "aparatur_pejabat_negara"){ echo 'selected'; }?>>Aparatur/Pejabat Negara</option>
                                <option value="tenaga_pengajar" <?php if($siswa->pekerjaan_ortu == "tenaga_pengajar"){ echo 'selected'; }?>>Tenaga Pengajar</option>
                                <option value="wiraswasta" <?php if($siswa->pekerjaan_ortu == "wiraswasta"){ echo 'selected'; }?>>Wiraswasta</option>
                                <option value="pertanian_peternakan" <?php if($siswa->pekerjaan_ortu == "pertanian_peternakan"){ echo 'selected'; }?>>Pertanian/Peternakan</option>
                                <option value="nelayan" <?php if($siswa->pekerjaan_ortu == "nelayan"){ echo 'selected'; }?>>Nelayan</option>
                                <option value="agama_kepercayaan" <?php if($siswa->pekerjaan_ortu == "agama_kepercayaan"){ echo 'selected'; }?>>Agama dan Kepercayaan</option>
                                <option value="pelajar_mahasiswa" <?php if($siswa->pekerjaan_ortu == "pelajar_mahasiswa"){ echo 'selected'; }?>>Pelajar/Mahasiswa</option>
                                <option value="tenaga_kesehatan" <?php if($siswa->pekerjaan_ortu == "tenaga_kesehatan"){ echo 'selected'; }?>>Tenaga Kesehatan</option>
                                <option value="pensiunan" <?php if($siswa->pekerjaan_ortu == "pensiunan"){ echo 'selected'; }?>>Pensiunan</option>
                                <option value="pegawai_swasta" <?php if($siswa->pekerjaan_ortu == "pegawai_swasta"){ echo 'selected'; }?>>Pegawai Swasta</option>
                                <option value="lainnya" <?php if($siswa->pekerjaan_ortu == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Jenjang Pendidikan ibu</label>
                        <div class="form-holder">
                            <select name="jenjang_ibu" id="jenjang_ibu" class="form-control">
                                <option value="-" disable>- Pilih Jenjang Pendidikan -</option>
                                <option value="tidak_sekolah" <?php if($siswa->jenjang_ibu == "tidak_sekolah"){ echo 'selected'; }?>>Tidak sekolah</option>
                                <option value="paud" <?php if($siswa->jenjang_ibu == "paud"){ echo 'selected'; }?>>PAUD</option>
                                <option value="tk_sederajat" <?php if($siswa->jenjang_ibu == "tk_sederajat"){ echo 'selected'; }?>>TK / sederajat</option>
                                <option value="putus_sd" <?php if($siswa->jenjang_ibu == "putus_sd"){ echo 'selected'; }?>>Putus SD</option>
                                <option value="sd_sederajat" <?php if($siswa->jenjang_ibu == "sd_sederajat"){ echo 'selected'; }?>>SD / sederajat</option>
                                <option value="smp_sederajat" <?php if($siswa->jenjang_ibu == "smp_sederajat"){ echo 'selected'; }?>>SMP / sederajat</option>
                                <option value="sma_sederajat" <?php if($siswa->jenjang_ibu == "sma_sederajat"){ echo 'selected'; }?>>SMA / sederajat</option>
                                <option value="paket_a" <?php if($siswa->jenjang_ibu == "paket_a"){ echo 'selected'; }?>>Paket A</option>
                                <option value="paket_b" <?php if($siswa->jenjang_ibu == "paket_b"){ echo 'selected'; }?>>Paket B</option>
                                <option value="paket_c" <?php if($siswa->jenjang_ibu == "paket_c"){ echo 'selected'; }?>>Paket C</option>
                                <option value="d1" <?php if($siswa->jenjang_ibu == "d1"){ echo 'selected'; }?>>D1</option>
                                <option value="d2" <?php if($siswa->jenjang_ibu == "d2"){ echo 'selected'; }?>>D2</option>
                                <option value="d3" <?php if($siswa->jenjang_ibu == "d3"){ echo 'selected'; }?>>D3</option>
                                <option value="d4" <?php if($siswa->jenjang_ibu == "d4"){ echo 'selected'; }?>>D4</option>
                                <option value="s1" <?php if($siswa->jenjang_ibu == "s1"){ echo 'selected'; }?>>S1</option>
                                <option value="s2" <?php if($siswa->jenjang_ibu == "s2"){ echo 'selected'; }?>>S2</option>
                                <option value="s3" <?php if($siswa->jenjang_ibu == "s3"){ echo 'selected'; }?>>S3</option>
                                <option value="non_formal" <?php if($siswa->jenjang_ibu == "non_formal"){ echo 'selected'; }?>>Non formal</option>
                                <option value="informal" <?php if($siswa->jenjang_ibu == "informal"){ echo 'selected'; }?>>Informal</option>
                                <option value="lainnya" <?php if($siswa->jenjang_ibu == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Penghasilan ibu</label>
                        <div class="form-holder">
                            <select name="penghasilan_ibu" id="penghasilan_ibu" class="form-control">
                                <option value="-" disable>- Pilih Rentang Penghasilan -</option>
                                <option value="kurang_1jt" <?php if($siswa->penghasilan_ibu == "kurang_1jt"){ echo 'selected'; }?>>&lt 1.000.000</option>
                                <option value="1jt_3jt" <?php if($siswa->penghasilan_ibu == "1jt_3jt"){ echo 'selected'; }?>>1.000.000 - 3.000.000</option>
                                <option value="3jt_5jt" <?php if($siswa->penghasilan_ibu == "3jt_5jt"){ echo 'selected'; }?>>3.000.000 - 5.000.000</option>
                                <option value="lebih_5jt" <?php if($siswa->penghasilan_ibu == "lebih_5jt"){ echo 'selected'; }?>>&gt 5.000.000</option>
                            </select>
                        </div>
                    </div>                    
                </div>
                <h2>4. DATA WALI SISWA</h2>
                <hr>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nama Lengkap wali</label>
                        <div class="form-holder">
                            <input id="nama_wali" name="nama_wali" type="text" value="<?php echo $siswa->nama_wali; ?>" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Pekerjaan wali</label>
                        <div class="form-holder">
                            <select name="pekerjaan_wali" id="pekerjaan_wali" class="form-control">
                                <option value="-" disable>- Pilih Pekerjaan -</option>
                                <option value="belum_tidak_bekerja" <?php if($siswa->pekerjaan_wali == "belum_tidak_bekerja"){ echo 'selected'; }?>>Belum/Tidak Bekerja</option>
                                <option value="aparatur_pejabat_negara" <?php if($siswa->pekerjaan_wali == "aparatur_pejabat_negara"){ echo 'selected'; }?>>Aparatur/Pejabat Negara</option>
                                <option value="tenaga_pengajar" <?php if($siswa->pekerjaan_wali == "tenaga_pengajar"){ echo 'selected'; }?>>Tenaga Pengajar</option>
                                <option value="wiraswasta" <?php if($siswa->pekerjaan_wali == "wiraswasta"){ echo 'selected'; }?>>Wiraswasta</option>
                                <option value="pertanian_peternakan" <?php if($siswa->pekerjaan_wali == "pertanian_peternakan"){ echo 'selected'; }?>>Pertanian/Peternakan</option>
                                <option value="nelayan" <?php if($siswa->pekerjaan_wali == "nelayan"){ echo 'selected'; }?>>Nelayan</option>
                                <option value="agama_kepercayaan" <?php if($siswa->pekerjaan_wali == "agama_kepercayaan"){ echo 'selected'; }?>>Agama dan Kepercayaan</option>
                                <option value="pelajar_mahasiswa" <?php if($siswa->pekerjaan_wali == "pelajar_mahasiswa"){ echo 'selected'; }?>>Pelajar/Mahasiswa</option>
                                <option value="tenaga_kesehatan" <?php if($siswa->pekerjaan_wali == "tenaga_kesehatan"){ echo 'selected'; }?>>Tenaga Kesehatan</option>
                                <option value="pensiunan" <?php if($siswa->pekerjaan_wali == "pensiunan"){ echo 'selected'; }?>>Pensiunan</option>
                                <option value="pegawai_swasta" <?php if($siswa->pekerjaan_wali == "pegawai_swasta"){ echo 'selected'; }?>>Pegawai Swasta</option>
                                <option value="lainnya" <?php if($siswa->pekerjaan_wali == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Jenjang Pendidikan wali</label>
                        <div class="form-holder">
                            <select name="jenjang_wali" id="jenjang_wali" class="form-control">
                                <option value="-" disable>- Pilih Jenjang Pendidikan -</option>
                                <option value="tidak_sekolah" <?php if($siswa->jenjang_wali == "tidak_sekolah"){ echo 'selected'; }?>>Tidak sekolah</option>
                                <option value="paud" <?php if($siswa->jenjang_wali == "paud"){ echo 'selected'; }?>>PAUD</option>
                                <option value="tk_sederajat" <?php if($siswa->jenjang_wali == "tk_sederajat"){ echo 'selected'; }?>>TK / sederajat</option>
                                <option value="putus_sd" <?php if($siswa->jenjang_wali == "putus_sd"){ echo 'selected'; }?>>Putus SD</option>
                                <option value="sd_sederajat" <?php if($siswa->jenjang_wali == "sd_sederajat"){ echo 'selected'; }?>>SD / sederajat</option>
                                <option value="smp_sederajat" <?php if($siswa->jenjang_wali == "smp_sederajat"){ echo 'selected'; }?>>SMP / sederajat</option>
                                <option value="sma_sederajat" <?php if($siswa->jenjang_wali == "sma_sederajat"){ echo 'selected'; }?>>SMA / sederajat</option>
                                <option value="paket_a" <?php if($siswa->jenjang_wali == "paket_a"){ echo 'selected'; }?>>Paket A</option>
                                <option value="paket_b" <?php if($siswa->jenjang_wali == "paket_b"){ echo 'selected'; }?>>Paket B</option>
                                <option value="paket_c" <?php if($siswa->jenjang_wali == "paket_c"){ echo 'selected'; }?>>Paket C</option>
                                <option value="d1" <?php if($siswa->jenjang_wali == "d1"){ echo 'selected'; }?>>D1</option>
                                <option value="d2" <?php if($siswa->jenjang_wali == "d2"){ echo 'selected'; }?>>D2</option>
                                <option value="d3" <?php if($siswa->jenjang_wali == "d3"){ echo 'selected'; }?>>D3</option>
                                <option value="d4" <?php if($siswa->jenjang_wali == "d4"){ echo 'selected'; }?>>D4</option>
                                <option value="s1" <?php if($siswa->jenjang_wali == "s1"){ echo 'selected'; }?>>S1</option>
                                <option value="s2" <?php if($siswa->jenjang_wali == "s2"){ echo 'selected'; }?>>S2</option>
                                <option value="s3" <?php if($siswa->jenjang_wali == "s3"){ echo 'selected'; }?>>S3</option>
                                <option value="non_formal" <?php if($siswa->jenjang_wali == "non_formal"){ echo 'selected'; }?>>Non formal</option>
                                <option value="informal" <?php if($siswa->jenjang_wali == "informal"){ echo 'selected'; }?>>Informal</option>
                                <option value="lainnya" <?php if($siswa->jenjang_wali == "lainnya"){ echo 'selected'; }?>>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <label>Penghasilan wali</label>
                        <div class="form-holder">
                            <select name="penghasilan_wali" id="penghasilan_wali" class="form-control">
                                <option value="-" disable>- Pilih Rentang Penghasilan -</option>
                                <option value="kurang_1jt" <?php if($siswa->penghasilan_wali == "kurang_1jt"){ echo 'selected'; }?>>&lt 1.000.000</option>
                                <option value="1jt_3jt" <?php if($siswa->penghasilan_wali == "1jt_3jt"){ echo 'selected'; }?>>1.000.000 - 3.000.000</option>
                                <option value="3jt_5jt" <?php if($siswa->penghasilan_wali == "3jt_5jt"){ echo 'selected'; }?>>3.000.000 - 5.000.000</option>
                                <option value="lebih_5jt" <?php if($siswa->penghasilan_wali == "lebih_5jt"){ echo 'selected'; }?>>&gt 5.000.000</option>
                            </select>
                        </div>
                    </div>                    
                </div>
                <h2>5. DATA KEBUTUHAN KELAS</h2>
                <hr>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Email<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="email" name="email" type="email" value="<?php echo $siswa->email; ?>" class="form-control" autocomplete="off">
                        </div>
                        <span class="invalid-feedback" style="color:red;" id="emailError"></span><br>
                        <small class="invalid-feedback">Email digunakan untuk penggunaan Aplikasi/LMS/Google Classroom/Google Form/Pengiriman E-rapor/Pengiriman E-Sertifikat</small>
                    </div>
                    <div class="form-wrapper">
                        <label>Nomer WA wali murid untuk administrasi<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="waadmin"  onkeypress="return hanyaAngka(event,false);" name="waadmin" type="text" value="<?php echo $siswa->waadmin; ?>" class="form-control" autocomplete="off">
                        </div>
                        <small class="invalid-feedback">Jika peserta pelatihan dewasa dapat mengisi nomor pribadi</small>
                    </div>
                </div>   
                <div class="form-group">
                    <div class="form-wrapper">
                        <label>Nomer HP (WA) wali murid yang akan dimasukkan ke WA Grup Kelas<span style="color: red;">*</span></label>
                        <div class="form-holder">
                            <input id="wawalmur"  onkeypress="return hanyaAngka(event,false);" name="wawalmur" type="text" value="<?php echo $siswa->wawalmur; ?>" class="form-control" autocomplete="off">
                        </div>
                        <small class="invalid-feedback">Jika peserta pelatihan dewasa dapat mengisi nomor pribadi</small>
                    </div>
                    <div class="form-wrapper">
                        <label>Nomer HP (WA) peserta yang akan dimasukkan ke WA Grup Kelas</label>
                        <div class="form-holder">
                            <input id="wapeserta"  onkeypress="return hanyaAngka(event,false);" name="wapeserta" type="text" value="<?php echo $siswa->wapeserta; ?>" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </div> 
                <div class="form-end">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked disabled> Periksa kembali data yang sudah diberikan. Pastikan data yang diberikan sudah benar dan sesuai.
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="button-holder">
                        <button type="button" style="background-color: blue;" onclick="save();">Simpan Data</button>
                        <button type="button" onclick="previous();">Sebelumnya</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>

<script>
    const emailField = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    // Regular Expression for email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Function to validate email format
    function validateEmail() {
        // Reset error message
        emailError.textContent = '';

        // Check if email matches the pattern
        if (emailField.value === '') {
            emailError.textContent = 'Email is required';
        } else if (!emailPattern.test(emailField.value)) {
            emailError.textContent = 'Please enter a valid email address';
        } else {
            emailError.textContent = ''; // Clear error if email is valid
        }
    }

    // Add event listener for real-time validation on input field
    emailField.addEventListener('input', validateEmail);

    function save() {
        var nama_ayah = document.getElementById('nama_ayah').value;
        var idsiswa = document.getElementById('idsiswa').value;
        var pekerjaan_ayah = document.getElementById('pekerjaan_ayah').value;
        var jenjang_ayah = document.getElementById('jenjang_ayah').value;
        var penghasilan_ayah = document.getElementById('penghasilan_ayah').value;
        var nama_ibu = document.getElementById('nama_ibu').value;
        var pekerjaan_ibu = document.getElementById('pekerjaan_ibu').value;
        var jenjang_ibu = document.getElementById('jenjang_ibu').value;
        var penghasilan_ibu = document.getElementById('penghasilan_ibu').value;
        var nama_wali = document.getElementById('nama_wali').value;
        var pekerjaan_wali = document.getElementById('pekerjaan_wali').value;
        var jenjang_wali = document.getElementById('jenjang_wali').value;
        var penghasilan_wali = document.getElementById('penghasilan_wali').value;
        var email = document.getElementById('email').value;
        var wawalmur = document.getElementById('wawalmur').value;
        var waadmin = document.getElementById('waadmin').value;
        var wapeserta = document.getElementById('wapeserta').value;
        
        if (nama_ayah === '') {
            document.getElementById('nama_ayah').focus();
            alert("Nama Ayah harus diisi");
        }else if(pekerjaan_ayah === '-') {
            document.getElementById('pekerjaan_ayah').focus();
            alert("Pekerjaan Ayah harus diisi");
        }else if(nama_ibu === '') {
            document.getElementById('nama_ibu').focus();
            alert("Nama Ibu harus diisi");
        }else if(pekerjaan_ibu === '-') {
            document.getElementById('pekerjaan_ibu').focus();
            alert("Pekerjaan Ibu harus diisi");
        }else if (email === '') {
            document.getElementById('email').focus();
            alert("Email harus diisi");
        }else if(!emailPattern.test(email)){
            document.getElementById('email').focus();
            alert("Format email tidak sesuai!");
        }else if(wawalmur === '') {
            document.getElementById('wawalmur').focus();
            alert("No Wa Grup Kelas harus diisi");
        }else if(waadmin === '') {
            document.getElementById('waadmin').focus();
            alert("No Wa Administrasi harus diisi");
        }else{
            var form_data = new FormData();
            form_data.append('nama_ayah', nama_ayah);
            form_data.append('idsiswa', idsiswa);
            form_data.append('pekerjaan_ayah', pekerjaan_ayah);
            form_data.append('jenjang_ayah', jenjang_ayah);
            form_data.append('penghasilan_ayah', penghasilan_ayah);
            form_data.append('nama_ibu', nama_ibu);
            form_data.append('pekerjaan_ibu', pekerjaan_ibu);
            form_data.append('jenjang_ibu', jenjang_ibu);
            form_data.append('penghasilan_ibu', penghasilan_ibu);
            form_data.append('nama_wali', nama_wali);
            form_data.append('pekerjaan_wali', pekerjaan_wali);
            form_data.append('jenjang_wali', jenjang_wali);
            form_data.append('penghasilan_wali', penghasilan_wali);
            form_data.append('email', email);
            form_data.append('wawalmur', wawalmur);
            form_data.append('waadmin', waadmin);
            form_data.append('wapeserta', wapeserta);

            $.ajax({
                url: "<?php echo base_url(); ?>registrasiulang/proses2",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    if(response.status == "ok"){
                      window.location.href = '<?php echo base_url().'registrasiulang/thanks' ?>';
                    }
                
                },error: function (response) {
                    alert(response.status);
                }
            });
        }
    }

    function previous(){
        window.location.href = '<?php echo base_url().'registrasiulang/form/'.$idsiswa_enkrip; ?>';
    }

    function hanyaAngka(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else {
            return true;
        }

        keychar = String.fromCharCode(key);
        if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else {
            return false;
        }
    }
</script>

</html>