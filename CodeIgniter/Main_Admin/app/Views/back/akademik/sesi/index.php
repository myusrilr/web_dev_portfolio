<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>sesi/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Sesi');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var nama_sesi = document.getElementById('nama_sesi').value;
        var waktu_awal = document.getElementById('waktu_awal').value;
        var waktu_akhir = document.getElementById('waktu_akhir').value;

        if (nama_sesi === '') {
            iziToast.error({
                title: 'Error',
                message: "Nama sesi tidak boleh kosong",
                position: 'topRight'
            });
        }else if (waktu_awal === '') {
            iziToast.error({
                title: 'Error',
                message: "Waktu awal tidak boleh kosong",
                position: 'topRight'
            });
        }else if (waktu_akhir === '') {
            iziToast.error({
                title: 'Error',
                message: "Waktu akhir tidak boleh kosong",
                position: 'topRight'
            });
        }else{
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>sesi/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>sesi/ajax_edit";
            }
        
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('nama_sesi', nama_sesi);
            form_data.append('waktu_awal', waktu_awal);
            form_data.append('waktu_akhir', waktu_akhir);
            
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
                        message: "Error json " + errorThrown,
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
                        url: "<?php echo base_url(); ?>sesi/hapus/" + id,
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
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Sesi');
        $.ajax({
            url: "<?php echo base_url(); ?>sesi/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsesi);
                $('[name="nama_sesi"]').val(data.nama_sesi);
                $('[name="waktu_awal"]').val(data.waktu1);
                $('[name="waktu_akhir"]').val(data.waktu2);
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Sesi Jadwal</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Sesi Jadwal</li>
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
                                    <th>Nama Sesi</th>
                                    <th>Waktu</th>
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
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama Sesi</label>
                            <input type="text" id="nama_sesi" name="nama_sesi" class="form-control" placeholder="Nama sesi" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Waktu Awal</label>
                            <input type="time" id="waktu_awal" name="waktu_awal" class="form-control" placeholder="Waktu Awal" autocomplete="off" value="<?php echo $curtime; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Waktu Akhir</label>
                            <input type="time" id="waktu_akhir" name="waktu_akhir" class="form-control" placeholder="Waktu Awal" autocomplete="off" value="<?php echo $curtime; ?>">
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