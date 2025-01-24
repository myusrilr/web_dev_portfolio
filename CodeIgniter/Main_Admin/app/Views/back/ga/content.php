<style>
.absen a:hover {
  background-color: #ADD8E6;
}
</style>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard General Affairs</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Main</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-toolbox f-36 text-primary"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><a href="<?php echo base_url(); ?>isuinfrastruktur">ISU INFRASTRUKTUR</a></h6>
                            <h2 class="m-b-0"><?php echo $isu; ?></h2>
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
                            <i class="fas fa-shopping-cart f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><a href="<?php echo base_url(); ?>persetujuanpembelian">PURCHASE REQUEST</a></h6>
                            <h2 class="m-b-0"><?php echo $beli; ?></h2>
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
                            <i class="fas fa-archive f-36 text-success"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><a href="<?php echo base_url(); ?>persetujuanpinjam">PEMINJAMAN</a></h6>
                            <h2 class="m-b-0"><?php echo $pinjam; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="card d-flex w-100 mb-12">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-4 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-warning"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-warning"><?php echo $surattugas; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/perijinantugas'; ?>">PERMINTAAN SURAT TUGAS</a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-4 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-warning"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-warning"><?php echo $suratkeluar; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/perijinansuratkeluar'; ?>">PERSETUJUAN SURAT KELUAR</a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-4 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-warning"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-warning"><?php echo $mou; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/persetujuanmou'; ?>">PERMINTAAN MoU</a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
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
                        <div class="card-body absen">
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
                            &emsp;&emsp;<a onclick="ijin('ijin');">Ijin / Cuti (Status disetujui)</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="cuti"><?php echo $aijin; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="ijin('darijin');">Ijin Darurat (Status disetujui)</a>
                                <div class="float-right">
                                    <span class="text-muted small" id="darurat"><?php echo $darijin; ?></span>
                                </div>
                            </div>
                            <div class="pb-4">
                            &emsp;&emsp;<a onclick="ijin('sakit');">Sakit (Status disetujui)</a>
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
                                <th>Jumlah</th>
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

<div class="modal fade" id="modal_detabsen">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Detail Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_detil_absen" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Scan Masuk</th>
                                <th>Terlambat</th>
                                <th>Jam Keluar</th>
                                <th>Scan Keluar</th>
                                <th>Keluar Cepat</th>
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

<!-- <div class="modal fade" id="modal_ijin">
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
                                <th>Jumlah</th>
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
</div> -->

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

