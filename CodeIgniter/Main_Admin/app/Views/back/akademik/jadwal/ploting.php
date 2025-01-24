<script type="text/javascript">

    var tb_siswa, tb_pengajar, tb_modal_siswa, tb_modal_pengajar, tb_modal_jadwal;
    var tb_modal_pindah_jadwal;

    $(document).ready(function () {
        tb_siswa = $('#tb_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxjadwalsiswa/<?php echo $head->idjadwal; ?>"
        });
        
        tb_pengajar = $('#tb_pengajar').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxjadwalpengajar/<?php echo $head->idjadwal; ?>"
        });
    });

    function reload_siswa() {
        tb_siswa.ajax.reload(null, false);
    }
    
    function reload_pengajar() {
        tb_pengajar.ajax.reload(null, false);
    }

    function add_tambah_siswa() {
        $('#form_tambah_siswa')[0].reset();
        $('#modal_tambah_siswa').modal('show');
    }

    function closemodal_tambah(){
        $('#modal_tambah_siswa').modal('hide');
    }

    function add_siswa() {
        $('#modal_siswa').modal('show');
        tb_modal_siswa = $('#tb_modal_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_modal_siswa/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
        tb_modal_siswa.destroy();
        tb_modal_siswa = $('#tb_modal_siswa').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_modal_siswa/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
    }
    
    function pilihsiswasementara(idsiswa, namalengkap){
        $('#idsiswa_terpilih').val(idsiswa);
        $('#nama_siswa_terpilih').val(namalengkap);
        $('#modal_siswa').modal('hide');
    }

    function showtanggal(){
        $('#modal_jadwal').modal('show');
        tb_modal_jadwal = $('#tb_modal_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_tanggal_mulai/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
        tb_modal_jadwal.destroy();
        tb_modal_jadwal = $('#tb_modal_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_tanggal_mulai/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
    }

    function pilihtanggalmulai(idjadwaldetil, tanggal){
        $('#idjadwaldetil_terpilih').val(idjadwaldetil);
        $('#tanggal_terpilih').val(tanggal);
        $('#modal_jadwal').modal('hide');
    }

    function save_tanggal_start(){
        var idsiswa = document.getElementById('idsiswa_terpilih').value;
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil_terpilih').value;
        var tanggal = document.getElementById('tanggal_terpilih').value;
        

        if(idsiswa === ""){
            iziToast.error({
                title: 'Stop',
                message: "Pilih siswa terlebih dahulu",
                position: 'topRight'
            });
        }else if(idjadwaldetil === ""){
            iziToast.error({
                title: 'Stop',
                message: "Pilih tanggal terlebih dahulu",
                position: 'topRight'
            });
        }else{

            $('#btnSaveTanggalStart').text('Menyimpan...');
            $('#btnSaveTanggalStart').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idsiswa', idsiswa);
            form_data.append('idjadwal', idjadwal);
            form_data.append('idjadwaldetil', idjadwaldetil);
            form_data.append('tanggal', tanggal);

            $.ajax({
                url: "<?php echo base_url(); ?>jadwal/proses_ploting_siswa",
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
                    reload_siswa();
                    $('#modal_tambah_siswa').modal('hide');

                    $('#btnSaveTanggalStart').text('Simpan');
                    $('#btnSaveTanggalStart').attr('disabled', false);
                    
                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error get data " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSaveTanggalStart').text('Simpan');
                    $('#btnSaveTanggalStart').attr('disabled', false);
                }
            });
        }
    }
    
    function add_pengajar(){
        $('#modal_pengajar').modal('show');
        tb_modal_pengajar = $('#tb_modal_pengajar').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_modal_pengajar/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
        tb_modal_pengajar.destroy();
        tb_modal_pengajar = $('#tb_modal_pengajar').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_modal_pengajar/<?php echo $head->idjadwal; ?>",
            retrieve:true
        });
    }
    
    function pilihguru(idpengajar){
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/proses_ploting_pengajar/" + idpengajar + "/<?php echo $head->idjadwal; ?>",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                iziToast.success({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });
                reload_pengajar();
                $('#modal_pengajar').modal('hide');
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function hapus_ploting_siswa(id, nama){
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus jadwal siswa " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>jadwal/hapus_ploting_siswa/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },success: function(data) {
                            reload_siswa();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }
    
    function hapus_ploting_pengajar(id, nama){
        swal({
                title: "Konformasi",
                text:  "Apakah yakin menghapus jadwal pengajar " + nama + " ini ?",
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
                        url: "<?php echo base_url(); ?>jadwal/hapus_ploting_pengajar/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },success: function(data) {
                            reload_pengajar();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function pindahkelas(id, nama){
        $('#modal_pindah_jadwal').modal('show');
        
        $('#idjadwal_siswa_pindah').val(id);
        $('#nama_siswa_pindah').html("NAMA SISWA : " + nama);

        tb_modal_pindah_jadwal = $('#tb_modal_pindah_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_pindah_jadwal/" + id,
            retrieve:true
        });
        tb_modal_pindah_jadwal.destroy();
        tb_modal_pindah_jadwal = $('#tb_modal_pindah_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_pindah_jadwal/" + id,
            retrieve:true
        });
    }

    function pilihjadwallain(idtujuan_tujuan){
        var idasal_jadwal = document.getElementById('idjadwal_siswa_pindah').value;
        $.ajax({
           url: "<?php echo base_url(); ?>jadwal/proses_pindah_kelas/" + idasal_jadwal + "/" + idtujuan_tujuan,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                console.log(data.status);
                iziToast.success({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });
                reload_siswa();
                $('#modal_pindah_jadwal').modal('hide');
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
        
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jadwal Ploting Pengajar dan Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>jadwal">Jadwal Kursus</a></li>
            <li class="breadcrumb-item active">Jadwal Ploting</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="idjadwal" name="idjadwal" readonly autocomplete="off" value="<?php echo $head->idjadwal; ?>">
                    <h6 class="small font-weight-semibold"><b><?php echo $head->groupwa . ' - ' . $head->nama_kursus; ?></b></h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Hari / Sesi</div>
                            <?php echo $head->hari . ' (' . $head->waktu_awal . ' - ' . $head->waktu_akhir . ')'; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Level</div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Tahun Ajaran</div>
                            <?php echo $head->tahun_ajar; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Meeting Id</div>
                            <?php echo $head->meeting_id; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header with-elements pb-0">
                    <h6 class="card-header-title mb-0">Jadwal Users</h6>
                    <div class="card-header-elements ml-auto p-0">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabsiswa">Siswa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabpengajar">Pengajar</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="nav-tabs-top">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabsiswa">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary btn-sm" onclick="add_tambah_siswa();"><i class="fas fa-plus"></i> Tambah Siswa </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="reload_siswa();">Reload</button>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable table-responsive">
                                    <table id="tb_siswa" class="datatables-demo table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tanggal Mulai</th>
                                                <th style="text-align: center;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabpengajar">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary btn-sm" onclick="add_pengajar();"><i class="fas fa-plus"></i> Tambah Pengajar </button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="reload_pengajar();">Reload</button>
                            </div>
                            <div class="card-body">
                                <div class="card-datatable table-responsive">
                                    <table id="tb_pengajar" class="datatables-demo table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
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
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_siswa">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_siswa">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama Siswa</label>
                            <div class="input-group">
                                <input type="hidden" id="idsiswa_terpilih" name="idsiswa_terpilih" readonly autocomplete="off">
                                <input type="text" id="nama_siswa_terpilih" name="nama_siswa_terpilih" class="form-control" placeholder="Nama Siswa" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="add_siswa();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <input type="hidden" id="idjadwaldetil_terpilih" name="idjadwaldetil_terpilih" readonly autocomplete="off">
                                <input type="text" id="tanggal_terpilih" name="tanggal_terpilih" class="form-control" placeholder="Tanggal Mulai" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="showtanggal();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal_tambah();">Tutup</button>
                <button id="btnSaveTanggalStart" type="button" class="btn btn-primary" onclick="save_tanggal_start();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_siswa">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_modal_siswa" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Daftar</th>
                                <th>Domisili</th>
                                <th>Nama</th>
                                <th>JKel</th>
                                <th>Sekolah</th>
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

<div class="modal fade" id="modal_jadwal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Tanggal Mulai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_modal_jadwal" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
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

<div class="modal fade" id="modal_pengajar">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Pengajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_modal_pengajar" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Whatsapp</th>
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

<div class="modal fade" id="modal_pindah_jadwal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data jadwal Available</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idjadwal_siswa_pindah" name="idjadwal_siswa_pindah" readonly><br>
                <label class="form-label" id="nama_siswa_pindah">NAMA SISWA : </label><br>
                <label class="form-label" id="sumber_jadwal_siswa_pindah">ASAL JADWAL : <?php echo $head->groupwa; ?></label>
                <hr>
                <div class="card-datatable table-responsive">
                    <table id="tb_modal_pindah_jadwal" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Rombel</th>
                                <th>Waktu</th>
                                <th>Periode</th>
                                <th>Mode Belajar<br>Tempat</th>
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