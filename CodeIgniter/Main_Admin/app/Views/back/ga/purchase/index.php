<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>persetujuanpembelian/ajaxlist"
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
        $('.modal-title').text('Persetujuan Pembelian');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var status = document.getElementById('status').value;
        var note = document.getElementById('note').value;
        
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>persetujuanpembelian/submitnote";
        
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
        $('.modal-title').text('Persetujuan Pembelian');
        $.ajax({
            url: "<?php echo base_url(); ?>persetujuanpembelian/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idbeli);
                if(data.status == 'Direvisi'){
                    $('[name="status"]').val("Revisi");
                }else{
                    $('[name="status"]').val(data.status);
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function proses(id) {
        $('#info2').hide();
        $('#form2')[0].reset();
        $('#modal_form2').modal('show');        
        $('.modal-title2').text('Catatan Pembelian');
        $.ajax({
            url: "<?php echo base_url(); ?>pembelian/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode2"]').val(data.idbeli);
                if(data.status === 'Selesai'){
                    $('#btnSave2').hide();
                    $('#btnSave3').hide();
                }

                document.getElementById('linkpurchase').href = data.linkpurchase;
                var text = data.done_at;
                document.getElementById('tgl').innerHTML = text.slice(0, 10);

            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function reload2(id) {
        table2 = $('#tb2').DataTable({
            ajax: "<?php echo base_url(); ?>pembelian/ajaxlistnote/"+id,
            retrieve:true
        });
        table2.destroy();
        table2 = $('#tb2').DataTable({
            ajax: "<?php echo base_url(); ?>pembelian/ajaxlistnote/"+id,
            retrieve:true
        });
    }
        
    function closemodal2(){
        $('#modal_form2').modal('hide');
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Permintaan Pembelian</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Permintaan Pembelian</li>
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
                                    <th width="15%">Link</th>
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
                                <option value="Revisi">Revisi</option>
                                <option value="Ditolak">Ditolak</option>
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
<div class="modal fade" id="modal_form2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title2">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="info2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Alert
                </div>
                <form id="form2">
                    <input type="hidden" id="kode2" name="kode2">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan Pembelian</label> : 
                            <a id="linkpurchase" name="linkpurchase" target="_blank" style="color: blue;"><b>Link Purchase</b></a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tanggal Pembelian Selesai</label> : 
                            <label class="form-label" id="tgl" name="tgl"></label> 
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal2();">Tutup</button>
                <button id="btnSave3" type="button" class="btn btn-success" onclick="done();">Pembelian Selesai</button>
            </div>
        </div>
    </div>
</div>