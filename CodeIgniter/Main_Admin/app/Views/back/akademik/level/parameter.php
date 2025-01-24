<script type="text/javascript">

    var save_method = "";
    var tb, tb_duplikasi;

    $(document).ready(function () {
        tb = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajaxparameter/<?php echo $head2->idlevel; ?>",
            ordering : false,
            paging : false
        });
    });

    function reload() {
        tb.ajax.reload(null, false);
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Parameter');
    }
    
    function save() {
        var kode = document.getElementById('kode').value;
        var idlevel = document.getElementById('idlevel').value;
        var parameter = document.getElementById('param').value;
        var filterInput = document.getElementById('filterInput').value;

        if (parameter === '') {
            iziToast.error({
                title: 'Error',
                message: "Parameter tidak boleh kosong",
                position: 'topRight'
            });
        }else{
            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>level/ajax_add_param";
            } else {
                url = "<?php echo base_url(); ?>level/ajax_edit_param";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idlevel', idlevel);
            form_data.append('parameter', parameter);
            form_data.append('filterInput', filterInput);
            
            $.ajax({
                url: url,
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
                    
                    reload();
                    $('#modal_form').modal('hide');
                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                    
                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
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
            title: "Apakah anda yakin?",
            text:  "menghapus parameter " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>level/hapusparameter/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function ganti(id){
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Parameter');
        $.ajax({
            url: "<?php echo base_url(); ?>level/showparameter/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idp_nilai);
                $('[name="param"]').val(data.parameter);
                $('[name="filterInput"]').val(data.isnumber);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function duplikasi(){
        $('#modal_duplikasi').modal('show');
        tb_duplikasi = $('#tb_duplikasi').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajaxloadduplikasi/<?php echo $head2->idlevel; ?>",
            ordering : false,
            paging : false,
            retrieve : true
        });
        tb_duplikasi.destroy();
        tb_duplikasi = $('#tb_duplikasi').DataTable({
            ajax: "<?php echo base_url(); ?>level/ajaxloadduplikasi/<?php echo $head2->idlevel; ?>",
            ordering : false,
            paging : false,
            retrieve : true
        });
    }

    function pilih_duplikasi(levelSumber, levelTujuan){
        var form_data = new FormData();
        form_data.append('idlevel_sumber', levelSumber);
        form_data.append('idlevel_tujuan', levelTujuan);
        
        $.ajax({
            url: "<?php echo base_url(); ?>level/duplikasi",
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
                
                reload();
                $('#modal_duplikasi').modal('hide');
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function kembali(){
        var idlevel_head = document.getElementById('idlevel_head').value;
        var idpendkursus_head = document.getElementById('idpendkursus_head').value;
        
        var form_data = new FormData();
        form_data.append('idlevel', idlevel_head);
        form_data.append('idpendkursus', idpendkursus_head);
        form_data.append('mode', 'kembali');
        
        $.ajax({
            url: "<?php echo base_url(); ?>level/backnext",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                if(data.status === "ok"){
                    window.location.href = "<?php echo base_url(); ?>level/parameternilai/" + data.idpendkursus + "/" + data.idlevel;
                }else{
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });    
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function lanjut(){
        var idlevel_head = document.getElementById('idlevel_head').value;
        var idpendkursus_head = document.getElementById('idpendkursus_head').value;
        
        var form_data = new FormData();
        form_data.append('idlevel', idlevel_head);
        form_data.append('idpendkursus', idpendkursus_head);
        form_data.append('mode', 'lanjut');
        
        $.ajax({
            url: "<?php echo base_url(); ?>level/backnext",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                if(data.status === "ok"){
                    window.location.href = "<?php echo base_url(); ?>level/parameternilai/" + data.idpendkursus + "/" + data.idlevel;
                }else{
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });    
                }
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
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
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>level/detillevel/<?php echo $idkursus_enkrip; ?>">Level <?php echo $head1->nama_kursus; ?></a>
            </li>
            <li class="breadcrumb-item active">Parameter Penilaian</li>
        </ol>
    </div>
    <div class="row">
        <input type="hidden" id="idlevel_head" name="idlevel_head" value="<?php echo $idlevel_enkrip; ?>" readonly>
        <input type="hidden" id="idpendkursus_head" name="idpendkursus_head" value="<?php echo $idkursus_enkrip; ?>" readonly>

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small"><b>Nama Kursus / Pendidikan</b></div>
                            <?php echo $head1->nama_kursus ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small"><b>Level</b></div>
                            <?php echo $head2->level ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Parameter Penilaian </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="duplikasi();">Duplikasi Data</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="kembali();"><< Back</button>
                    <button type="button" class="btn btn-info btn-sm" onclick="lanjut();">Next >></button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Parameter</th>
                                    <th>Hanya Angka</th>
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
                    <input type="hidden" id="idlevel" name="idlevel" value="<?php echo $head2->idlevel; ?>">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Parameter</label>
                            <input type="text" id="param" name="param" class="form-control" placeholder="Parameter" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Filter Input</label>
                            <select class="form-control" id="filterInput" name="filterInput">
                                <option value="0">Huruf</option>
                                <option value="1">Angka</option>
                            </select>
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

<div class="modal fade" id="modal_duplikasi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Sumber Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_duplikasi" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
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