<script type="text/javascript">

    var save_method; //for save method string
    $('#erroralasan').hide();$('#errorsurat').hide();

    function simpan() {
        var alasan = document.getElementById('alasan').value;
        var surat = $('#surat').prop('files')[0];

        var tot = 0;
        
        if(alasan === ''){
            $('#erroralasan').show();
        }else{$('#erroralasan').hide(); tot += 1;}
        if(surat === ''){
            $('#errorsurat').show();
        }else{$('#errorsurat').hide(); tot += 1;}
        
        if(tot === 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>pemutusan/proses";

            var form_data = new FormData();
            form_data.append('alasan', alasan);
            form_data.append('file', surat);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if(data.status == "kirim"){
                        swal("Berhasil!", "Datamu berhasil dikirim.", "success");
                    }else{
                        swal("Berhasil!", "Datamu berhasil disimpan.", "success");
                    }
                    location.reload();

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function kirim() {
        swal({
            title: 'Apa anda Yakin?',
            text: "Anda tidak dapat mengedit data ulang ketika form dikirim!",
            icon: 'danger',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tidak!',
            cancelButtonText: 'Ya, Saya yakin!',
            reverseButtons: true,
            dangerMode: true,
            closeOnConfirm: false,
            closeOnCancel: false,
        },
        function(isConfirm) {
            if (isConfirm === true) {
                swal("Oke! Datamu tidak jadi dikirim.");
            }else{
                $.ajax({
                    url: "<?php echo base_url(); ?>pemutusan/kirim/",
                    type: "POST",
                    dataType: "JSON",
                    error: function() {
                        alert('Error');
                    },
                    success: function(data) {
                        swal("Berhasil!", "Datamu berhasil dikirim.", "success");
                        location.reload();
                    }
                });
                
            }
        });
    }

    function batal() {
        swal({
            title: 'Batalkan pemutusan kontrak?',
            text: "Apakah anda yakin untuk membatalkan pemutusan kontrak?",
            icon: 'danger',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Batalkan!',
            reverseButtons: true,
            dangerMode: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "<?php echo base_url(); ?>pemutusan/batalkan/",
                    type: "POST",
                    dataType: "JSON",
                    error: function() {
                        alert('Error');
                    },
                    success: function(data) {
                        swal("Kerja bagus!", "Datamu berhasil dihapus / batalkan.", "success");
                        window.location.href = "<?php echo base_url(); ?>homekaryawan";
                    }
                });
            }
        });
    }
</script>
<div class="container flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <?php if($alasan->status == "Revisi"){?>
                <div class="alert alert-dark-warning alert-dismissible fade show">
                    Terdapat Revisi Untuk Pengajuanmu : <br>
                    <b><?php echo $alasan->catatan; ?></b>
                </div>
            <?php }else if($alasan->status == "Diajukan"){?>
                <div class="alert alert-dark-info alert-dismissible fade show">
                    Pengajuanmu berhasil dikirimkan! Silahkan tunggu 2x24 jam yaa.
                </div>
            <?php }else if($alasan->status == "Disetujui"){?>
                <div class="alert alert-dark-success alert-dismissible fade show">
                    <center>Pengajuanmu telah disetujui.
                    <br><br><b><i>" We were glad that you were a part of our organization for so long and have contributed so much to its growth. :)
                        <br>We wish you boundless success wherever you go. "</i></b></center>    
                </div>
            <?php } ?>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <h6 class="card-header">Form Pemutusan Kontrak</h6>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="kode" name="kode" value="">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Alasan Pemutusan Kontrak</label>
                                <textarea class="form-control" rows="3" id="alasan" name="alasan"><?php echo $alasan->alasan; ?></textarea>
                                <small class="invalid-feedback" id="erroralasan">Alasan wajib diisi</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Scan Surat Pengunduran Diri</label>
                                <input type="file" id="surat" class="form-control" name="surat">
                                <small class="invalid-feedback" id="errorsurat">Surat wajib dilampirkan</small>
                            </div>
                            <?php foreach($linkform->getResult() as $row){?>
                            <div class="form-group">
                                <label class="form-label">Link <?php echo $row->judul ?></label>
                                <a href="<?php echo $row->link ?>" target="_blank">Klik disini</a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php if($alasan->status != "Disetujui"){ ?>
                    <button type="button" class="btn btn-danger" onclick="batal();">Batalkan</button>
                    <?php }?>
                    <?php if($alasan->kirim == '' || $alasan->status == "Revisi"){ ?>
                        <button type="button" class="btn btn-info" onclick="simpan();">Simpan</button>
                        <button type="button" class="btn btn-success float-right" onclick="kirim();">Kirim</button>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>