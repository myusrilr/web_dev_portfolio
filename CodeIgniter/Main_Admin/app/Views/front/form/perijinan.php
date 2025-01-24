<div class="container flex-grow-1 container-p-y" id="accordion2">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Pengajuan Ijin / Lembur<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Jenis Pengajuan</label>
                                    <select class="custom-select" id="jenis" name="jenis">
                                        <option value="" disabled selected>Pilih Jenis Pengajuan</option>
                                        <option value="Lembur">Lembur</option>
                                        <option value="Ijin">Ijin</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Ijin Darurat">Ijin Darurat</option>
                                    </select>
                                    <small class="invalid-feedback" id="errorjenis">Jenis Pengajuan wajib dipilih</small>
                                </div>
                            </div>
                            <div class="col-12">
                            <span style="color: #2e76bb;">Update! <i>Isi tanggal perijinan secara terpisah. Jika ijin 2 hari maka harus input 2x perijinan sesuai tanggalnya.</i></span></div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="floating-label" for="Date1">Tanggal</label>
                                    <input type="date" class="form-control" id="Date1" name="Date1" placeholder="123">
                                    <small class="invalid-feedback">Tanggal wajib diisi</small>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <!-- <label class="floating-label" for="Date2">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="Date2" name="Date2" placeholder="123">
                                    <small class="invalid-feedback">Tanggal Selesai wajib diisi</small> -->
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="floating-label" for="Time1">Waktu Mulai</label>
                                    <input type="time" class="form-control" id="Time1" name="Time1" placeholder="123">
                                    <small class="invalid-feedback">Waktu Mulai wajib diisi</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="floating-label" for="Time2">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="Time2" name="Time2" placeholder="123">
                                    <small class="invalid-feedback">Waktu Selesai wajib diisi</small>
                                </div>
                            </div> 
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" rows="3" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan disini"></textarea>
                                    <small class="invalid-feedback" id="errorketerangan">Keterangan Lembur / Ijin wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Surat Pendukung (Opsional)</label>
                                    <input type="file" id="foto" class="form-control" name="foto">
                                    <small class="invalid-feedback" id="errorsurat">Surat Pendukung harus dilampirkan</small>
                                </div>
                            </div>
                            <input type="hidden" id="idkaryawan" name="idkaryawan" value="<?php $idusers; ?>">
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Perijinan / Lembur</h4>
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
                                    <th>Jenis</th>
                                    <th>Tanggal dan Waktu</th>
                                    <th>Keterangan</th>
                                    <th>Surat Pendukung</th>
                                    <th>Status</th>
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
    
<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function () {
    table = $('#tb').DataTable({
        ajax: "<?php echo base_url(); ?>perijinan/ajaxlist"
    });

});

function save(){
    var idkaryawan = document.getElementById('idkaryawan').value;
    var tanggalmulai = document.getElementById('Date1').value;
    // var tanggalselesai = document.getElementById('Date2').value;
    var waktumulai = document.getElementById('Time1').value;
    var waktuselesai = document.getElementById('Time2').value;
    var jenis = document.getElementById('jenis').value;
    var keterangan = document.getElementById('keterangan').value;
    var foto = $('#foto').prop('files')[0];

    var tot = 0;
    if (tanggalmulai === '') {
        document.getElementById('Date1').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('Date1').classList.remove('is-invalid'); tot += 1;} 
    // if(tanggalselesai === ''){
    //     document.getElementById('Date2').classList.add('form-control', 'is-invalid');
    // }else{document.getElementById('Date2').classList.remove('is-invalid'); tot += 1;}
    if(waktumulai === ''){
        document.getElementById('Time1').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('Time1').classList.remove('is-invalid'); tot += 1;}
    if(waktuselesai === ''){
        document.getElementById('Time2').classList.add('form-control', 'is-invalid');
    }else{document.getElementById('Time2').classList.remove('is-invalid'); tot += 1;}
    if(jenis === ''){
        $('#errorjenis').show();
    }else{$('#errorjenis').hide(); tot += 1;}
    if(keterangan === ''){
        $('#errorketerangan').show();
    }else{$('#errorketerangan').hide(); tot += 1;}
    if(waktuselesai < waktumulai){alert('Waktu selesai tidak boleh lebih kecil dari waktu mulai!');}else{tot+=1;}
    // if(tanggalmulai > tanggalselesai){alert('Tanggal Selesai tidak boleh kurang dari tanggal mulai!');}else{tot+=1;}

    if(tot === 6){
        $('#btnSave').text('Mengirim...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>perijinan/ajax_add";
        
        var form_data = new FormData();
        form_data.append('idkaryawan', idkaryawan);
        form_data.append('tanggalmulai', tanggalmulai);
        // form_data.append('tanggalselesai', tanggalselesai);
        form_data.append('waktumulai', waktumulai);
        form_data.append('waktuselesai', waktuselesai);
        form_data.append('jenis', jenis);
        form_data.append('keterangan', keterangan);
        form_data.append('file', foto);
        
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
                $alert = swal("Berhasil!", "Datamu berhasil dikirim.", "success");
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

function hapus(id,nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "Membatalkan pengajuan jenis " + nama + " ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Batalkan",
            cancelButtonText: "Tidak",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>perijinan/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dibatalkan.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

function reload() {
    table.ajax.reload(null, false); //reload datatable ajax
}
</script>