<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Permintaan Pembelian Barang<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse show" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Link Dokumen</label>
                                    <input type="text" class="form-control" id="link" name="link" placeholder="Masukkan Link Dokumen disini">
                                    <small class="invalid-feedback">Link Dokumen wajib diisi</small>
                                    <small><i>*Isi Dokumen : No, Nama Barang, Jumlah, Link toko/barang (Saran), Pilihan Paket, Harga, Ongkir, Total, Keterangan</i></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan Pembelian</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                                    <small class="invalid-feedback" id="errorketerangan">Keterangan Pembelian wajib diisi</small>
                                    <br><small><i>*Contoh pengisian : Kebutuhan untuk peralatan lantai atas. (Enter) 1. Mouse - 4, dst. (Format: Kebutuhan (Enter) No. Nama Barang - Jumlah)</i></small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Permintaan Pembelian Barang</h4>
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
    
<script type="text/javascript">

var save_method; //for save method string
var table;

tinymce.init({
    selector: "textarea#keterangan", theme: "modern", height: 100,
});

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>purchase/ajaxlist"
    });

});

function save(){
    var kode = document.getElementById('kode').value;
    var keterangan = tinyMCE.get('keterangan').getContent();
    var link = document.getElementById('link').value;

    var tot = 0;
    if (link === '') {
        document.getElementById('link').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('link').classList.remove('is-invalid'); tot += 1;} 
    if(keterangan === ''){
        $('#errorketerangan').show();
    }else{$('#errorketerangan').hide(); tot += 1;}
    
    if(tot === 2){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if(save_method === 'update'){
            url = "<?php echo base_url(); ?>purchase/ajax_edit";
        }else{
            url = "<?php echo base_url(); ?>purchase/ajax_add";
        }
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('link', link);
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
        url: "<?php echo base_url(); ?>purchase/ganti/" + id,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            $('[name="kode"]').val(data.idbeli);
            document.getElementById("link").focus();
            tinyMCE.get('keterangan').setContent(data.deskripsi);
            $('[name="link"]').val(data.link);
            $('#btnSave').text('Perbarui');
            document.getElementById("btnSave").className = "btn btn-warning btn-block mt-4";
        }, error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
}
</script>