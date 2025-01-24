<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Detail Data Kemitraan</h4>
    
    <div class="row">
        <div class="col" id="accordion2">
            <!-- Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" aria-expanded="true" href="#accordion2-1">Data Instansi<div class="collapse-icon"></div></a>
                </div>
                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <input type="hidden" id="kode" name="kode" value="<?php echo $mitra->idmitra; ?>">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Nama Institusi </label>
                            <div class="col-sm-10">
                                <input type="text" id="namasekolah" name="namasekolah" class="form-control" placeholder="Masukkan Nama Institusi" value="<?php echo $mitra->namasekolah ?>">
                                <small class="invalid-feedback">Nama Institusi wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">PIC Institusi </label>
                            <div class="col-sm-10">
                                <input type="text" id="kepsek" name="kepsek" class="form-control" placeholder="Masukkan PIC Institusi" value="<?php echo $mitra->kepsek ?>">
                                <small class="invalid-feedback">PIC Institusi wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Contact Number </label>
                            <div class="col-sm-10">
                                <input type="text" id="cp" name="cp" class="form-control" placeholder="Masukkan Contact Number" value="<?php echo $mitra->cp ?>" onkeypress="return hanyaAngka(event,false);">
                                <small class="invalid-feedback">Contact Number wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Jenis Kemitraan </label>
                            <div class="col-sm-10">
                                <select id="jeniskemitraan" name="jeniskemitraan" class="form-control">
                                    <option value="Perluasan Bisnis" <?php if($mitra->jeniskemitraan == 'Perluasan Bisnis'){ echo 'selected';  } ?>>Perluasan Bisnis </option>
                                    <option value="Layanan Training"  <?php if($mitra->jeniskemitraan == 'Layanan Training'){ echo 'selected';  } ?>>Layanan Training </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <label class="col-form-label col-sm-2 text-sm-right">Tipe Institusi </label>
                            <div id="tipeInstitusiTraining" class="col-sm-10" style="display: none;">
                                <select id="jenis" name="jenis" class="form-control" >
                                    <option value="Sekolah" <?php if($mitra->jenis == 'Sekolah'){ echo 'selected';  } ?>>Sekolah </option>
                                    <option value="Corporate"  <?php if($mitra->jenis == 'Corporate'){ echo 'selected';  } ?>>Corporate </option>
                                    <option value="Pemerintah"  <?php if($mitra->jenis == 'Pemerintah'){ echo 'selected';  } ?>>Pemerintah </option>
                                    <option value="Lainnya"  <?php if($mitra->jenis == 'Lainnya'){ echo 'selected';  } ?>>Lainnya </option>
                                </select>
                            </div>
                            <div id="tipeInstitusiPerluasan" class="col-sm-10" style="display: none;">
                                <select id="jenis" name="jenis" class="form-control">
                                    <option value="Kemitraan 1 Guru" <?php if($mitra->jenis == 'Kemitraan 1 Guru'){ echo 'selected';  } ?>>Mitra Guru </option>
                                    <option value="Kemitraan 2 Koordinator"  <?php if($mitra->jenis == 'Kemitraan 2 Koordinator'){ echo 'selected';  } ?>>Mitra Koordinator </option>
                                    <option value="Kemitraan 3 Sekolah"  <?php if($mitra->jenis == 'Kemitraan 3 Sekolah'){ echo 'selected';  } ?>>Mitra Sekolah </option>
                                    <option value="Kemitraan 4 White Label"  <?php if($mitra->jenis == 'Kemitraan 4 White Label'){ echo 'selected';  } ?>>Mitra White Label </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Alamat Institusi </label>
                            <div class="col-sm-10">
                                <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Masukkan Alamat Institusi" value="<?php echo $mitra->lokasi ?>">
                                <small class="invalid-feedback">Alamat Institusi wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Provinsi </label>
                            <div class="col-sm-10">
                                <select class="form-control" id="provinsi" name="provinsi" onchange="pilih_kabupaten();">
                                    <option value="-">- Pilih Provinsi -</option>
                                    <?php
                                    foreach ($provinsi->getResult() as $row) {
                                    ?>
                                        <option value="<?php echo $row->idprovinsi; ?>" <?php if($mitra->provinsi == $row->idprovinsi){ echo 'selected'; }?>> <?php echo $row->nama; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Kota / Kabupaten </label>
                            <div class="col-sm-10">
                                <select class="form-control" id="kabupaten" name="kabupaten">
                                    <option value="-">- Pilih Kabupaten -</option>
                                </select>
                                <small class="invalid-feedback">Kota / Kabupaten wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Jumlah Karyawan </label>
                            <div class="col-sm-10">
                                <input type="number" id="jml" name="jml" min="0" class="form-control" placeholder="Masukkan Jumlah Karyawan" value="<?php echo $mitra->jml ?>">
                                <small class="invalid-feedback">Jumlah Karyawan wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Kategori Bidang Usaha </label>
                            <div class="col-sm-10">
                                <select id="bidang" name="bidang" class="form-control">
                                    <option value="Services" <?php if($mitra->bidang == 'Services'){ echo 'selected';  } ?>>Services </option>
                                    <option value="Manufacturing"  <?php if($mitra->bidang == 'Manufacturing'){ echo 'selected';  } ?>>Manufacturing </option>
                                    <option value="Goods Processing"  <?php if($mitra->bidang == 'Goods Processing'){ echo 'selected';  } ?>>Goods Processing </option>
                                    <option value="Agriculture"  <?php if($mitra->bidang == 'Agriculture'){ echo 'selected';  } ?>>Agriculture </option>
                                    <option value="Finance, Banking, and Insurance"  <?php if($mitra->bidang == 'Finance, Banking, and Insurance'){ echo 'selected';  } ?>>Finance, Banking, and Insurance </option>
                                    <option value="Reselling and Retail"  <?php if($mitra->bidang == 'Reselling and Retail'){ echo 'selected';  } ?>>Reselling and Retail</option>
                                    <option value="IT and HighTech"  <?php if($mitra->bidang == 'IT and HighTech'){ echo 'selected';  } ?>>IT and HighTech </option>
                                    <option value="Healthcare And Social Assistance"  <?php if($mitra->bidang == 'Healthcare And Social Assistance'){ echo 'selected';  } ?>>Healthcare And Social Assistance </option>
                                    <option value="Petroleum"  <?php if($mitra->bidang == 'Petroleum'){ echo 'selected';  } ?>>Petroleum </option>
                                    <option value="Real Estate and Construction"  <?php if($mitra->bidang == 'Real Estate and Construction'){ echo 'selected';  } ?>>Real Estate and Construction </option>
                                    <option value="Wholesale Trade"  <?php if($mitra->bidang == 'Wholesale Trade'){ echo 'selected';  } ?>>Wholesale Trade </option>
                                    <option value="Cars, Vehicles, Ships, and Aircrafts"  <?php if($mitra->bidang == 'Cars, Vehicles, Ships, and Aircrafts'){ echo 'selected';  } ?>>Cars, Vehicles, Ships, and Aircrafts </option>
                                    <option value="Telecommunication"  <?php if($mitra->bidang == 'Telecommunication'){ echo 'selected';  } ?>>Telecommunication </option>
                                    <option value="Food and Beverages"  <?php if($mitra->bidang == 'Food and Beverages'){ echo 'selected';  } ?>>Food and Beverages </option>
                                    <option value="Ecommerce"  <?php if($mitra->bidang == 'Ecommerce'){ echo 'selected';  } ?>>Ecommerce </option>
                                    <option value="Future Oriented Business Ideas And New Technologies"  <?php if($mitra->bidang == 'Future Oriented Business Ideas And New Technologies'){ echo 'selected';  } ?>>Future Oriented Business Ideas And New Technologies </option>
                                    <option value="Information"  <?php if($mitra->bidang == 'Information'){ echo 'selected';  } ?>>Information </option>
                                    <option value="Military"  <?php if($mitra->bidang == 'Military'){ echo 'selected';  } ?>>Military </option>
                                    <option value="Online Services"  <?php if($mitra->bidang == 'Online Services'){ echo 'selected';  } ?>>Online Services </option>
                                </select>
                                <small class="invalid-feedback">Kategori Bidang Usaha wajib diisi</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right">Aplikasi </label>
                            <div class="col-sm-10">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="leapverse" <?php if($mitra->leapverse == 'Ya'){ echo 'checked';  } ?>>
                                    <span class="form-check-label">Leapverse</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="elsa" <?php if($mitra->elsa == 'Ya'){ echo 'checked';  } ?>>
                                    <span class="form-check-label">Elsa</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="classin" <?php if($mitra->classin == 'Ya'){ echo 'checked';  } ?>>
                                    <span class="form-check-label">ClassIn</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="btnSave" type="button" class="btn btn-primary float-right" style="margin-bottom:20px;" onclick="save();">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- / Info -->

            <!-- Info -->
            <div class="card mb-4" id="accordion3">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark" data-toggle="collapse" aria-expanded="true" href="#accordion3-1">Visi dan Misi<div class="collapse-icon"></div></a>
                </div>
                <div id="accordion3-1" class="collapse" data-parent="#accordion3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="visimisi" name="visimisi"><?php echo $mitra->visimisi; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h6 class="my-3">PROGRAM SEKOLAH</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="program" name="program"><?php echo $mitra->program; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h6 class="my-3">SARANA & PRASARANA</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="sdm" name="sdm"><?php echo $mitra->sdm; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- <h6 class="my-3">KELEBIHAN DAN KEKURANGAN</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="weakness" name="weakness"><?php //echo $mitra->weakness; ?></textarea>
                                </div>
                            </div>
                        </div> -->
                        <h6 class="my-3">CATATAN / REKOMENDASI</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="rekomen" name="rekomen"><?php echo $mitra->rekomen; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="btnS" type="button" class="btn btn-primary float-right" style="margin-bottom:20px;" onclick="proses();">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- / Info -->

            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">Catatan Kemitraan 
                    <?php //if($mitra->status != 'done'){ ?>
                        <div class="float-right">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>&nbsp;&nbsp;
                            <button class="btn btn-sm btn-info btn-fw " onclick="add()">Tambah Catatan</button>
                        </div>
                    <?php //} ?>
                    </h6>

                    <!-- Tambah-->
                    <form id="form">
                        <h5 class="modal-title">Tambah Catatan</h5>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="idnote" name="idnote">
                                <div class="form-group">
                                    <textarea class="form-control" id="note" name="note"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="custom-select" id="status" name="status">
                                        <option value="" disabled selected>Pilih status</option>
                                        <option value="connect" <?php if($mitra->status == 'connect'){ echo 'selected';  } ?>>Connect</option>
                                        <option value="follow up" <?php if($mitra->status == 'follow up'){ echo 'selected';  } ?>>Follow up</option>
                                        <option value="transfer" <?php if($mitra->status == 'transfer'){ echo 'selected';  } ?>>Transfer</option>
                                        <option value="on-going" <?php if($mitra->status == 'on-going'){ echo 'selected';  } ?>>On Going</option>
                                        <option value="done" <?php if($mitra->status == 'done'){ echo 'selected';  } ?>>Done</option>
                                        <option value="canceled" <?php if($mitra->status == 'canceled'){ echo 'selected';  } ?>>Canceled</option>
                                    </select>
                                </div>
                                <div class="form-group" id="startdate" style="display; none;">
                                    <label class="form-label">Tanggal Mulai </label>
                                    <input type="date" id="starttgl" name="starttgl" class="form-control">
                                    <small class="invalid-feedback">Tanggal Mulai wajib diisi</small>
                                </div>
                                <div class="form-group" id="enddate" style="display; none;">
                                    <label class="form-label">Tanggal Selesai </label>
                                    <input type="date" id="endtgl" name="endtgl" class="form-control">
                                    <small class="invalid-feedback">Tanggal Mulai wajib diisi</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Assign User</label>
                                    <select class="select2-demo form-control" multiple style="width: 100%;  z-index:100000;" name="staff[]">
                                        <?php foreach($users->getResult() as $row){ ?>
                                        <option value="<?php echo $row->idusers; ?>"><?php echo ucwords(strtolower($row->nama ?: '')); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <button id="btnSimpan" type="button" class="btn btn-info float-right" onclick="simpan();">Simpan</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive mt-4">
                        <table class="table mb-0" id="tb" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="20%">PIC Leap</th>
                                    <th width="40%">Catatan</th>
                                    <th width="30%">Assigned Person/Division</th>
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
    
</div>

<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">
    // Select2
    $(function() {
        $('.select2-demo').select2({});

        
    });

    var table; 
    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>mitra/listnote/<?php echo $mitra->idmitra; ?>",
            scrollY: 300,   
            scrollX: true,
            autoWidth: false,
        });
    });

    $('#form').hide();

    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#catat", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#visimisi", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#program", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#sdm", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#weakness", theme: "modern", height: 100,
    });

    tinymce.init({
        selector: "textarea#rekomen", theme: "modern", height: 100,
    });

    function add() {
        $('#form')[0].reset();
        $('#form').show();
        $('[name="idnote"]').val("");

        var data_kosong = [];
        $(".select2-demo").select2().val(data_kosong).trigger('change.select2');
    }

    function edit(id) {
        $('#form')[0].reset();
        $('#form').show();
        $.ajax({
            url: "<?php echo base_url(); ?>mitra/editing/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="idnote"]').val(data.idmnote);
                $('[name="status"]').val(data.status);
                if(data.note === null){
                    tinymce.get('note').setContent("");
                }else{
                    tinymce.get('note').setContent(data.note);
                }
                $(".select2-demo").select2().val(data.users).trigger('change.select2');
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
        $('#form').hide();
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var namasekolah = document.getElementById('namasekolah').value;
        var lokasi = document.getElementById('lokasi').value;
        var kepsek = document.getElementById('kepsek').value;
        var cp = document.getElementById('cp').value;
        var jenis = document.getElementById('jenis').value;
        var provinsi = document.getElementById('provinsi').value;
        var kotkab = document.getElementById('kabupaten').value;
        var jml = document.getElementById('jml').value;
        var bidang = document.getElementById('bidang').value;
        var leapverse = document.getElementById('leapverse');
        var jeniskemitraan = document.getElementById('jeniskemitraan').value;
        var elsa = document.getElementById('elsa');
        var classin = document.getElementById('classin');

        var tot = 0;
        if (namasekolah === '') {
            document.getElementById('namasekolah').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('namasekolah').classList.remove('is-invalid'); tot += 1;} 
        if (lokasi === '') {
            document.getElementById('lokasi').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('lokasi').classList.remove('is-invalid'); tot += 1;} 
        if (kepsek === '') {
            document.getElementById('kepsek').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('kepsek').classList.remove('is-invalid'); tot += 1;} 
        if (cp === '') {
            document.getElementById('cp').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('cp').classList.remove('is-invalid'); tot += 1;} 
        if (provinsi === '') {
            document.getElementById('provinsi').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('provinsi').classList.remove('is-invalid'); tot += 1;} 
        if (kotkab === '') {
            document.getElementById('kabupaten').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('kabupaten').classList.remove('is-invalid'); tot += 1;} 
        if (jml === '') {
            document.getElementById('jml').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('jml').classList.remove('is-invalid'); tot += 1;} 
        
        if(tot === 7){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>mitra/addmitra";

            if(leapverse.checked == true){
                leapverse = "Ya";
            }else{
                leapverse = "Tidak";
            }
            if(elsa.checked == true){
                elsa = "Ya";
            }else{
                elsa = "Tidak";
            }
            if(classin.checked == true){
                classin = "Ya";
            }else{
                classin = "Tidak";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('namasekolah', namasekolah);
            form_data.append('lokasi', lokasi);
            form_data.append('kepsek', kepsek);
            form_data.append('cp', cp);
            form_data.append('provinsi', provinsi);
            form_data.append('kotkab', kotkab);
            form_data.append('jml', jml);
            form_data.append('bidang', bidang);
            form_data.append('leapverse', leapverse);
            form_data.append('elsa', elsa);
            form_data.append('classin', classin);
            form_data.append('jenis', jenis);
            form_data.append('jeniskemitraan', jeniskemitraan);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 

                    $('#btnSave').text('Perbarui');
                    document.getElementById("btnSave").className = "btn btn-warning float-right";
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

    function proses() {
        var kode = document.getElementById('kode').value;
        var visimisi = tinyMCE.get('visimisi').getContent();
        var program = tinyMCE.get('program').getContent();
        var sdm = tinyMCE.get('sdm').getContent();
        var weakness = tinyMCE.get('weakness').getContent();
        var rekomen = tinyMCE.get('rekomen').getContent();

        $('#btnS').text('Menyimpan...'); //change button text
        $('#btnS').attr('disabled', true); //set button disable 

        var url = "";
        url = "<?php echo base_url(); ?>mitra/adddetail";

        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('visimisi', visimisi);
        form_data.append('program', program);
        form_data.append('sdm', sdm);
        form_data.append('weakness', weakness);
        form_data.append('rekomen', rekomen);
        
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });

                $('#btnS').text('Simpan'); //change button text
                $('#btnS').attr('disabled', false); //set button enable 

                $('#btnS').text('Perbarui');
                document.getElementById("btnS").className = "btn btn-warning float-right";
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnS').text('Simpan'); //change button text
                $('#btnS').attr('disabled', false); //set button enable 
            }
        });
    }

    function simpan() {
        var kode = document.getElementById('kode').value;
        var note = tinyMCE.get('note').getContent();
        var idnote = document.getElementById('idnote').value;
        var status = document.getElementById('status').value;
        var startdate = document.getElementById('starttgl').value;
        var enddate = document.getElementById('endtgl').value;
        var staff = $('.select2-demo').val();

        $('#btnSimpan').text('Menyimpan...'); //change button text
        $('#btnSimpan').attr('disabled', true); //set button disable 

        var url = "";
        if(idnote === ''){
            url = "<?php echo base_url(); ?>mitra/submitnote";
        }else{
            url = "<?php echo base_url(); ?>mitra/editnote";
        }

        if(status === "on-going" && startdate === null){
            alert("Tanggal Mulai harus diisi!");
        }else if(status === "done" && enddate === null){
            alert("Tanggal Selesai harus diisi!");
        }

        var form_data = new FormData();
        form_data.append('idmitra', kode);
        form_data.append('note', note);
        form_data.append('idnote', idnote);
        form_data.append('status', status);
        form_data.append('startdate', startdate);
        form_data.append('enddate', enddate);
        form_data.append('staff', staff);
        
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });

                reload();

                $('#btnSimpan').text('Simpan'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSimpan').text('Simpan'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            }
        });
    }

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus Catatan ini?",
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
                        url: "<?php echo base_url(); ?>mitra/hapusnote/" + id,
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

    document.addEventListener("DOMContentLoaded", function() {
        var jeniskemitraan = document.getElementById('jeniskemitraan');

        function toggleDropdown() {
            var selectedOption = jeniskemitraan.value;
            var perluasanDiv = document.getElementById('tipeInstitusiPerluasan');
            var trainingDiv = document.getElementById('tipeInstitusiTraining');

            if (selectedOption === 'Perluasan Bisnis') {
                perluasanDiv.style.display = 'block';
                trainingDiv.style.display = 'none';
            } else if (selectedOption === 'Layanan Training') {
                perluasanDiv.style.display = 'none';
                trainingDiv.style.display = 'block';
            } else {
                perluasanDiv.style.display = 'none';
                trainingDiv.style.display = 'none';
            }
        }

        jeniskemitraan.addEventListener('change', toggleDropdown);
        toggleDropdown(); // Initial call to set correct display

        var statusmitra = document.getElementById('status');

        function toggleDropdown2() {
            var selectedOption2 = statusmitra.value;
            var startDiv = document.getElementById('startdate');
            var endDiv = document.getElementById('enddate');

            if (selectedOption2 === 'on-going') {
                startDiv.style.display = 'block';
                endDiv.style.display = 'none';
            } else if (selectedOption2 === 'done') {
                startDiv.style.display = 'none';
                endDiv.style.display = 'block';
            } else {
                startDiv.style.display = 'none';
                endDiv.style.display = 'none';
            }
        }

        statusmitra.addEventListener('change', toggleDropdown2);
        toggleDropdown2(); // Initial call to set correct display
    });

    function pilih_kabupaten() {
        var provinsi = document.getElementById('provinsi').value;
        var form_data = new FormData();
        form_data.append('provinsi', provinsi);

        $.ajax({
            url: "<?php echo base_url(); ?>mitra/kabupaten",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kabupaten').html(data.status);
                $('[name="kabupaten"]').val("<?php echo $mitra->kotkab; ?>");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    // Panggil fungsi saat halaman dimuat
    window.onload = function() {
        var provinsi = document.getElementById('provinsi').value;
        if (provinsi !== '-') { // Jika provinsi sudah dipilih (bukan opsi default)
            pilih_kabupaten();  // Panggil fungsi untuk memuat kabupaten
        }
    }
</script>