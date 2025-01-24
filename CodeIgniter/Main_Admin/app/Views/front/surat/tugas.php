<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Pengajuan Surat Tugas<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <!-- Multiple -->
                                <div class="form-group">
                                    <label class="form-label">Staff Bertugas</label>
                                    <select class="select2-demo form-control" multiple style="width: 100%" name="staff[]">
                                        <?php foreach($users->getResult() as $row){ ?>
                                        <option value="<?php echo $row->idusers; ?>" <?php if($row->idusers == $idusers){ echo 'selected'; }?>><?php echo $row->nama; ?></option>
                                        <?php } ?>
                                    </select>
                                    <small class="invalid-feedback" id="errorstaff">Staff Bertugas wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Acara</label>
                                    <textarea class="form-control" rows="3" id="acara" name="acara" placeholder="Masukkan Acara disini"></textarea>
                                    <small class="invalid-feedback" id="erroracara">Acara wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Undangan Dari</label>
                                    <input type="text" class="form-control" id="undangan" name="undangan" placeholder="Masukkan Undangan Dari disini">
                                    <small class="invalid-feedback">Undangan dari wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal & Waktu</label>
                                    <textarea class="form-control" id="tgl" name="tgl"></textarea>
                                    <small class="invalid-feedback" id="errortgl">Tanggal & Waktu wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kegiatan secara</label>
                                    <select class="custom-select" id="jenis" name="jenis">
                                        <option value="" disabled selected>Pilih Jenis Kegiatan</option>
                                        <option value="Offline">Offline (Ditempat)</option>
                                        <option value="Online">Online</option>
                                    </select>
                                    <small class="invalid-feedback" id="errorjenis">Jenis Kegiatan wajib dipilih</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi disini">
                                    <small class="invalid-feedback">Lokasi wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Surat Tugas</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Acara</th>
                                    <th>Staff Bertugas</th>
                                    <th>Tanggal dan Waktu</th>
                                    <th>Aksi</th>
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
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">No Surat Tugas</label>
                            <input type="text" id="nosurat" name="nosurat" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link Laporan Kegiatan : </label> <a href="" target="_blank" id="link" name="link">Klik disini</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan</label>
                            <textarea id="notelaporan" name="notelaporan" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave2" type="button" class="btn btn-success" onclick="simpan();">SELESAI</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sosial">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title2">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form2">
                    <input type="hidden" id="kodes" name="kodes">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Keterangan</label>
                            <select class="custom-select" id="sos" name="sos">
                                <option value="" disabled selected>Pilih Keterangan</option>
                                <option value="Disosialisasikan">Disosialisasikan</option>
                                <option value="Tidak Disosialisasikan">Tidak Disosialisasikan</option>
                            </select>
                            <small class="invalid-feedback" id="errorsos">Keterangan wajib dipilih</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalsos();">Tutup</button>
                <button id="btnSave3" type="button" class="btn btn-primary" onclick="simpansos();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_batal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-titleb">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="formb">
                    <input type="hidden" id="kode2" name="kode2">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Alasan Pembatalan</label>
                            <textarea id="alasan" name="alasan" class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave3" type="button" class="btn btn-danger" onclick="simpanbatal();">Ya, Batalkan</button>
                <button type="button" class="btn btn-default" onclick="closemodalcancel();">Tutup</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">

var save_method, save_method2; //for save method string
var table;

tinymce.init({
    selector: "textarea#tgl", theme: "modern", height: 100,
});

function closemodal(){
    $('#modal_form').modal('hide');
}

function closemodalsos(){
    $('#modal_sosial').modal('hide');
}

function closemodalcancel(){
    $('#modal_batal').modal('hide');
}

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>surattugas/ajaxlist"
    });

});

// Select2
$(function() {
  $('.select2-demo').select2();
});

