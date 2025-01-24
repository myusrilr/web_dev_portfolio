<script type="text/javascript">

    var save_method; //for save method string
    var table;

    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 100,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>persetujuanpinjam/ajaxlist"
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
        $('.modal-title').text('Persetujuan Peminjaman');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var status = document.getElementById('status').value;
        var note = tinyMCE.get('note').getContent();
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>persetujuanpinjam/submitnote";
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('status', status);
        form_data.append('note', note);
        
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
                $('#info').show();
                if(data.status == "simpan"){
                    $('#info').text('Berhasil menyimpan data!');
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
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function ganti(id) {
        $('#info').hide();
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');        
        $('.modal-title').text('Persetujuan Peminjaman');
        $.ajax({
            url: "<?php echo base_url(); ?>persetujuanpinjam/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idpinjam);
                $('[name="status"]').val(data.status);
                if(data.catatan === ''){
                    tinyMCE.get('note').setContent(data.deskripsi);
                }else{
                    tinyMCE.get('note').setContent(data.catatan);
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
        
    function closemodal2(){
        $('#modal_form2').modal('hide');
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Permintaan Peminjaman Barang</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Permintaan Peminjaman Barang</li>
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
                                    <th>Deskripsi</th>
                                    <th width="15%">Tanggal Peminjaman</th>
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
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Status</label>
                            <select class="custom-select" id="status" name="status">
                                <option value="" disabled selected>Pilih status</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan</label>
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