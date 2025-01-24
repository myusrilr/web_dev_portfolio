<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Visual Data Human Resource Development</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Data Visual</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card support-bar">
                <div class="card-header with-elements">
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_jml_siswa_bulan" class="custom-select" onchange="pilih_jml_siswa();">
                                    <option value="~">Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_jml_siswa_tahun" class="custom-select" onchange="pilih_jml_siswa();">
                                    <option value="~">Tahun</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <h2 class="m-0">Siswa Regular</h2>
                    <p class="mb-3 mt-3">Total Siswa Regular</p>
                </div>
                <div class="card-footer text-white" style="background-color: #1F1746;">
                    <div class="row text-center">
                        <div class="col border-right">
                            <h4 id="jml_siswa_regular" class="m-0 text-white"><?php echo $jml_siswa_regular; ?></h4>
                            <span>Regular</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-white" style="background-color: #1F1746;">
                    <div class="row text-center">
                        <div class="col border-right">
                            <h4 id="jml_siswa_regular" class="m-0 text-white"><?php echo $jml_siswa_mitra; ?></h4>
                            <span>Mitra</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6">
            <div class="card support-bar">
                <div class="card-body pb-0">
                    <h2 class="m-0"><?php echo $totalNo2; ?></h2>
                    <span class="text-c-purple">Provinsi</span>
                    <p class="mb-3 mt-3">Total jumlah sebaran siswa berdasarkan provinsi.</p>
                </div>
                <div id="chartAngka2" style="height:100px;width:100%;"></div>
                <div class="card-footer text-white" style="background-color: #1F1746;">
                    <div class="row text-center">
                        <?php
                        foreach ($no2->getResult() as $row) {
                            if($row->nama != ""){
                                $nama = $row->nama;
                            }else{
                                $nama = "Unverified";
                            }
                        ?>
                            <div class="col">
                                <h4 class="m-0 text-white"><?php echo $row->jml; ?></h4>
                                <span style="font-size: 10px;"><?php echo $nama; ?></span>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Lokasi Persebaran Siswa <?php echo $tahun; ?></h6>
                </div>
                <div class="card-body">
                    <div id="maps" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-8 col-xs-8">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Persebaran Siswa Berdasarakan Kursus</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="text-light text-tiny font-weight-semibold align-middle">Tahun</span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select class="custom-select">
                                    <option>All</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_siswa_periode" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card support-bar">
                        <div class="card-header with-elements">
                            <div class="card-header-elements ml-auto">
                                <label class="text m-0">
                                    <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                        <select class="custom-select">
                                            <option>All</option>
                                        </select>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <h2 class="m-0">Pembelian Ulang</h2>
                            <p class="mb-3 mt-3">Prosentase pembelian ulang kursus.</p>
                        </div>
                        <div class="card-footer text-white" style="background-color: #1F1746;">
                            <div class="row text-center">
                                <div class="col border-right">
                                    <h4 class="m-0 text-white"><?php echo round($prosentase_pembelian_ulang, 10) . ' %'; ?></h4>
                                    <span>Prosentase</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12">
                    <div class="card support-bar">
                        <div class="card-header with-elements">
                            <div class="card-header-elements ml-auto">
                                <label class="text m-0">
                                    <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                        <select class="custom-select" onchange="keluar_masuk(this);">
                                            <option value="~">Tahun</option>
                                            <?php echo $datatahun; ?>
                                        </select>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <h2 class="m-0">Masuk Keluar Siswa</h2>
                            <p class="mb-3 mt-3">Data masuk dan keluar siswa (Regular).</p>
                        </div>
                        <div class="card-footer text-white" style="background-color: #1F1746;">
                            <div class="row text-center">
                                <div class="col border-right">
                                    <h4 id="siswa_masuk" class="m-0 text-white"><?php echo $siswa_masuk_regular; ?></h4>
                                    <span>Masuk</span>
                                </div>
                                <div class="col border-right">
                                    <h4 id="siswa_keluar" class="m-0 text-white"><?php echo $siswa_keluar_regular; ?></h4>
                                    <span>Keluar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Masuk Keluar Per Bulan</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="text-light text-tiny font-weight-semibold align-middle">Tahun</span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select class="custom-select" onchange="pilih_grafik_siswa(this);">
                                    <option>All</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_siswa" height="150"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Masuk Keluar Per Kursus</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_bulan_masuk_keluar_perkursus" class="custom-select" onchange="masuk_keluar_per_kursus();">
                                    <option value="~">Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_tahun_masuk_keluar_perkursus" class="custom-select" onchange="masuk_keluar_per_kursus();">
                                    <option value="~">Tahun</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="masuk_keluar_siswa_kursus" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class=" col-xl-4 col-md-4 col-xs-12">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Keluar Berdasarakan Alasan</h6>
                </div>
                <div class="row no-gutters row-bordered">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card-body">
                            <canvas id="grafik_siswa_keluar_per_tag" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Jumlah Siswa Berdasarkan Lama Belajar (CODING) </h6>
                    <div class="card-header-elements ml-auto">
                        
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="siswa_bertahan" height="200;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Jumlah Siswa Berdasarkan Lama Belajar (GE) </h6>
                    <div class="card-header-elements ml-auto">
                        
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="siswa_bertahan_ge" height="200;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Demografi</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="text-light text-tiny font-weight-semibold align-middle">Tahun</span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cbTahunDemografi" class="custom-select" onchange="pilih_grafik_demografi(this);">
                                    <option>All</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="row no-gutters row-bordered">
                    <div class="col-md-4 col-lg-4 col-xs-12">
                        <div class="card-body">
                            <canvas id="grafik_demograsi_usia" height="350"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xs-12">
                        <div class="card-body">
                            <canvas id="grafik_demograsi_tingkat" height="350"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xs-12">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <input type="hidden" id="defIdKabKot" value="<?php echo $def_idKabkot; ?>" readonly autocomplete="off">
                                <input type="text" id="defNamaKabKot" class="form-control" placeholder="Default kota" readonly autocomplete="off" value="<?php echo $def_namaKabkot; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="showKabKot();">...</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik_demograsi_tinggal" height="270"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card support-bar">
                <div class="card-header with-elements">
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_bulan_kerjasama_ins" class="custom-select" onchange="kerja_sama_ins();">
                                    <option value="~">Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="cb_tahun_kerjasama_ins" class="custom-select" onchange="kerja_sama_ins();">
                                    <option value="~">Tahun</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <h2 class="m-0">Kerjasama Institusi</h2>
                    <p class="mb-3 mt-3">Total Institusi yang bekerjasama</p>
                </div>
                <div class="card-footer text-white" style="background-color: #1F1746;">
                    <div class="row text-center">
                        <div class="col border-right">
                            <h4 id="total_ins" class="m-0 text-white"><?php echo $total_instansi; ?></h4>
                            <span>Total Institusi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-md-6">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Lama Kerjasama Instansi</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_kerjasama_instansi" height="150;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-12 col-md-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Total Siswa (Mitra)</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="bulan_grafik_mitra" class="custom-select" onchange="grafik_mitra();">
                                    <option value="~">Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </span>
                            <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                <select id="tahun_grafik_mitra" class="custom-select" onchange="grafik_mitra();">
                                    <option value="~">Tahun</option>
                                    <?php echo $datatahun; ?>
                                </select>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_batang_total_siswa_mitra" height="100;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-md-6">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Demografi B2B jumlah karyawan</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_demografi_b2b_jml_karyawan" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-md-6">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Demografi B2B bidang usaha</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_demografi_b2b_bidang_usaha" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-md-6 col-md-6">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Demografi B2B provinsi</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_demografi_b2b_provinsi" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-md-6">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Demografi B2B kabupaten / kota</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik_demografi_b2b_kabkot" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">Aplikasi Leapverse</h6>
                    <div class="card-header-elements ml-auto">
                        <label class="text m-0">
                            <div class="input-group mb-3">
                                <input type="file" id="file_app" name="file_app" class="form-control" placeholder="File Upload">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="uploadFileLeapVerse();">Upload</button>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-6 col-lg-6 col-xs-12">
                        <div class="card support-bar">
                            <div class="card-header with-elements">
                                <div class="card-header-elements ml-auto">
                                    <label class="text m-0">
                                        <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                            <select id="cb_bulan_leapverse_download" class="custom-select" onchange="js_total_leapverse_download();">
                                                <option value="~">Bulan</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </span>
                                        <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                            <select id="cb_tahun_leapverse_download" class="custom-select" onchange="js_total_leapverse_download();">
                                                <option value="~">Tahun</option>
                                                <?php echo $datatahun; ?>
                                            </select>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h2 class="m-0">Leapverse Download</h2>
                                <p class="mb-3 mt-3">Total Leapverse Download</p>
                            </div>
                            <div class="card-footer text-white" style="background-color: #1F1746;">
                                <div class="row text-center">
                                    <div class="col border-right">
                                        <h4 id="total_leapverse_download" class="m-0 text-white"><?php echo $total_leapverse_download; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xs-12">
                        <div class="card support-bar">
                            <div class="card-header with-elements">
                                <div class="card-header-elements ml-auto">
                                    <label class="text m-0">
                                        <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                            <select id="cb_tahun_mitra_leapverse" class="custom-select" onchange="mitra_leapverse();">
                                                <option value="~">Tahun</option>
                                                <?php echo $datatahun; ?>
                                            </select>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h2 class="m-0">Mitra Leapverse</h2>
                                <p class="mb-3 mt-3">Mitra Leapverse</p>
                            </div>
                            <div class="card-footer text-white" style="background-color: #1F1746;">
                                <div class="row text-center">
                                    <div class="col border-right">
                                        <h4 id="total_mitra_leapverse" class="m-0 text-white"><?php echo $mitra_leapverse; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xs-12">

                        <div class="card support-bar">
                            <div class="card-header with-elements">
                                <div class="card-header-elements ml-auto">
                                    <label class="text m-0">
                                        <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                            <select id="cb_leapverse_aktif_bulan" class="custom-select" onchange="js_mitra_leapverse_aktif();">
                                                <option value="1" <?php if($bulan == 1){ echo 'selected'; } ?> >Januari</option>
                                                <option value="2" <?php if($bulan == 2){ echo 'selected'; } ?>>Februari</option>
                                                <option value="3" <?php if($bulan == 3){ echo 'selected'; } ?>>Maret</option>
                                                <option value="4" <?php if($bulan == 4){ echo 'selected'; } ?>>April</option>
                                                <option value="5" <?php if($bulan == 5){ echo 'selected'; } ?>>Mei</option>
                                                <option value="6" <?php if($bulan == 6){ echo 'selected'; } ?>>Juni</option>
                                                <option value="7" <?php if($bulan == 7){ echo 'selected'; } ?>>Juli</option>
                                                <option value="8" <?php if($bulan == 8){ echo 'selected'; } ?>>Agustus</option>
                                                <option value="9" <?php if($bulan == 9){ echo 'selected'; } ?>>September</option>
                                                <option value="10" <?php if($bulan == 10){ echo 'selected'; } ?>>Oktober</option>
                                                <option value="11" <?php if($bulan == 11){ echo 'selected'; } ?>>November</option>
                                                <option value="12" <?php if($bulan == 12){ echo 'selected'; } ?>>Desember</option>
                                            </select>
                                        </span>
                                        <span class="switcher switcher-primary switcher-sm d-inline-block align-middle mr-0 ml-2">
                                            <select id="cb_leapverse_aktif_tahun" class="custom-select" onchange="js_mitra_leapverse_aktif();">
                                                <?php echo $datatahun; ?>
                                            </select>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <canvas id="grafik_leapverse" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    
</div>


<div class="modal fade" id="modal_kabkot">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tbKabKot" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;" width="5%">#</th>
                                <th>Kabupaten</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Maps -->
    <script type="text/javascript" src="<?php echo base_url(); ?>leaf/leaflet.js"></script>
    <script type="text/javascript">
        var markers = [];
        var chart_grafik_siswa = null;
        var chart_masuk_keluar_per_kursus = null;

        var chart_demografi_usia = null;
        var chart_demografi_tingkat = null;
        var chart_demografi_tinggal = null;

        var tbKabKot;

        var map = L.map('maps', {
            fullscreenControl: {
                pseudoFullscreen: false
            }
        }).setView({
            lat: 0.7893,
            lon: 113.9213
        }, 4);

        $(document).ready(function() {
            grafik_siswa();

            grafik_demografi_usia();
            grafik_demografi_tingkat_sekolah();
            grafik_demografi_lokasi();

            grafik_siswa_periode();
            grafik_siswa_keluar_per_tag();
            
            siswa_bertahan_coding();
            siswa_bertahan_ge();
            loadMaps();

            grafik_no2();
            masuk_keluar_siswa_kursus();

            batang_siswa_mitra();

            b2b_jumlah_karyawan();
            b2b_bidang_usaha();
            b2b_provinsi();
            b2b_kota(); 

            lama_kerjasama_ins();
            leapverse_aktif();
        });

        function showKabKot(){
            $('#modal_kabkot').modal('show');
            $('.modal-title').text('Data Kabupaten / Kota');
            tbKabKot = $('#tbKabKot').DataTable({
                ajax: "<?php echo base_url(); ?>visual/getKabkot",
                retrieve:true
            });
            tbKabKot.destroy();
            tbKabKot = $('#tbKabKot').DataTable({
                ajax: "<?php echo base_url(); ?>visual/getKabkot",
                retrieve:true
            });
        }
        
        function pilihkabkot(idkabkot, nama){
            $('#defIdKabKot').val(idkabkot);
            $('#defNamaKabKot').val(nama);
            
            var tahun = document.getElementById('cbTahunDemografi').value;

            var form_data = new FormData();

            $.ajax({
                url: "<?php echo base_url(); ?>visual/reload_demografi_tinggal/" + tahun + "/" + idkabkot,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {
                    
                    chart_demografi_tinggal.data.labels[0] = hasil.lokasi;

                    chart_demografi_tinggal.data.datasets[0] = {
                        label: 'Laki-laki',
                        data: hasil.laki,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_demografi_tinggal.data.datasets[1] = {
                        label: 'Perempuan',
                        data: hasil.perempuan,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_demografi_tinggal.update();

                    $('#modal_kabkot').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function grafik_no2() {
            var options1 = {
                chart: {
                    type: 'area',
                    height: 100,
                    sparkline: {
                        enabled: true
                    }
                },
                colors: ["#1F1746"],
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                series: [{
                    name: 'series1',
                    data: <?php echo $grapNo2; ?>
                }],
                tooltip: {
                    fixed: {
                        enabled: false
                    },
                    x: {
                        show: false
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return ''
                            }
                        }
                    },
                    marker: {
                        show: false
                    }
                }
            }
            new ApexCharts(document.querySelector("#chartAngka2"), options1).render();
        }


        function grafik_siswa() {
            var ctx = document.getElementById("grafik_siswa").getContext('2d');
            chart_grafik_siswa = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: ["Januari", "Februari", "Maret", "April", "Maret", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Novembers", "Desember"],
                    datasets: [{
                        label: 'Masuk',
                        data: <?php echo $data_siswa_masuk; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Keluar',
                        data: <?php echo $data_siswa_keluar; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "MASUK - KELUAR [SISWA]"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function pilih_grafik_siswa(saya) {
            // chart.data.datasets[0].data[0] = 10;
            // chart.data.datasets[1].data[0] = 20;

            // chart.data.datasets[0].data[1] = 30;
            // chart.data.datasets[1].data[1] = 10;

            // chart.data.datasets[0].data[2] = 15;
            // chart.data.datasets[1].data[2] = 15;

            var form_data = new FormData();
            form_data.append('tahun', saya.value);

            $.ajax({
                url: "<?php echo base_url(); ?>visual/siswa_masuk_keluar",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(hasil) {

                    chart_grafik_siswa.data.datasets[0] = {
                        label: 'Siswa Masuk',
                        data: hasil.masuk,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_grafik_siswa.data.datasets[1] = {
                        label: 'Siswa Keluar',
                        data: hasil.keluar,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_grafik_siswa.update();

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function siswa_bertahan_coding() {
            var ctx = document.getElementById("siswa_bertahan").getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["0 - 6", "7 - 12", "13 - 18", "19 - 24"],
                    datasets: [{
                        data: <?php echo $bertahan_coding; ?>,
                        backgroundColor: '#104D97',
                        borderColor: '#104D97',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: "Siswa Bertahan (Bulan)"
                    },
                    legend: {
                        display: false
                    },
                }
            });
        }

        function siswa_bertahan_ge() {
            var ctx = document.getElementById("siswa_bertahan_ge").getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["0 - 1", "2 - 3", "4 - 5", "6 - 7", "8 Up"],
                    datasets: [{
                        data: <?php echo $bertahan_ge; ?>,
                        backgroundColor: '#104D97',
                        borderColor: '#104D97',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: "Siswa Bertahan (Tahun)"
                    },
                    legend: {
                        display: false
                    },
                }
            });
        }

        function grafik_siswa_periode() {
            Chart.defaults.global.defaultFontFamily = "Calibri";
            Chart.defaults.global.defaultFontSize = 14;

            var color = [];
            for (var i = 0; i < <?php echo $jml_kursus; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
            }

            var ctx = document.getElementById("grafik_siswa_periode").getContext('2d');

            var data_sisa_periode = {
                labels: <?php echo $nama_kursus; ?>,
                datasets: [{
                    data: <?php echo $jml_siswa_kursus; ?>,
                    backgroundColor: color,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                            const percentage = value / total * 100
                            return percentage.toFixed(2) + "%";
                        },
                        color: '#fff',
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 0,
                        bottom: 200
                    }
                },
                legend: {
                    display: false
                }, 
                title: {
                    display: false,
                    text: 'SEBARAN KURSUS',
                    position: "top"
                }
            };

            new Chart(ctx, {
                type: 'pie',
                data: data_sisa_periode,
                options: options

            });
        }

        function grafik_siswa_keluar_per_tag() {

            var color = [];
            var border = [];
            for (var i = 0; i < <?php echo $jml_tag; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 0.5)";
                var n2 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
                border.push(n2);
            }

            var ctx = document.getElementById("grafik_siswa_keluar_per_tag").getContext('2d');
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $nama_tag; ?>,
                    datasets: [{
                        label: 'Jumlah Siswa Keluar',
                        data: <?php echo $jml_keluar_tag; ?>,
                        backgroundColor: '#1F1746',
                        borderColor: '#1F1746',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Keluar By Nama Tag"
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }

        function grafik_siswa_keluar_per_periode() {
            var ctx = document.getElementById("grafik_siswa_keluar_periode").getContext('2d');
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $nama_periode; ?>,
                    datasets: [{
                        label: 'Jumlah Siswa Keluar',
                        data: <?php echo $jml_keluar_periode; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Keluar By Periode"
                    },
                    legend: {
                        display: false
                    }
                }
            });
        }

        function grafik_demografi_usia() {
            var ctx = document.getElementById("grafik_demograsi_usia").getContext('2d');
            chart_demografi_usia = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: ["Usia 0-9", "Usia 10 - 20", "Usia 11 - 30", "Usia 31 - 40", "Usia > 40"],
                    datasets: [{
                        label: 'Laki-laki',
                        data: <?php echo $data_usia_demografi_laki; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: <?php echo $data_usia_demografi_perempuan; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "MASUK - KELUAR [SISWA]"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function grafik_demografi_tingkat_sekolah() {
            var ctx = document.getElementById("grafik_demograsi_tingkat").getContext('2d');
            chart_demografi_tingkat = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: ["TK", "SD", "SMP", "SMA", "D3", "D4", "S1", "S2"],
                    datasets: [{
                        label: 'Laki-laki',
                        data: <?php echo $demografi_tingkat_l; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: <?php echo $demografi_tingkat_p; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "MASUK - KELUAR [SISWA]"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function grafik_demografi_lokasi() {
            var ctx = document.getElementById("grafik_demograsi_tinggal").getContext('2d');
            chart_demografi_tinggal = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $lokasi_siswa; ?>,
                    datasets: [{
                        label: 'Laki-laki',
                        data: <?php echo $lokasi_siswaL; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: <?php echo $lokasi_siswaP; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Demografi Wilayah"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function loadMaps() {
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© LEAP'
            }).addTo(map);


            load_marker();
        }

        function masuk_keluar_per_kursus() {
            var bulan = document.getElementById('cb_bulan_masuk_keluar_perkursus').value;
            var tahun = document.getElementById('cb_tahun_masuk_keluar_perkursus').value;

            var form_data = new FormData();

            $.ajax({
                url: "<?php echo base_url(); ?>visual/masuk_keluar_siswa_kursus/" + bulan + "/" + tahun,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'GET',
                success: function(hasil) {

                    chart_masuk_keluar_per_kursus.data.datasets[0] = {
                        label: 'Masuk',
                        data: hasil.masuk,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_masuk_keluar_per_kursus.data.datasets[1] = {
                        label: 'Keluar',
                        data: hasil.keluar,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_masuk_keluar_per_kursus.update();

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });

        }

        function masuk_keluar_siswa_kursus() {
            var ctx = document.getElementById("masuk_keluar_siswa_kursus").getContext('2d');
            chart_masuk_keluar_per_kursus = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $kursus3; ?>,
                    datasets: [{
                        label: 'Masuk',
                        data: <?php echo $masuk3; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Keluar',
                        data: <?php echo $keluar3; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    indexAxis: 'y',
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Masuk Keluar per kursus"
                    },
                    legend: {
                        display: true
                    }
                }
            });
        }


        function load_marker() {
            $.ajax({
                url: "<?php echo base_url(); ?>visual/load_marker",
                type: "GET",
                dataType: "TEXT",
                success: function(data) {
                    var hasil = JSON.parse(data);

                    for (var i = 0; i < hasil.length; i++) {
                        addMarkerFromDB(hasil[i].idkab, hasil[i].simbol, hasil[i].lat, hasil[i].lon, hasil[i].nama, hasil[i].jmlsiswa);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error load marker');
                }
            });
        }

        function addMarkerFromDB(id, simbol, lintang, bujur, nama, jmlsiswa) {
            let customIcon = {
                iconUrl: simbol,
                iconSize: [20, 20]
            };
            let myIcon = L.icon(customIcon);

            let iconOptions = {
                title: nama,
                draggable: false,
                icon: myIcon,
                id: id
            };

            var popupContent = '<table>' +
                '<tr><td>Kabupaten</td><td>&nbsp;:&nbsp;</td><td>' + nama + '</td></tr>' +
                '<tr><td>Jumlah Siswa</td><td>&nbsp;:&nbsp;</td><td>' + jmlsiswa + '</td></tr>';

            var newLatLng = new L.LatLng(lintang, bujur);
            var marker = new L.marker(newLatLng, iconOptions);
            marker._id = id;
            marker.bindPopup(popupContent, {
                closeButton: true
            });

            map.addLayer(marker);
            markers.push(marker);
        }

        function pilih_jml_siswa() {
            var bulan = document.getElementById('cb_jml_siswa_bulan').value;
            var tahun = document.getElementById('cb_jml_siswa_tahun').value;
            $.ajax({
                url: "<?php echo base_url(); ?>visual/load_jml_siswa/" + bulan + "/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#jml_siswa_regular').html(data.jml_siswa_regular);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error get data " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function keluar_masuk(komponen) {
            var tahun = komponen.value;
            $.ajax({
                url: "<?php echo base_url(); ?>visual/load_masuk_keluar/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#siswa_masuk').html(data.siswa_masuk_regular);
                    $('#siswa_keluar').html(data.siswa_keluar_regular);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error get data " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function pilih_grafik_demografi(komponen){
            var tahun = komponen.value;
            demografi_usia(tahun);
            demografi_tingkat(tahun);
            demografi_tinggal(tahun);
        }

        function demografi_usia(tahun){
            $.ajax({
                url: "<?php echo base_url(); ?>visual/reload_demografi_usia/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {

                    chart_demografi_usia.data.datasets[0] = {
                        label: 'Laki-laki',
                        data: hasil.laki,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_demografi_usia.data.datasets[1] = {
                        label: 'Perempuan',
                        data: hasil.perempuan,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_demografi_usia.update();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function demografi_tingkat(tahun){
            $.ajax({
                url: "<?php echo base_url(); ?>visual/reload_demografi_tingkat/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {

                    chart_demografi_tingkat.data.datasets[0] = {
                        label: 'Laki-laki',
                        data: hasil.laki,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_demografi_tingkat.data.datasets[1] = {
                        label: 'Perempuan',
                        data: hasil.perempuan,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_demografi_tingkat.update();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function demografi_tinggal(tahun){
            var defIdKabKot = document.getElementById('defIdKabKot').value;
            $.ajax({
                url: "<?php echo base_url(); ?>visual/reload_demografi_tinggal/" + tahun + "/" + defIdKabKot,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {
                    
                    chart_demografi_tinggal.data.labels[0] = hasil.lokasi;

                    chart_demografi_tinggal.data.datasets[0] = {
                        label: 'Laki-laki',
                        data: hasil.laki,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }

                    chart_demografi_tinggal.data.datasets[1] = {
                        label: 'Perempuan',
                        data: hasil.perempuan,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }

                    chart_demografi_tinggal.update();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function kerja_sama_ins(){
            var bulan = document.getElementById('cb_bulan_kerjasama_ins').value;
            var tahun = document.getElementById('cb_tahun_kerjasama_ins').value;

            $.ajax({
                url: "<?php echo base_url(); ?>visual/kerja_sama_ins/" + bulan + "/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {
                    $('#total_ins').html(hasil.total);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function pilih_jml_siswa_mitra(){
            var bulan = document.getElementById('cb_jml_siswa_bulan_mitra').value;
            var tahun = document.getElementById('cb_jml_siswa_tahun_mitra').value;

            // jml_siswa_mitra
            $.ajax({
                url: "<?php echo base_url(); ?>visual/ajax_jumlah_siswa_mitra/" + bulan + "/" + tahun,
                type: "GET",
                dataType: "JSON",
                success: function(hasil) {
                    $('#jml_siswa_mitra').html(hasil.total);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function batang_siswa_mitra() {
            var ctx = document.getElementById("grafik_batang_total_siswa_mitra").getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $mitra; ?>,
                    datasets: [{
                        label: 'Laki-laki',
                        data: <?php echo $mitra_laki; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }, {
                        label: 'Perempuan',
                        data: <?php echo $mitra_perempuan; ?>,
                        backgroundColor: "#93BFE6",
                        borderColor: "#93BFE6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                autoSkip: false,        // Pastikan tidak melewati label
                                maxRotation: 90,        // Rotasi maksimal label (ke bawah)
                                minRotation: 90         // Rotasi minimal label (90 derajat)
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Total Siswa Mitra"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function lama_kerjasama_ins() {
            var ctx = document.getElementById("grafik_kerjasama_instansi").getContext('2d');
            new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: <?php echo $nama_ins_kerjasama; ?>,
                    datasets: [{
                        label: 'Lama Kerjasama (Bulan)',
                        data: <?php echo $jumlah_ins_kerjasama; ?>,
                        backgroundColor: "#1F1746",
                        borderColor: "#1F1746",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: "Lama Kerja Sama"
                    },
                    legend: {
                        display: true
                    },
                }
            });
        }

        function b2b_jumlah_karyawan() {
            Chart.defaults.global.defaultFontFamily = "Calibri";
            Chart.defaults.global.defaultFontSize = 16;

            var color = [];
            for (var i = 0; i < <?php echo $jml_kursus; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
            }

            var ctx = document.getElementById("grafik_demografi_b2b_jml_karyawan").getContext('2d');

            var data_sisa_periode = {
                labels: ["1 - 5", "6 - 25", "26 - 50", "51 - 100", "> 100"],
                datasets: [{
                    data: <?php echo $b2b_jumlah_karyawan; ?>,
                    backgroundColor: color,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                            const percentage = value / total * 100
                            return percentage.toFixed(2) + "%";
                        },
                        color: '#fff',
                    }
                },
                layout: {
                    padding: {
                        left: 60,
                        right: 60,
                        top: 10,
                        bottom: 60
                    }
                },
                legend: {
                    display: true
                }, 
                title: {
                    display: false,
                    text: 'B2B Jumlah Karyawan',
                    position: "top"
                }
            };

            new Chart(ctx, {
                type: 'pie',
                data: data_sisa_periode,
                options: options

            });
        }

        function b2b_bidang_usaha() {
            Chart.defaults.global.defaultFontFamily = "Calibri";
            Chart.defaults.global.defaultFontSize = 16;

            var color = [];
            for (var i = 0; i < <?php echo $counter_b2b_bidang_usaha; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
            }

            var ctx = document.getElementById("grafik_demografi_b2b_bidang_usaha").getContext('2d');

            var data = {
                labels: <?php echo $nama_b2b_bidang_usaha; ?>,
                datasets: [{
                    data: <?php echo $jumlah_b2b_bidang_usaha; ?>,
                    backgroundColor: color,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                            const percentage = value / total * 100
                            return percentage.toFixed(2) + "%";
                        },
                        color: '#fff',
                    }
                },
                layout: {
                    padding: {
                        left: 60,
                        right: 60,
                        top: 10,
                        bottom: 60
                    }
                },
                legend: {
                    display: true
                }, 
                title: {
                    display: false,
                    text: 'B2B Jumlah Karyawan',
                    position: "top"
                }
            };

            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options

            });
        }

        function b2b_provinsi() {
            Chart.defaults.global.defaultFontFamily = "Calibri";
            Chart.defaults.global.defaultFontSize = 16;

            var color = [];
            for (var i = 0; i < <?php echo $counter_b2b_provinsi; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
            }

            var ctx = document.getElementById("grafik_demografi_b2b_provinsi").getContext('2d');

            var data = {
                labels: <?php echo $nama_b2b_provinsi; ?>,
                datasets: [{
                    data: <?php echo $jumlah_b2b_provinsi; ?>,
                    backgroundColor: color,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                            const percentage = value / total * 100
                            return percentage.toFixed(2) + "%";
                        },
                        color: '#fff',
                    }
                },
                layout: {
                    padding: {
                        left: 60,
                        right: 60,
                        top: 10,
                        bottom: 60
                    }
                },
                legend: {
                    display: true
                }, 
                title: {
                    display: false,
                    text: 'B2B Provinsi',
                    position: "top"
                }
            };

            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options

            });
        }


        function b2b_kota() {
            Chart.defaults.global.defaultFontFamily = "Calibri";
            Chart.defaults.global.defaultFontSize = 16;

            var color = [];
            for (var i = 0; i < <?php echo $counter_b2b_kabkot; ?>; i++) {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);

                var n1 = "rgb(" + r + "," + g + "," + b + ", 1)";
                color.push(n1);
            }

            var ctx = document.getElementById("grafik_demografi_b2b_kabkot").getContext('2d');

            var data = {
                labels: <?php echo $nama_b2b_kabkot; ?>,
                datasets: [{
                    data: <?php echo $jumlah_b2b_kabkot; ?>,
                    backgroundColor: color,
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                tooltips: {
                    enabled: false
                },
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            const datapoints = ctx.chart.data.datasets[0].data
                            const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
                            const percentage = value / total * 100
                            return percentage.toFixed(2) + "%";
                        },
                        color: '#fff',
                    }
                },
                layout: {
                    padding: {
                        left: 60,
                        right: 60,
                        top: 10,
                        bottom: 60
                    }
                },
                legend: {
                    display: true
                }, 
                title: {
                    display: false,
                    text: 'B2B Kabupaten Kota',
                    position: "top"
                }
            };

            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options

            });
        }

        function uploadFileLeapVerse(){
            var file = $('#file_app').prop('files')[0];
            
            var form_data = new FormData();
            form_data.append('file', file);
            
            $.ajax({
                url: "<?php echo base_url(); ?>visual/uploadFileLeapVerse",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    console.log(response.status);
                    iziToast.success({
                        title: 'Info',
                        message: response.status,
                        position: 'topRight'
                    });

                },error: function (response) {
                    iziToast.error({
                        title: 'Info',
                        message: response.status,
                        position: 'topRight'
                    });
                }
            });
        }

        function js_total_leapverse_download(){
            var bulan = document.getElementById('cb_bulan_leapverse_download').value;
            var tahun = document.getElementById('cb_tahun_leapverse_download').value;

            var form_data = new FormData();
            form_data.append('bulan', bulan);
            form_data.append('tahun', tahun);

            $.ajax({
                url: "<?php echo base_url(); ?>visual/leapverse_download",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(hasil) {
                    $('#total_leapverse_download').html(hasil.status);
                },error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        function mitra_leapverse(){
            var tahun = document.getElementById('cb_tahun_mitra_leapverse').value;

            var form_data = new FormData();
            form_data.append('tahun', tahun);

            $.ajax({
                url: "<?php echo base_url(); ?>visual/mitra_leapverse",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(hasil) {
                    $('#total_mitra_leapverse').html(hasil.status);
                },error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        

        var chart_leapverse_aktif = null;

        function leapverse_aktif() {
            var ctx = document.getElementById("grafik_leapverse").getContext('2d');
            chart_leapverse_aktif = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $tgl_leapverse_aktif; ?>,
                    datasets: [{
                        data: <?php echo $jumlah_leapverse_aktif; ?>,
                        label: 'Jumlah Aktif',
                        backgroundColor: '#104D97',
                        borderColor: '#104D97',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: "Leapverse Aktif"
                    },
                    legend: {
                        display: false
                    },
                }
            });
        }

        function js_mitra_leapverse_aktif(){
            var bulan = document.getElementById('cb_leapverse_aktif_bulan').value;
            var tahun = document.getElementById('cb_leapverse_aktif_tahun').value;

            var form_data = new FormData();
            form_data.append('bulan', bulan);
            form_data.append('tahun', tahun);

            $.ajax({
                url: "<?php echo base_url(); ?>visual/leapverse_aktif",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(hasil) {

                    chart_leapverse_aktif.data.labels = hasil.tgl;

                    chart_leapverse_aktif.data.datasets[0] = {
                        label: 'Jumlah Aktif',
                        data: hasil.jumlah,
                        backgroundColor: "#104D97",
                        borderColor: "#104D97",
                        borderWidth: 1
                    }

                    chart_leapverse_aktif.update();

                },
                error: function(jqXHR, textStatus, errorThrown) {

                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

    </script>