function save(){
    var kode = document.getElementById('kode').value;
    var acara = document.getElementById('acara').value;
    var undangan = document.getElementById('undangan').value;
    var tgl = tinyMCE.get('tgl').getContent(); 
    var lokasi = document.getElementById('lokasi').value;
    var jenis = document.getElementById('jenis').value;
    var staff = $('.select2-demo').val();
    var coba =  $('.select2-demo').find('option:selected').length;

    var tot = 0;
    if (undangan === '') {
        document.getElementById('undangan').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('undangan').classList.remove('is-invalid'); tot += 1;} 
    if(tgl === ''){
        document.getElementById('tgl').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('tgl').classList.remove('is-invalid'); tot += 1;}
    if(tgl === ''){
        $('#errortgl').show();
    }else{$('#errortgl').hide(); tot += 1;}
    if(jenis === ''){
        $('#errorjenis').show();
    }else{$('#errorjenis').hide(); tot += 1;}
    if(acara === ''){
        $('#erroracara').show();
    }else{$('#erroracara').hide(); tot += 1;}
    if(coba === 0){
        $('#errorstaff').show();
    }else{$('#errorstaff').hide(); tot += 1;}

    if(tot === 6){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if(save_method === 'update'){
            url = "<?php echo base_url(); ?>surattugas/ajax_edit";
        }else{
            url = "<?php echo base_url(); ?>surattugas/ajax_add";
        }
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('acara', acara);
        form_data.append('undangan', undangan);
        form_data.append('tgl', tgl);
        form_data.append('lokasi', lokasi);
        form_data.append('jenis', jenis);
        form_data.append('staff', staff);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function (data) {
                $alert = swal("Berhasil!", "Datamu berhasil dikirim.", "success");
                setTimeout($alert, 5000);
                window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                reload();

                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
}

function simpan(){
    var kode = document.getElementById('kode').value;
    var notelaporan = document.getElementById('notelaporan').value;

    var tot = 0;  
    if (notelaporan === '') {
        document.getElementById('notelaporan').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('notelaporan').classList.remove('is-invalid'); tot += 1;} 

    if(tot === 1){
        $('#btnSave2').text('Mengirim...'); //change button text
        $('#btnSave2').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>surattugas/laporan";
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('notelaporan', notelaporan);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function (data) {
                $alert = swal("Berhasil!", data.status, "success");
                setTimeout($alert, 5000);
                location.reload();

                $('#btnSave2').text('Kirim'); //change button text
                $('#btnSave2').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave2').text('Kirim'); //change button text
                $('#btnSave2').attr('disabled', false); //set button enable 
            }
        });
    }
}

function simpansos(){
    var kodes = document.getElementById('kodes').value;
    var sos = document.getElementById('sos').value;

    var tot = 0;  
    if (sos === '') {
        document.getElementById('sos').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('sos').classList.remove('is-invalid'); tot += 1;} 

    if(tot === 1){
        $('#btnSave3').text('Menyimpan...'); //change button text
        $('#btnSave3').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>surattugas/ketsos";
        
        var form_data = new FormData();
        form_data.append('kode', kodes);
        form_data.append('sos', sos);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function (data) {
                $alert = swal("Berhasil!", data.status, "success");
                setTimeout($alert, 5000);
                location.reload();

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave3').text('Simpan'); //change button text
                $('#btnSave3').attr('disabled', false); //set button enable 
            }
        });
    }
}

function add(id) {
    $('#info').hide();
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Laporan Kegiatan');
    $.ajax({
        url: "<?php echo base_url(); ?>surattugas/gantimodal/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode"]').val(data.idsurat);
            $('[name="nosurat"]').val(data.nosurat);
            var a = document.getElementById('link'); //or grab it by tagname etc
            a.href = data.linklaporan;
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function updateket(id) {
    $('#info').hide();
    save_method2 = 'add';
    $('#form2')[0].reset();
    $('#modal_sosial').modal('show');
    $('.modal-title2').text('Laporan Kegiatan');
    $.ajax({
        url: "<?php echo base_url(); ?>surattugas/gantiket/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kodes"]').val(data.idsurat);
            $('[name="sos"]').val(data.ket);
            var a = document.getElementById('link'); //or grab it by tagname etc
            a.href = data.linklaporan;
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function ganti(id) {
    $('#info').hide();
    save_method = 'update'; 
    $.ajax({
        url: "<?php echo base_url(); ?>surattugas/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            document.getElementById("accordion2-1").className = "collapse show";
            $('[name="kode"]').val(data.idsurat);
            $('.select2-demo').val(data.users).change();
            document.getElementById("acara").focus();
            tinyMCE.get('tgl').setContent(data.waktu);
            $('[name="acara"]').val(data.acara);
            $('[name="undangan"]').val(data.undangan);
            $('[name="lokasi"]').val(data.lokasi);
            $('[name="jenis"]').val(data.jenis);
            $('#btnSave').text('Perbarui');
            document.getElementById("btnSave").className = "btn btn-warning btn-block mt-4";
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}

function hapus(id, nama) {
    swal({
        title: "Datamu akan terhapus!",
        text:  "Apakah anda yakin? Membatalkan pengajuan " + nama + " ini? ",
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
                    url: "<?php echo base_url(); ?>surattugas/hapus/" + id,
                    type: "POST",
                    dataType: "JSON",
                    error: function() {
                        alert('Error');
                    },
                    success: function(data) {
                        reload();
                        swal("Berhasil!", "Datamu berhasil dibatalkan.", "success");
                    }
                });
            }else {
                swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
            }
    });
}

function cancel(id) {
    $('#info2').hide();
    save_method = 'add';
    $('#formb')[0].reset();
    $('#modal_batal').modal('show');
    $('.modal-titleb').text('Batalkan Surat Tugas?');
    $.ajax({
        url: "<?php echo base_url(); ?>surattugas/gantimodal/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode2"]').val(data.idsurat);
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}
</script>