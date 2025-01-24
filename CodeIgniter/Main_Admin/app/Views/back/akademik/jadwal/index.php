<script type="text/javascript">

    var save_method = "";
    var table, tb_pengajar, tb_zoom, tb_level;
    var tb_archive;
    var tb_list_nomor;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxlist",
            ordering:false
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Jadwal');
    }

    function getHari(){
        var hari = "";
        if(document.getElementById('ckSenin').checked){
            hari += "Senin,";
        }
        if(document.getElementById('ckSelasa').checked){
            hari += "Selasa,";
        }
        if(document.getElementById('ckRabu').checked){
            hari += "Rabu,";
        }
        if(document.getElementById('ckKamis').checked){
            hari += "Kamis,";
        }
        if(document.getElementById('ckJumat').checked){
            hari += "Jumat,";
        }
        if(document.getElementById('ckSabtu').checked){
            hari += "Sabtu,";
        }
        
        return hari.substring(0, hari.length -1);
    }
    
    function save() {
        var kode = document.getElementById('kode').value;
        var g_wa = document.getElementById('g_wa').value;
        var kursus = document.getElementById('kursus').value;
        var sesi = document.getElementById('sesi').value;
        var periode = document.getElementById('periode').value;
        var hari = getHari();
        var idlevel = document.getElementById('idlevel').value;
        var level = document.getElementById('level').value;
        var idzoom = document.getElementById('idzoom').value;
        var zoom = document.getElementById('zoom').value;
        var mode_belajar = document.getElementById('mode_belajar').value;
        var tempat = document.getElementById('tempat').value;

        var abai = "Tidak";
        if(document.getElementById('ckAbai').checked){
            abai = "Ya";
        }

        var tot = 0;
        if (g_wa === '') {
            document.getElementById('g_wa').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('g_wa').classList.remove('is-invalid');
            tot += 1;
        }

        if (kursus === '-') {
            document.getElementById('kursus').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('kursus').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (sesi === '-') {
            document.getElementById('sesi').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('sesi').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (periode === '-') {
            document.getElementById('periode').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('periode').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (hari === '') {
            document.getElementById('hari').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('hari').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (level === '') {
            document.getElementById('level').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('level').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (zoom === '') {
            document.getElementById('zoom').classList.add('form-control', 'is-invalid');
        } else {
            document.getElementById('zoom').classList.remove('is-invalid');
            tot += 1;
        }
        
        if (tot === 7) {
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>jadwal/ajax_add_jadwal";
            } else {
                url = "<?php echo base_url(); ?>jadwal/ajax_edit_jadwal";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('g_wa', g_wa);
            form_data.append('idsesi', sesi);
            form_data.append('periode', periode);
            form_data.append('kursus', kursus);
            form_data.append('hari', hari);
            form_data.append('idlevel', idlevel);
            form_data.append('zoom', zoom);
            form_data.append('idzoom', idzoom);
            form_data.append('mode_belajar', mode_belajar);
            form_data.append('tempat', tempat);
            form_data.append('mode_pindah', 'tidak');
            form_data.append('abai', abai);

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    $('#modal_form').modal('hide');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);

                    reload();

                }, error: function (jqXHR, textStatus, errorThrown) {
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

    function reset() {
        document.getElementById('kode').value = "";
        document.getElementById('g_wa').value = "";
        document.getElementById('kursus').value = "";
        document.getElementById('sesi').value = "";
        document.getElementById('periode').value = "";
        document.getElementById('hari').value = "";
        document.getElementById('idlevel').value = "";
        document.getElementById('level').value = "";
        document.getElementById('idzoom').value = "";
        document.getElementById('zoom').value = "";
    }

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text: "menghapus group " + nama + " ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "<?php echo base_url(); ?>jadwal/hapusjadwal/" + id,
                    type: "POST",
                    dataType: "JSON",
                    error: function (data) {
                        swal("Gagal!", data.status, "error");
                    },
                    success: function (data) {
                        reload();
                        swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                    }
                });
            } else {
                swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
            }
        });
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Jadwal');
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/showjadwal/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                document.getElementById('kode').value = data.idjadwal;
                document.getElementById('g_wa').value = data.groupwa;
                document.getElementById('kursus').value = data.kursus;
                document.getElementById('sesi').value = data.id_sesi;
                document.getElementById('idlevel').value = data.id_level;
                document.getElementById('level').value = data.level;
                document.getElementById('idzoom').value = data.idzoom;
                document.getElementById('zoom').value = data.link;
                document.getElementById('tempat').value = data.tempat;
                document.getElementById('mode_belajar').value = data.mode_belajar;
                
                // menampilkan data hari
                var strHari = data.hari;
                var dataHari = strHari.split(",");
                for(var i=0; i<dataHari.length ; i++){
                    var temp = dataHari[i].toLowerCase();
                    if(temp === "senin"){
                        document.getElementById('ckSenin').checked = true;
                    }
                    if(temp === "selasa"){
                        document.getElementById('ckSelasa').checked = true;
                    }
                    if(temp === "rabu"){
                        document.getElementById('ckRabu').checked = true;
                    }
                    if(temp === "kamis"){
                        document.getElementById('ckKamis').checked = true;
                    }
                    if(temp === "jumat"){
                        document.getElementById('ckJumat').checked = true;
                    }
                    if(temp === "sabtu"){
                        document.getElementById('ckSabtu').checked = true;
                    }
                    
                }
                
                // menampilkan data periode
                $.ajax({
                    url: "<?php echo base_url(); ?>jadwal/showperiode_edit/" + data.kursus + "/" + data.periode,
                    type: "POST",
                    dataType: "JSON",
                    success: function (data) {
                        $('#periode').html(data.status);
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        iziToast.error({
                            title: 'Error',
                            message: "Error get data " + errorThrown,
                            position: 'topRight'
                        });
                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function showpengajar(){
        $('#modal_pengajar').modal('show');
        tb_pengajar = $('#tb_pengajar').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxpengajar",
            retrieve : true
        });
        tb_pengajar.destroy();
        tb_pengajar = $('#tb_pengajar').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxpengajar",
            retrieve : true
        });
    }

    function pilihguru(id, nama){
        $('[name="idpengajar"]').val(id);
        $('[name="pengajar"]').val(nama);
        $('#modal_pengajar').modal('hide');
    }
    
    function pilihperiode(){
        var kursus = document.getElementById('kursus').value;
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/showperiode/" + kursus,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#periode').html(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function showzoom(){
        $('#modal_zoom').modal('show');
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
        tb_zoom.destroy();
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
    }
    
    function pilihzoom(id, link){
        $('[name="idzoom"]').val(id);
        $('[name="zoom"]').val(link);
        $('#modal_zoom').modal('hide');
    }
    
    function showlevel(){
        var kursus = document.getElementById('kursus').value;
        if(kursus === "-"){
            swal("Pilih kursus terlebih dahulu", "info");
        }else{
            $('#modal_level').modal('show');
            tb_level = $('#tb_level').DataTable({
                ajax: "<?php echo base_url(); ?>jadwal/ajaxlevel/" + kursus,
                retrieve : true
            });
            tb_level.destroy();
            tb_level = $('#tb_level').DataTable({
                ajax: "<?php echo base_url(); ?>jadwal/ajaxlevel/" + kursus,
                retrieve : true
            });
        }
    }
    
    function pilihlevel(idlevel, level){
        $('[name="idlevel"]').val(idlevel);
        $('[name="level"]').val(level);
        $('#modal_level').modal('hide');
    }
    
    function ploting(idjadwal){
        window.location.href = "<?php echo base_url(); ?>jadwal/ploting/" + idjadwal;
    }

    function wa(idjadwal){
        $('#modal_wa').modal('show');
        $('#idjadwal_kirim').val(idjadwal);
        tb_list_nomor = $('#tb_list_nomor').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_list_nomor/" + idjadwal,
            retrieve : true
        });
        tb_list_nomor.destroy();
        tb_list_nomor = $('#tb_list_nomor').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_list_nomor/" + idjadwal,
            retrieve : true
        });

        // menampilkan data untuk format pengiriman
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/displayformatjadwal/" + idjadwal,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#displayFormatJadwal').html(data.displayFormatJadwal);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });

    }

    var dataJSON;
    var index = 0;
    var max_length;
    var jml_bagian = 0;
    var prosentase = 0;

    function kirimwa(){
        var idjadwal_kirim = document.getElementById('idjadwal_kirim').value;
        var displayFormatJadwal = document.getElementById('displayFormatJadwal').value;

        if(idjadwal_kirim === ""){
            iziToast.info({
                title: 'Info',
                message: "Pilih jadwal terlebih dahulu",
                position: 'topRight'
            });
        }else{
            $('#btnKirimWA').html('<i class="ion ion-logo-whatsapp"></i> Loading...');
            $('#btnKirimWA').attr('disabled', true);

            $.ajax({
                url: "<?php echo base_url(); ?>jadwal/getlistnomor/" + idjadwal_kirim,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    if(data.jml < 1){
                        
                        $('#btnKirimWA').html('<i class="ion ion-logo-whatsapp"></i> Kirim Jadwal');
                        $('#btnKirimWA').attr('disabled', false);

                        iziToast.error({
                            title: 'Error',
                            message: "Minimal 1 nomor WA",
                            position: 'topRight'
                        });

                    } else{
                        dataJSON = JSON.parse(data.result);
                        max_length = dataJSON.length;

                        var idjadwal_kirim = document.getElementById('idjadwal_kirim').value;
                        var nomor_wa = dataJSON[index].wa;

                        jml_bagian += 1;
                        prosentase = (jml_bagian / max_length) * 100;
                        $(".progress-bar").css("width", prosentase + "%").text(prosentase + "%");

                        // kirim pertama
                        proseskirimwa(idjadwal_kirim, nomor_wa, displayFormatJadwal);
                    }

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }
    }

    function proseskirimwa(idjadwal_kirim, nomor_wa, displayFormatJadwal){
        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal_kirim);
        form_data.append('nowa', nomor_wa);
        form_data.append('displayFormatJadwal', displayFormatJadwal);
        
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/kirimpesan",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                console.log(data.message);

                if(index != (max_length - 1)){
                    
                    // kirim terus
                    index += 1;
                    var idjadwal_kirim = document.getElementById('idjadwal_kirim').value;
                    nomor_wa = dataJSON[index].wa;
                    proseskirimwa(idjadwal_kirim, nomor_wa, displayFormatJadwal);
                    
                    jml_bagian += 1;
                    prosentase = (jml_bagian / max_length) * 100;
                    $(".progress-bar").css("width", prosentase + "%").text(prosentase + "%");

                }else if(index == (max_length - 1)){
                    // reset index
                    index = 0;
                    $('#btnKirimWA').html('<i class="ion ion-logo-whatsapp"></i> Kirim Jadwal');
                    $('#btnKirimWA').attr('disabled', false);

                    $(".progress-bar").css("width", 0 + "%").text(0 + "%");
                }
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function uplevel(kode){
        window.location.href = "<?php echo base_url(); ?>jadwal/uplevel/" + kode;
    }

    function show_archive(){
        $('#modal_archive').modal('show');
        
        tb_archive = $('#tb_archive').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxlist_unacrhive",
            retrieve : true
        });
        tb_archive.destroy();
        tb_archive = $('#tb_archive').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxlist_unacrhive",
            retrieve : true
        });
    }

    function unarchive(idjadwal){
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/unarchive/" + idjadwal,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                reload();
                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });
                if(data.status === "Unarchive berhasil"){
                    $('#modal_archive').modal('hide');
                }

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function archivekan(id, nama){
        swal({
            title: "Konfirmasi",
            text:  "apakah anda yakin meng-archive jadwal " + nama + " ini ?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Archive",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jadwal/archivekan/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Jadwal berhasil diarchive.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function catatansiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporanpengajaran/catatansiswa/" + kode;
    }

    function raporsiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporanpengajaran/raporsiswa/" + kode;
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jadwal Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Jadwal Kursus</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Jadwal</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="show_archive();">Jadwal Ter-Archive</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kelas</th>
                                    <th>Kursus<br>Tahun Ajaran</th>
                                    <th>Hari<br>Sesi</th>
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
</div>

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Rombel</label>
                            <input type="text" id="g_wa" name="g_wa" class="form-control" placeholder="Rombel" autocomplete="off">
                            <small class="invalid-feedback">Rombel wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Zoom</label>
                            <div class="input-group">
                                <input type="hidden" id="idzoom" name="idzoom" readonly autocomplete="off">
                                <input type="text" id="zoom" name="zoom" class="form-control" placeholder="Zoom Meeting" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="showzoom();">...</button>
                                </span>
                                <small class="invalid-feedback">Link Zoom wajib diisi</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Model Belajar</label>
                            <select id="mode_belajar" name="mode_belajar" class="form-control">
                                <option value="Offline">Offline</option>
                                <option value="Online">Online</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tempat Belajar</label>
                            <input type="text" id="tempat" name="tempat" class="form-control" placeholder="Tempat Belajar" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label"><input id="ckAbai" name="ckAbai" type="checkbox">&nbsp;&nbsp;Abaikan Isian dibawah</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <hr style="color:black;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Sesi</label>
                            <select id="sesi" name="sesi" class="form-control">
                                <option value="-">- Pilih -</option>
                                <?php
                                foreach ($sesi->getResult() as $row) {
                                    ?>
                                <option value="<?php echo $row->idsesi; ?>"><?php echo $row->nama_sesi.' ('.$row->waktu_awal.' - '.$row->waktu_akhir.')'; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <small class="invalid-feedback">Pilih sesi terlebih dahulu</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Kursus</label>
                            <select id="kursus" name="kursus" class="form-control" onchange="pilihperiode();">
                                <option value="-">- Pilih -</option>
                                <?php
                                foreach ($kursus->getResult() as $row) {
                                    ?>
                                <option value="<?php echo $row->idpendkursus; ?>"><?php echo $row->nama_kursus; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <small class="invalid-feedback">Pilih jenis kursus</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Periode</label>
                            <select id="periode" name="periode" class="form-control">
                                <option value="-">- Pilih -</option>
                            </select>
                            <small class="invalid-feedback">Pilih periode kursus</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Level</label>
                            <div class="input-group">
                                <input type="hidden" id="idlevel" name="idlevel" readonly autocomplete="off">
                                <input type="text" id="level" name="level" class="form-control" placeholder="Level" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="showlevel();">...</button>
                                </span>
                                <small class="invalid-feedback">Level wajib diisi</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Hari</label>
                            <div id="hari">
                                <label class="form-check form-check-inline">
                                    <input id="ckSenin" class="form-check-input" type="checkbox" value="Senin">
                                    <span class="form-check-label">Senin</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckSelasa" class="form-check-input" type="checkbox" value="Selasa">
                                    <span class="form-check-label">Selasa</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckRabu" class="form-check-input" type="checkbox" value="Rabu">
                                    <span class="form-check-label">Rabu</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckKamis" class="form-check-input" type="checkbox" value="Kamis">
                                    <span class="form-check-label">Kamis</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckJumat" class="form-check-input" type="checkbox" value="Jumat">
                                    <span class="form-check-label">Jumat</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckSabtu" class="form-check-input" type="checkbox" value="Sabtu">
                                    <span class="form-check-label">Sabtu</span>
                                </label>
                            </div>
                            <small class="invalid-feedback">Pilih hari</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pengajar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Pengajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_pengajar" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Foto</th>
                                <th>Jam Kerja</th>
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

<div class="modal fade" id="modal_zoom">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Zoom</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_zoom" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Meeting ID</th>
                                <th>Passcode</th>
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

<div class="modal fade" id="modal_level">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_level" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Level</th>
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

<div class="modal fade" id="modal_wa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data List WA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idjadwal_kirim" readonly>
                <button id="btnKirimWA" type="button" class="btn btn-success btn-sm" onclick="kirimwa();"><i class="ion ion-logo-whatsapp"></i> Kirim Jadwal</button>
                <hr>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" style="min-width: 0px;"></div>
                </div>
                <textarea id="displayFormatJadwal" name="displayFormatJadwal" class="form-control" rows="10"></textarea>
                <div class="card-datatable table-responsive">
                    <table id="tb_list_nomor" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor</th>
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

<div class="modal fade" id="modal_archive">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Jadwal Archive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_archive" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelas</th>
                                <th>Kursus<br>Tahun Ajaran</th>
                                <th>Hari<br>Sesi</th>
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