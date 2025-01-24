<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlistkeluar"
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function batalkan(id, nama) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin membatalkan siswa keluar " + nama + " ?",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>siswa/batalkeluar/" + id,
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

    function cetak() {
        window.open("<?php echo base_url() ?>siswa/cetakkeluar", "_blank");
    }

    function exportdata() {
        window.location.href = "<?php echo base_url() ?>siswa/exportsiswakeluar";
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Data Siswa');
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="kode"]').val(data.idsiswa);
                $('[name="tgl_daftar"]').val(data.tgl_daftar);
                $('[name="domisili"]').val(data.domisili);
                $('[name="nama_lengkap"]').val(data.nama_lengkap);
                $('[name="panggilan"]').val(data.panggilan);
                $('[name="tmplahir"]').val(data.tmp_lahir);
                $('[name="tgllahir"]').val(data.tgl_lahir);
                $('[name="sekolah"]').val(data.nama_sekolah);
                $('[name="lv_sekolah"]').val(data.level_sekolah);
                $('[name="ortu"]').val(data.nama_ortu);
                $('[name="pekerjaan_ortu"]').val(data.pekerjaan_ortu);
                $('[name="no_induk"]').val(data.no_induk);
                $('[name="email"]').val(data.email);
                $('[name="idmitra"]').val(data.idmitra);
                $('[name="no_hp"]').val(data.tlp);
                $('[name="provinsi"]').val(data.provinsi);

                if (data.jkel === "Laki-laki") {
                    document.getElementById('rbLaki').checked = true;
                    document.getElementById('rbPerempuan').checked = false;
                } else if (data.jkel === "Perempuan") {
                    document.getElementById('rbLaki').checked = false;
                    document.getElementById('rbPerempuan').checked = true;
                }

                // mencari nilai kabupaten
                var form_data = new FormData();
                form_data.append('provinsi', data.provinsi);
                $.ajax({
                    url: "<?php echo base_url(); ?>siswa/kabupaten",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function(data1) {
                        $('#kabupaten').html(data1.status);
                        $('[name="kabupaten"]').val(data.kabupaten);

                        // mencari nilai kecamatan
                        form_data = new FormData();
                        form_data.append('kabupaten', data.kabupaten);

                        $.ajax({
                            url: "<?php echo base_url(); ?>siswa/kecamatan",
                            dataType: 'JSON',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'POST',
                            success: function(data2) {
                                $('#kecamatan').html(data2.status);
                                $('[name="kecamatan"]').val(data.kecamatan);

                                // mencari kelurahan
                                form_data = new FormData();
                                form_data.append('kecamatan', data.kecamatan);

                                $.ajax({
                                    url: "<?php echo base_url(); ?>siswa/kelurahan",
                                    dataType: 'JSON',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    type: 'POST',
                                    success: function(data3) {
                                        $('#kelurahan').html(data3.status);
                                        $('[name="kelurahan"]').val(data.kelurahan);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown4) {
                                        iziToast.error({
                                            title: 'Error',
                                            message: "Error json " + errorThrown4,
                                            position: 'topRight'
                                        });
                                    }
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown3) {
                                iziToast.error({
                                    title: 'Error',
                                    message: "Error json " + errorThrown3,
                                    position: 'topRight'
                                });
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown2) {
                        iziToast.error({
                            title: 'Error',
                            message: "Error json " + errorThrown2,
                            position: 'topRight'
                        });
                    }
                });

            },
            error: function(jqXHR, textStatus, errorThrown1) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown1,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal() {
        $('#modal_form').modal('hide');
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Siswa</h4>
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>siswa">Siswa</a></li>
            <li class="breadcrumb-item active">Siswa Keluar</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="exportdata();"><i class="ion ion-ios-download"></i> Export Excel </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="cetak();"><i class="ion ion-ios-print"></i> Cetak PDF </button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Induk</th>
                                    <th>Siswa</th>
                                    <th>Ortu</th>
                                    <th style="text-align: center;">Alasan Keluar</th>
                                    <th>Aksi</th>
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
                            <label class="form-label">Tanggal Daftar</label>
                            <input type="date" id="tgl_daftar" name="tgl_daftar" class="form-control" placeholder="Tanggal Daftar" value="<?php echo $curdate; ?>" onchange="getNoInduk();">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">No Induk</label>
                            <input type="text" id="no_induk" name="no_induk" class="form-control" placeholder="No Induk" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Kemitraan <i style="color:blue">(isi jika siswa masuk kemitraan)</i></label>
                            <select class="form-control" id="idmitra" name="idmitra">
                                <option value="">- Pilih Kemitraan -</option>
                                <?php
                                foreach ($mitra->getResult() as $row) {
                                ?>
                                    <option value="<?php echo $row->idmitra; ?>"> <?php echo $row->instansi; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Panggilan</label>
                            <input type="text" id="panggilan" name="panggilan" class="form-control" placeholder="Panggilan" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 17px;">
                        <div class="form-group col mb-0">
                            <label class="form-label">No HP</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No HP" autocomplete="off">
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 17px;">
                        <div class="form-group col">
                            <label class="form-label">Domisili</label>
                            <input type="text" id="domisili" name="domisili" class="form-control" placeholder="Domisili" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <label class="form-label">Provinsi</label>
                            <select class="form-control" id="provinsi" name="provinsi" onchange="pilih_kabupaten();">
                                <option value="-">- Pilih Provinsi -</option>
                                <?php
                                foreach ($provinsi->getResult() as $row) {
                                ?>
                                    <option value="<?php echo $row->idprovinsi; ?>"> <?php echo $row->nama; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Kabupaten / Kota</label>
                            <select class="form-control" id="kabupaten" name="kabupaten" onchange="pilih_kecamatan();">
                                <option value="-">- Pilih Kabupaten -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 20px;">
                        <div class="form-group col mb-0">
                            <label class="form-label">Kecamatan</label>
                            <select class="form-control" id="kecamatan" name="kecamatan" onchange="pilih_kelurahan();">
                                <option value="-">- Pilih Kecamatan -</option>
                            </select>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Kelurahan</label>
                            <select class="form-control" id="kelurahan" name="kelurahan">
                                <option value="-">- Pilih Kelurahan -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col" style="margin-top: 20px;">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <label class="form-check-label"><input class="form-check-input" type="radio" id="rbLaki" name="jkel" checked value="Laki-laki"> Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label"><input class="form-check-input" type="radio" id="rbPerempuan" name="jkel" value="Perempuan"> Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <label class="form-label">Tempat</label>
                            <input type="text" id="tmplahir" name="tmplahir" class="form-control" placeholder="Tempat" autocomplete="off">
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tgllahir" name="tgllahir" class="form-control" placeholder="Tanggal Lahir" autocomplete="off" value="<?php echo $curdate; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Sekolah</label>
                            <input type="text" id="sekolah" name="sekolah" class="form-control" placeholder="Sekolah" autocomplete="off">
                        </div>
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Level Sekolah</label>
                            <select class="form-control" id="lv_sekolah" name="lv_sekolah">
                                <option value="TK">TK</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Orang Tua</label>
                            <input type="text" id="ortu" name="ortu" class="form-control" placeholder="Nama Orang Tua" autocomplete="off">
                        </div>
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Pekerjaan Orang Tua</label>
                            <input type="text" id="pekerjaan_ortu" name="pekerjaan_ortu" class="form-control" placeholder="Pekerjaan Orang Tua" autocomplete="off">
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