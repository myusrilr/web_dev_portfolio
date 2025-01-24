<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>rekruitmen/ajaxlist",
        });

        table2 = $('#tbbidang').DataTable({
            ajax: "<?php echo base_url(); ?>rekruitmen/listform",
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function reload2() {
        table2.ajax.reload(null, false); //reload datatable ajax
    }

    function add(id) {
        $('#info').hide();
        $('#formmodal')[0].reset();
        $('#kode').val(id);
        $('#modal_form').modal('show');
        $('.modal-title').text('Proses Pelamar');
    }

    function users() {
        var jml = $('input[name=kodepelamar]:checked').length;
        if(jml < 1){
            alert("Anda belum memilih pelamar!");
        }else{
            $('#infousers').hide();
            $('#formmodalusers')[0].reset();
            $('#modal_formusers').modal('show');
        } 
    }

    function saveusers() {
        $('#btnSaveU').text('Menyimpan...'); //change button text
        $('#btnSaveU').attr('disabled', true); //set button disable 

        var kodepelamar = [];
        $("input:checkbox[name=kodepelamar]:checked").each(function(){
            kodepelamar.push($(this).val());
        });
        var staff = $('.select2-demo').val();

        var url = "";
        url = "<?php echo base_url(); ?>rekruitmen/submitpewawancara";
        
        var form_data = new FormData();
        form_data.append('idpelamar', kodepelamar);
        form_data.append('staff', staff);
        
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
                $('#infousers').show();
                if(data.status == "simpan"){
                    $('#infousers').text('Berhasil menyimpan data!');
                    window.setTimeout(function () {
                        $('#modal_formusers').modal('hide');
                    }, 1000);
                }
                reload();

                $('#btnSaveU').text('Simpan'); //change button text
                $('#btnSaveU').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSaveU').text('Simpan'); //change button text
                $('#btnSaveU').attr('disabled', false); //set button enable 
            }
        });
    }

    function detail(kode) {
        window.location.href = "<?php echo base_url(); ?>rekruitmen/detail/"+kode;
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var status = document.getElementById('status').value;
        var permintaan = document.getElementById('permintaan').value;
        var link = document.getElementById('link').value;
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>rekruitmen/submitnote";
        
        var form_data = new FormData();
        form_data.append('idpelamar', kode);
        form_data.append('status', status);
        form_data.append('permintaan', permintaan);
        form_data.append('link', link);
        
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
                    window.setTimeout(function () {
                        $('#modal_form').modal('hide');
                    }, 1000);
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

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus data pelamar : " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>rekruitmen/hapus/" + id,
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
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function delusers() {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus pewawancara pada pelamar ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    var kodepelamar = [];
                    $("input:checkbox[name=kodepelamar]:checked").each(function(){
                        kodepelamar.push($(this).val());
                    });

                    var url = "";
                    url = "<?php echo base_url(); ?>rekruitmen/hapususer";

                    var form_data = new FormData();
                    form_data.append('idpelamar', kodepelamar);

                    $.ajax({
                        url: url,
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        error: function() {
                            alert('Error');
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

    function hapusform(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus Link From : " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>rekruitmen/hapusform/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload2();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function proses() {
        $('#btnS').text('Menyimpan...');
        $('#btnS').attr('disabled', true);

        var bidang = document.getElementById('bidang').value;
        // var aktif = document.getElementById('aktif').value;

        var tot = 0;
        if (bidang === '') {
            document.getElementById('bidang').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('bidang').classList.remove('is-invalid'); tot += 1;} 
        
        if(tot === 1){
            var form_data = new FormData();
            form_data.append('bidang', bidang);
            // form_data.append('aktif', aktif);

            $.ajax({
                url: "<?php echo base_url(); ?>rekruitmen/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    reload2();

                    $('#btnS').text('Simpan');
                    $('#btnS').attr('disabled', false);
                }, error: function (response) {
                    alert(response.status);
                    $('#btnS').text('Simpan');
                    $('#btnS').attr('disabled', false);
                }
            });
        }
    }

    function copyText(element) {
        var range, selection, worked;

        if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();        
            range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }
        
        try {
            document.execCommand('copy');
            alert('text copied');
        }
        catch (err) {
            alert('unable to copy text');
        }
    }

    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function closemodalusers(){
        $('#modal_formusers').modal('hide');
    }

    // Select2
    $(function() {
        $('.select2-demo').select2({
            dropdownParent: $('#modal_formusers')
        });
    });
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Pelamar</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Pelamar</li>
        </ol>
    </div>
    <?php if($role == 'R00001'){ ?>
    <div class="row">
        <div class="col-xl-12 col-md-12" id="accordion2">
            <div class="card"> 
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Daftar Bidang<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Bidang Loker</label>
                                    <input type="text" class="form-control" id="bidang" name="bidang" placeholder="ex. Coding">
                                    <small class="invalid-feedback">Bidang Loker wajib diisi</small>
                                </div>
                            </div>
                            <!-- <div class="col-2">
                                <br>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="aktif" name="aktif" value="1">
                                    <span class="custom-control-label" for="aktif">Aktif</span>
                                </label>
                            </div> -->
                            <div class="col-2">
                                <br>
                                <button type="button" id="btnS" class="btn btn-sm btn-primary" onclick="proses();">Simpan</button>
                            </div>
                            <div class="col-12"><br>
                                <table id="tbbidang" class="datatables-demo table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Bidang</th>
                                            <th width="10%" style="text-align: center;">Aksi</th>
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
    <?php } ?>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-success btn-sm" onclick="users()"><i class="feather icon-users"></i> Tambah Pewawancara</button>
                        <button type="button" class="btn btn-sm btn-danger btn-sm" onclick="delusers()"><i class="feather icon-trash"></i> Hapus Pewawancara</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Bidang</th>
                                    <th width="55%">Detail</th>
                                    <th width="10%">Pewawancara</th>
                                    <?php if($role != 'R00003'){ ?>
                                    <th width="10%">Permintaan</th>
                                    <?php } ?>
                                    <th width="10%" style="text-align: center;">Aksi</th>
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
                <form id="formmodal">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Permintaan Karyawan Baru</label>
                            <select class="custom-select" id="permintaan" name="permintaan">
                                <option value="" disabled selected>Pilih Permintaan Karyawan Baru</option>
                                <?php foreach($permintaan->getResult() as $row){
                                    echo '<option value="'.$row->idpengajuan.'">'.$row->keterangan.' (Total: '.$row->jumlah.' orang - Pengajuan : '.$row->nama.')</option>';
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="Tahap Test">Tahap Test</option>
                                <option value="Interview">Interview</option>
                                <option value="MicroTeaching">MicroTeaching</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Link</label>
                            <input type="text" class="form-control" name="link" id="link">
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

<div class="modal fade" id="modal_formusers">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Tambah Pewawancara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="infousers">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="formmodalusers">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-group">
                        <label class="form-label">Pewawancara</label>
                        <select class="select2-demo form-control" multiple style="width: 100%;  z-index:100000;" name="staff[]">
                            <?php foreach($users->getResult() as $row){ ?>
                            <option value="<?php echo $row->idusers; ?>"><?php echo $row->nama; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalusers();">Tutup</button>
                <button id="btnSaveU" type="button" class="btn btn-primary" onclick="saveusers();">Simpan</button>
            </div>
        </div>
    </div>
</div>