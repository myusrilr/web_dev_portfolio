<script type="text/javascript">

    var tb, tb_tanggal;
    
    $(document).ready(function () {
        console.log("<?php echo base_url(); ?>presensisiswa/ajaxlistkomp/<?php echo $head->idjadwal.'/'.$subhead->idjadwaldetil; ?>");
        tb = $('#tb').DataTable({
            ajax : "<?php echo base_url(); ?>presensisiswa/ajaxlistkomp/<?php echo $head->idjadwal.'/'.$subhead->idjadwaldetil; ?>",
            ordering : false,
            paging : false,
            searching : false
        });
    });
    
    function reload(){
        tb.ajax.reload(null, false);
    }
    
    function absenkur(idsiswa, idjadwal, idkur_kel){
        var nilai = "tidak";
        if(document.getElementById(idsiswa).checked){
            nilai = "ya";
        }
        
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;

        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal);
        form_data.append('idsiswa', idsiswa);
        form_data.append('nilai', nilai);
        form_data.append('idjadwaldetil', idjadwaldetil);
        form_data.append('idkur_kel', idkur_kel);

        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/prosespresensikur",
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

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function save(){
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        var catatan = document.getElementById('catatan').value;
        
        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal);
        form_data.append('catatan', catatan);
        form_data.append('idjadwaldetil', idjadwaldetil);

        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/proses_catatan",
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

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function mundur(){
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        
        var form_data = new FormData();
        form_data.append('mode', "mundur");
        form_data.append('idjadwaldetil', idjadwaldetil);
        form_data.append('idjadwal', idjadwal);
        
        
        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/proses_maju_mundur",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                console.log(data.status);
                if(data.status === "ok"){
                    window.location.href = data.link;
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
    
    function maju(){
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        
        var form_data = new FormData();
        form_data.append('mode', "maju");
        form_data.append('idjadwaldetil', idjadwaldetil);
        form_data.append('idjadwal', idjadwal);
        
        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/proses_maju_mundur",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                console.log(data.status);
                if(data.status === "ok"){
                    window.location.href = data.link;
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
    
    function catatan(idsiswa, nama){
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Catatan ' + nama);
        $('#id_siswa_for_catatan').val(idsiswa)
        
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        
        var form_data = new FormData();
        form_data.append('idsiswa', idsiswa);
        form_data.append('idjadwal', idjadwal);
        form_data.append('idjadwaldetil', idjadwaldetil);
        
        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/showcatatansiswa",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                $('#catatan_siswa').val(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
    function closemodal_catatan(){
        $('#modal_form').modal('hide');
    }
    
    function save_catatan(){
        var idsiswa = document.getElementById('id_siswa_for_catatan').value;
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        var catatan = document.getElementById('catatan_siswa').value;
        
        $('#btnSaveCatatan').text('Menyimpan...'); //change button text
        $('#btnSaveCatatan').attr('disabled', true); //set button disable 

        var form_data = new FormData();
        form_data.append('idsiswa', idsiswa);
        form_data.append('idjadwal', idjadwal);
        form_data.append('idjadwaldetil', idjadwaldetil);
        form_data.append('catatan', catatan);

        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/prosescatatan",
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
                
                $('#btnSaveCatatan').text('Simpan');
                $('#btnSaveCatatan').attr('disabled', false);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });

                $('#btnSaveCatatan').text('Simpan');
                $('#btnSaveCatatan').attr('disabled', false);
            }
        });
    }
    
    function loncattgl(){
        $('#modal_list_tgl').modal('show');
        tb_tanggal = $('#tb_tanggal').DataTable({
            ajax : "<?php echo base_url(); ?>presensisiswa/ajaxtgl/<?php echo $head->idjadwal; ?>",
            ordering : false,
            retrieve:true
        });
        tb_tanggal.destroy();
        tb_tanggal = $('#tb_tanggal').DataTable({
            ajax : "<?php echo base_url(); ?>presensisiswa/ajaxtgl/<?php echo $head->idjadwal; ?>",
            ordering : false,
            retrieve:true
        });
    }
    
    function jumpto(kode){
        window.location.href = "<?php echo base_url(); ?>presensisiswa/siswa/" + kode;
    }

    function pilihsemua(){
        var idjadwal = document.getElementById('idjadwal').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        
        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal);
        form_data.append('idjadwaldetil', idjadwaldetil);
        
        $.ajax({
            url: "<?php echo base_url(); ?>presensisiswa/checkall",
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

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Presensi Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>presensisiswa">Jadwal Pengajaran</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>presensisiswa/detil/<?php echo $idjadwalenkrip; ?>">Detil Jadwal Pengajaran</a>
            </li>
            <li class="breadcrumb-item active">Presensi Siswa</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">
                        <b><?php echo $head->groupwa . ' - ' . $head->kursus; ?></b>
                        &nbsp;&nbsp;&nbsp;
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info btn-fw" onclick="mundur();">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-info btn-fw" onclick="loncattgl();">
                                <i class="fas fa-calendar-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-info btn-fw" onclick="maju();">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Hari / Sesi</div>
                            <?php echo $head->hari . ' (' . $head->sesi . ')'; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small">Level</div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small">Start Kursus</div>
                            <?php echo $head->periode; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small">Meeting Id</div>
                            <?php echo $head->meeting_id; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Tanggal</div>
                            <?php echo $ptm.' ('.$subhead->tglawal.')'; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <h6 class="card-header">Catatan Kelas</h6>
                        <div class="card-body">
                            <input type="hidden" id="idjadwal" value="<?php echo $head->idjadwal; ?>">
                            <input type="hidden" id="idjadwaldetil" value="<?php echo $subhead->idjadwaldetil; ?>">
                            <textarea id="catatan" class="form-control" rows="5"><?php echo $catatan; ?></textarea>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-primary" onclick="save();">Simpan Catatan</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <h6 class="card-header">Data Siswa</h6>
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-success" onclick="pilihsemua()">Check All</button>
                            <div class="table-responsive">
                                <table id="tb" class="datatables-demo table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%">Kompetensi</th>
                                            <?php foreach($siswa->getResult() as $row){ ?>
                                            <th width="15%"><?php echo $row->nama_lengkap; ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <?php foreach($siswa->getResult() as $row){ ?>
                                            <td><?php echo '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">'
                                            . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="catatan('."'".$row->idsiswa."'".','."'".$row->nama_lengkap."'".')">Catatan Siswa</button>'
                                            . '</div></div>' ?></td>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
                    <input type="hidden" id="kode_catatan" name="kode_catatan" readonly>
                    <input type="hidden" id="id_siswa_for_catatan" name="id_siswa_for_catatan" readonly>
                    
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan</label>
                            <textarea id="catatan_siswa" name="catatan_siswa" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal_catatan();">Tutup</button>
                <button id="btnSaveCatatan" type="button" class="btn btn-primary" onclick="save_catatan();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_list_tgl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Jadwal Kursus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tb_tanggal" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
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