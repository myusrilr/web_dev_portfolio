<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>zoom/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Link Zoom');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var topic = document.getElementById('topic').value;
        var link = document.getElementById('link').value;
        var meeting_id = document.getElementById('meeting_id').value;
        var passcode = document.getElementById('passcode').value;

        
        if (topic === '') {
            iziToast.error({
                title: 'Error',
                message: "Topik tidak boleh kosong",
                position: 'topRight'
            });
        }else if (link === '') {
            iziToast.error({
                title: 'Error',
                message: "Link zoom tidak boleh kosong",
                position: 'topRight'
            });
        }else if (meeting_id === '') {
            iziToast.error({
                title: 'Error',
                message: "Meeting ID tidak boleh kosong",
                position: 'topRight'
            });
        }else if (passcode === '') {
            iziToast.error({
                title: 'Error',
                message: "Passcode tidak boleh kosong",
                position: 'topRight'
            });
        }else{
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>zoom/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>zoom/ajax_edit";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('topic', topic);
            form_data.append('link', link);
            form_data.append('meetingid', meeting_id);
            form_data.append('passcode', passcode);
            
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
                    reload();
                    closemodal();
                    
                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }
    
    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus Meeting ID" + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>zoom/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
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
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Link Zoom');
        $.ajax({
            url: "<?php echo base_url(); ?>zoom/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idzoom);
                $('[name="topic"]').val(data.topic);
                $('[name="link"]').val(data.link);
                $('[name="meeting_id"]').val(data.meeting_id);
                $('[name="passcode"]').val(data.passcode);
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Link Zoom</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Link Zoom</li>
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
                                    <th style="text-align: center;">#</th>
                                    <th>Topic<br>Meeting ID<br>Passcode</th>
                                    <th>Link</th>
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
                            <label class="form-label">Topic</label>
                            <input type="text" id="topic" name="topic" class="form-control" placeholder="Topic" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link</label>
                            <input type="text" id="link" name="link" class="form-control" placeholder="Link Zoom" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Meeting ID</label>
                            <input type="text" id="meeting_id" name="meeting_id" class="form-control" placeholder="Meeting ID" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Passcode</label>
                            <input type="text" id="passcode" name="passcode" class="form-control" placeholder="Passcode" autocomplete="off">
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