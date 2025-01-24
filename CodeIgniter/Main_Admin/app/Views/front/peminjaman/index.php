<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Peminjaman Barang<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse show" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal">
                                    <small class="invalid-feedback">Tanggal Peminjaman wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                                    <small class="invalid-feedback" id="errorketerangan">Deskripsi Peminjaman wajib diisi</small>
                                    <br><small><i>*Format : no. nama barang - jml - keperluan - tgl pengembalian</i></small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Peminjaman Barang</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
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
    
<script type="text/javascript">

var save_method; //for save method string
var table;

tinymce.init({
    selector: "textarea#keterangan", theme: "modern", height: 100,
});

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>pinjam/ajaxlist"
    });

});

function save(){
    var kode = document.getElementById('kode').value;
    var keterangan = tinyMCE.get('keterangan').getContent();
    var tanggal = document.getElementById('tanggal').value;

    var tot = 0;
    if (tanggal === '') {
        document.getElementById('tanggal').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('tanggal').classList.remove('is-invalid'); tot += 1;} 
    if(keterangan === ''){
        $('#errorketerangan').show();
    }else{$('#errorketerangan').hide(); tot += 1;}
    
    if(tot === 2){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if(save_method === 'update'){
            url = "<?php echo base_url(); ?>pinjam/ajax_edit";
        }else{
            url = "<?php echo base_url(); ?>pinjam/ajax_add";
        }
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('tanggal', tanggal);
        form_data.append('keterangan', keterangan);
        
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

function ganti(id) {
    $('#info').hide();
    save_method = 'update';
    $.ajax({
        url: "<?php echo base_url(); ?>pinjam/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode"]').val(data.idbeli);
            tinyMCE.get('keterangan').setContent(data.deskripsi);
            $('[name="tanggal"]').val(data.tanggal);
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}
</script>