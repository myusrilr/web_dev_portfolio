<script type="text/javascript">

    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxcatatansiswa/<?php echo $head->idjadwal; ?>"
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function followUp(idjadwaldetil, idsiswa){
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('[name="idjadwaldetil"]').val(idjadwaldetil);
        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/showfollowup/" + idjadwaldetil + "/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idcs_follow_up);
                $('[name="idsiswa"]').val(data.idsiswa);
                $('[name="kesimpulan"]').val(data.kesimpulan);
                $('[name="status"]').val(data.status_follow);
            }, error: function (jqXHR, textStatus, errorThrown) {
                swal("Error get data " + errorThrown);
            }
        });
    }

    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function save(){
        var kode = document.getElementById('kode').value;
        var idjadwaldetil = document.getElementById('idjadwaldetil').value;
        var idsiswa = document.getElementById('idsiswa').value;
        var kesimpulan = document.getElementById('kesimpulan').value;
        var status = document.getElementById('status').value;

        if(kesimpulan === ""){
            iziToast.error({
                title: 'Error',
                message: "Kesimpulan tidak boleh kosong",
                position: 'topRight'
            });
        }else if(status === ""){
            iziToast.error({
                title: 'Error',
                message: "Status follow up tidak boleh kosong",
                position: 'topRight'
            });
        }else{

            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idjadwaldetil', idjadwaldetil);
            form_data.append('idsiswa', idsiswa);
            form_data.append('kesimpulan', kesimpulan);
            form_data.append('status', status);
            
            $.ajax({
                url: "<?php echo base_url(); ?>laporanpengajaran/prosesfollow",
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
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Catatan Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporanpengajaran">Jadwal Pengajaran</a></li>
            <li class="breadcrumb-item active">Daftar List Siswa</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Tahun Ajar</b></div>
                            <?php echo $head->tahun_ajar; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Kursus</b></div>
                            <?php echo $head->kursus; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Rombel</b></div>
                            <?php echo $head->groupwa; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Hari</b></div>
                            <?php echo $head->hari; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Level</b></div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Mode Belajar / Tempat</b></div>
                            <?php echo $head->mode_belajar.' '.$head->tempat; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-0">
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Detail</th>
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
                <h5>Follow Up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <input type="hidden" id="idjadwaldetil" name="idjadwaldetil">
                    <input type="hidden" id="idsiswa" name="idsiswa">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Kesimpulan</label>
                            <textarea class="form-control" id="kesimpulan" name="kesimpulan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="">- PILIH STATUS -</option>    
                                <option value="NEED FURTHER OBSERVATION">NEED FURTHER OBSERVATION</option>
                                <option value="CASE CLOSED">CASE CLOSED</option>
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