<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Pengaduan Permasalahan Infrastruktur<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse show" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Tuliskan Permasalahan Infrastruktur</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan">
                                    <small class="invalid-feedback">Permasalahan wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <?php if($pro->wa != ''){ ?>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                        <?php }else{?>
                        <span class="badge badge-warning">Mohon isi nomor WA terlebih dahulu! <b><a href="<?php echo base_url().'/riwayat'?>">Klik link ini yaa...</a></b></span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Permasalahan Infrastruktur</h4>
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
                                    <th width="15%">Tanggal Pengaduan</th>
                                    <th width="15%">Pengguna</th>
                                    <th>Keterangan Masalah</th>
                                    <th style="text-align: center;" width="5%">Status</th>
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

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>problem/ajaxlist"
    });

});

function save(){
    var keterangan = document.getElementById('keterangan').value;

    var tot = 0;
    if (keterangan === '') {
        document.getElementById('keterangan').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('keterangan').classList.remove('is-invalid'); tot += 1;} 
    
    if(tot === 1){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>problem/ajax_add";
        
        var form_data = new FormData();
        form_data.append('kode', kode);
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
                alert(data.status);
                window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                reload();
                
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

function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "Membatalkan pengajuan " + nama + " ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>problem/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            window.open("https://wa.me/" + data.nomor +"?text=" + data.pesan, "blank"); 
                            swal("Berhasil!", "Datamu berhasil dibatalkan.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }
</script>