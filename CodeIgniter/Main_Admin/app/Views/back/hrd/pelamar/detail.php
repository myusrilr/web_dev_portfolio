<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card">

        <!-- Status -->
        <div class="card-body">
            <strong class="mr-2">Status:</strong>
            <span class="text-big">
                <?php if($lamar->status == 'Diterima'){
                    echo '<span class="badge badge-success">'.strtoupper($lamar->status).'</span>';
                }else if($lamar->status == 'Ditolak'){
                    echo '<span class="badge badge-danger">'.strtoupper($lamar->status).'</span>';
                }else if($lamar->status == 'baru'){
                    echo '<span class="badge badge-info">'.strtoupper($lamar->status).'</span>';
                }else{
                    echo '<span class="badge badge-warning">'.strtoupper($lamar->status).'</span>';
                } ?>
            </span>
            <span class="text-muted small ml-1"><?php echo date('d M Y', strtotime($lamar->created_at))?> / <b><?php echo strtoupper($lamar->jenis) ?></b></span>
        </div>
        <!-- / Status -->

        <div class="row">
            <div class="col-xl-12 col-md-12" id="accordion2">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">IDENTITAS PELAMAR<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Nama Lengkap / Panggilan</div>
                                <b><?php echo $lamar->nama.' / '.$lamar->panggilan; ?></b>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted small">Tempat, Tanggal Lahir</div>
                                <?php echo $lamar->ttl ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted small">Jenis Kelamin</div>
                                <?php echo $lamar->jk ?>
                            </div>
                            <div class="col-9">
                                <div class="text-muted small">Alamat</div>
                                <?php echo $lamar->alamat ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted small">Domisili</div>
                                <?php echo $lamar->domisili ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">CV, ijazah, transkrip, KTP, NPWP, KK, sertifikat (TOEFL dll)</div>
                                <a href="<?php echo $lamar->link ?>">Link Drive</a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted small">History Kesehatan</div>
                                <?php echo $lamar->sehat ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="text-muted small">Status Pernikahan</div>
                                <?php echo $lamar->statusnikah ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <div class="text-muted small">Pengalaman Kerja</div>
                                <?php $t = str_replace('</p>','<br>', $lamar->pengalaman);
                                echo str_replace('<p>','', $t); ?>
                            </div>
                            <div class="col-md-6 mb-6">
                                <div class="text-muted small">Pendidikan Terakhir</div>
                                <?php echo $lamar->ppdk ?>    
                                <br><br>
                                <div class="text-muted small">Pekerjaan Terakhir</div>
                                <?php echo $lamar->work ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Hasil Test Toefl</div>
                                <?php echo $lamar->toefl ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Apakah pernah mengajar secara daring?</div>
                                <?php echo $lamar->ajar ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Aplikasi/program digital yang telah dikuasai</div>
                                <?php echo $lamar->app ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-muted small">Jika pernah mengajar secara daring, sebutkan semua aplikasi / program yang pernah digunakan untuk mengajar secara daring tersebut!</div>
                                <?php echo $lamar->apps ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12 col-md-12" id="accordion3">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion3-2">MEDIA SOSIAL<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion3-2" class="collapse" data-parent="#accordion3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="text-muted small">No WA</div>
                                    <?php echo $lamar->wa ?>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-muted small">Email</div>
                                    <?php echo $lamar->email ?>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-muted small">Sosial media</div>
                                    <?php if($lamar->fb != ''){?>
                                    <a href="<?php echo $lamar->fb; ?>" target="_blank"  class="d-block text-dark mb-2" target="_blank">
                                        <i class="ion ion-logo-facebook ui-w-30 text-center text-facebook"></i> Facebook
                                    </a>
                                    <?php }if($lamar->ig != ''){?>
                                    <a href="<?php echo $lamar->ig; ?>" target="_blank" class="d-block text-dark mb-0">
                                        <i class="ion ion-logo-instagram ui-w-30 text-center text-instagram"></i> Instagram
                                    </a>
                                    <?php }?>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="text-muted small">Linkedin</div>
                                    <a href="<?php echo $lamar->linkedin; ?>" target="_blank" class="d-block text-dark mb-2">
                                        <i class="ion ion-logo-linkedin ui-w-30 text-center text-linkedin"></i> Linkedin
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12 col-md-12" id="accordion4">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion4-1">INFORMASI TAMBAHAN<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion4-1" class="collapse" data-parent="#accordion4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Apa yang kamu ketahui tentang LEAP?</div>
                                    <?php echo $lamar->wawasan ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Apakah Anda punya laptop/komputer sendiri?</div>
                                    <?php echo $lamar->laptop ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Akses internet yang Anda miliki saat ini</div>
                                    <?php echo $lamar->internet ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Kegiatan Saat Ini</div>
                                    <?php echo $lamar->kegiatan ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Rencana 3 Tahun ke Depan</div>
                                    <?php echo $lamar->rencana ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Mobilitas</div>
                                    <?php echo $lamar->mobilitas ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Darimana Anda mengetahui informasi tentang lowongan ini?</div>
                                    <?php echo $lamar->info ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12 col-md-12" id="accordion5">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion5-1">KETERSEDIAAN<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion5-1" class="collapse" data-parent="#accordion5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Jika saat ini sudah bekerja, apakah ada rencana mengundurkan diri?</div>
                                    <?php echo $lamar->resign ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Gaji yang diharapkan</div>
                                    <?php echo $lamar->gaji ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Bersedia untuk bekerja secara offline (WFO) di lokasi kantor LEAP (Rungkut Asri Tengah VII/51, Surabaya)</div>
                                    <?php echo $lamar->wfo ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">Jika saya diterima, paling cepat saya bisa mulai bergabung/ magang di LEAP Surabaya pada tanggal :</div>
                                    <?php echo date("d F Y", strtotime($lamar->bergabung)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12 col-md-12" id="accordion6">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion6-1">HASIL TEST PSIKOLOGI<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion6-1" class="collapse" data-parent="#accordion6">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="text-muted small">(1) Test IQ</div>
                                    <img src="<?php echo base_url().'/uploads/'.$lamar->piciq?>" width="200px" onclick="showimg('iq')">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-muted small">(2) Test Minat</div>
                                    <img src="<?php echo base_url().'/uploads/'.$lamar->picminat?>" width="200px" onclick="showimg('minat')">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="text-muted small">(3) Test Kepribadian</div>
                                    <img src="<?php echo base_url().'/uploads/'.$lamar->picpribadi?>" width="200px" onclick="showimg('kepribadian')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12 col-md-12" id="accordion7">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion7-1">DETAIL LINK<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion7-1" class="collapse" data-parent="#accordion7">
                        <div class="card-body">
                            <div class="row" style="margin-top: -20px;">
                                <div class="table-responsive mt-4">
                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Status</th>
                                                <th>Link Drive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($notes->getResult() as $row) {?>
                                            <tr>
                                                <td><?php echo $row->status;?></td>
                                                <td><a href="<?php echo $row->link;?>" target="_blank">Link Response</a></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h6 class="small font-weight-semibold">CATATAN 
            <?php if($lamar->status != 'Diterima'){ ?>
                <div class="float-right">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>&nbsp;&nbsp;
                    <button class="btn btn-sm btn-warning btn-fw " onclick="tanya()">Tambah Pertanyaan</button>&nbsp;&nbsp;
                    <button class="btn btn-sm btn-info btn-fw " onclick="add()">Tambah Catatan</button>
                    <!-- <a href="<?php //echo base_url().'/rekruitmen/pertanyaan/'.$kode; ?>" class="btn btn-sm btn-warning btn-fw ">Tambah Pertanyaan</a>
                    <a href="<?php //echo base_url().'/rekruitmen/catatan/'.$kode;?>" class="btn btn-sm btn-info btn-fw ">Tambah Catatan</a> -->
                </div>
            <?php } ?>
            </h6>

            <!-- Tambah Pelamar -->
            <form id="form">
                <h5 class="modal-title">Tambah Catatan Pelamar</h5>
                <div class="form-row">
                    <div class="form-group col">
                        <textarea class="form-control" name="note" id="note"></textarea>
                        <span id="errornote" style="color: red;">* Wajib diisi</span>
                    </div>
                </div>
                <button id="btnSave" type="button" class="btn btn-info float-right" onclick="save();">Simpan</button>
            </form>

            <!-- Tambah Pertanyaan -->
            <form id="form2">
                <h5 class="modal-title">Tambah Pertanyaan</h5>
                <input type="hidden" id="kode" name="kode" value="<?php echo $lamar->idpelamar; ?>">
                <div class="form-row">
                    <div class="form-group col">
                        <textarea class="form-control" name="pertanyaan" id="pertanyaan"></textarea>
                        <span id="errorpertanyaan" style="color: red;">* Wajib diisi</span>
                    </div>
                </div>
                <button id="btnSave" type="button" class="btn btn-warning float-right" onclick="simpan();">Simpan</button>
            </form>

            <!-- Edit Pertanyaan dan Catatan -->
            <form id="form3">
                <input type="hidden" id="idnote" name="idnote">
                <div class="form-row">
                    <div class="form-group col"> 
                        <label class="form-label">Pertanyaan</label>
                        <textarea class="form-control" name="tanya" id="tanya"></textarea>
                        <span id="errortanya" style="color: red;">* Wajib diisi</span>
                    </div> 
                    <div class="form-group col">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="catat" id="catat"></textarea>
                        <span id="errorcatatan" style="color: red;">* Wajib diisi</span>
                    </div>
                </div>
                <button id="btnEdit" type="button" class="btn btn-primary float-right" onclick="update();">Simpan</button>
            </form>

            <div class="table-responsive mt-4">
                <table class="table mb-0" id="tb" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="30%">Keterangan</th>
                            <th width="60%">Detail</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- / Items -->
    </div>
</div>

<div class="modal fade" id="modal_show_img">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title2">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <img id="imgdetil" src="" class="img-thumbnail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal2();">Tutup</button>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $('#errorpertanyaan').hide();
    $('#errornote').hide();
    $('#form').hide();
    $('#form2').hide();
    $('#form3').hide();

    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#catat", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#tanya", theme: "modern", height: 100, 
    });

    tinymce.init({
        selector: "textarea#pertanyaan", theme: "modern", height: 100,
    });

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>rekruitmen/listnote/<?php echo $lamar->idpelamar; ?>",
            scrollY: 300,   
            scrollX: true,
            autoWidth: false,
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
        $('#form2').hide();
        $('#form3').hide();
        $('#form').hide();
    }

    function hapus(id) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus data catatan ini?",
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
                        url: "<?php echo base_url(); ?>rekruitmen/hapusnote/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }

    function add() {
        $('#errornote').hide();
        $('#form2').hide();
        $('#form3').hide();
        $('#form')[0].reset();
        $('#form').show();
    }

    function edit(id) {
        $('#errorcatatan').hide();
        $('#errortanya').hide();
        $('#form').hide();
        $('#form2').hide();
        $('#form3')[0].reset();
        $('#form3').show();
        $.ajax({
            url: "<?php echo base_url(); ?>rekruitmen/editing/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="idnote"]').val(data.idnote);
                if(data.note === null){
                    tinymce.get('catat').setContent("");
                }else{
                    tinymce.get('catat').setContent(data.note);
                }
                if(data.pertanyaan === null){
                    tinymce.get('tanya').setContent("");
                }else{
                    tinymce.get('tanya').setContent(data.pertanyaan);
                }
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function tanya() {
        $('#errorpertanyaan').hide();
        $('#form').hide();
        $('#form3').hide();
        $('#form2')[0].reset();
        $('#form2').show();
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var note = tinyMCE.get('note').getContent();
        
        var tot = 0;
        if (note === '') {$('#errornote').show();}else{$('#errornote').hide(); tot += 1;} 

        if(tot == 1){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>rekruitmen/submitnote";
            
            var form_data = new FormData();
            form_data.append('idpelamar', kode);
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
                    if(data.status == "simpan"){
                        alert("Berhasil menyimpan Data!");
                        tinyMCE.get('note').setContent("");
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
    }

    function closemodal2(){
        $('#modal_show_img').modal('hide');
    }

    function simpan() {
        var kode = document.getElementById('kode').value;
        var pertanyaan = tinyMCE.get('pertanyaan').getContent();
        
        var tot = 0;
        if (pertanyaan === '') {$('#errorpertanyaan').show();}else{$('#errorpertanyaan').hide(); tot += 1;} 

        if(tot == 1){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>rekruitmen/submitpertanyaan";
            
            var form_data = new FormData();
            form_data.append('idpelamar', kode);
            form_data.append('pertanyaan', pertanyaan);
            
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
                        alert("Berhasil menyimpan Data!");
                        tinyMCE.get('pertanyaan').setContent("");
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
        
    }

    function showimg(jenis){
        $('#modal_show_img').modal('show');
        if(jenis === 'iq'){
            $('.modal-title2').text('Gambar Hasil Tes IQ');
        }else if(jenis === 'minat'){
            $('.modal-title2').text('Gambar Hasil Tes Minat');
        }else if(jenis === 'kepribadian'){
            $('.modal-title2').text('Gambar Hasil Tes Kepribadian');
        }
        var kode = document.getElementById('kode').value;
        $.ajax({
            url: "<?php echo base_url(); ?>rekruitmen/load_gambar/" + kode+"/"+jenis,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#imgdetil').attr("src", data.foto);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error load foto');
            }
        });      
    }

    function update() {
        var kode = document.getElementById('idnote').value;
        var catat = tinyMCE.get('catat').getContent();
        var tanya = tinyMCE.get('tanya').getContent();
        
        // var tot = 0;
        // if (catat === '') {$('#errorcatat').show();}else{$('#errorcatat').hide(); tot += 1;} 
        // if (tanya === '') {$('#errortanya').show();}else{$('#errortanya').hide(); tot += 1;} 

        // if(tot == 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>pelamarkaryawan/editnote";
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('note', catat);
            form_data.append('pertanyaan', tanya);
            
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
                        alert("Berhasil mengubah data!");
                        tinyMCE.get('catat').setContent("");
                        tinyMCE.get('tanya').setContent("");
                    }
                    reload();
                    $('#modal_edit').modal('hide');

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        // }
    }
    
</script>
<!-- [ content ] End -->