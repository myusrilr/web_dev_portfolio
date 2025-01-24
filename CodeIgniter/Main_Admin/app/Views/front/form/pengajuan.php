<script type="text/javascript">

    var save_method; //for save method string
    var table;

    tinymce.init({
        selector: "textarea#syarat", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#pertanyaan", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#test", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#alur", theme: "modern", height: 100,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>pengajuan/ajaxlist"
        });
    });

    function detail(kode) {
        window.location.href = "<?php echo base_url(); ?>pengajuan/detail/"+kode;
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var jumlah = document.getElementById('jumlah').value;
        var keterangan = document.getElementById('keterangan').value;
        var syarat = tinyMCE.get('syarat').getContent();
        var pertanyaan = tinyMCE.get('pertanyaan').getContent();
        var alur = tinyMCE.get('alur').getContent();
        var test = tinyMCE.get('test').getContent();

        var tot = 0;
        if (jumlah === '') {
            document.getElementById('jumlah').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('jumlah').classList.remove('is-invalid'); tot += 1;} 
        if(syarat === ''){
            $('#errorsyarat').show();
        }else{$('#errorsyarat').hide(); tot += 1;}
        if(keterangan === ''){
            $('#errorketerangan').show();
        }else{$('#errorketerangan').hide(); tot += 1;}
        if(pertanyaan === ''){
            $('#errorpertanyaan').show();
        }else{$('#errorpertanyaan').hide(); tot += 1;}
        if(alur === ''){
            $('#erroralur').show();
        }else{$('#erroralur').hide(); tot += 1;}
        if(test === ''){
            $('#errortest').show();
        }else{$('#errortest').hide(); tot += 1;}
        
        if(tot === 6){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (kode === '') {
                url = "<?php echo base_url(); ?>pengajuan/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>pengajuan/ajax_edit";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('jumlah', jumlah);
            form_data.append('keterangan', keterangan);
            form_data.append('syarat', syarat);
            form_data.append('pertanyaan', pertanyaan);
            form_data.append('alur', alur);
            form_data.append('test', test);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    swal("Berhasil!", "Datamu berhasil dikirim.", "success");
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

    function ganti(id){
        $("#accordion2-1").collapse('show');
        $.ajax({
            url: "<?php echo base_url(); ?>pengajuan/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idpengajuan);
                $('[name="jumlah"]').val(data.jumlah);
                $('[name="keterangan"]').val(data.keterangan);
                tinyMCE.get('syarat').setContent(data.syarat);
                tinyMCE.get('pertanyaan').setContent(data.pertanyaan);
                tinyMCE.get('alur').setContent(data.alur);
                tinyMCE.get('test').setContent(data.test);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
</script>
<div class="container flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12 col-md-12" id="accordion2">
            <div class="card">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">Form Pengajuan Karyawan Baru<div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" id="kode" name="kode" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Keperluan</label>
                                    <textarea class="form-control" rows="3" id="keterangan" name="keterangan" placeholder="Masukkan Keperluan disini"></textarea>
                                    <small class="invalid-feedback" id="errorketerangan">Keperluan wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jumlah Orang</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah" onclick="hanyaAngka()" placeholder="Masukkan Jumlah Orang disini">
                                    <small class="invalid-feedback">Jumlah orang wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Syarat Pelamar</label>
                                    <textarea class="form-control" id="syarat" name="syarat"></textarea>
                                    <small class="invalid-feedback" id="errorsyarat">Syarat pelamar wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pertanyaan untuk Probing</label>
                                    <textarea class="form-control" id="pertanyaan" name="pertanyaan"></textarea>
                                    <small class="invalid-feedback" id="errorpertanyaan">Pertanyaan untuk probing wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alur Rekruitmen</label>
                                    <textarea class="form-control" id="alur" name="alur"></textarea>
                                    <small class="invalid-feedback" id="erroralur">Alur rekruitmen wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Detail Test</label>
                                    <textarea class="form-control" id="test" name="test"></textarea>
                                    <small class="invalid-feedback" id="errortest">Detail Test wajib diisi</small>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-block mt-4" id="btnSave" onclick="save();">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="font-weight-bold py-3 mb-0">Daftar Pengajuan Karyawan Baru</h4>
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
                                    <th>Detail</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th width="10%">Aksi</th>
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