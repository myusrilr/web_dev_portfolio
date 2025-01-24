<script type="text/javascript">
    var save_method, save_method1, save_method2;

    $(document).ready(function() {
        reload();
    });

    function reload() {
        reload_judul();
        reload_tema();
        reload_kompetensi();
    }

    function reload_judul() {
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/ajaxkurikulum/<?php echo $idlevel; ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#wadah_judul').html(data.status);
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

    function reload_tema() {
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/ajaxtema/<?php echo $idlevel; ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#wadah_tema').html(data.status);
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

    function reload_kompetensi() {
        console.log("<?php echo base_url(); ?>kurikulum/ajaxkompetensi/<?php echo $idlevel; ?>");
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/ajaxkompetensi/<?php echo $idlevel; ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#wadah_sub_tema').html(data.status);
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

    tinymce.init({
        selector: "textarea#menu",
        theme: "modern",
        height: 100
    });

    tinymce.init({
        selector: "textarea#kompetensi",
        theme: "modern",
        height: 100
    });

    function add() {
        save_method = "add";
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah kurikulum');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var judul = document.getElementById('judul').value;
        var idlevel = document.getElementById('idlevel').value;

        if (judul === '') {
            iziToast.error({
                title: 'Stop',
                message: "Judul tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>kurikulum/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>kurikulum/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('judul', judul);
            form_data.append('idlevel', idlevel);

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
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus kurikulum " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>kurikulum/hapus/" + id,
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
        $('.modal-title').text('Ganti Kurikulum');
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idkurikulum);
                $('[name="judul"]').val(data.judul);
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

    function addtema(id, nama) {
        save_method1 = "add";
        $('#form_detil')[0].reset();
        $('#modal_detil').modal('show');
        $('.modal-title-tema').text('Tambah Tema');
        $('#key').val(id);
    }

    function save1() {
        $('#btnSaveDetil').text('Menyimpan...');
        $('#btnSaveDetil').attr('disabled', true);

        var kode = document.getElementById('kode_detil').value;
        var idkurikulum = document.getElementById('key').value;
        var menu = tinyMCE.get('menu').getContent();

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('idkurikulum', idkurikulum);
        form_data.append('menu', menu);

        var url = "";
        if (save_method1 === 'add') {
            url = "<?php echo base_url(); ?>kurikulum/ajax_add_tema";
        } else {
            url = "<?php echo base_url(); ?>kurikulum/ajax_edit_tema";
        }

        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                iziToast.success({
                    title: 'Info',
                    message: response.status,
                    position: 'topRight'
                });
                reload();
                $('#modal_detil').modal('hide');

                $('#btnSaveDetil').text('Simpan');
                $('#btnSaveDetil').attr('disabled', false);
            },
            error: function(response) {
                iziToast.error({
                    title: 'Error',
                    message: response.status,
                    position: 'topRight'
                });

                $('#btnSaveDetil').text('Simpan');
                $('#btnSaveDetil').attr('disabled', false);
            }
        });
    }

    function gantitema(id) {
        save_method1 = 'update';
        $('#form_detil')[0].reset();
        $('#modal_detil').modal('show');
        $('.modal-title-tema').text('Ganti Tema');
        $('#key').val(id);
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/showtema/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode_detil"]').val(data.idkur_det);
                $('[name="key"]').val(data.idkurikulum);
                tinyMCE.get('menu').setContent(data.menu);
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

    function hapustema(id) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus tema ini ?",
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
                        url: "<?php echo base_url(); ?>kurikulum/hapustema/" + id,
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

    function closemodaldetil() {
        $('#modal_detil').modal('hide');
    }

    function addkompetensi(id) {
        save_method2 = "add";
        $('#form_sub_detil')[0].reset();
        $('#modal_sub_detil').modal('show');
        $('.modal-title-kompetensi').text('Tambah Kompetensi');
        $('#key_kur_det').val(id);
    }

    function gantikompetensi(id) {
        save_method2 = 'update';
        $('#form_sub_detil')[0].reset();
        $('#modal_sub_detil').modal('show');
        $('.modal-title-kompetensi').text('Ganti Kompetensi');
        $.ajax({
            url: "<?php echo base_url(); ?>kurikulum/showkompetensi/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode_sub_detil"]').val(data.idkur_det_sub);
                $('[name="key_kur_det"]').val(data.idkur_det);
                tinyMCE.get('kompetensi').setContent(data.kompetensi);
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

    function save2() {
        $('#btnSaveSubDetil').text('Menyimpan...');
        $('#btnSaveSubDetil').attr('disabled', true);

        var kode = document.getElementById('kode_sub_detil').value;
        var idkur_det = document.getElementById('key_kur_det').value;
        var kompetensi = tinyMCE.get('kompetensi').getContent();

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('idkur_det', idkur_det);
        form_data.append('kompetensi', kompetensi);

        var url = "";
        if (save_method2 === 'add') {
            url = "<?php echo base_url(); ?>kurikulum/ajax_add_kompetensi";
        } else {
            url = "<?php echo base_url(); ?>kurikulum/ajax_edit_kompetensi";
        }

        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                iziToast.success({
                    title: 'Info',
                    message: response.status,
                    position: 'topRight'
                });
                reload();
                $('#modal_sub_detil').modal('hide');

                $('#btnSaveSubDetil').text('Simpan');
                $('#btnSaveSubDetil').attr('disabled', false);
            },
            error: function(response) {
                iziToast.error({
                    title: 'Error',
                    message: response.status,
                    position: 'topRight'
                });

                $('#btnSaveSubDetil').text('Simpan');
                $('#btnSaveSubDetil').attr('disabled', false);
            }
        });
    }

    function hapuskompetensi(id) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus kurikulum ini ?",
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
                        url: "<?php echo base_url(); ?>kurikulum/hapuskurikulum/" + id,
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

    function closemodalsubdetil() {
        $('#modal_sub_detil').modal('hide');
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Detil Jadwal Pengajaran</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>kurikulum">Level Pendidikan (Kursus)</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="<?php echo base_url(); ?>kurikulum/level/<?php echo $idpendkursus; ?>">Level Pendidikan</a>
            </li>
            <li class="breadcrumb-item">Kurikulum</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">
                        <b>Maintenance Data Kurikulum</b>
                    </h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Kursus</div>
                            <?php echo $nm_kursus; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Level</div>
                            <?php echo $nm_level; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">

                <div class="col-md">
                    <div class="card mb-3">
                        <h6 class="card-header text-center">Judul</h6>
                        <div class="kanban-box px-2 pt-2">
                            <div id="wadah_judul"></div>
                        </div>
                        <div class="card-footer text-center py-2">
                            <a href="javascript:void(0)" onclick="add();"><i class="ion ion-md-add"></i>&nbsp; Tambah Judul</a>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div id="wadah_tema"></div>
                </div>


                <div class="col-md">
                    <div id="wadah_sub_tema"></div>
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
                    <input type="hidden" id="idlevel" name="idlevel" value="<?php echo $idlevel; ?>">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Judul</label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" autocomplete="off">
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

<div class="modal fade" id="modal_detil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-tema">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_detil">
                    <input type="hidden" id="kode_detil" name="kode_detil" readonly>
                    <input type="hidden" id="key" name="key" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tema</label>
                            <textarea class="form-control" id="menu" name="menu"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodaldetil();">Tutup</button>
                <button id="btnSaveDetil" type="button" class="btn btn-primary" onclick="save1();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sub_detil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-kompetensi">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_sub_detil">
                    <input type="hidden" id="kode_sub_detil" name="kode_sub_detil" readonly>
                    <input type="hidden" id="key_kur_det" name="key_kur_det" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Kompetensi</label>
                            <textarea class="form-control" id="kompetensi" name="kompetensi"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalsubdetil();">Tutup</button>
                <button id="btnSaveSubDetil" type="button" class="btn btn-primary" onclick="save2();">Simpan</button>
            </div>
        </div>
    </div>
</div>