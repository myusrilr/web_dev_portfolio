<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">

    var tb, mode;

    $(document).ready(function () {
        tb = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxlist"
        });
    });

    function filter() {
        mode = "all";
        var tgl1 = document.getElementById('tanggal1').value;
        var tgl2 = document.getElementById('tanggal2').value;
        var tags = document.getElementById('tags').value;

        if(tgl2 < tgl1){
            alert('Tanggal mulai harus kurang dari tanggal selesai!');
        }else{
            if(tgl1 != '' && tags == ''){
                mode = "tgl";
                tb.destroy();
                tb = $('#tb').DataTable({
                    ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxparam/" +mode+":"+tgl1+":"+tgl2,
                    retrieve: true
                });
            }else if(tgl1 == '' && tags != ''){
                mode = "tag";
                tb.destroy();
                tb = $('#tb').DataTable({
                    ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxparam/" +mode+":"+tags,
                    retrieve: true
                });
            }else if(tgl1 != '' && tags != ''){
                mode = "filter";
                tb.destroy();
                tb = $('#tb').DataTable({
                    ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxparam/" +mode+":"+tags+":"+tgl1+":"+tgl2,
                    retrieve: true
                });
            }else{
                alert("Tidak ada filter!");
            }
        }
    }

    function batalkan(){
        location.reload();
    }

    function reload(){
        tb.ajax.reload(null, false);
    }

    function catatansiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporanpengajaran/catatansiswa/" + kode;
    }

    function raporsiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporanpengajaran/raporsiswa/" + kode;
    }
    
    function catatankelas(kode){
        window.location.href = "<?php echo base_url(); ?>laporanpengajaran/catatankelas/" + kode;
    }

    function komentar(idcatatan){
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('[name="kode"]').val(idcatatan);
        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/showcatatankelas/" + idcatatan,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idcatatan_kelas);
                $('[name="catatan"]').val(data.catatan);
                $('[name="materi_diskusi"]').val(data.materi_diskusi);
                $('[name="hasil_konfirmasi"]').val(data.hasil_konfirmasi);
                $(".select2-demo").select2().val(data.tags).trigger('change.select2');
                $('.select2-demo').select2({
                    dropdownParent: $('#modal_form'),
                });
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
        var materi_diskusi = document.getElementById('materi_diskusi').value;
        var hasil_konfirmasi = document.getElementById('hasil_konfirmasi').value;
        var tag = $('.select2-demo').val();

        if(materi_diskusi === ""){
            iziToast.error({
                title: 'Error',
                message: "materi diskusi tidak boleh kosong",
                position: 'topRight'
            });
        }else if(hasil_konfirmasi === ""){
            iziToast.error({
                title: 'Error',
                message: "Hasil konfirmasi tidak boleh kosong",
                position: 'topRight'
            });
        }else{

            $('#btnSave').text('Menyimpan...');
            $('#btnSave').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('tag', tag);
            form_data.append('materi_diskusi', materi_diskusi);
            form_data.append('hasil_konfirmasi', hasil_konfirmasi);
            
            $.ajax({
                url: "<?php echo base_url(); ?>laporanpengajaran/proseskomentarcatatan",
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
                    closemodal();

                    $('#btnSave').text('Simpan');
                    $('#btnSave').attr('disabled', false);
                    
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

    // Select2
    $(function() {
        $('.select2-demo').select2({
            dropdownParent: $('#modal_form'),
        });
    });

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Pengajaran</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Laporan Pengajaran</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <input type="date" id="tanggal1" name="tanggal1" class="form-control">
                        </div>
                        <div class="col-3">
                            <input type="date" id="tanggal2" name="tanggal2"class="form-control">
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="tags" name="tags">
                                <option value="" selected>--Pilih Tag Materi Diskusi--</option>
                                <?php foreach($tags->getResult() as $row){ ?>
                                <option value="<?php echo $row->idtagmd; ?>"><?php echo $row->tag; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-warning btn-sm" onclick="filter();" style="width: 60%; background-color: #4CAF50;">Filter</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="batalkan();">Batalkan</button>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="80%">Kelas</th>
                                    <th width="10%">Detail Kelas</th>
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
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Materi Diskusi</label>
                            <textarea class="form-control" id="materi_diskusi" name="materi_diskusi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tag Materi Diskusi</label>
                        <select class="select2-demo form-control" multiple style="width: 100%;  z-index:100000;" name="tag[]">
                            <?php foreach($tags->getResult() as $row){ ?>
                            <option value="<?php echo $row->idtagmd; ?>"><?php echo $row->tag; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Hasil Konfirmasi</label>
                            <textarea class="form-control" id="hasil_konfirmasi" name="hasil_konfirmasi" rows="3"></textarea>
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