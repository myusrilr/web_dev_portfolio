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
                            <label class="form-label">Nama kursus/seminar/pelatihan</label>
                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama kursus/seminar/pelatihan disini">
                            <small class="invalid-feedback">Nama kursus/seminar/pelatihan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal</label>
                            <input type="text" id="tanggal" name="tanggal" class="form-control" placeholder="Masukkan Tanggal disini">
                            <small class="invalid-feedback">Tanggal wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Lokasi</label>
                            <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Masukkan Lokasi disini">
                            <small class="invalid-feedback">Lokasi wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">No Sertifikat</label>
                            <input type="text" id="nosertifikat" name="nosertifikat" class="form-control" placeholder="Masukkan No Sertifikat disini">
                            <small class="invalid-feedback">No Sertifikat wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                            <small class="invalid-feedback" id="errordeskripsi">Deskripsi wajib diisi</small>
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
        selector: "textarea#deskripsi", theme: "modern", height: 250,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>riwayatkursus/ajaxlist/<?php echo $idkaryawan; ?>",
        });

        $('#info').hide();
        $('#errordeskripsi').hide();
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        $('#errordeskripsi').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Data Riwayat Kursus/Seminar/Pelatihan');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var idkaryawan = document.getElementById('idkaryawan').value;
        var lokasi = document.getElementById('lokasi').value;
        var nama = document.getElementById('nama').value;
        var nosertifikat = document.getElementById('nosertifikat').value;
        var tanggal = document.getElementById('tanggal').value;
        var deskripsi = tinyMCE.get('deskripsi').getContent();

        var tot = 0;
        if (lokasi === '') {
            document.getElementById('lokasi').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('lokasi').classList.remove('is-invalid'); tot += 1;} 
        if(nama === ''){
            document.getElementById('nama').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('nama').classList.remove('is-invalid'); tot += 1;}
        if(tanggal === ''){
            document.getElementById('tanggal').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('tanggal').classList.remove('is-invalid'); tot += 1;}
        if(nosertifikat === ''){
            document.getElementById('nosertifikat').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('nosertifikat').classList.remove('is-invalid'); tot += 1;}
        if(deskripsi === ''){
            $('#errordeskripsi').show();
        }else{$('#errordeskripsi').hide(); tot += 1;}
        
        if(tot === 5){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>riwayatkursus/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>riwayatkursus/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idkaryawan', idkaryawan);
            form_data.append('lokasi', lokasi);
            form_data.append('nosertifikat', nosertifikat);
            form_data.append('nama', nama);
            form_data.append('tanggal', tanggal);
            form_data.append('deskripsi', deskripsi);
            
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
                        $('[name="lokasi"]').val("");
                        $('[name="tanggal"]').val("");
                        $('[name="nama"]').val("");
                        $('[name="nosertifikat"]').val("");
                        tinyMCE.get('deskripsi').setContent("");
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
            text:  "menghapus Data tanggal " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>riwayatkursus/hapus/" + id,
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
        $('.modal-title').text('Ganti Data Riwayat Kursus/Seminar/Pelatihan');
        $.ajax({
            url: "<?php echo base_url(); ?>riwayatkursus/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idkursus);
                $('[name="lokasi"]').val(data.lokasi);
                $('[name="nama"]').val(data.nama);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="nosertifikat"]').val(data.nosertifikat);
                tinyMCE.get('deskripsi').setContent(data.deskripsi);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>