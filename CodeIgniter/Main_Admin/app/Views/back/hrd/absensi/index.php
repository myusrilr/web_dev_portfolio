<script type="text/javascript">

    var save_method; //for save method string
    var table, table2;
    
    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 250,
    });

    tinymce.init({
        selector: "textarea#verif", theme: "modern", height: 250,
    });

    tinymce.init({
        selector: "textarea#verif2", theme: "modern", height: 250,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>absence/ajaxlist"
        });

        table2 = $('#tb2').DataTable({
            ajax: "<?php echo base_url(); ?>absence/ajaxlistnote"
        });

        $('#info').hide();
        $('#info3').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function reload2() {
        table2.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Import Excel');
    }

    function note() {
        $('#info2').hide();
        $('#form2')[0].reset();
        $('#modal_form2').modal('show');
        $('.modal-title2').text('Analisa Absensi Karyawan');
    }

    function save() {
        var file = $('#file').prop('files')[0];

        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var form_data = new FormData();
        form_data.append('file', file);
        
        $.ajax({
            url: "<?php echo base_url(); ?>absence/ajax_upload",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                alert(response.status);
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                $('#modal_form').modal('hide');
                reload();
                
            }, error: function (response) {
                alert(response.status);
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
                reload();
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function save2() {
        var tgl = document.getElementById('tgl').value;
        var note = tinyMCE.get('note').getContent();
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>absence/submitnote";
        
        var form_data = new FormData();
        form_data.append('note', note);
        form_data.append('tgl', tgl);
        
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
                $('#info2').show();
                if(data.status == "simpan"){
                    $('#info2').text('Berhasil menyimpan data!');
                    $('[name="note"]').val("");
                }
                reload2();

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function closemodal2(){
        $('#modal_form2').modal('hide');
    }

    function verif(id) {
        $('#info3').hide();
        $('#form3')[0].reset();
        $('#modal_form3').modal('show');
        $('.modal-title3').text('Verifikasi Manual Absensi');
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

        var url = "";
        url = "<?php echo base_url(); ?>absence/saveverif";
        
        var form_data = new FormData();
        form_data.append('verif', verif);
        form_data.append('scanmasuk', scanmasuk);
        form_data.append('scankeluar', scankeluar);
        form_data.append('status', status);
        form_data.append('kode', kode);
        
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
                reload();

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }
        });
    }

    function closemodal3(){
        $('#modal_form3').modal('hide');
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

    function selectall() {
        var ele=document.getElementsByName('kodeabsen');  
        for(var i=0; i<ele.length; i++){  
            if(ele[i].type=='checkbox')  
                ele[i].checked=true;  
        }  
    }

    function deselectall() {
        var ele=document.getElementsByName('kodeabsen');  
        for(var i=0; i<ele.length; i++){  
            if(ele[i].type=='checkbox')  
                ele[i].checked=false;  
        }  
    }
    
    function closemodal4(){
        $('#modal_form4').modal('hide');
    }

    function verifbulk() {
        var jml = $('input[name=kodeabsen]:checked').length;
        if(jml < 1){
            alert("Anda belum memilih absensi yang ingin diverifikasi manual!");
        }else{
            $('#info4').hide();
            $('#form4')[0].reset();
            $('#modal_form4').modal('show');
        }
    }

    function saveverifbulk() {
        var verif = tinyMCE.get('verif2').getContent();
        var status = document.getElementById('status2').value;
        
        var kodeabsen=[];
        $("input:checkbox[name=kodeabsen]:checked").each(function(){
            kodeabsen.push($(this).val());
        });

        var url = "";
        url = "<?php echo base_url(); ?>absence/saveverifbulk";
        
        var form_data = new FormData();
        form_data.append('verif', verif);
        form_data.append('status', status);
        form_data.append('kode', kodeabsen);
        
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
                if(data.status == "update"){
                    alert('Berhasil menyimpan data!');
                    $('#modal_form4').modal('hide');
                }
                reload();

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Absensi</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Absensi</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12" id="accordion2">
            <div class="card"> 
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Catatan Analisa Absensi Karyawan<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <?php if($role!='R00004'){?>
                        <button type="button" class="btn btn-info btn-sm" onclick="note();">Catatan</button>
                        <?php } ?>
                        <div class="card-datatable table-responsive">
                            <table id="tb2" class="datatables-demo table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" width="10%">Tanggal</th>
                                        <th style="text-align: center;">Catatan</th>
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
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php if($role!='R00004'){?>
                    <button type="button" class="btn btn-success btn-sm" onclick="add();"><i class="fas fa-file-excel"></i> Import Excel</button>
                    <button type="button" class="btn btn-info btn-sm float-right" onclick="verifbulk();">Verifikasi Manual</button>
                    <?php } ?>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm" onclick="selectall();">Pilih Semua</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="deselectall();">Batalkan pilihan</button>
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Nama Karyawan</th>
                                    <th>Hari</th>
                                    <th>Tanggal</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Scan Masuk</th>
                                    <th>Scan Keluar</th>
                                    <th style="text-align: center;" width="10%">Keterangan</th>
                                    <th style="text-align: center;" width="10%">Aksi</th>
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
                <div class="alert alert-success alert-dismissible fade show" id="info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form">
                    <div class="form-group fill">
                        <label for="excel" class="col-sm-3 control-label">File Absensi</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="file" name="file">
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

<div class="modal fade" id="modal_form2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title2">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="info2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form2">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Periode</label>
                            <input type="date" id="tgl" name="tgl" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <textarea class="form-control" name="note" id="note"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal2();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save2();">Simpan</button>
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

<div class="modal fade" id="modal_form4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Verifikasi Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="info4">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form4">
                    <div class="form-group col">
                        <label class="form-label">Status</label>
                        <select class="custom-select" id="status2" name="status2">
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
                        <textarea class="form-control" name="verif2" id="verif2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal4();">Tutup</button>
                <button id="btnSave4" type="button" class="btn btn-primary" onclick="saveverifbulk();">Simpan</button>
            </div>
        </div>
    </div>
</div>