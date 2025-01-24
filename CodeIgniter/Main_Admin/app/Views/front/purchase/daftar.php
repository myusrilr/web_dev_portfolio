<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Link Drive Catatan Pembelian</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan Link drive disini" value="<?php echo $link; ?>">
                        <small class="invalid-feedback">Link Drive wajib diisi</small>
                    </div>
                    <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="savelink();">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Permintaan Pembelian Barang</h4>
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
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
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
<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>pembelian/ajaxlist"
    });

});

function save(){
    var kode = document.getElementById('kode').value;
    var status = document.getElementById('status').value;
    var link = document.getElementById('link').value;

    var tot = 0;
    if (status === '') {
        document.getElementById('status').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('status').classList.remove('is-invalid'); tot += 1;}
    if (link === '') {
        document.getElementById('link').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;}
    
    if(tot === 2){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>pembelian/ajax_edit";
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('status', status);
        form_data.append('link', link);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function (data) {
                $alert = swal("Berhasil!", data.status, "success");
                setTimeout($alert, 5000);
                reload();
                closemodal();
                
                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
}

function savelink(){
    var link = document.getElementById('link').value;

    var tot = 0;
    if (link === '') {
        document.getElementById('link').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;}
    
    if(tot === 1){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>pembelian/savelink";
        
        var form_data = new FormData();
        form_data.append('link', link);
        
        // ajax adding data to database
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            traditional: true,
            type: 'POST',
            success: function (data) {
                $alert = swal("Berhasil!", data.status, "success");
                setTimeout($alert, 5000);
                location.reload();
                
                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSave').text('Kirim'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }
}

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
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

function ganti(id) {
    $('#info').hide();
    save_method = 'update';
    $('#form')[0].reset();
    $('#modal_form').modal('show');        
    $('.modal-title').text('Proses Pembelian');
    $.ajax({
        url: "<?php echo base_url(); ?>pembelian/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode"]').val(data.idbeli);
            $('[name="status"]').val(data.status);
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

function closemodal(){
    $('#modal_form').modal('hide');
}

function closemodal2(){
    $('#modal_form2').modal('hide');
}

function done(){
    var id = document.getElementById('kode2').value;

    swal({
        title: "Apakah anda yakin?",
        text:  "Mengubah pembelian ini menjadi selesai?",
        showCancelButton: true,
        confirmButtonClass: "btn btn-danger",
        confirmButtonText: "Ya, Yakin",
        cancelButtonText: "Batal",
        closeOnConfirm: false,
        closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "<?php echo base_url(); ?>pembelian/done/" + id,
                    type: "POST",
                    dataType: "JSON",
                    error: function(data) {
                        swal("Gagal!", data.status, "error");
                    },success: function(data) {
                        reload();
                        $('#modal_form2').modal('hide');
                        swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                    }
                });
            }else {
                swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
            }
    });
}
</script>