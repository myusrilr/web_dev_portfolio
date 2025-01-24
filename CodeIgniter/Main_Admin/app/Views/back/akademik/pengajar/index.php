<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Siswa');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var tgldaftar = document.getElementById('tgl_daftar').value;
        var domisili = document.getElementById('domisili').value;
        var nama_lengkap = document.getElementById('nama_lengkap').value;
        var panggilan = document.getElementById('panggilan').value;
        var tmplahir = document.getElementById('tmplahir').value;
        var tgllahir = document.getElementById('tgllahir').value;
        var sekolah = document.getElementById('sekolah').value;
        var lv_sekolah = document.getElementById('lv_sekolah').value;
        var ortu = document.getElementById('ortu').value;
        var pekerjaan_ortu = document.getElementById('pekerjaan_ortu').value;

        var tot = 0;
        if (tgldaftar === '') {
            document.getElementById('tgl_daftar').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgl_daftar').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (domisili === '') {
            document.getElementById('domisili').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('domisili').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (nama_lengkap === '') {
            document.getElementById('nama_lengkap').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('nama_lengkap').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (panggilan === '') {
            document.getElementById('panggilan').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('panggilan').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tmplahir === '') {
            document.getElementById('tmplahir').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tmplahir').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (tgllahir === '') {
            document.getElementById('tgllahir').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('tgllahir').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        var jkel = "Laki-laki";
        if(document.getElementById('rbLaki').checked){
            jkel = document.getElementById('rbLaki').value;
        }else if(document.getElementById('rbPerempuan').checked){
            jkel = document.getElementById('rbPerempuan').value;
        }
        
        if (sekolah === '') {
            document.getElementById('sekolah').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('sekolah').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (lv_sekolah === '') {
            document.getElementById('lv_sekolah').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('lv_sekolah').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (ortu === '') {
            document.getElementById('ortu').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('ortu').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if (pekerjaan_ortu === '') {
            document.getElementById('pekerjaan_ortu').classList.add('form-control', 'is-invalid');
        }else{
            document.getElementById('pekerjaan_ortu').classList.remove('is-invalid'); 
            tot += 1;
        }
        
        if(tot === 10){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>siswa/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>siswa/ajax_edit";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('tgldaftar', tgldaftar);
            form_data.append('domisili', domisili);
            form_data.append('namalengkap', nama_lengkap);
            form_data.append('jkel', jkel);
            form_data.append('panggilan', panggilan);
            form_data.append('tmplahir', tmplahir);
            form_data.append('tgllahir', tgllahir);
            form_data.append('sekolah', sekolah);
            form_data.append('lv_sekolah', lv_sekolah);
            form_data.append('ortu', ortu);
            form_data.append('pekerjaan_ortu', pekerjaan_ortu);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if(data.status === "simpan"){
                        $('#info').show();
                        $('#info').text('Berhasil menyimpan data!');
                        reset();
                        reload();
                        window.setTimeout(function () {
                            $('#modal_form').modal('hide');
                        }, 1000);
                        
                    }else if(data.status === "ganti"){
                        $('#info').show();
                        $('#info').text('Berhasil memperbarui data!');
                        reset();
                        reload();
                        window.setTimeout(function () {
                            $('#modal_form').modal('hide');
                        }, 1000);
                        
                    }else{
                        $('#info').show();
                        $('#info').text(data.status);
                    }

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }
    
    function reset(){
        document.getElementById('kode').value = "";
        document.getElementById('tgl_daftar').value = "";
        document.getElementById('domisili').value = "";
        document.getElementById('nama_lengkap').value = "";
        document.getElementById('panggilan').value = "";
        document.getElementById('tmplahir').value = "";
        document.getElementById('tgllahir').value = "";
        document.getElementById('sekolah').value = "";
        document.getElementById('lv_sekolah').value = "";
        document.getElementById('ortu').value = "";
        document.getElementById('pekerjaan_ortu').value = "";
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
                        url: "<?php echo base_url(); ?>siswa/hapus/" + id,
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
        $('.modal-title').text('Ganti Siswa');
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
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
                if(data.jkel === "Laki-laki"){
                    document.getElementById('rbLaki').checked = true;
                    document.getElementById('rbPerempuan').checked = false;
                }else if(data.jkel === "Perempuan"){
                    document.getElementById('rbLaki').checked = false;
                    document.getElementById('rbPerempuan').checked = true;
                }
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Error get data " + errorThrown);
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item active">Siswa</li>
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
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Tgl Daftar</th>
                                    <th>Domisili</th>
                                    <th>Nama Lengkap</th>
                                    <th>Panggilan</th>
                                    <th>JKel</th>
                                    <th>Sekolah</th>
                                    <th>Lv Sekolah</th>
                                    <th>Ortu</th>
                                    <th>Pekerjaan Ortu</th>
                                    <th>Ttl</th>
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
                <div class="alert alert-success alert-dismissible fade show" id="info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Daftar</label>
                            <input type="date" id="tgl_daftar" name="tgl_daftar" class="form-control" placeholder="Tanggal Daftar" value="<?php echo $curdate; ?>">
                            <small class="invalid-feedback">Tanggal Daftar wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Domisili</label>
                            <input type="text" id="domisili" name="domisili" class="form-control" placeholder="Domisili" autocomplete="off">
                            <small class="invalid-feedback">Domisili wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" autocomplete="off">
                            <small class="invalid-feedback">Nama lengkap wajib diisi</small>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Panggilan</label>
                            <input type="text" id="panggilan" name="panggilan" class="form-control" placeholder="Panggilan" autocomplete="off">
                            <small class="invalid-feedback">Panggilan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col" style="margin-top: 17px;">
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
                            <small class="invalid-feedback">Tempat lahir wajib diisi</small>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tgllahir" name="tgllahir" class="form-control" placeholder="Tanggal Lahir" autocomplete="off" value="<?php echo $curdate; ?>">
                            <small class="invalid-feedback">Tanggal lahir wajib diisi</small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Sekolah</label>
                            <input type="text" id="sekolah" name="sekolah" class="form-control" placeholder="Sekolah" autocomplete="off">
                            <small class="invalid-feedback">Sekolah wajib diisi</small>
                        </div>
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Level Sekolah</label>
                            <input type="text" id="lv_sekolah" name="lv_sekolah" class="form-control" placeholder="Level Sekolah" autocomplete="off">
                            <small class="invalid-feedback">Level sekolah wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Orang Tua</label>
                            <input type="text" id="ortu" name="ortu" class="form-control" placeholder="Nama Orang Tua" autocomplete="off">
                            <small class="invalid-feedback">Orang tua wajib diisi</small>
                        </div>
                        <div class="form-group col mb-0" style="margin-top: 17px;">
                            <label class="form-label">Pekerjaan Orang Tua</label>
                            <input type="text" id="pekerjaan_ortu" name="pekerjaan_ortu" class="form-control" placeholder="Pekerjaan Orang Tua" autocomplete="off">
                            <small class="invalid-feedback">Pekerjaan orang tua wajib diisi</small>
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