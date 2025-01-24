<script type="text/javascript">

    var save_method; //for save method string
    var table;
    
    tinymce.init({
        selector: "textarea#pengumuman", theme: "modern", height: 100
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>pengumuman/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $.ajax({
            url: "<?php echo base_url(); ?>pengumuman/number/",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="urutan"]').val(data.urutan);
                $('#modal_form').modal('show');
                $('.modal-title').text('Tambah Pengumuman');
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var urutan = document.getElementById('urutan').value;
        var pengumuman = tinyMCE.get('pengumuman').getContent();
        var gambar = $("#file")[0].files[0];

        if (judul === '') {
            iziToast.error({
                title: 'Error',
                message: "Judul tidak boleh kosong",
                position: 'topRight'
            });
        }else{
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>pengumuman/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>pengumuman/ajax_edit";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('urutan', urutan);
            form_data.append('pengumuman', pengumuman);
            form_data.append('file', gambar);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {

                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                    reload();
                    $('#modal_form').modal('hide');

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }
    
    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus pengumuman " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>pengumuman/hapus/" + id,
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
        $('.modal-title').text('Ganti Pengumuman');
        $.ajax({
            url: "<?php echo base_url(); ?>pengumuman/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.kode);
                $('[name="urutan"]').val(data.urutan);
                $('[name="judul"]').val(data.judul);
                tinyMCE.get('pengumuman').setContent(data.isi);
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
    <h4 class="font-weight-bold py-3 mb-0">Pengumuman</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>home">Beranda</a></li>
            <li class="breadcrumb-item active">Pengumuman</li>
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
                                    <th>Urutan</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Gambar</th>
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
    <div class="modal-dialog modal-lg">
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
                            <label class="form-label">Urutan Pengumuman (Optional)</label>
                            <input type="number" class="form-control" id="urutan" name="urutan" min="1" max="20" placeholder="Urutan">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Judul</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Isi Pengumuman</label>
                            <textarea class="form-control" name="pengumuman" id="pengumuman" row="5"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Gambar</label>
                            <input type="file" id="file" name="file" class="form-control">
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