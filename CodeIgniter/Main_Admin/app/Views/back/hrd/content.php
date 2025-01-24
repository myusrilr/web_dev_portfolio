<script type="text/javascript">

    $(document).ready(function () {
        //$('#modal_pengumuman').modal('show');
    });

</script>

<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard Human Resource Development</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Main</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-tie f-36 text-primary"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">KARYAWAN</h6>
                            <h2 class="m-b-0"><?php echo $karyawan; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-female f-36 text-danger"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">PEREMPUAN</h6>
                            <h2 class="m-b-0"><?php echo $wanita; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-male f-36 text-success"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">LAKI-LAKI</h6>
                            <h2 class="m-b-0"><?php echo $pria; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-clock f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">FULLTIME</h6>
                            <h2 class="m-b-0"><?php echo $full; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-tie f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">PARTIME</h6>
                            <h2 class="m-b-0"><?php echo $part; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-friends f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">MAGANG</h6>
                            <h2 class="m-b-0"><?php echo $magang; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger"><?php echo $pelamar; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url() . '/rekruitmen'; ?>">PELAMAR BARU <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-danger"><?php echo $pegawai; ?></span>
                                    <br>
                                    <small class="text-muted"><a href="<?php echo base_url() . '/permintaan'; ?>">PERMINTAAN PEGAWAI BARU <?php echo strtoupper(date('F Y')) ?></a></small>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger"><?php echo $perijinan; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url() . '/persetujuan'; ?>">PERIJINAN / LEMBUR <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-danger"><?php echo $resign; ?></span>
                                    <br>
                                    <small class="text-muted"><a href="<?php echo base_url() . '/resign'; ?>">PERMINTAAN RESIGN <?php echo strtoupper(date('F Y')) ?></a></small>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">CHART PERMINTAAN PERIJINAN/LEMBUR <?php echo date("Y"); ?></h6>
                </div>
                <div class="card-body py-0">
                    <div id="chart-bar-moris" style="height:300px"></div>
                </div>
                <div class="card-footer pt-0 pb-0">
                    <div class="row row-bordered row-border-light">
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-primary" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">LEMBUR</p>
                                    <h5 class="mb-0"><?php echo $jlembur; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-success" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">IJIN</p>
                                    <h5 class="mb-0"><?php echo $jijin; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-warning" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">SAKIT</p>
                                    <h5 class="mb-0"><?php echo $jsakit; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-danger" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">IJIN DARURAT</p>
                                    <h5 class="mb-0"><?php echo $jurgent; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">CHART KEHADIRAN (<?php echo strtoupper(date("F")); ?> 2023)</h6>
                </div>
                <div class="row no-gutters row-bordered">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <select class="form-control" id="bulan" name="bulan">
                                        <!-- <option>Pilih bulan</option> -->
                                        <option value="1" <?php if(date("m") == '01'){ echo 'selected'; }?>>Januari</option>
                                        <option value="2" <?php if(date("m") == '02'){ echo 'selected'; }?>>Februari</option>
                                        <option value="3" <?php if(date("m") == '03'){ echo 'selected'; }?>>Maret</option>
                                        <option value="4" <?php if(date("m") == '04'){ echo 'selected'; }?>>April</option>
                                        <option value="5" <?php if(date("m") == '05'){ echo 'selected'; }?>>Mei</option>
                                        <option value="6" <?php if(date("m") == '06'){ echo 'selected'; }?>>Juni</option>
                                        <option value="7" <?php if(date("m") == '07'){ echo 'selected'; }?>>Juli</option>
                                        <option value="8" <?php if(date("m") == '08'){ echo 'selected'; }?>>Agustus</option>
                                        <option value="9" <?php if(date("m") == '09'){ echo 'selected'; }?>>September</option>
                                        <option value="10" <?php if(date("m") == '10'){ echo 'selected'; }?>>Oktober</option>
                                        <option value="11" <?php if(date("m") == '11'){ echo 'selected'; }?>>November</option>
                                        <option value="12" <?php if(date("m") == '12'){ echo 'selected'; }?>>Desember</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <?php 
                                    echo '<select class="form-control" id="tahun" name="tahun">';
                                    //echo '<option>Pilih tahun</option>';
                                    for($i = date("Y")-3; $i <=date("Y")+5; $i++){
                                        if($i == date("Y")){
                                            echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                        }else{
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="filter();" style="background-color: #4CAF50;">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-12 col-xl-5">
                        <div class="card-body">
                            <div class="pb-4">
                                <b>Hadir</b>
                                <div class="float-right">
                                    <span class="text-muted small" id="hadir"><?php echo $hadir; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('telat');">Terlambat</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="terlambat"><?php echo $telat; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('tepat');">Tepat Waktu</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="tepat"><?php echo $tepat; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                                <b>Tidak Hadir</b>
                                <div class="float-right">
                                    <span class="text-muted small" id="tdkhadir"><?php echo $tdkhadir; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('ijin');">Ijin / Cuti</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="cuti"><?php echo $aijin; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('darijin');">Ijin Darurat</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="darurat"><?php echo $darijin; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('sakit');">Sakit</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="sakit"><?php echo $sakit; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="absensi('alpha');">Alpha</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="alpha"><?php echo $alpha; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-12 col-xl-7">
                        <div class="card-body">
                            <div id="absensi"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pengumuman">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        $counter = 0;
                        foreach ($pengumuman->getResult() as $row) {
                            if($counter == 0){
                                ?>
                        <li data-target="#carouselExample" data-slide-to="<?php echo $counter; ?>" class="active"></li>
                                <?php
                            }else{
                                ?>
                        <li data-target="#carouselExample" data-slide-to="<?php echo $counter; ?>"></li>
                                <?php
                            }
                            $counter++;
                        }
                        ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php
                        $counter = 0;
                        foreach ($pengumuman->getResult() as $row) {
                            $img = base_url().'/images/white.png';
                            if(strlen($row->gambar) > 0){
                                if(file_exists('uploads/'.$row->gambar)){
                                    $img = base_url().'/uploads/'.$row->gambar;
                                }
                            }
                            
                            if($counter == 0){
                                ?>
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="<?php echo $img; ?>" alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h3><?php echo $row->judul; ?></h3>
                                <p><?php echo $row->isi; ?></p>
                            </div>
                        </div>
                                <?php
                            }else{
                                ?>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="<?php echo $img; ?>" alt="Second slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h3><?php echo $row->judul; ?></h3>
                                <p><?php echo $row->isi; ?></p>
                            </div>
                        </div>
                                <?php
                            }
                            $counter++;
                        }
                        ?>
                        
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_absen">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_absen" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Scan Masuk</th>
                                <th>Scan Keluar</th>
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

<div class="modal fade" id="modal_ijin">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Absensi Ijin / Ijin Darurat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_ijin" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th style="text-align: center;">Status</th>
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

<script>
    var tb_absen, tb_ijin, mode;

    function filter() {
        mode = "all";
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;

        if(tahun != '' && bulan == ''){
            mode = "tahun";
            var url = "<?php echo base_url(); ?>home/ajaxparam/" +mode+":"+tahun;
        }else if(tahun == '' && bulan != ''){
            mode = "bulan";
            var url = "<?php echo base_url(); ?>home/ajaxparam/" +mode+":"+bulan;
        }else if(tahun != '' && bulan != ''){
            mode = "filter";
            var url = "<?php echo base_url(); ?>home/ajaxparam/" +mode+":"+bulan+":"+tahun;
        }else{
            alert("Tidak ada filter!");
        }

        if(mode != "all"){
            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    if(data.hadir > 0){
                        document.getElementById("hadir").className = "text-success";
                    }else{
                        document.getElementById("hadir").className = "text-muted small";
                    }
                    if(data.telat > '0'){
                        document.getElementById("terlambat").className = "text-success";
                    }else{
                        document.getElementById("terlambat").className = "text-muted small";
                    }
                    if(data.tepat > '0'){
                        document.getElementById("tepat").className = "text-success";
                    }else{
                        document.getElementById("tepat").className = "text-muted small";
                    }
                    if(data.tdkhadir > 0){
                        document.getElementById("tdkhadir").className = "text-success";
                    }else{
                        document.getElementById("tdkhadir").className = "text-muted small";
                    }
                    if(data.aijin > '0'){
                        document.getElementById("cuti").className = "text-success";
                    }else{
                        document.getElementById("cuti").className = "text-muted small";
                    }
                    if(data.darijin > '0'){
                        document.getElementById("darurat").className = "text-success";
                    }else{
                        document.getElementById("darurat").className = "text-muted small";
                    }
                    if(data.sakit > '0'){
                        document.getElementById("sakit").className = "text-success";
                    }else{
                        document.getElementById("sakit").className = "text-muted small";
                    }
                    if(data.alpha > '0'){
                        document.getElementById("alpha").className = "text-success";
                    }else{
                        document.getElementById("alpha").className = "text-muted small";
                    }
                    document.getElementById("hadir").innerHTML = data.hadir;
                    document.getElementById("terlambat").innerHTML = data.telat;
                    document.getElementById("tepat").innerHTML = data.tepat;
                    document.getElementById("tdkhadir").innerHTML = data.tdkhadir;
                    document.getElementById("cuti").innerHTML = data.aijin;
                    document.getElementById("darurat").innerHTML = data.darijin;
                    document.getElementById("sakit").innerHTML = data.sakit;
                    document.getElementById("alpha").innerHTML = data.alpha;

                    absensibar(data.telat, data.tepat, data.aijin,  data.darijin, data.sakit, data.alpha);
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data');
                }
            });
        }
    }

    $(document).ready(function () {
        Morris.Bar({
            element: 'chart-bar-moris',
            data: [
            <?php foreach ($jmlijin->getResult() as $row) { ?>
                {
                    y: '<?php echo $row->bln; ?>',
                    a: <?php echo $row->jmlijin; ?>,
                    b: <?php echo $row->jmllembur; ?>,
                    c: <?php echo $row->jmlsakit; ?>,
                    d: <?php echo $row->jmlizin; ?>,
                },
            <?php } ?>
            ],
            xkey: 'y',
            barSizeRatio: 0.70,
            barGap: 5,
            responsive: true,
            ykeys: ['a', 'b', 'c', 'd'],
            labels: ['Ijin', 'Lembur', 'Sakit', 'Ijin Darurat'],
            barColors: ['#2e76bb', '#62d493', '#f4ab55', '#FF4961'],
            hideHover: 'auto'
        });

        var telat = <?php echo $telat; ?>;
        var tepat = <?php echo $tepat; ?>;
        var aijin = <?php echo $aijin; ?>;
        var sakit = <?php echo $sakit; ?>;
        var alpha = <?php echo $alpha; ?>;
        
        absensibar(telat, tepat, aijin, sakit, alpha);
    });

    function absensibar(telat, tepat, aijin, darijin, sakit, alpha){
        $("#absensi").empty();
        $(document).ready(function () {
            Morris.Bar({
                element: 'absensi',
                data: [
                        {
                            y: '<?php echo date("M Y")?>',
                            a: telat,
                            b: tepat,
                            c: aijin,
                            d: darijin,
                            e: sakit,
                            f: alpha,
                        },
                ],
                xkey: 'y',
                barSizeRatio: 0.70,
                barGap: 5,
                responsive: true,
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f'],
                labels: ['Terlambat', 'Tepat Waktu', 'Ijin', 'Ijin Darurat', 'Sakit', 'Alpha'],
                barColors: ['#2e76bb', '#62d493', '#f4ab55', '#FF4961'],
                hideHover: 'auto'
            });
        });
    }

    function absensi(status){
        $('#modal_absen').modal('show');
        
        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status":"+bulan":"+tahun,
            retrieve : true
        });
        tb_absen.destroy();
        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status":"+bulan":"+tahun,
            retrieve : true
        });
    }

    function ijin(status){
        $('#modal_ijin').modal('show');
        
        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status":"+bulan":"+tahun,
            retrieve : true
        });
        tb_absen.destroy();
        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status":"+bulan":"+tahun,
            retrieve : true
        });
    }
    
</script>
<!-- [ content ] End -->