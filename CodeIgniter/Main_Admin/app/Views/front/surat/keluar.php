<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Pengajuan Surat Keluar<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse show" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Keterangan Surat</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan Surat disini">
                                    <small class="invalid-feedback">Keterangan Surat Keluar wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Surat Keluar (Link Gdocs / Gdrive)</label>
                                    <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan Link Surat Keluar disini">
                                    <small class="invalid-feedback">Link Surat Keluar wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Surat Keluar</h4>
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
                                    <th width="15%">Tanggal Pengajuan</th>
                                    <th>Keterangan Surat Keluar</th>
                                    <th>Link Surat</th>
                                    <th style="text-align: center;" width="5%">Status</th>
                                    <th style="text-align: center;" width="5%">Aksi</th>
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
    
<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>suratkeluar/ajaxlist"
    });

});

function save(){
    var kode = document.getElementById('kode').value;
    var keterangan = document.getElementById('keterangan').value;
    var link = document.getElementById('link').value;

    var tot = 0;
    if (keterangan === '') {
        document.getElementById('keterangan').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('keterangan').classList.remove('is-invalid'); tot += 1;} 
    if (link === '') {
        document.getElementById('link').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;} 

    if(tot === 2){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'update') {
            url = "<?php echo base_url(); ?>suratkeluar/ajax_edit";
        }else {
            url = "<?php echo base_url(); ?>suratkeluar/ajax_add";
        }
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('keterangan', keterangan);
        form_data.append('link', link);
        
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
                window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                location.reload();

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

function ganti(id) {
    $('#info').hide();
    save_method = 'update';
    $.ajax({
        url: "<?php echo base_url(); ?>suratkeluar/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode"]').val(data.idsurat);
            $('[name="keterangan"]').val(data.keterangan);
            document.getElementById("keterangan").focus();
            $('[name="link"]').val(data.link);
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
            title: "Apakah anda yakin?",
            text:  "Membatalkan pengajuan " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>suratkeluar/hapus/" + id,
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
</script>