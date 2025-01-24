<script type="text/javascript">

    var tb, tblevel, tb_zoom;

    $(document).ready(function () {
        tb = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxsiswa/<?php echo $head->idjadwal; ?>",
            paging: false
        });
    });

    function reload() {
        tb.ajax.reload(null, false);
    }

    function checkAll(ele) {
       var checkboxes = document.getElementsByName('siswa[]');
       if (ele.checked) {
           for (var i = 0; i < checkboxes.length; i++) {
               if (checkboxes[i].type == 'checkbox' ) {
                   checkboxes[i].checked = true;
               }
           }
       } else {
           for (var i = 0; i < checkboxes.length; i++) {
               if (checkboxes[i].type == 'checkbox') {
                   checkboxes[i].checked = false;
               }
           }
       }
    }
    
    function proses_naik_level(){
        var checkboxes = document.getElementsByName('siswa[]');
        var checkboxesChecked = [];
        
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkboxesChecked.push(checkboxes[i]);
            }
        }
        
        if(checkboxesChecked.length > 0){
            var selected = Array.from(checkboxesChecked).map(x => x.value)
            $('#form_pindah')[0].reset();
            $('#modal_pindah').modal('show');
            $('[name="siswa"]').val(selected);
            loadData('<?php echo $head->idjadwal; ?>');

        }else{
            iziToast.error({
                title: 'Error',
                message: "Minimal 1 siswa terpilih",
                position: 'topRight'
            });
        }
    }

    function loadData(id){
        $.ajax({
            url: "<?php echo base_url(); ?>jadwal/showjadwal/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                document.getElementById('idzoom').value = data.idzoom;
                document.getElementById('zoom').value = data.link;
                document.getElementById('tempat').value = data.tempat;
                document.getElementById('mode_belajar').value = data.mode_belajar;
                
                // menampilkan data hari
                var strHari = data.hari;
                var dataHari = strHari.split(",");
                for(var i=0; i<dataHari.length ; i++){
                    var temp = dataHari[i].toLowerCase();
                    if(temp === "senin"){
                        document.getElementById('ckSenin').checked = true;
                    }
                    if(temp === "selasa"){
                        document.getElementById('ckSelasa').checked = true;
                    }
                    if(temp === "rabu"){
                        document.getElementById('ckRabu').checked = true;
                    }
                    if(temp === "kamis"){
                        document.getElementById('ckKamis').checked = true;
                    }
                    if(temp === "jumat"){
                        document.getElementById('ckJumat').checked = true;
                    }
                    if(temp === "sabtu"){
                        document.getElementById('ckSabtu').checked = true;
                    }
                    
                }
                
                // menampilkan data periode
                $.ajax({
                    url: "<?php echo base_url(); ?>jadwal/showperiode_edit/" + data.kursus + "/" + data.periode,
                    type: "POST",
                    dataType: "JSON",
                    success: function (data) {
                        $('#periode').html(data.status);
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        iziToast.error({
                            title: 'Error',
                            message: "Error get data " + errorThrown,
                            position: 'topRight'
                        });
                    }
                });

            }, error: function (jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function closemodal(){
        $('#modal_pindah').modal('hide');
    }

    function showlevel(){
        $('#modal_level').modal('show');
        tblevel = $('#tblevel').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_naik_level/<?php echo $head->idpendkursus.'/'.$head->idlevel; ?>",
            retrieve: true,
            ordering:false
        });
        tblevel.destroy();
        tblevel = $('#tblevel').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajax_naik_level/<?php echo $head->idpendkursus.'/'.$head->idlevel; ?>",
            retrieve: true,
            ordering:false
        });
    }

    function pilihlevel(kode, nama){
        $('[name="id_next_level"]').val(kode);
        $('[name="nama_next_level"]').val(nama);
        $('#modal_level').modal('hide');
    }

    function showzoom(){
        $('#modal_zoom').modal('show');
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
        tb_zoom.destroy();
        tb_zoom = $('#tb_zoom').DataTable({
            ajax: "<?php echo base_url(); ?>jadwal/ajaxzoom",
            retrieve : true
        });
    }

    function pilihzoom(id, link){
        $('[name="idzoom"]').val(id);
        $('[name="zoom"]').val(link);
        $('#modal_zoom').modal('hide');
    }

    function getHari(){
        var hari = "";
        if(document.getElementById('ckSenin').checked){
            hari += "Senin,";
        }
        if(document.getElementById('ckSelasa').checked){
            hari += "Selasa,";
        }
        if(document.getElementById('ckRabu').checked){
            hari += "Rabu,";
        }
        if(document.getElementById('ckKamis').checked){
            hari += "Kamis,";
        }
        if(document.getElementById('ckJumat').checked){
            hari += "Jumat,";
        }
        if(document.getElementById('ckSabtu').checked){
            hari += "Sabtu,";
        }
        
        return hari.substring(0, hari.length -1);
    }

    function save(){
        var idjadwal_lama = document.getElementById('idjadwal_lama').value;
        var idjadwal_baru = document.getElementById('idjadwal_baru').value;
        var siswa = document.getElementById('siswa').value;
        var rombel_lama = document.getElementById('rombel_lama').value;
        var rombel_baru = document.getElementById('rombel_baru').value;
        var id_next_level = document.getElementById('id_next_level').value;
        var sesi = document.getElementById('sesi').value;
        var periode = document.getElementById('periode').value;
        var hari = getHari();
        var idzoom = document.getElementById('idzoom').value;
        var zoom = document.getElementById('zoom').value;
        var mode_belajar = document.getElementById('mode_belajar').value;
        var tempat = document.getElementById('tempat').value;
        var kursus = document.getElementById('kursus').value;
        var tot_siswa = document.getElementById('tot_siswa').value;
        
        
        if (idjadwal_lama === '') {
            iziToast.error({
                title: 'Stop',
                message: "Jadwal lama tidak boleh kosong",
                position: 'topRight'
            });
        }else if (siswa === '') {
            iziToast.error({
                title: 'Stop',
                message: "Siswa tidak boleh kosong",
                position: 'topRight'
            });
        }else if (rombel_lama === '') {
            iziToast.error({
                title: 'Stop',
                message: "Rombel lama boleh kosong",
                position: 'topRight'
            });
        }else if (rombel_baru === '') {
            iziToast.error({
                title: 'Stop',
                message: "Rombel baru boleh kosong",
                position: 'topRight'
            });
        }else if(id_next_level === ""){
            iziToast.error({
                title: 'Stop',
                message: "Level baru boleh kosong",
                position: 'topRight'
            });
        }else  if (periode === '-') {
            iziToast.error({
                title: 'Stop',
                message: "Pilih periode terlebih dahulu",
                position: 'topRight'
            });
        }else if (hari === '') {
            iziToast.error({
                title: 'Stop',
                message: "Pilih minimal 1 hari",
                position: 'topRight'
            });
        }else if (id_next_level === '') {
            iziToast.error({
                title: 'Stop',
                message: "Tingkat lanjutan tidak boleh kosong",
                position: 'topRight'
            });

        }else if (idzoom === '') {
            iziToast.error({
                title: 'Stop',
                message: "Zoom link tidak boleh kosong",
                position: 'topRight'
            });

        } else {
            $('#btnSavePindah').text('Menyimpan...');
            $('#btnSavePindah').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', idjadwal_baru);
            form_data.append('idjadwal_lama', idjadwal_lama);
            form_data.append('g_wa', rombel_baru);
            form_data.append('idsesi', sesi);
            form_data.append('periode', periode);
            form_data.append('kursus', kursus);
            form_data.append('hari', hari);
            form_data.append('idlevel', id_next_level);
            form_data.append('zoom', zoom);
            form_data.append('idzoom', idzoom);
            form_data.append('mode_belajar', mode_belajar);
            form_data.append('tempat', tempat);
            form_data.append('mode_pindah', 'ya');
            form_data.append('siswa', siswa);
            form_data.append('tot_siswa', tot_siswa);

            $.ajax({
                url: "<?php echo base_url(); ?>jadwal/ajax_add_jadwal",
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
                    reload();

                    $('#modal_pindah').modal('hide');
                    $('#btnSavePindah').text('Simpan');
                    $('#btnSavePindah').attr('disabled', false);

                    if(data.status === "Data tersimpan"){
                        window.location.href = "<?php echo base_url(); ?>jadwal";
                    }

                }, error: function (jqXHR, textStatus, errorThrown) {
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSavePindah').text('Simpan');
                    $('#btnSbtnSavePindahave').attr('disabled', false);
                }
            });
        }
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jadwal Ploting Pengajar dan Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</i></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>jadwal">Jadwal Kursus</a></li>
            <li class="breadcrumb-item active">Jadwal Ploting</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold"><b><?php echo $head->groupwa . ' - ' . $head->nama_kursus; ?></b></h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Hari / Sesi</div>
                            <?php echo $head->hari . ' (' . $head->waktu_awal . ' - ' . $head->waktu_akhir . ')'; ?>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="text-muted small">Level</div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="text-muted small">Tahun Ajaran</div>
                            <?php echo $head->tahun_ajar; ?>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="text-muted small">Meeting Id</div>
                            <?php echo $head->meeting_id; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Pengajar</div>
                            <?php echo $pengajar; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-info btn-sm" onclick="proses_naik_level();"><i class="fas fa-plus"></i> Proses Naik Level </button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">#</th>
                                    <th>Nama Siswa</th>
                                    <th>Jkel</th>
                                    <th>Asal Sekolah</th>
                                    <th>Nama Ortu</th>
                                    <th style="text-align: center;"><input type="checkbox" onchange="checkAll(this)"></th>
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

