<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>pengguna/ajaxlist",
            scrollx: true,
            responsive: true
        });
        
        closeerror();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        closeerror();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah pengguna');
    }

    function expert(id) {
        $('#form2')[0].reset();
        $('#modal_form2').modal('show');
        $('.modal-title2').text('Tambah Expertise');
        document.getElementById('kodeE').value = id;
        document.getElementById('expert').classList.remove('is-invalid');
    }

    function expertedit(id) {
        $('#form2')[0].reset();
        $('#modal_form2').modal('show');
        $('.modal-title2').text('Edit Expertise');
        document.getElementById('kodeE').value = id;
        document.getElementById('expert').classList.remove('is-invalid');
        $.ajax({
            url: "<?php echo base_url(); ?>pengguna/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="expert"]').val(data.expertise);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function saveE() {
        var kode = document.getElementById('kodeE').value;
        var expert = document.getElementById('expert').value;

        var tot = 0;
        if (expert === '') {
            document.getElementById('expert').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('expert').classList.remove('is-invalid'); tot += 1;} 

        if (tot === 1) {
            $('#btnSaveE').text('Menyimpan...'); //change button text
            $('#btnSaveE').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>pengguna/ajax_addE";

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('expert', expert);

            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if(data.status == "simpan"){
                        iziToast.info({
                            title: 'Success',
                            message: data.status,
                            position: 'topRight'
                        });
                    }else{
                        iziToast.info({
                            title: 'Info',
                            message: data.status,
                            position: 'topRight'
                        });
                    }
                    $('#modal_form2').modal('hide');
                    reload();

                    $('#btnSaveE').text('Simpan'); //change button text
                    $('#btnSaveE').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSaveE').text('Simpan'); //change button text
                    $('#btnSaveE').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function subtopik(kode) {
        window.location.href = "<?php echo base_url(); ?>pengguna/detil/"+kode;
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var email = document.getElementById('email').value;
        var jabatan = document.getElementById('jabatan').value;
        var tanggal = document.getElementById('tanggal').value;
        var idrole = document.getElementById('idrole').value;
        var status = document.getElementById('status').value;
        var expertise = document.getElementById('expertise').value;

        var tot = 0;
        if (email === '') {
            document.getElementById('email').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('email').classList.remove('is-invalid'); tot += 1;} 
        if(tanggal === ''){
            document.getElementById('tanggal').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('tanggal').classList.remove('is-invalid'); tot += 1;}
        if(jabatan === ''){
            $('#errorjabatan').show();
        }else{$('#errorjabatan').hide(); tot += 1;}
        if(idrole === ''){
            $('#errorrole').show();
        }else{$('#errorrole').hide(); tot += 1;}

        if (tot === 4) {
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>pengguna/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>pengguna/ajax_edit";
            }
            
            var hasil=[];
            $("input:checkbox[name=akses]:checked").each(function(){
                hasil.push($(this).val());
            });

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('email', email);
            form_data.append('idjabatan', jabatan);
            form_data.append('tanggal', tanggal);
            form_data.append('idrole', idrole);
            form_data.append('status', status);
            form_data.append('expertise', expertise);
            form_data.append('hasil', hasil);

            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    $('#info').show();
                    if(data.status == "simpan"){
                        $('#info').text('Berhasil menyimpan data!');
                        $('[name="email"]').val("");
                        $('[name="tanggal"]').val("");
                    }else{
                        iziToast.info({
                            title: 'Info',
                            message: data.status,
                            position: 'topRight'
                        });
                        $('#modal_form').modal('hide');
                        reload();
                    }
                    reload();

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
                        url: "<?php echo base_url(); ?>pengguna/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
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

    function closeerror(){
        $('#errorjabatan').hide();
        $('#errorjabatan').hide();
        $('#errorrole').hide(); 
        $('#info').hide();
        // $('#errorjamkerja').hide(); 
        document.getElementById('email').classList.remove('is-invalid');
        document.getElementById('tanggal').classList.remove('is-invalid');
    }

    function ganti(id) {
        closeerror();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Pengguna');
        $.ajax({
            url: "<?php echo base_url(); ?>pengguna/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idusers);
                $('[name="email"]').val(data.email);
                // $('[name="jamkerja"]').val(data.idjamkerja);
                $('[name="jabatan"]').val(data.idjabatan);
                $('[name="tanggal"]').val(data.thnbekerja);
                $('[name="status"]').val(data.status);
                $('[name="expertise"]').val(data.expertise);
                $('[name="idrole"]').val(data.idrole);
                if(data.ispurchase == 1){
                    document.getElementById("ispurchase").checked = true;
                }
                if(data.isteaching == 1){
                    document.getElementById("isteaching").checked = true;
                }
                if(data.ishr == true){
                    document.getElementById("ishr").checked = true;
                }if(data.isga == true){
                    document.getElementById("isga").checked = true;
                }if(data.isit == true){
                    document.getElementById("isit").checked = true;
                }if(data.ispdd == true){
                    document.getElementById("ispdd").checked = true;
                }if(data.isbusdev == true){
                    document.getElementById("isbusdev").checked = true;
                }if(data.ispimpinan == true){
                    document.getElementById("ispimpinan").checked = true;
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function lock(id) {
        if (confirm("Apakah anda yakin mereset password pengguna ini ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>pengguna/reset/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error reset password');
                }
            });
        }
    }

    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function closemodalE(){
        $('#modal_form2').modal('hide');
    }

    function detail(kode) {
        window.location.href = "<?php echo base_url(); ?>pengguna/detail/"+kode;
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Karyawan</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Karyawan</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php if($role != 'R00004'){ ?>
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data</button>
                    <?php } ?>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">ID Karyawan</th>
                                    <th width="15%">Foto</th>
                                    <th>Detail</th>
                                    <!-- <th width="10%">Jam Kerja</th> -->
                                    <th>Hak Akses</th>
                                    <th>Status</th>
                                    <th width="15%" style="text-align: center;">Aksi</th>
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
                            <label class="form-label">Divisi & Jabatan</label>
                            <select class="custom-select" id="jabatan" name="jabatan">
                                <option value="" disabled selected>Pilih Divisi & Jabatan</option>
                                <?php
                                foreach($jabatan->getResult() as $row) {?>
                                <option value="<?php echo $row->idjabatan; ?>"><?php echo $row->nama.' - '.$row->jabatan; ?></option>
                                <?php }?>
                            </select>
                            <small id="errorjabatan" class="invalid-feedback">Divisi & Jabatan wajib dipilih</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Mulai Bekerja</label>
                            <input class="form-control" type="date" name="tanggal" id="tanggal" placeholder="Contoh: 02-3-2023">
                            <small class="invalid-feedback">Tanggal Mulai Bekerja wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="text" name="email" id="email" placeholder="Masukkan email">
                            <small class="invalid-feedback">Email wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Expertise</label>
                            <input class="form-control" type="text" name="expertise" id="expertise" placeholder="Masukkan Expertise">
                            <small class="invalid-feedback">Expertise wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Hak Akses Utama</label>
                            <select class="custom-select"  id="idrole" name="idrole">
                                <option value="" disabled selected>Pilih Hak Akses</option>
                                <?php
                                foreach($roles->getResult() as $row) {?>
                                <option value="<?php echo $row->idrole; ?>"><?php echo strtoupper($row->nama_role) ?></option>
                                <?php }?>
                            </select>
                            <small id="errorrole" class="invalid-feedback">Hak Akses wajib dipilih</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">AKSES TAMBAHAN</label>
                        </div>
                    </div>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ishr" name="akses" value="ishr">
                        <span class="custom-control-label" for="ishr">Akses HR</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isit" name="akses" value="isit">
                        <span class="custom-control-label" for="isit">Akses IT</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ispdd" name="akses" value="ispdd">
                        <span class="custom-control-label" for="ispdd">Akses Pendidikan</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isga" name="akses" value="isga">
                        <span class="custom-control-label" for="isga">Akses General Affairs</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isbusdev" name="akses" value="isbusdev">
                        <span class="custom-control-label" for="isbusdev">Akses Busdev</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ispimpinan" name="akses" value="ispimpinan">
                        <span class="custom-control-label" for="ispimpinan">Akses Pimpinan</span>
                    </label>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status Akun</label>
                            <select class="custom-select"  id="status" name="status">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ispurchase" name="akses" value="ispurchase">
                        <span class="custom-control-label" for="ispurchase">Akses Purchasing / Pembelian</span>
                    </label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isteaching" name="akses" value="isteaching">
                        <span class="custom-control-label" for="isteaching">Akses Pengajar (untuk bidang lain)</span>
                    </label>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_form2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title2">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form2">
                    <input type="hidden" id="kodeE" name="kodeE">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Expertise</label>
                            <input class="form-control" type="text" name="expert" id="expert" placeholder="Masukkan expertise">
                            <small class="invalid-feedback">Expertise wajib diisi</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalE();">Tutup</button>
                <button id="btnSaveE" type="button" class="btn btn-primary" onclick="saveE();">Simpan</button>
            </div>
        </div>
    </div>
</div>
