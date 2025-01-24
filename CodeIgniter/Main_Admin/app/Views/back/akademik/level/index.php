<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Kursus');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var nama = document.getElementById('nama').value;
        var keterangan = document.getElementById('keterangan').value;

        if (nama === '') {
            iziToast.error({
                title: 'Error',
                message: "Nama kursus tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>level/ajax_add_kursus";
            } else {
                url = "<?php echo base_url(); ?>level/ajax_edit_kursus";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nama', nama);
            form_data.append('keterangan', keterangan);

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);

                },
                error: function(jqXHR, textStatus, errorThrown) {
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
                text: "menghapus kursus " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>level/hapuskursus/" + id,
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
                } else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
            });
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Kursus');
        $.ajax({
            url: "<?php echo base_url(); ?>level/show_kursus/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idpendkursus);
                $('[name="nama"]').val(data.nama_kursus);
                $('[name="keterangan"]').val(data.keterangan);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function level(kode) {
        window.location.href = "<?php echo base_url(); ?>level/detillevel/" + kode;
    }

    function rapor(kode) {
        window.location.href = "<?php echo base_url(); ?>level/formatrapor/" + kode;
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Pendidikan / Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Pendidikan (Kursus)</li>
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
                                    <th>#</th>
                                    <th>Nama Kursus</th>
                                    <th>Keterangan</th>
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
                            <label class="form-label">Nama Kursus</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Kursus" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan" autocomplete="off">
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