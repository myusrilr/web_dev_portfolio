<script type="text/javascript">
    var mode_global = "all";
    var table, tbRombel, tbJadwal;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajaxlist/all"
        });
    });

    function pindah(param) {
        window.location.href = "<?php echo base_url(); ?>calonsiswa/calon/" + param;
    }

    function pindah(url) {
        window.location.href = url;
    }

    function cetak() {
        var mode = mode_global;
        window.open("<?php echo base_url() ?>calonsiswa/cetak/" + mode, "_blank");
    }

    function reload(mode) {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajaxlist/" + mode,
            retrieve: true
        });
        table.destroy();
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>calonsiswa/ajaxlist/" + mode,
            retrieve: true
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
        window.open("https://api.whatsapp.com/send?phone=" + full + "&text=<?php echo base_url() ?>calonsiswasp/index/" +
            idcalon);
    }

    function opsiterima(id, nama) {
        iziToast.show({
            color: 'dark',
            icon: 'fas fa-question',
            title: 'Konfirmasi',
            message: 'Opsi penerimaan ' + nama + ' ?',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                [
                    '<button>Terima</button>',
                    function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);

                        $.ajax({
                            url: "<?php echo base_url(); ?>calonsiswa/terima/" + id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data) {
                                iziToast.success({
                                    title: 'Info',
                                    message: data.status,
                                    position: 'topRight'
                                });
                                reload("all");

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
                ],
                [
                    '<button>Tolak</button>',
                    function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);

                        $.ajax({
                            url: "<?php echo base_url(); ?>calonsiswa/tolak/" + id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data) {
                                iziToast.success({
                                    title: 'Info',
                                    message: data.status,
                                    position: 'topRight'
                                });
                                reload("all");

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
                ],
                [
                    '<button>Pending</button>',
                    function(instance, toast) {
                        instance.hide({
                            transitionOut: 'fadeOutUp'
                        }, toast);

                        $.ajax({
                            url: "<?php echo base_url(); ?>calonsiswa/pending/" + id,
                            type: "POST",
                            dataType: "JSON",
                            success: function(data) {
                                iziToast.success({
                                    title: 'Info',
                                    message: data.status,
                                    position: 'topRight'
                                });
                                reload("all");

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
                ]
            ]
        });
    }
</script>

<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Calon Siswa</h4>
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
            <li class="breadcrumb-item active">Calon Siswa</li>
        </ol>
    </div>

    <div class="container">
        <div class="row g-3">
            <?php
            foreach ($kursus->getResult() as $row) {
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-primary text-white widget-visitor-card"
                        style="cursor:pointer; border-radius:25px; height: 150px;"
                        onclick="pindah('<?php echo $modul->enkrip_url($row->idpendkursus); ?>');">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h2 class="text-white mb-2">
                                <?php
                                $jml = $model->getAllQR("SELECT COUNT(*) as jml FROM form_calon WHERE idpendkursus = '" . $row->idpendkursus . "';")->jml;
                                echo $jml;
                                ?>
                            </h2>
                            <h6 class="text-white mb-0"><?php echo $row->nama_kursus; ?></h6>
                            <i class="feather icon-user-plus mt-2"></i>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="col-12">
                <div class="card bg-info text-white widget-visitor-card"
                    style="cursor:pointer; border-radius:25px; height: 150px;"
                    onclick="pindah('Calonsiswa/catatan_admin');">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h1 class="text-white mb-2" style="font-size: 2.5em;">Catatan Admin Calon Siswa</h1>
                        <i class="feather icon-edit mt-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-sm" onclick="cetak();"><i
                                    class="fas fa-print"></i> Cetak </button>

                            <div class="pull-right">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rbOpsi" value="All" checked
                                        onchange="reload('all');">
                                    <span class="form-check-label">All</span>
                                </label>
                                <?php
                                foreach ($kursus->getResult() as $row) {
                                ?>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rbOpsi"
                                            value="<?php echo $row->nama_kursus; ?>"
                                            onchange="reload('<?php echo $row->idpendkursus; ?>');">
                                        <span class="form-check-label"><?php echo $row->nama_kursus; ?></span>
                                    </label>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Calon</th>
                                    <th>Tlp Calon</th>
                                    <th>Email Calon</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
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

<div class="modal fade" id="modal_terima">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="idcalon" name="idcalon">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama Calon</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Calon Siswa"
                                autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Kursus</label>
                            <input type="text" id="kursus" name="kursus" class="form-control" placeholder="Kursus"
                                autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jadwal / Rombel</label>
                            <div class="input-group">
                                <input type="hidden" id="idjadwal" name="idjadwal" readonly autocomplete="off">
                                <input type="text" id="namajadwal" name="namajadwal" class="form-control"
                                    placeholder="Rombel" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button"
                                        onclick="showrombel();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <input type="hidden" id="idjadwaldetil" name="idjadwaldetil" readonly
                                    autocomplete="off">
                                <input type="text" id="tanggal_terpilih" name="tanggal_terpilih" class="form-control"
                                    placeholder="Tanggal Mulai" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button"
                                        onclick="showtanggal();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>