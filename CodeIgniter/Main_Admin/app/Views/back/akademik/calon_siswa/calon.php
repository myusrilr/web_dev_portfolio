<script type="text/javascript">
    var table, tb_opsi;
    var save_method = "";

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajaxcalon/<?php echo $head->idpendkursus; ?>"
        });
        load_wadah_pertanyaan();
    });

    function reload() {
        table.ajax.reload(null, false);
        load_wadah_pertanyaan();
    }

    function load_wadah_pertanyaan() {
        var id = document.getElementById('idpendkursus').value;
        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/load_pertanyaan/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#wadah_pertanyaan').html(data.status);
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

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah calon');
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti calon');
        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/showcalonsiswa/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode_calon"]').val(data.idcalon);
                $('[name="nama_calon"]').val(data.nama);
                $('[name="tlp_calon"]').val(data.tlp);
                $('[name="email_calon"]').val(data.email);
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

    function save_calon() {
        var kode_calon = document.getElementById('kode_calon').value;
        var idpendkursus_calon = document.getElementById('idpendkursus_calon').value;
        var nama_calon = document.getElementById('nama_calon').value;
        var tlp_calon = document.getElementById('tlp_calon').value;
        var email_calon = document.getElementById('email_calon').value;

        if (nama_calon === '') {
            iziToast.error({
                title: 'Error',
                message: "Nama calon tidak boleh kosong",
                position: 'topRight'
            });
        } else if (tlp_calon === '') {
            iziToast.error({
                title: 'Error',
                message: "Telepon calon tidak boleh kosong",
                position: 'topRight'
            });
        } else if (email_calon === '') {
            iziToast.error({
                title: 'Error',
                message: "Email calon tidak boleh kosong",
                position: 'topRight'
            });
        } else {

            var form_data = new FormData();
            form_data.append('kode_calon', kode_calon);
            form_data.append('idpendkursus', idpendkursus_calon);
            form_data.append('nama_calon', nama_calon);
            form_data.append('tlp_calon', tlp_calon);
            form_data.append('email_calon', email_calon);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>calonsiswa/ajax_add_calon";
            } else {
                url = "<?php echo base_url(); ?>calonsiswa/ajax_edit_calon";
            }

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

    function hapus(id, nama) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus calon siswa " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>calonsiswa/hapus/" + id,
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

    function add_pertanyaan() {
        save_method = 'add';
        $('#form_pertanyaan')[0].reset();
        $('#modal_pertanyaan').modal('show');
        $('.modal-pertanyaan').text('Tambah Pertanyaan');
    }

    function save_pertanyaan() {
        var idcalon_p = document.getElementById('idcalon_p').value;
        var idpendkursus = document.getElementById('idpendkursus').value;
        var pertanyaan = document.getElementById('pertanyaan').value;
        var mode = document.getElementById('mode').value;

        if (idpendkursus === '') {
            iziToast.error({
                title: 'Error',
                message: "Pendidikan kursus tidak boleh kosong",
                position: 'topRight'
            });
        } else if (pertanyaan === '') {
            iziToast.error({
                title: 'Error',
                message: "Pendidikan kursus tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnSavePertanyaan').text('Menyimpan...');
            $('#btnSavePertanyaan').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idcalon_p', idcalon_p);
            form_data.append('idpendkursus', idpendkursus);
            form_data.append('pertanyaan', pertanyaan);
            form_data.append('mode', mode);

            $.ajax({
                url: "<?php echo base_url(); ?>calonsiswa/ajax_add_pertanyaan",
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
                    $('#modal_pertanyaan').modal('hide');
                    $('#btnSavePertanyaan').text('Simpan');
                    $('#btnSavePertanyaan').attr('disabled', false);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSavePertanyaan').text('Simpan');
                    $('#btnSavePertanyaan').attr('disabled', false);
                }
            });
        }
    }

    function hapus_pertanyaan(id, pertanyaan) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus pertanyaan " + pertanyaan + " ?",
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
                        url: "<?php echo base_url(); ?>calonsiswa/hapus_pertanyaan/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", data.status, "success");
                        }
                    });
                } else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
            });
    }

    function detil_pertanyaan(id, pertanyaan) {
        $('#form_pertanyaan_detil')[0].reset();
        $('#modal_pertanyaan_detil').modal('show');
        $('.modal-pertanyaan-detil').text(pertanyaan);
        $('#idcalon_p_detil').val(id);
        tb_opsi = $('#tb_opsi').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajax_opsi/" + id,
            retrieve: true
        });
        tb_opsi.destroy();
        tb_opsi = $('#tb_opsi').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajax_opsi/" + id,
            retrieve: true
        });
    }

    function save_pertanyaan_detil() {
        var idcalon_pd = document.getElementById('idcalon_pd').value;
        var idcalon_p_detil = document.getElementById('idcalon_p_detil').value;
        var pertanyaan_detil = document.getElementById('pertanyaan_detil').value;

        if (idcalon_p_detil === '') {
            iziToast.error({
                title: 'Error',
                message: "Key tidak boleh kosong",
                position: 'topRight'
            });
        } else if (pertanyaan_detil === '') {
            iziToast.error({
                title: 'Error',
                message: "Pertanyaan tidak boleh kosong",
                position: 'topRight'
            });
        } else {

            var form_data = new FormData();
            form_data.append('idcalon_pd', idcalon_pd);
            form_data.append('idcalon_p_detil', idcalon_p_detil);
            form_data.append('pertanyaan_detil', pertanyaan_detil);

            $.ajax({
                url: "<?php echo base_url(); ?>calonsiswa/ajax_add_pertanyaan_detil",
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
                    $('#modal_pertanyaan_detil').modal('hide');
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

    function hapusopsi(id, no) {
        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/hapusopsi/" + id,
            type: "POST",
            dataType: "JSON",
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            },
            success: function(data) {
                reload();
                $('#modal_pertanyaan_detil').modal('hide');
            }
        });
    }

    function tulismandiri(id) {
        window.location.href = "<?php echo base_url(); ?>calonsiswa/tulismandiri/" + id;
    }

    function lengkapiekstern(id) {
        window.open("<?php echo base_url(); ?>calonsiswasp/index/" + id, "_blank");
    }

    function kirimwa(tlp, idcalon) {
        var awal_tlp = tlp.substr(0, 1);
        var akhir_tlp = tlp.substr(1);

        var full = tlp;
        if (awal_tlp === "0") {
            full = "+62" + akhir_tlp;
        }
        window.open("https://api.whatsapp.com/send?phone=" + full + "&text=<?php echo base_url() ?>calonsiswasp/index/" + idcalon);
    }

    function simpan_urutan(id, saya) {
        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('nilai', saya.value);

        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/simpan_urutan",
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
                load_wadah_pertanyaan();
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

    function pindah_input_saat(id, saya) {
        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('nilai', saya.value);

        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/simpan_input_pada_saat",
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
                load_wadah_pertanyaan();
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

    function pilih_table_rujukan(id, saya) {
        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('nilai', saya.value);

        $.ajax({
            url: "<?php echo base_url(); ?>calonsiswa/simpan_table_rujukan",
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
                load_wadah_pertanyaan();
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
    <h4 class="font-weight-bold py-3 mb-0">Calon Siswa <?php echo $head->nama_kursus; ?></h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <?php
                if (session()->get("logged_pendidikan")) {
                    echo '<a href="' . base_url() . '/homependidikan">Beranda</a>';
                } else if (session()->get("logged_hr")) {
                    echo '<a href="' . base_url() . '/home">Beranda</a>';
                }
                ?>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>calonsiswa">Calon Siswa</a></li>
            <li class="breadcrumb-item active">Calon Siswa <?php echo $head->nama_kursus; ?></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="idpendkursus" name="idpendkursus" value="<?php echo $head->idpendkursus; ?>" readonly>
                    <div class="nav-tabs-top mb-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#navs-data">Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#navs-pertanyaan">Pertanyaan</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-data">
                                <div class="card-body">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah </button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-datatable table-responsive">
                                            <table id="tb" class="datatables-demo table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Calon</th>
                                                        <th>Telp Calon</th>
                                                        <th>Email Calon</th>
                                                        <th style="text-align: center;">Status</th>
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
                            <div class="tab-pane fade" id="navs-pertanyaan">
                                <div class="card-body">
                                    <div class="card-header">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="add_pertanyaan();"><i class="fas fa-plus"></i> Tambah Pertanyaan </button>
                                    </div>
                                    <div class="card-body" id="wadah_pertanyaan">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pertanyaan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-pertanyaan">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_pertanyaan">
                    <input type="hidden" id="idcalon_p" name="idcalon_p" value="" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Pertanyaan</label>
                            <input type="text" id="pertanyaan" name="pertanyaan" class="form-control" placeholder="Pertanyaan" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Mode</label>
                            <select id="mode" name="mode" class="form-control">
                                <option value="text">Text</option>
                                <option value="radio">Radio Button</option>
                                <option value="select">Select</option>
                                <option value="date">Date</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button id="btnSavePertanyaan" type="button" class="btn btn-sm btn-primary" onclick="save_pertanyaan();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pertanyaan_detil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-pertanyaan-detil">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_pertanyaan_detil">
                    <input type="hidden" id="idcalon_pd" name="idcalon_pd" readonly>
                    <input type="hidden" id="idcalon_p_detil" name="idcalon_p_detil" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Pertanyaan</label>
                            <input type="text" id="pertanyaan_detil" name="pertanyaan_detil" class="form-control" placeholder="Pertanyaan Detil" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tb_opsi" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Opsi</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_pertanyaan_detil();">Simpan</button>
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
                    <input type="hidden" id="kode_calon" name="kode_calon" readonly>
                    <input type="hidden" id="idpendkursus_calon" name="idpendkursus_calon" value="<?php echo $head->idpendkursus; ?>" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama</label>
                            <input type="text" id="nama_calon" name="nama_calon" class="form-control" placeholder="Nama Calon" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Telepon</label>
                            <input type="text" id="tlp_calon" name="tlp_calon" class="form-control" placeholder="Telepon Calon" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Email</label>
                            <input type="text" id="email_calon" name="email_calon" class="form-control" placeholder="Email Calon" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="save_calon();">Simpan</button>
            </div>
        </div>
    </div>
</div>