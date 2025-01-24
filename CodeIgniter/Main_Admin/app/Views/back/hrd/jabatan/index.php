<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>jabatan/ajaxlist"
        });

        $('#kat').hide();
        $('#info').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#kat').hide();$('#info').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Jabatan');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var jabatan = document.getElementById('jabatan').value;
        var iddivisi = document.getElementById('iddivisi').value;
        var induk = document.getElementById('induk').value;
        
        var tot = 0;
        if (jabatan === '') {
            document.getElementById('jabatan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('jabatan').classList.remove('is-invalid'); tot += 1;} 
        if(iddivisi === ''){
            $('#kat').show();
        }else{$('#kat').hide(); tot += 1;}
        
        if(tot === 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>jabatan/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>jabatan/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('jabatan', jabatan);
            form_data.append('iddivisi', iddivisi);
            form_data.append('induk', induk);
            
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
                        $('#info').show();
                        $('#info').text('Berhasil menyimpan data!');
                        $('[name="jabatan"]').val("");
                    }else{
                        $('#info').show();
                        $('#info').text('Berhasil memperbarui data!');
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
                        url: "<?php echo base_url(); ?>jabatan/hapus/" + id,
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

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Jabatan');
        $.ajax({
            url: "<?php echo base_url(); ?>jabatan/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idjabatan);
                $('[name="iddivisi"]').val(data.iddivisi);
                $('[name="jabatan"]').val(data.jabatan);
                pilih_jabatan_edit(data.induk);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function pilih_jabatan(){
        var iddivisi = document.getElementById('iddivisi').value;
        $.ajax({
            url: "<?php echo base_url(); ?>jabatan/getJabatan/" + iddivisi,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#induk').html(data.hasil);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function pilih_jabatan_edit(induk){
        var iddivisi = document.getElementById('iddivisi').value;
        $.ajax({
            url: "<?php echo base_url(); ?>jabatan/getJabatan/" + iddivisi,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('#induk').html(data.hasil);
                $('[name="induk"]').val(induk);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function treeview(){
        window.location.href = "<?php echo base_url(); ?>jabatan/treeview";
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jabatan</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Jabatan</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="treeview();"><i class="fas fa-tree"></i> Tree View </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Divisi</th>
                                    <th>Jabatan</th>
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
                            <label class="form-label">Divisi</label>
                            <select class="custom-select" id="iddivisi" name="iddivisi" onchange="pilih_jabatan();">
                                <option value="" disabled selected>Pilih divisi</option>
                                <?php
                                foreach($divisi->getResult() as $row) {?>
                                <option value="<?php echo $row->iddivisi; ?>"><?php echo $row->nama; ?></option>
                                <?php }?>
                            </select>
                            <small id="kat" style="color:red;">Divisi wajib dipilih</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Induk Jabatan (Optional)</label>
                            <select class="custom-select" id="induk" name="induk">
                                <option value="" selected>Pilih induk jabatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Masukkan jabatan" >
                            <small class="invalid-feedback">Jabatan wajib diisi</small>
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