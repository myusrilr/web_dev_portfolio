<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>linkbidang/ajaxlist"
        });
        
        $('#kat').hide();
        $('#info').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#kat').hide();$('#info').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Link Dokumen');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var share = document.getElementById('share');
        var jenis = document.getElementById('jenis').value;
        var link = document.getElementById('link').value;
        
        if (share.checked === true){
            var n = 1;
        }else{
            var n = 0;
        }

        var tot = 0;
        if (judul === '') {
            document.getElementById('judul').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('judul').classList.remove('is-invalid'); tot += 1;} 
        if(link === ''){
            document.getElementById('link').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;}
        
        if(tot === 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>linkbidang/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>linkbidang/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('link', link);
            form_data.append('idkatbid', jenis);
            form_data.append('share', n);
            
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
                        $('#info').show();
                        $('#info').text('Berhasil menyimpan data!');
                        $('[name="judul"]').val("");
                        $('[name="link"]').val("");
                    }else{
                        $('#info').show();
                        $('#info').text('Berhasil memperbarui data!');
                        window.setTimeout(function () {
                            $('#modal_form').modal('hide');
                        }, 1000);
                    }
                    reload();

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
                        url: "<?php echo base_url(); ?>linkbidang/hapus/" + id,
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

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Link Dokumen');
        $.ajax({
            url: "<?php echo base_url(); ?>linkbidang/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idformbid);
                $('[name="jenis"]').val(data.idkatbid);
                $('[name="judul"]').val(data.namaformbid);
                $('[name="link"]').val(data.link);
                if(data.share === '1'){
                    document.getElementById("share").checked = true;
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Daftar Link Dokumen</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Daftar Link Dokumen</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Kategori</th>
                                    <th width="45%">Dokumen</th>
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
                            <label class="form-label">Kategori (Opsional)</label>
                            <select class="custom-select" id="jenis" name="jenis">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <?php
                                foreach($bidangkat->getResult() as $row) {?>
                                <option value="<?php echo $row->idkatbid; ?>"><?php echo $row->namakatbid; ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Judul Dokumen</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul Dokumen" >
                            <small class="invalid-feedback">Judul wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link Dokumen</label>
                            <input type="text" id="link" name="link" class="form-control" placeholder="Masukkan link dokumen">
                            <small class="invalid-feedback">Link dokumen wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" id="share" name="share">
                            <span class="form-check-label">Share link ini untuk semua karyawan</span>
                        </label>
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