<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>libur/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Libur');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var deskripsi = document.getElementById('deskripsi').value;
        var link = document.getElementById('url').value;
        var tglawal = document.getElementById('tgl_awal').value;
        var tglakhir = document.getElementById('tgl_akhir').value;

        if (judul === '') {
            iziToast.error({
                title: 'Error',
                message: "Judul tidak boleh kosong",
                position: 'topRight'
            });
        }else if (tglawal === '') {
            iziToast.error({
                title: 'Error',
                message: "Tanggal awal tidak boleh kosong",
                position: 'topRight'
            });
        }else if (tglakhir === '') {
            iziToast.error({
                title: 'Error',
                message: "Tanggal akhir tidak boleh kosong",
                position: 'topRight'
            });
        }else{
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>libur/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>libur/ajax_edit";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('deskripsi', deskripsi);
            form_data.append('url', link);
            form_data.append('tglawal', tglawal);
            form_data.append('tglakhir', tglakhir);

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
                        url: "<?php echo base_url(); ?>libur/hapus/" + id,
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
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Libur');
        $.ajax({
            url: "<?php echo base_url(); ?>libur/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idlibur);
                $('[name="judul"]').val(data.title);
                $('[name="deskripsi"]').val(data.description);
                $('[name="url"]').val(data.url);
                $('[name="tgl_awal"]').val(data.start);
                $('[name="tgl_akhir"]').val(data.end);

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
    <h4 class="font-weight-bold py-3 mb-0">Sesi Jadwal</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Sesi Jadwal</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Url</th>
                                    <th>Tanggal</th>
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
                            <label class="form-label">Judul</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link / Url</label>
                            <input type="text" id="url" name="url" class="form-control" placeholder="Link / Url" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date" id="tgl_awal" name="tgl_awal" class="form-control" placeholder="Tanggal Awal" autocomplete="off" value="<?php echo $curdate; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" id="tgl_akhir" name="tgl_akhir" class="form-control" placeholder="Tanggal Akhir" autocomplete="off" value="<?php echo $curdate; ?>">
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