<div class="modal fade" id="modal_form3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title3">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="info3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form3">
                    <input type="hidden" id="kode" name="kode">
                    <input type="hidden" id="idkaryawan" name="idkaryawan">
                    <input type="hidden" id="bulan" name="bulan">
                    <input type="hidden" id="thn" name="thn">
                    <input type="hidden" id="filter" name="filter">
                    <div class="form-group col">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" id="karyawan" name="karyawan" class="form-control" disabled>
                    </div>
                    <div class="form-group col">
                        <label class="form-label">Tanggal</label>
                        <input type="text" id="tanggal" name="tanggal" class="form-control" disabled>
                    </div>
                    <div class="form-group col">
                        <label class="form-label">Scan Masuk - Keluar</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6" style="margin-left: 10px;"><input type="time" id="scanmasuk" name="scanmasuk" class="form-control"></div>
                        <div class="form-group col-md-5"><input type="time" id="scankeluar" name="scankeluar" class="form-control"></div>
                    </div>
                    <div class="form-group col">
                        <label class="form-label">Status</label>
                        <select class="custom-select" id="status" name="status">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Terlambat">Terlambat</option>
                            <option value="Tepat Waktu">Tepat Waktu</option>
                            <option value="Libur">Libur</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Ijin/Cuti">Ijin/Cuti</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <textarea class="form-control" name="verif" id="verif"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal3();">Tutup</button>
                <button id="btnSave3" type="button" class="btn btn-primary" onclick="saveverif();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var mode; 
    var tb_absen, tb_detil_absen;

    $(document).ready(function() {
        absensibar(<?php echo $hadir.','.$telat.','.$tepat.','.$tdkhadir.','.$aijin.','.$darijin.','.$sakit.','.$alpha.','.date('m'); ?>);
    });

    function filter(){
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
                    document.getElementById("hadir").innerHTML = data.hadir;
                    document.getElementById("terlambat").innerHTML = data.telat;
                    document.getElementById("tepat").innerHTML = data.tepat;
                    document.getElementById("tdkhadir").innerHTML = data.tdkhadir;
                    document.getElementById("cuti").innerHTML = data.aijin;
                    document.getElementById("darurat").innerHTML = data.darijin;
                    document.getElementById("sakit").innerHTML = data.sakit;
                    document.getElementById("alpha").innerHTML = data.alpha;

                    absensibar(data.hadir, data.telat, data.tepat, data.tdkhadir, data.aijin, data.darijin, data.sakit, data.alpha, data.bulan);
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data');
                }
            });
        }
    }

    function absensibar(hadir, telat, tepat, tdkhadir, aijin, darijin, sakit, alpha, bulan){
        $("#absensi").empty();
        if(hadir > 0){
            document.getElementById("hadir").className = "text-success";
        }else{
            document.getElementById("hadir").className = "text-muted small";
        }
        if(telat > '0'){
            document.getElementById("terlambat").className = "text-success";
        }else{
            document.getElementById("terlambat").className = "text-muted small";
        }
        if(tepat > '0'){
            document.getElementById("tepat").className = "text-success";
        }else{
            document.getElementById("tepat").className = "text-muted small";
        }
        if(tdkhadir > 0){
            document.getElementById("tdkhadir").className = "text-success";
        }else{
            document.getElementById("tdkhadir").className = "text-muted small";
        }
        if(aijin > '0'){
            document.getElementById("cuti").className = "text-success";
        }else{
            document.getElementById("cuti").className = "text-muted small";
        }
        if(sakit > '0'){
            document.getElementById("sakit").className = "text-success";
        }else{
            document.getElementById("sakit").className = "text-muted small";
        }
        if(darijin > '0'){
            document.getElementById("darurat").className = "text-success";
        }else{
            document.getElementById("darurat").className = "text-muted small";
        }
        if(alpha > '0'){
            document.getElementById("alpha").className = "text-success";
        }else{
            document.getElementById("alpha").className = "text-muted small";
        }
        let month = bulan;
        const monthsArray = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];
        $(document).ready(function () {
            Morris.Bar({
                element: 'absensi',
                data: [
                        {
                            y: monthsArray[month - 1],
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
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;

        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status+":"+bulan+":"+tahun,
            retrieve : true
        });
        tb_absen.destroy();
        tb_absen = $('#tb_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_absen/"+status+":"+bulan+":"+tahun,
            retrieve : true
        });
    }

    function detilabsen(idkaryawan, bulan, tahun, status){
        $('#modal_detabsen').modal('show');

        tb_detil_absen = $('#tb_detil_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_detil_absen/"+idkaryawan+":"+bulan+":"+tahun+":"+status,
            retrieve : true
        });
        tb_detil_absen.destroy();
        tb_detil_absen = $('#tb_detil_absen').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_detil_absen/"+idkaryawan+":"+bulan+":"+tahun+":"+status,
            retrieve : true
        });
    }

    function ijin(status){
        $('#modal_ijin').modal('show');
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;

        tb_ijin = $('#tb_ijin').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_ijin/"+status+":"+bulan+":"+tahun,
            retrieve : true
        });
        tb_ijin.destroy();
        tb_ijin = $('#tb_ijin').DataTable({
            ajax: "<?php echo base_url(); ?>home/ajaxlist_ijin/"+status+":"+bulan+":"+tahun,
            retrieve : true
        });
    }

    tinymce.init({
        selector: "textarea#verif", theme: "modern", height: 250,
    });

    function verif(id,idkaryawan,bulan,thn,filter) {
        $('#info3').hide();
        $('#form3')[0].reset();
        $('#modal_form3').modal('show');
        $('.modal-title3').text('Verifikasi Manual Absensi');
        $('[name="idkaryawan"]').val(idkaryawan);
        $('[name="bulan"]').val(bulan);
        $('[name="thn"]').val(thn);
        $('[name="filter"]').val(filter);
        $.ajax({
            url: "<?php echo base_url(); ?>absence/karyawan/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idabsensi);
                $('[name="karyawan"]').val(data.nama);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="scanmasuk"]').val(data.scanmasuk);
                $('[name="scankeluar"]').val(data.scankeluar);
                $('[name="status"]').val(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function saveverif() {
        var verif = tinyMCE.get('verif').getContent();
        var scanmasuk = document.getElementById('scanmasuk').value;
        var scankeluar = document.getElementById('scankeluar').value;
        var status = document.getElementById('status').value;
        var kode = document.getElementById('kode').value;
        var idkaryawan = document.getElementById('idkaryawan').value;
        var bulan = document.getElementById('bulan').value;
        var thn = document.getElementById('thn').value;
        var filter = document.getElementById('filter').value;

        var url = "";
        url = "<?php echo base_url(); ?>absence/saveverifab";
        
        var form_data = new FormData();
        form_data.append('verif', verif);
        form_data.append('scanmasuk', scanmasuk);
        form_data.append('scankeluar', scankeluar);
        form_data.append('status', status);
        form_data.append('kode', kode);
        form_data.append('idkaryawan', idkaryawan);
        form_data.append('bulan', bulan);
        form_data.append('thn', thn);
        form_data.append('filter', filter);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                $('#info3').show();
                if(data.status == "update"){
                    alert('Berhasil menyimpan data!');
                    $('#modal_form3').modal('hide');
                }

                tb_detil_absen = $('#tb_detil_absen').DataTable({
                    ajax: "<?php echo base_url(); ?>home/ajaxlist_detil_absen/"+data.idkaryawan+":"+data.bulan+":"+data.thn+":"+data.filter,
                    retrieve : true
                });
                tb_detil_absen.destroy();
                tb_detil_absen = $('#tb_detil_absen').DataTable({
                    ajax: "<?php echo base_url(); ?>home/ajaxlist_detil_absen/"+data.idkaryawan+":"+data.bulan+":"+data.thn+":"+data.filter,
                    retrieve : true
                });

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }
        });
    }

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus catatan verifikasi manual atas " + nama + " ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>absence/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Catatan Verifikasi Manual berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function closemodal3(){
        $('#modal_form3').modal('hide');
    }
    
</script>