<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>perijinantugas/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add(id,link) {
        $('#info').hide();
        $('#form')[0].reset();
        $('#kode').val(id);
        save_method = 'add';
        $('#modal_form').modal('show');
        $('.modal-title').text('Persetujuan Surat Tugas');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var status = document.getElementById('status').value;
        var note = document.getElementById('note').value;
        var nomor = document.getElementById('nomor').value;
        var link = document.getElementById('link').value;
        var linklaporan = document.getElementById('linklaporan').value;
        
        var tot = 0;
        if (status === '') {
            document.getElementById('status').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('status').classList.remove('is-invalid'); tot += 1;} 
        if(link === ''){
            document.getElementById('link').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;}
        if(linklaporan === ''){
            document.getElementById('linklaporan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('linklaporan').classList.remove('is-invalid'); tot += 1;}
        if(nomor === ''){
            document.getElementById('nomor').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('nomor').classList.remove('is-invalid'); tot += 1;}
        
        if(tot === 4){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>perijinantugas/submitnote";
            } else {
                url = "<?php echo base_url(); ?>perijinantugas/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('idsurat', kode);
            form_data.append('status', status);
            form_data.append('note', note);
            form_data.append('nomor', nomor);
            form_data.append('link', link);
            form_data.append('linklaporan', linklaporan);
            
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
                    if(data.status == "simpan"){
                        $alert = swal("Berhasil!", "Datamu berhasil dikirim.", "success");
                        setTimeout($alert, 5000);
                        if(data.wa == "yes"){
                            window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                        }
                        $('#modal_form').modal('hide');
                        reload();
                    }

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Edit Persetujuan Surat Tugas');
        $.ajax({
            url: "<?php echo base_url(); ?>perijinantugas/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsurat);
                $('[name="status"]').val(data.status);
                $('[name="nomor"]').val(data.nosurat);
                $('[name="note"]').val(data.catatan);
                $('[name="link"]').val(data.link);
                $('[name="linklaporan"]').val(data.linklaporan);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>perijinantugas/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Perijinan Surat Tugas</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Perijinan Surat Tugas</li>
        </ol>
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
                                    <th>Tgl Diajukan</th>
                                    <th>Acara</th>
                                    <th>Staff Bertugas</th>
                                    <th>Tanggal dan Waktu</th>
                                    <th>Status</th>
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
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                                <option value="Laporan sudah Diisi">Laporan sudah Diisi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Surat Tugas</label>
                        <input type="text" class="form-control" id="nomor" name="nomor">
                        <small class="invalid-feedback">Nomor Surat Tugas wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Surat</label>
                        <input type="text" class="form-control" id="link" name="link">
                        <small class="invalid-feedback">Link Surat wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Laporan Kegiatan</label>
                        <input type="text" class="form-control" id="linklaporan" name="linklaporan">
                        <small class="invalid-feedback">Link Laporan wajib diisi</small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" name="note" id="note" row="5"></textarea>
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