<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>periode/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        $('#info').hide();
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Periode Kursus');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var term = document.getElementById('term').value;
        var tahun_ajaran = document.getElementById('tahun_ajaran').value;
        var tanggal = document.getElementById('tanggal').value;
        var bulan_awal = document.getElementById('bulan_awal').value;
        var tahun_awal = document.getElementById('tahun_awal').value;
        var kursus = document.getElementById('kursus').value;
        var jml_sesi = document.getElementById('jml_sesi').value;

        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>periode/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>periode/ajax_edit";
        }

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('term', term);
        form_data.append('tanggal', tanggal);
        form_data.append('bulan_awal', bulan_awal);
        form_data.append('tahun_awal', tahun_awal);
        form_data.append('kursus', kursus);
        form_data.append('jml_sesi', jml_sesi);
        form_data.append('tahun_ajaran', tahun_ajaran);
        
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
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
                
                closemodal();
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
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
                        url: "<?php echo base_url(); ?>periode/hapus/" + id,
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
        $('.modal-title').text('Ganti Periode Kursus');
        $.ajax({
            url: "<?php echo base_url(); ?>periode/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idperiode);
                $('[name="term"]').val(data.nama_term);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="bulan_awal"]').val(data.bulan_awal);
                $('[name="tahun_awal"]').val(data.tahun_awal);
                $('[name="kursus"]').val(data.idpendkursus);
                $('[name="jml_sesi"]').val(data.jml_sesi);
                $('[name="tahun_ajaran"]').val(data.tahun_ajar);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Error get data " + errorThrown);
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }


</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Periode Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Periode Kursus</li>
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
                                    <th>#</th>
                                    <th>Nama Term</th>
                                    <th>Tahun Ajar</th>
                                    <th>Start Kursus</th>
                                    <th>Kursus</th>
                                    <th>Jml Sesi</th>
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
                            <label class="form-label">Nama term</label>
                            <input type="text" id="term" name="term" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jumlah Sesi</label>
                            <input type="text" id="jml_sesi" name="jml_sesi" class="form-control" autocomplete="off" onkeypress="return hanyaAngka(event, false);">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col mb-0">
                            <label class="form-label">Start Kursus</label>
                            <select id="tanggal" name="tanggal" class="form-control">
                                <?php
                                for($i=1; $i<=30; $i++){
                                    ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label"></label>
                            <select id="bulan_awal" name="bulan_awal" class="form-control">
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                        <div class="form-group col mb-0">
                            <label class="form-label"></label>
                            <select id="tahun_awal" name="tahun_awal" class="form-control">
                                <?php
                                for ($i=$tahun_awal; $i <= $tahun_akhir ; $i++) { 
                                    if($i == $tahun){
                                        ?>
                                <option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    }else{
                                        ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    }
                                    
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" style="margin-top: 17px;">
                        <div class="form-group col">
                            <label class="form-label">Kursus</label>
                            <select id="kursus" name="kursus" class="form-control">
                                <?php
                                foreach ($kursus->getResult() as $row) {
                                    ?>
                                <option value="<?php echo $row->idpendkursus; ?>"><?php echo $row->nama_kursus; ?></option>
                                    <?php
                                }
                                ?>
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