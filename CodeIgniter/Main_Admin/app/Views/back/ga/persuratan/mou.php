<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>persetujuanmou/ajaxlist"
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add(id) {
        $('#info').hide();
        $('#form')[0].reset();
        $('#kode').val(id);
        $('#modal_form').modal('show');
        $('.modal-title').text('Persetujuan MoU');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var status = document.getElementById('status').value;
        var note = document.getElementById('note').value;
        var link = document.getElementById('link').value;
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>persetujuanmou/submitnote";
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('status', status);
        form_data.append('note', note);
        form_data.append('link', link);
        
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
                if(data.status == "simpan"){
                    $alert = swal("Berhasil!", "Datamu berhasil dikirim.", "success");
                    setTimeout($alert, 5000);
                    if(data.wa == "yes"){
                        window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                    }
                    $('#modal_form').modal('hide');
                    reload();
                }

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');        
        $('.modal-title').text('Persetujuan MoU');
        $.ajax({
            url: "<?php echo base_url(); ?>persetujuanmou/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idmou);
                if(data.status == 'Terdapat Revisi'){
                    $('#statuses').hide();
                    $('#noted').hide();
                }else{
                    $('#statuses').show();
                    $('#noted').show();
                    if(data.status == 'Direvisi'){
                        $('[name="status"]').val("Revisi");
                    }else{
                        $('[name="status"]').val(data.status);
                    }
                }
                $('[name="link"]').val(data.link);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Perijinan MoU</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Perijinan MoU</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th width="15%">Tanggal Pengajuan</th>
                                    <th>Detail MoU</th>
                                    <th>Link Docs / Drive</th>
                                    <th style="text-align: center;" width="5%">Status</th>
                                    <th style="text-align: center;" width="5%">Aksi</th>
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
                <div class="alert alert-success alert-dismissible fade show" id="info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form">
                    <input type="hidden" id="kode" name="kode">
                    <div class="form-row" id="statuses">
                        <div class="form-group col">
                            <label class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Revisi">Revisi</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link MoU</label>
                        <input type="text" class="form-control" id="link" name="link">
                        <small class="invalid-feedback">Link MoU wajib diisi</small>
                    </div>
                    <div class="form-row" id="noted">
                        <div class="form-group col">
                            <label class="form-label">Catatan <i>*diisi ketika ditolak / revisi</i></label>
                            <textarea class="form-control" name="note" id="note" row="5"></textarea>
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