<div class="modal fade" id="modal_pindah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Form Naik Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_pindah">
                    <input type="hidden" id="idjadwal_lama" name="idjadwal_lama" readonly value="<?php echo $head->idjadwal; ?>">
                    <input type="hidden" id="idjadwal_baru" name="idjadwal_baru" readonly>
                    <input type="hidden" id="tot_siswa" name="tot_siswa" readonly value="<?php echo $tot_siswa; ?>">
                    <input type="hidden" id="kursus" name="kursus" readonly value="<?php echo $head->idpendkursus; ?>">
                    
                    <input type="hidden" id="siswa" name="siswa" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Rombel Lama</label>
                            <input type="text" id="rombel_lama" name="rombel_lama" class="form-control" placeholder="Rombel Lama" autocomplete="off" readonly value="<?php echo $head->groupwa; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Rombel Baru</label>
                            <input type="text" id="rombel_baru" name="rombel_baru" class="form-control" placeholder="Rombel Baru" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Level Selanjutnya</label>
                            <div class="input-group">
                                <input type="hidden" id="id_next_level" name="id_next_level" readonly autocomplete="off">
                                <input type="text" id="nama_next_level" name="nama_next_level" class="form-control" placeholder="Level" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="showlevel();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Sesi</label>
                            <select id="sesi" name="sesi" class="form-control">
                                <option value="-">- Pilih -</option>
                                <?php
                                foreach ($sesi->getResult() as $row) {
                                    if($row->idsesi == $head->idsesi){
                                        ?>
                                <option selected value="<?php echo $row->idsesi; ?>"><?php echo $row->nama_sesi.' ('.$row->waktu_awal.' - '.$row->waktu_akhir.')'; ?></option>
                                        <?php
                                    }else{
                                        ?>
                                <option value="<?php echo $row->idsesi; ?>"><?php echo $row->nama_sesi.' ('.$row->waktu_awal.' - '.$row->waktu_akhir.')'; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Periode</label>
                            <select id="periode" name="periode" class="form-control">
                                <option value="-">- Pilih -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Hari</label>
                            <div id="hari">
                                <label class="form-check form-check-inline">
                                    <input id="ckSenin" class="form-check-input" type="checkbox" value="Senin">
                                    <span class="form-check-label">Senin</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckSelasa" class="form-check-input" type="checkbox" value="Selasa">
                                    <span class="form-check-label">Selasa</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckRabu" class="form-check-input" type="checkbox" value="Rabu">
                                    <span class="form-check-label">Rabu</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckKamis" class="form-check-input" type="checkbox" value="Kamis">
                                    <span class="form-check-label">Kamis</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckJumat" class="form-check-input" type="checkbox" value="Jumat">
                                    <span class="form-check-label">Jumat</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input id="ckSabtu" class="form-check-input" type="checkbox" value="Sabtu">
                                    <span class="form-check-label">Sabtu</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Zoom</label>
                            <div class="input-group">
                                <input type="hidden" id="idzoom" name="idzoom" readonly autocomplete="off">
                                <input type="text" id="zoom" name="zoom" class="form-control" placeholder="Zoom Meeting" readonly autocomplete="off">
                                <span class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="button" onclick="showzoom();">...</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Model Belajar</label>
                            <select id="mode_belajar" name="mode_belajar" class="form-control">
                                <option value="Offline">Offline</option>
                                <option value="Online">Online</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tempat Belajar</label>
                            <input type="text" id="tempat" name="tempat" class="form-control" placeholder="Tempat Belajar" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSavePindah" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_level">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <table id="tblevel" class="datatables-demo table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_zoom">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Zoom</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_zoom" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Meeting ID</th>
                                <th>Passcode</th>
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