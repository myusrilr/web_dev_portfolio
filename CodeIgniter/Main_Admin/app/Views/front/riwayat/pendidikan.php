    <div class="col">
        <!-- Messages list -->
        <div class="card">
            <hr class="border-light m-0">
            <div class="card-header">
                <button type="button" class="btn btn-info btn-sm" onclick="addpendidikan();"><i class="fas fa-plus"></i> Tambah Data</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="card-datatable table-responsive">
                        <table id="tbpendidikan" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Sekolah / Kampus</th>
                                    <th>Pengalaman Organisasi</th>
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

<div class="modal fade" id="modal_pendidikan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="infopendidikan">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="formpendidikan">
                    <input type="hidden" id="kodependidikan" name="kodependidikan">
                    <input type="hidden" id="idkaryawan" name="idkaryawan" value="<?php echo $idusers; ?>">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Sekolah / Kampus</label>
                            <input type="text" id="sekolah" name="sekolah" class="form-control" placeholder="Masukkan Sekolah / Kampus disini">
                            <small class="invalid-feedback">Sekolah / Kampus wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jenjang</label>
                            <select class="custom-select" id="jenjang" name="jenjang">
                                <option value="" disabled selected>Pilih Jenjang Pendidikan</option>
                                <option value="TK">TK</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Akademi D1">Akademi D1</option>
                                <option value="Akademi D2">Akademi D2</option>
                                <option value="Akademi D3">Akademi D3</option>
                                <option value="Universitas (S1)">Universitas (S1)</option>
                                <option value="Pasca Sarjana (S2)">Pasca Sarjana (S2)</option>
                                <option value="Doktoral">Doktoral</option>
                            </select>
                            <small class="invalid-feedback" id="ket">Jenjang wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Prodi / Jurusan</label>
                            <input type="text" id="prodi" name="prodi" class="form-control" placeholder="Masukkan Prodi / Jurusan disini">
                            <small class="invalid-feedback">Prodi / Jurusan wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tahun Masuk - Lulus</label>
                            <input type="text" id="tahun" name="tahun" class="form-control" placeholder="Contoh : 2017-2021">
                            <small class="invalid-feedback">Tahun wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">IPK</label>
                            <input type="text" id="ipk" name="ipk" class="form-control" placeholder="Masukkan IPK disini">
                            <small class="invalid-feedback">IPK wajib diisi</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Pengalaman Organisasi</label>
                            <textarea id="organisasi" name="organisasi" class="form-control" row="3" placeholder="Masukkan Pengalaman Organisasi disini"></textarea>
                            <small class="invalid-feedback" id="errorog">Pengalaman Organisasi wajib diisi</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closependidikan();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="savependidikan();">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        tablependidikan = $('#tbpendidikan').DataTable({
            ajax: "<?php echo base_url(); ?>riwayatpendidikan/ajaxlist/<?php echo $idkaryawan; ?>",
        });

        $('#infopendidikan').hide();
        $('#ket').hide();
    });

    function reload() {
        tablependidikan.ajax.reload(null, false); //reload datatable ajax
    }

    function addpendidikan() {
        $('#infopendidikan').hide();
        $('#ket').hide();
        save_method = 'add';
        $('#formpendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
        $('.modal-title').text('Tambah Data Pendidikan');
    }

    function savependidikan() {
        var kodependidikan = document.getElementById('kodependidikan').value;
        var idkaryawan = document.getElementById('idkaryawan').value;
        var sekolah = document.getElementById('sekolah').value;
        var jenjang = document.getElementById('jenjang').value;
        var prodi = document.getElementById('prodi').value;
        var tahun = document.getElementById('tahun').value;
        var ipk = document.getElementById('ipk').value;
        var organisasi = document.getElementById('organisasi').value;

        var tot = 0;
        if (sekolah === '') {
            document.getElementById('sekolah').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('sekolah').classList.remove('is-invalid'); tot += 1;} 
        if(prodi === ''){
            document.getElementById('prodi').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('prodi').classList.remove('is-invalid'); tot += 1;}
        if(tahun === ''){
            document.getElementById('tahun').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('tahun').classList.remove('is-invalid'); tot += 1;}
        if(ipk === ''){
            document.getElementById('ipk').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('ipk').classList.remove('is-invalid'); tot += 1;}
        if(jenjang === ''){
            $('#ket').show();
        }else{$('#ket').hide(); tot += 1;}
        
        if(tot === 5){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>riwayatpendidikan/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>riwayatpendidikan/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kodependidikan', kodependidikan);
            form_data.append('idkaryawan', idkaryawan);
            form_data.append('organisasi', organisasi);
            form_data.append('sekolah', sekolah);
            form_data.append('jenjang', jenjang);
            form_data.append('ipk', ipk);
            form_data.append('tahun', tahun);
            form_data.append('prodi', prodi);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    $('#infopendidikan').show();
                    if(data.status == "simpan"){
                        $('#infopendidikan').text('Berhasil menyimpan data!');
                        $('[name="sekolah"]').val("");
                        $('[name="tahun"]').val("");
                        $('[name="ipk"]').val("");
                        $('[name="prodi"]').val("");
                        $('[name="organisasi"]').val("");
                    }else{
                        $('#infopendidikan').text('Berhasil memperbarui data!');
                        window.setTimeout(function () {
                            $('#modal_pendidikan').modal('hide');
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
            text:  "menghapus Data pendidikan sekolah / kampus " + nama + " ini?",
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
                        url: "<?php echo base_url(); ?>riwayatpendidikan/hapus/" + id,
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
        $('#formpendidikan')[0].reset();
        $('#modal_pendidikan').modal('show');
        $('.modal-title').text('Ganti Data Pendidikan');
        $.ajax({
            url: "<?php echo base_url(); ?>riwayatpendidikan/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kodependidikan"]').val(data.idpendidikan);
                $('[name="jenjang"]').val(data.jenjang);
                $('[name="sekolah"]').val(data.sekolah);
                $('[name="tahun"]').val(data.tahun);
                $('[name="ipk"]').val(data.ipk);
                $('[name="prodi"]').val(data.prodi);
                $('[name="organisasi"]').val(data.organisasi);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closependidikan(){
        $('#modal_pendidikan').modal('hide');
    }


</script>