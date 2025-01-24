<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>jamkerja/ajaxlist"
        });

        $('#info').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Jam Kerja');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var namajamkerja = document.getElementById('namajamkerja').value;
        var jammasuk = document.getElementById('Time1').value;
        var jampulang = document.getElementById('Time2').value;

        var tot = 0;
        if (namajamkerja === '') {
            document.getElementById('namajamkerja').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('namajamkerja').classList.remove('is-invalid'); tot += 1;} 
        if (jammasuk === '') {
            document.getElementById('Time1').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('Time1').classList.remove('is-invalid'); tot += 1;} 
        if (jampulang === '') {
            document.getElementById('Time2').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('Time2').classList.remove('is-invalid'); tot += 1;} 
        
        if(tot === 3){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>jamkerja/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>jamkerja/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('namajamkerja', namajamkerja);
            form_data.append('jammasuk', jammasuk);
            form_data.append('jampulang', jampulang);
            
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
                        $('[name="namajamkerja"]').val("");
                        $('[name="Time1"]').val("");
                        $('[name="Time2"]').val("");
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
            text:  "menghapus Jam Kerja " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>jamkerja/hapus/" + id,
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
        $('.modal-title').text('Ganti Jam Kerja');
        $.ajax({
            url: "<?php echo base_url(); ?>jamkerja/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idjamkerja);
                $('[name="namajamkerja"]').val(data.namajamkerja);
                $('[name="Time1"]').val(data.jammasuk);
                $('[name="Time2"]').val(data.jampulang);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jam Kerja</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Jam Kerja</li>
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
                                    <th>Grup Jam Kerja</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th style="text-align: center;" width="10%">Aksi</th>
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
                <div class="row">
                    <input type="hidden" id="kode" name="kode">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Grup Jam Kerja</label>
                            <input type="text" id="namajamkerja" name="namajamkerja" class="form-control" placeholder="Masukkan Grup Jam Kerja" >
                            <small class="invalid-feedback">Grup Jam Kerja wajib diisi</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group fill">
                            <label class="floating-label" for="Time1">Jam Masuk</label>
                            <input type="time" class="form-control" id="Time1" name="Time1" placeholder="123">
                            <small class="invalid-feedback">Jam Masuk wajib diisi</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group fill">
                            <label class="floating-label" for="Time2">Jam Pulang</label>
                            <input type="time" class="form-control" id="Time2" name="Time2" placeholder="123">
                            <small class="invalid-feedback">Jam Pulang wajib diisi</small>
                        </div>
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