<script type="text/javascript">
    var save_method = "";
    var save_method_sub_detil = "";
    var tb_level, tb_subtitle, tb_param, tb_subtitle_rumus;

    $(document).ready(function() {
        reload();
    });

    function reload() {
        console.log("<?php echo base_url(); ?>level/ajaxformat/<?php echo $head->idpendkursus; ?>");
        $.ajax({
            url: "<?php echo base_url(); ?>level/ajaxformat/<?php echo $head->idpendkursus; ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#tb').html(data.status);
            },
            error: function(data) {
                swal("Gagal!", data.status, "error");
            }
        });
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Format Rapor');
    }

    function save() {
        var idformat_rapor = document.getElementById('idformat_rapor').value;
        var idpendkursus = document.getElementById('idpendkursus').value;
        var title = document.getElementById('title').value;

        if (idpendkursus === '') {
            iziToast.error({
                title: 'Stop',
                message: "Jenis kursus tidak boleh kosong",
                position: 'topRight'
            });
        } else if (title === '') {
            iziToast.error({
                title: 'Stop',
                message: "Title tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnSimpan1').text('Menyimpan...');
            $('#btnSimpan1').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>level/ajax_add_format1";
            } else {
                url = "<?php echo base_url(); ?>level/ajax_edit_format1";
            }

            var form_data = new FormData();
            form_data.append('idformat_rapor', idformat_rapor);
            form_data.append('idpendkursus', idpendkursus);
            form_data.append('title', title);

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

                    $('#btnSimpan1').text('Simpan');
                    $('#btnSimpan1').attr('disabled', false);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSimpan1').text('Simpan');
                    $('#btnSimpan1').attr('disabled', false);
                }
            });
        }
    }

    function hapus(id, nama) {
        swal({
                title: "Konformasi",
                text: "Apakah anda yakin menghapus format " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>level/hapus_format1/" + id,
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
        $('.modal-title').text('Ganti Format Rapor');
        $.ajax({
            url: "<?php echo base_url(); ?>level/showformatrapor/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="idformat_rapor"]').val(data.idformat_rapor);
                $('[name="title"]').val(data.title);
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

    function display_level(id) {
        $('#idformat_rapor').val(id);

        var idpendkursus = document.getElementById('idpendkursus').value;
        $('#modal_level').modal('show');
        tb_level = $('#tb_level').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_dialog_level/" + idpendkursus + "/" + id,
            ordering: false,
            paging: false,
            retrieve: true
        });
        tb_level.destroy();
        tb_level = $('#tb_level').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_dialog_level/" + idpendkursus + "/" + id,
            ordering: false,
            paging: false,
            retrieve: true
        });
    }

    function checkAll(ele) {
        var checkboxes = document.getElementsByName('level[]');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }

    function pilihlevel() {
        var idpendkursus = document.getElementById('idpendkursus').value;
        var checkboxes = document.getElementsByName('level[]');
        var checkboxesChecked = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkboxesChecked.push(checkboxes[i]);
            }
        }

        if (checkboxesChecked.length > 0) {
            var selected = Array.from(checkboxesChecked).map(x => x.value);
            proses_level(idpendkursus, selected);

        } else {
            iziToast.error({
                title: 'Error',
                message: "Minimal 1 siswa terpilih",
                position: 'topRight'
            });
        }
    }

    function proses_level(idpendkursus, selected) {
        $('#btnProsesPilih').text('Loading...');
        $('#btnProsesPilih').attr('disabled', true);

        var idformat_rapor = document.getElementById('idformat_rapor').value;

        var form_data = new FormData();
        form_data.append('idpendkursus', idpendkursus);
        form_data.append('terpilih', selected);
        form_data.append('idformat_rapor', idformat_rapor);

        $.ajax({
            url: "<?php echo base_url() ?>level/proses_pilih",
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
                $('#modal_level').modal('hide');

                $('#btnProsesPilih').text('Proses');
                $('#btnProsesPilih').attr('disabled', false);

                reload();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });

                $('#btnProsesPilih').text('Proses');
                $('#btnProsesPilih').attr('disabled', false);
            }
        });
    }

    function subdetail(idformat, title) {
        $('#modal_sub_detil').modal('show');
        $('#idformat_rapor').val(idformat);
        $('#namaformat_head').html(title);

        reload_subtitle();
    }

    function add_subtitle() {
        save_method_sub_detil = 'add';
        $('#form_sub_detil')[0].reset();
        $('#modal_form_sub_detil').modal('show');
        $('.modal-title-sub-detil').text('Tambah Sub Detail');
        $('#idformat_rapor_sub_detil').val(document.getElementById('idformat_rapor').value);
    }

    function reload_subtitle() {
        var idformat = document.getElementById('idformat_rapor').value;
        tb_subtitle = $('#tb_subtitle').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_sub_detail/" + idformat,
            ordering: false,
            retrieve: true
        });
        tb_subtitle.destroy();
        tb_subtitle = $('#tb_subtitle').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_sub_detail/" + idformat,
            ordering: false,
            retrieve: true
        });
    }

    function ganti_subtitle(id) {
        save_method_sub_detil = 'ganti';
        $('#form_sub_detil')[0].reset();
        $('#modal_form_sub_detil').modal('show');
        $('.modal-title-sub-detil').text('Ganti Sub Detail');
        $('#idformat_rapor_sub_detil').val(document.getElementById('idformat_rapor').value);
        $.ajax({
            url: "<?php echo base_url(); ?>level/show_subtitle/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="idformat_rd"]').val(data.idformat_rd);
                $('[name="idformat_rapor_sub_detil"]').val(data.idformat_rapor);
                $('[name="subtitle"]').val(data.subtitle);
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

    function save_sub_detil() {

        var idformat_rd = document.getElementById('idformat_rd').value;
        var idformat_rapor = document.getElementById('idformat_rapor_sub_detil').value;
        var subtitle = document.getElementById('subtitle').value;

        if (idformat_rapor === '') {
            iziToast.error({
                title: 'Stop',
                message: "Judul utama tidak boleh kosong",
                position: 'topRight'
            });
        } else if (subtitle === '') {
            iziToast.error({
                title: 'Stop',
                message: "Sub judul tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnSimpan2').text('Menyimpan...');
            $('#btnSimpan2').attr('disabled', true);

            var url = "";
            if (save_method_sub_detil === 'add') {
                url = "<?php echo base_url(); ?>level/ajax_add_sub_detil";
            } else {
                url = "<?php echo base_url(); ?>level/ajax_edit_sub_detil";
            }

            var form_data = new FormData();
            form_data.append('idformat_rd', idformat_rd);
            form_data.append('idformat_rapor', idformat_rapor);
            form_data.append('subtitle', subtitle);

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
                    $('#modal_form_sub_detil').modal('hide');

                    $('#btnSimpan2').text('Simpan');
                    $('#btnSimpan2').attr('disabled', false);

                    reload_subtitle();
                    reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSimpan2').text('Simpan');
                    $('#btnSimpan2').attr('disabled', false);
                }
            });
        }
    }

    function hapus_subtitle(id, nama) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus subtitle " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>level/hapus_subtitle/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },
                        success: function(data) {
                            reload_subtitle();
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                } else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
            });
    }

    function template() {
        $('#modal_preview').modal('show');
    }

    function preview() {
        $('#modal_rapor').modal('show');
        $.ajax({
            url: "<?php echo base_url(); ?>level/ajax_dialog_combobox/<?php echo $head->idpendkursus; ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#level_format_rapor').html(data.status);
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

    function display_format_rapor() {
        var idlevel = document.getElementById('level_format_rapor').value;
        if (idlevel === "-") {
            $('#layout_sisi_kanan').html("");
            iziToast.error({
                title: 'Stop',
                message: "Pilih level kursus terlebih dahulu",
                position: 'topRight'
            });
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>level/ajax_format_preview_rapor/" + idlevel,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    $('#layout_sisi_kanan').html(data.status);
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
    }

    function rumushead(idformat_rapor) {
        $('#modal_parameter').modal('show');
        tb_param = $('#tb_param').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_param_head/" + idformat_rapor,
            ordering: false,
            retrieve: true
        });
        tb_param.destroy();
        tb_param = $('#tb_param').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_param_head/" + idformat_rapor,
            ordering: false,
            retrieve: true
        });
    }

    function pilih_parameter_head(idformat_rapor, idparam, namaparam) {

        var form_data = new FormData();
        form_data.append('idformat_rapor', idformat_rapor);
        form_data.append('idparam', idparam);

        $.ajax({
            url: "<?php echo base_url(); ?>level/pilih_parameter_head",
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
                $('#modal_parameter').modal('hide');
                reload();

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

    function rumusdetil(kode_head, kode, nama, level) {
        $.ajax({
            url: "<?php echo base_url(); ?>level/cek_avaiable_rumus/" + kode_head,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status === "ada") {
                    $('#modal_rumus_detil').modal('show');
                    $('[name="idformat_rapor_rumus"]').val(kode_head);
                    $('[name="idformat_rd_rumus"]').val(kode);
                    $('[name="idlevel"]').val(level);
                    $('#judul_rumus_sub_title').html(nama);

                    reload_rumus_sub_title(kode_head, kode, level);
                } else {
                    iziToast.error({
                        title: 'Stop',
                        message: "Input level terlebih dahulu",
                        position: 'topRight'
                    });
                }
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

    function operasi_detil() {
        $('#modal_operator').modal('show');
    }

    function operasi_angka() {
        $('#form_angka_detil')[0].reset();
        $('#modal_angka').modal('show');
    }

    function simpan_angka_detil() {
        var idf_head = document.getElementById('idformat_rapor_rumus').value;
        var idf_detil = document.getElementById('idformat_rd_rumus').value;
        var angka = document.getElementById('angka_detil').value;
        var idlevel = document.getElementById('idlevel').value;

        var form_data = new FormData();
        form_data.append('idformat_rapor', idf_head);
        form_data.append('idformat_rd', idf_detil);
        form_data.append('idparam', angka);
        form_data.append('idlevel', idlevel);

        $.ajax({
            url: "<?php echo base_url(); ?>level/pilih_parameter",
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
                $('#modal_angka').modal('hide');
                reload_rumus_sub_title(idf_head, idf_detil, idlevel);
                reload();

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

    function proses_operator(operator) {

        var idf_head = document.getElementById('idformat_rapor_rumus').value;
        var idf_detil = document.getElementById('idformat_rd_rumus').value;
        var idlevel = document.getElementById('idlevel').value;

        var form_data = new FormData();
        form_data.append('idformat_rapor', idf_head);
        form_data.append('idformat_rd', idf_detil);
        form_data.append('idparam', operator);
        form_data.append('idlevel', idlevel);

        $.ajax({
            url: "<?php echo base_url(); ?>level/pilih_parameter",
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
                $('#modal_operator').modal('hide');
                reload_rumus_sub_title(idf_head, idf_detil, idlevel);
                reload();

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

    function reload_rumus_sub_title(kode_head, kode_detil, level) {
        tb_subtitle_rumus = $('#tb_subtitle_rumus').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_rumus_subtitle/" + kode_head + "/" + kode_detil + "/" + level,
            ordering: false,
            retrieve: true,
            paging: false
        });
        tb_subtitle_rumus.destroy()
        tb_subtitle_rumus = $('#tb_subtitle_rumus').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_rumus_subtitle/" + kode_head + "/" + kode_detil + "/" + level,
            ordering: false,
            retrieve: true,
            paging: false
        });
    }

    function parameter_detil() {
        var idformat_rapor = document.getElementById('idformat_rapor_rumus').value;
        var idformat_rd_rumus = document.getElementById('idformat_rd_rumus').value;
        var idlevel = document.getElementById('idlevel').value;

        $('#modal_parameter').modal('show');
        tb_param = $('#tb_param').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_param/" + idformat_rapor + "/" + idformat_rd_rumus + "/" + idlevel,
            ordering: false,
            retrieve: true
        });
        tb_param.destroy();
        tb_param = $('#tb_param').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajax_param/" + idformat_rapor + "/" + idformat_rd_rumus + "/" + idlevel,
            ordering: false,
            retrieve: true
        });
    }

    function hapus_param_sub(id, nama) {
        swal({
                title: "Konformasi",
                text: "Apakah anda yakin menghapus " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>level/hapus_sub_rumus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },
                        success: function(data) {
                            var head = document.getElementById('idformat_rapor_rumus').value;
                            var detil = document.getElementById('idformat_rd_rumus').value;
                            var idlevel = document.getElementById('idlevel').value;
                            reload_rumus_sub_title(head, detil, idlevel);
                            reload();

                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                } else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
            });
    }

    function pilih_parameter(idf_head, idf_detil, idparam, namaparam, idlevel) {

        var form_data = new FormData();
        form_data.append('idformat_rapor', idf_head);
        form_data.append('idformat_rd', idf_detil);
        form_data.append('idparam', idparam);
        form_data.append('idlevel', idlevel);

        $.ajax({
            url: "<?php echo base_url(); ?>level/pilih_parameter",
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
                $('#modal_parameter').modal('hide');
                reload_rumus_sub_title(idf_head, idf_detil, idlevel);
                reload();

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
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Pendidikan / Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>level">Pendidikan (Kursus)</a>
            </li>
            <li class="breadcrumb-item active">Format Template <?php echo $head->nama_kursus; ?></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-12">
                            <div class="text-muted small"><b>Nama Kursus / Pendidikan</b></div>
                            <strong><?php echo $head->nama_kursus ?></strong>
                            <br><br>
                            <label style="color: red;">Format penggantian template sesuai kotak warna merah</label>&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary btn-sm" onclick="template();"> Tampilkan Template </button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="preview();"> Preview Rapor </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <input type="hidden" id="idpendkursus" name="idpendkursus" value="<?php echo $head->idpendkursus; ?>">
            <input type="hidden" id="idformat_rapor" name="idformat_rapor">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <div id="tb" class="card-datatable table-responsive">

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
                    <input type="hidden" id="idformat_rapor" name="idformat_rapor">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Title" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnSimpan1" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_level">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Daftar Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <button id="btnProsesPilih" type="button" class="btn btn-info btn-sm" onclick="pilihlevel();"> Proses </button>
                <br>
                <table id="tb_level" class="datatables-demo table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Level</th>
                            <th style="text-align: center;"><input type="checkbox" onchange="checkAll(this)"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sub_detil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="namaformat_head">Daftar Sub Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idformat_rapor" name="idformat_rapor" readonly>
                <button type="button" class="btn btn-info btn-sm" onclick="add_subtitle();"><i class="fas fa-plus"></i> Tambah </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="reload_subtitle();">Reload</button>

                <div class="card-datatable table-responsive">
                    <table id="tb_subtitle" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sub Title</th>
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

<div class="modal fade" id="modal_form_sub_detil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-sub-detil">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_sub_detil">
                    <input type="hidden" id="idformat_rapor_sub_detil" name="idformat_rapor_sub_detil">
                    <input type="hidden" id="idformat_rd" name="idformat_rd">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Sub Title</label>
                            <input type="text" id="subtitle" name="subtitle" class="form-control" placeholder="Sub Title" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnSimpan2" class="btn btn-primary" onclick="save_sub_detil();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_preview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Preview Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <img src="<?php echo $deftemplate; ?>" class="img-thumbnail">
            </div>
        </div>
    </div>
</div>



<style>
    .dialogbody {
        background: url(<?php echo base_url() . "/images/background.jpg"; ?>) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        margin-top: 0cm;
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 0cm;
        height: 780px;
    }

    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 300px;
    }

    .column1 {
        float: left;
        width: 48.5%;
        padding: 10px;
        height: 300px;
    }

    .column2 {
        float: left;
        width: 51.5%;
        padding: 10px;
        height: 300px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="modal_rapor">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <select class="form-control" id="level_format_rapor" onchange="display_format_rapor();">
                    <option value="-">- Pilih Level -</option>
                </select>
                <br>
                <div id="dialogbody" class="dialogbody">
                    <div class="row">
                        <div class="column1">
                            <table border="0" style="width: 90%; margin-top: 40px; margin-right: 20px; margin-left: 20px; font-size: 12px;">
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <img src="<?php echo base_url() . "/images/logoreport.jpg"; ?>" alt="logo" style="width: 220px; height: auto;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;">ACCREDITATION LEVEL B</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Operational Licence : 188 / 14226 / 436.7.1 / 2020</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Nilek : 05209.1.0593 / 09</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">NPSN : K0560112</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Rungkut Asri Tengah VII / 51, Surabaya 60293</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Phone : (031) 870 5464 - 0813 3538 1619</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">www.leapsurabaya.sch.id</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;"><u>OUR VISION</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <p style="margin-left: 30px; margin-right: 30px;">Leap's vision is to become holistic provider is 2030 to create competent graduates thorough collaborate with our staheholders.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr style="border: 1px solid black;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;"><u>STUDENT PROGRESS REPORT</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 100px;">&nbsp;&nbsp;NAME</td>
                                    <td style="text-align: left;" id="nama_siswa">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;LEVEL</td>
                                    <td style="text-align: left;" id="level_siswa">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;TEACHER</td>
                                    <td style="text-align: left;" id="nama_guru">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;TERM</td>
                                    <td style="text-align: left;" id="term">&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <div class="column2">
                            <table id="layout_sisi_kanan" border="0" style="width: 90%; margin-top: 60px; margin-right: 20px; font-size: 11px;">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_rumus_detil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="judul_rumus_sub_title">Sub Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idformat_rapor_rumus" name="idformat_rapor_rumus">
                <input type="hidden" id="idformat_rd_rumus" name="idformat_rd_rumus">
                <input type="hidden" id="idlevel" name="idlevel">

                <button type="button" class="btn btn-primary btn-sm" onclick="parameter_detil();"> Parameter </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="operasi_detil();"> Operasi </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="operasi_angka();"> Angka </button>

                <div class="card-datatable table-responsive">
                    <table id="tb_subtitle_rumus" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Rumus</th>
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

<div class="modal fade" id="modal_parameter">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Parameter Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_param" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Parameter</th>
                                <th>Level</th>
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

<div class="modal fade" id="modal_operator">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Operator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator('+');"> + </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator('-');"> - </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator('*');"> * </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator('/');"> / </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator('(');"> ( </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="proses_operator(')');"> ) </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_angka">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Input Angka</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_angka_detil">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Angka</label>
                            <input type="text" id="angka_detil" name="angka_detil" class="form-control" placeholder="Angka" autocomplete="off" onkeypress="return hanyaAngka(event, false);">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="simpan_angka_detil();">Simpan</button>
            </div>
        </div>
    </div>
</div>