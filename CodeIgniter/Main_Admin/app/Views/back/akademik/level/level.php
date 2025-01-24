<script type="text/javascript">
    var save_method = "";
    var tb;

    $(document).ready(function() {
        tb = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajaxlevel/<?php echo $head->idpendkursus; ?>",
            ordering: false
        });
    });

    function reload() {
        tb.ajax.reload(null, false);
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Level');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var idpendkursus = document.getElementById('idpendkursus').value;
        var level = document.getElementById('level').value;
        var tingkatan = document.getElementById('tingkatan').value;

        if (idpendkursus === '') {
            iziToast.error({
                title: 'Error',
                message: "Pendidikan kursus tidak boleh kosong",
                position: 'topRight'
            });
        } else if (level === "") {
            iziToast.error({
                title: 'Error',
                message: "Level tidak boleh kosong",
                position: 'topRight'
            });

        } else {
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>level/ajax_add_level";
            } else {
                url = "<?php echo base_url(); ?>level/ajax_edit_level";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idpendkursus', idpendkursus);
            form_data.append('level', level);
            form_data.append('tingkatan', tingkatan);

            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    reload();
                    $('#modal_form').modal('hide');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);

                },
                error: function(jqXHR, textStatus, errorThrown) {
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

    function hapus(id, nama) {
        swal({
                title: "Apakah anda yakin?",
                text: "menghapus level " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>level/hapus/" + id,
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
        $('.modal-title').text('Ganti Level');
        $.ajax({
            url: "<?php echo base_url(); ?>level/showlevel/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idlevel);
                $('[name="level"]').val(data.level);
                $('[name="tingkatan"]').val(data.tingkatan);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function paramnilai(idpendkursus, idlevel) {
        window.location.href = "<?php echo base_url(); ?>level/parameternilai/" + idpendkursus + "/" + idlevel;
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Pendidikan / Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>level">Pendidikan (Kursus)</a>
            </li>
            <li class="breadcrumb-item active">Level <?php echo $head->nama_kursus; ?></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small"><b>Nama Kursus / Pendidikan</b></div>
                            <?php echo $head->nama_kursus ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data <?php echo $head->nama_kursus; ?></button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="40%">Level</th>
                                    <th>Tingkatan</th>
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
                    <input type="hidden" id="idpendkursus" name="idpendkursus" value="<?php echo $head->idpendkursus; ?>">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Level</label>
                            <input type="text" id="level" name="level" class="form-control" placeholder="Level" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tingkatan</label>
                            <input type="text" id="tingkatan" name="tingkatan" class="form-control" placeholder="Tingkatan" autocomplete="off" onkeypress="return hanyaAngka(event,false);">
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