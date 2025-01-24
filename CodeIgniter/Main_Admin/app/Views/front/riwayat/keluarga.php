    <div class="col">
        <!-- Messages list -->
        <div class="card">
            <hr class="border-light m-0">
            <div class="card-header">
                <button type="button" class="btn btn-info btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Hubungan</th>
                                    <th>Nama Lengkap</th>
                                    <th>Pekerjaan</th>
                                    <th>No hp</th>
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
        <!-- / Messages list -->

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
                    <input type="hidden" id="idkaryawan" name="idkaryawan" value="<?php echo $idusers; ?>">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" id="namalengkap" name="namalengkap" class="form-control" placeholder="Masukkan Nama Lengkap disini">
                            <small class="invalid-feedback">Nama Lengkap wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Hubungan</label>
                            <input type="text" id="hubungan" name="hubungan" class="form-control" placeholder="Masukkan Hubungan disini">
                            <small class="invalid-feedback">Hubungan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" placeholder="Masukkan Pekerjaan disini">
                            <small class="invalid-feedback">Pekerjaan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">No hp</label>
                            <input type="text" id="hp" name="hp" class="form-control" placeholder="081xxx" placeholder="Masukkan No hp disini">
                            <small class="invalid-feedback">No hp wajib diisi</small>
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
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>riwayatkeluarga/ajaxlist/<?php echo $idkaryawan; ?>",
        });

        $('#info').hide();
        $('#ket').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        $('#ket').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Data ');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var idkaryawan = document.getElementById('idkaryawan').value;
        var hubungan = document.getElementById('hubungan').value;
        var namalengkap = document.getElementById('namalengkap').value;
        var pekerjaan = document.getElementById('pekerjaan').value;
        var hp = document.getElementById('hp').value;

        var tot = 0;
        if (hubungan === '') {
            document.getElementById('hubungan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('hubungan').classList.remove('is-invalid'); tot += 1;} 
        if(namalengkap === ''){
            document.getElementById('namalengkap').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('namalengkap').classList.remove('is-invalid'); tot += 1;}
        if(pekerjaan === ''){
            document.getElementById('pekerjaan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('pekerjaan').classList.remove('is-invalid'); tot += 1;}
        if(hp === ''){
            document.getElementById('hp').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('hp').classList.remove('is-invalid'); tot += 1;}
        
        if(tot === 4){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>riwayatkeluarga/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>riwayatkeluarga/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idkaryawan', idkaryawan);
            form_data.append('hubungan', hubungan);
            form_data.append('namalengkap', namalengkap);
            form_data.append('pekerjaan', pekerjaan);
            form_data.append('hp', hp);
            
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
                        $('[name="hubungan"]').val("");
                        $('[name="pekerjaan"]').val("");
                        $('[name="namalengkap"]').val("");
                        $('[name="hp"]').val("");
                    }else{
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
            text:  "menghapus Data keluarga " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>riwayatkeluarga/hapus/" + id,
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
                    swal("Berhasil dibatalkan.");
                }
        });
    }

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti Data Keluarga');
        $.ajax({
            url: "<?php echo base_url(); ?>riwayatkeluarga/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idkeluarga);
                $('[name="hubungan"]').val(data.hubungan);
                $('[name="namalengkap"]').val(data.namalengkap);
                $('[name="pekerjaan"]').val(data.pekerjaan);
                $('[name="hp"]').val(data.hp);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>