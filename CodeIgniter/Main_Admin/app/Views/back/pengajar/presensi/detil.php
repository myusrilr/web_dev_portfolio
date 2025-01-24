<script type="text/javascript">

    var save_method, table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>presensisiswa/ajaxdetil/<?php echo $idjadwal; ?>",
            ordering:false
        });
    });
    
    function pilih(kode){
        window.location.href = "<?php echo base_url(); ?>presensisiswa/siswa/" + kode;
    }

    function pilihapk(kode){
        window.location.href = "<?php echo base_url(); ?>presensisiswa/siswaapk/" + kode;
    }

    function materi(kode, level){
        save_method = "add";
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Materi Kurikulum');
        $('#kode').val(kode);

        tb_level = $('#tb_level').DataTable({
            ajax: "<?php echo base_url(); ?>presensisiswa/ajaxlevel/"+level,
            paging : false,
            retrieve : true
        });
        tb_level.destroy();
        tb_level = $('#tb_level').DataTable({
            ajax: "<?php echo base_url(); ?>presensisiswa/ajaxlevel/"+level,
            paging : false,
            retrieve : true
        });
    }

    function materiedit(kode, level){
        save_method = 'update';
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Materi Kurikulum');
        $('#kode').val(kode);

        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/ganti/" + kode,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                tb_level = $('#tb_level').DataTable({
                    ajax: "<?php echo base_url(); ?>presensisiswa/ajaxlevel2/"+level+","+kode,
                    paging : false,
                    retrieve : true
                });
                tb_level.destroy();
                tb_level = $('#tb_level').DataTable({
                    ajax: "<?php echo base_url(); ?>presensisiswa/ajaxlevel2/"+level+","+kode,
                    paging : false,
                    retrieve : true
                });
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function preview_presensi(){
        window.location.href = "<?php echo base_url(); ?>presensisiswa/preview/<?php echo $idjadwalenkrip; ?>";
    }

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var jml = $('input[name=kodebadan]:checked').length;
        
        if (jml < 0) {
            iziToast.error({
                title: 'Stop',
                message: "Anda belum memilih kurikulum!",
                position: 'topRight'
            });

        }else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var kodebadan=[];
            $("input:checkbox[name=kodebadan]:checked").each(function(){
                kodebadan.push($(this).val());
            });

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>presensisiswa/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>presensisiswa/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('hasil', kodebadan);
            
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
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);

                }, error: function (jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Detil Jadwal Pengajaran</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>presensisiswa">Jadwal Pengajaran</a>
            </li>
            <li class="breadcrumb-item active">Detil Jadwal Pengajaran</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">
                        <b><?php echo $head->groupwa . ' - ' . $head->nama_kursus; ?></b>
                        &nbsp;&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" onclick="preview_presensi();">
                                <i class="feather icon-eye"></i> Preview Presensi
                            </button>
                        </div>
                    </h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Hari / Sesi</div>
                            <?php echo $head->hari . ' (' . $head->sesi . ')'; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Level</div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Start Kursus</div>
                            <?php echo $head->periode; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Meeting Id</div>
                            <?php echo $head->meeting_id; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive" style="padding: 0px;">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="kode" id="kode">
                <div id="container_table" class="card-datatable table-responsive">
                    <table id="tb_level" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Kompetensi</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>