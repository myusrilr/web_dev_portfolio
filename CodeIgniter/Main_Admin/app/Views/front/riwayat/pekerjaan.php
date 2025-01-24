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
                                    <th>Detail</th>
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
                            <label class="form-label">Nama Perusahaan</label>
                            <input type="text" id="namaperusahaan" name="namaperusahaan" class="form-control" placeholder="Masukkan Nama Perusahaa disini">
                            <small class="invalid-feedback">Nama Perusahaan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Periode</label>
                            <input type="text" id="periode" name="periode" class="form-control" placeholder="Masukkan Periode disini">
                            <small class="invalid-feedback">Periode wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Masukkan Jabatan disini">
                            <small class="invalid-feedback">Jabatan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jobdesk</label>
                            <textarea class="form-control" id="jobdesk" name="jobdesk"></textarea>
                            <small class="invalid-feedback" id="errorjobdesk">Jobdesk wajib diisi</small>
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

    tinymce.init({
        selector: "textarea#jobdesk", theme: "modern", height: 250,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>riwayatpekerjaan/ajaxlist/<?php echo $idkaryawan; ?>",
        });

        $('#info').hide();
        $('#errorjobdesk').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        $('#errorjobdesk').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Data Riwayat Pekerjaan');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var idkaryawan = document.getElementById('idkaryawan').value;
        var periode = document.getElementById('periode').value;
        var namaperusahaan = document.getElementById('namaperusahaan').value;
        var jabatan = document.getElementById('jabatan').value;
        var jobdesk = tinyMCE.get('jobdesk').getContent();

        var tot = 0;
        if (periode === '') {
            document.getElementById('periode').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('periode').classList.remove('is-invalid'); tot += 1;} 
        if(namaperusahaan === ''){
            document.getElementById('namaperusahaan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('namaperusahaan').classList.remove('is-invalid'); tot += 1;}
        if(jabatan === ''){
            document.getElementById('jabatan').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('jabatan').classList.remove('is-invalid'); tot += 1;}
        if(jobdesk === ''){
            $('#errorjobdesk').show();
        }else{$('#errorjobdesk').hide(); tot += 1;}
        
        if(tot === 4){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>riwayatpekerjaan/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>riwayatpekerjaan/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idkaryawan', idkaryawan);
            form_data.append('periode', periode);
            form_data.append('namaperusahaan', namaperusahaan);
            form_data.append('jabatan', jabatan);
            form_data.append('jobdesk', jobdesk);
            
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
                        $('[name="periode"]').val("");
                        $('[name="jabatan"]').val("");
                        $('[name="namaperusahaan"]').val("");
                        $('[name="jobdesk"]').val("");
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
            text:  "menghapus Data jabatan " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>riwayatpekerjaan/hapus/" + id,
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
        $('.modal-title').text('Ganti Data jabatan');
        $.ajax({
            url: "<?php echo base_url(); ?>riwayatpekerjaan/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idpekerjaan);
                $('[name="periode"]').val(data.periode);
                $('[name="namaperusahaan"]').val(data.namaperusahaan);
                $('[name="jabatan"]').val(data.jabatan);
                tinyMCE.get('jobdesk').setContent(data.jobdesk);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>