<script type="text/javascript">
    var tb_jadwal;
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxjadwal/<?php echo $siswa->idsiswa; ?>"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#modal_jadwal').modal('show');
        $('.modal-title').text('Tambah Jadwal');
        tb_jadwal = $('#tb_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlistjadwal/<?php echo $siswa->idsiswa; ?>",
            retrieve: true
        });
        tb_jadwal.destroy();
        tb_jadwal = $('#tb_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlistjadwal/<?php echo $siswa->idsiswa; ?>",
            retrieve: true
        });
    }

    function pilih(idjadwal, idsiswa) {
        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal);
        form_data.append('idsiswa', idsiswa);

        $.ajax({
            url: "<?php echo base_url(); ?>siswa/simpanjadwalsiswa",
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

                $('#modal_jadwal').modal('hide');
                reload();

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

    function hapusjadwal(id, nama, namasiswa) {
        swal({
                title: "Apakah anda yakin?",
                text: "menghapus jadwal siswa " + namasiswa + " dengan group wa " + nama + " ?",
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
                        url: "<?php echo base_url(); ?>siswa/hapusjadwal/" + id,
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

    function lulus(idsiswa, namasiswa, idjadwalsiswa, groupwa) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin membuat lulus siswa " + namasiswa + " pada rombel " + groupwa + " ?",
                showCancelButton: true,
                confirmButtonClass: "btn btn-success",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>siswa/buatlulus/" + idsiswa + "/" + idjadwalsiswa,
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

    function batalkanlulus(idsiswa, namasiswa, idjadwalsiswa, groupwa) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin membatalkan kelulusan siswa " + namasiswa + " pada rombel " + groupwa + " ?",
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
                        url: "<?php echo base_url(); ?>siswa/batallulus/" + idsiswa + "/" + idjadwalsiswa,
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

    function nonaktif(idsiswa, namasiswa, idjadwalsiswa, groupwa) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menonaktifkan siswa " + namasiswa + " pada rombel " + groupwa + " ?",
                showCancelButton: true,
                confirmButtonClass: "btn btn-success",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>siswa/nonaktif/" + idsiswa + "/" + idjadwalsiswa,
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

    function aktifkan(idsiswa, namasiswa, idjadwalsiswa, groupwa) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin mengaktifkan kembali siswa " + namasiswa + " pada rombel " + groupwa + " ?",
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
                        url: "<?php echo base_url(); ?>siswa/aktifkan/" + idsiswa + "/" + idjadwalsiswa,
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
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>siswa">Siswa</a></li>
            <li class="breadcrumb-item active">Jadwal Siswa</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold"><b><?php echo $siswa->nama_lengkap . ' (' . $siswa->panggilan . ')'; ?></b></h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Sekolah</div>
                            <?php echo $siswa->nama_sekolah ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Level Sekolah</div>
                            <?php echo $siswa->level_sekolah; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Domisili</div>
                            <?php echo $siswa->domisili; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">TTL</div>
                            <?php echo $siswa->tmp_lahir . ', ' . $siswa->tgllahir; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Jadwal</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rombel</th>
                                    <th>Pengajar</th>
                                    <th>Hari</th>
                                    <th>Meeting ID</th>
                                    <th>Level</th>
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


<div class="modal fade" id="modal_jadwal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_jadwal" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Group WA</th>
                                <th>Hari</th>
                                <th>Sesi</th>
                                <th>Periode</th>
                                <th>Level</th>
                                <th>Zoom</th>
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