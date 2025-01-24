<script type="text/javascript">
    var save_method; //for save method string
    
    $(document).ready(function () {
        if(<?php echo $peng ?> > 0){
            $('#modal_pengumuman').modal('show');
        }
    });
    
    tinymce.init({
        selector: "textarea#keterangan", theme: "modern", height: 100,
    });

    function clockin() {
        $('#info').hide();
        save_method = 'in';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Absen Masuk');
    }

    function closemodal(){
        $('#modal_form').modal('hide');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var password = document.getElementById('password').value;
        var keterangan = tinyMCE.get('keterangan').getContent();

        var tot = 0;
        if (password === '') {
            document.getElementById('password').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('password').classList.remove('is-invalid'); tot += 1;} 
        if(keterangan === ''){
            $('#errorketerangan').show();
        }else{$('#errorketerangan').hide(); tot += 1;}
        
        if(tot === 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'in') {
                url = "<?php echo base_url(); ?>absen/clockin";
            } else {
                url = "<?php echo base_url(); ?>absen/clockout";
            }

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('password', password);
            form_data.append('keterangan', keterangan);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
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

    function clockout() {
        $('#info').hide();
        save_method = 'out';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Absen Keluar');
        $.ajax({
            url: "<?php echo base_url(); ?>absen/cek/",
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idabsensi);
                tinyMCE.get('keterangan').setContent(data.note1);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
</script>
<div class="container flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="ion ion-ios-log-in display-4 d-block text-primary"></i>
                            
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-primary"><b>CLOCK-IN</b></span>
                                <br>
                            </span>
                            <?php if($clockin == '') {?>
                            <button onclick="clockin();" class="btn btn-primary btn-round d-block float-right"><i class="feather icon-clock"></i>&nbsp; CLOCK IN</button>
                            <?php } else{
                                echo '<span class="text-big mr-1 text-secondary"><b>'.date('h:i',strtotime($clockin)).'</b></span>';
                            } ?>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="ion ion-ios-log-out display-4 d-block text-warning"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-warning"><b>CLOCK-OUT</b></span>
                                <br>
                            </span>
                            <?php if($clockin != '' && $clockout == '') {?>
                            <button onclick="clockout();" class="btn btn-warning btn-round d-block float-right"><i class="feather icon-clock"></i>&nbsp; CLOCK OUT</button>
                            <?php } else if($clockout != ''){
                                echo '<span class="text-big mr-1 text-secondary"><b>'.date('h:i',strtotime($clockout)).'</b></span>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($pro->minat == null){?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-dark-warning alert-dismissible fade show">
                Kamu belum ngisi <b>Data Profilmu</b> nih! <a href="<?php echo base_url(); ?>riwayat"><b>Isi yukk..</b></a>
            </div>
        </div>
    </div>
    <?php } if($kary->ktp == null){?>
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-dark-info alert-dismissible fade show">
                Kamu belum ngisi <b>Data Lengkapmu</b> nih! <a href="<?php echo base_url(); ?>personal" style="color: #000"><b>Isi yukk..</b></a>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="row">
        <div class="col-xl-5 col-md-6">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="oi oi-home bg-primary ui-rounded-icon"></i>
                    <h4 class="mt-2">PROFIL <span class="text-primary">LEAP</span></h4>
                    <p class="mb-3">Berdiri sejak tahun 2006 dan telah memfasilitasi pembelajaran bahasa Inggris untuk anak mulai usia 5 tahun hingga dewasa. </p>
                    <a href="<?php echo base_url() ?>profilleap" class="btn btn-primary btn-sm btn-round" style="color: #fff;">Lihat Lebih Banyak</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-user-tie bg-warning ui-rounded-icon"></i>
                    <h4 class="mt-2">KARYAWAN <span class="text-primary">LEAP</span></h4>
                    <p>Klik tombol dibawah <br> untuk lihat profil lengkap rekan kerjamu. <i class="lnr lnr-smile"></i></p>
                    <a href="<?php echo base_url() ?>karyawan" class="btn btn-warning btn-sm btn-round" style="color: #fff;">Lihat Lebih Banyak</a>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card mb-4">
                <h5 class="card-header"><i class="fas fa-birthday-cake text-danger"></i> Ulang Tahun <?php echo strtoupper(date("F Y")); ?></h5>
                <div class="card-body">
                    <div class="review-block">
                        <?php foreach($bday->getResult() as $row){
                        if($row->foto == null){
                            $def_foto = base_url().'/images/noimg.jpg';
                        }else{
                            $def_foto = $row->foto;
                        }?>
                        <div class="row pt-0 pb-2">
                            <div class="col-sm-auto pb-2">
                                <img src="<?php echo base_url().'/uploads/'.$def_foto?>" alt="user image" style="height:50px; width:50px; object-fit: cover;" class="img-fluid rounded-circle ui-w-50 ml-0">
                            </div>
                            <div class="col">
                                <h6 class="m-b-15"><?php echo $row->nama ?></h6>
                                <p class="mt-2 m-b-15 text-muted"> <?php echo $row->tgl.' '.date("F")?></p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- first card start -->
        <!-- Staustic card 11 Start -->
        <div class="col-sm-3">
            <div class="card bg-primary text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $hadir->jml; ?></h2>
                    <h5 class="text-white">JUMLAH KEHADIRAN</h5>
                    <i class="feather icon-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-success text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $tepat->jml; ?></h2>
                    <h5 class="text-white">TEPAT WAKTU</h5>
                    <i class="feather icon-thumbs-up"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-danger text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $telat->jml; ?></h2>
                    <h5 class="text-white">TERLAMBAT</h5>
                    <i class="feather icon-user-minus"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-warning text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $jam;?></h2>
                    <h5 class="text-white">TABUNGAN JAM</h5>
                    <i class="feather icon-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="fas fa-calendar-times display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger">TOTAL : <?php echo $ijin; ?></span>
                                <br>
                                <small class="text-muted"></a href="<?php echo base_url();?>perijinan">PERIJINAN BULAN <?php echo strtoupper(date('F Y')); ?></a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="fas fa-clock display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger">TOTAL : <?php echo $lembur; ?></span>
                                <br>
                                <small class="text-muted"></a href="<?php echo base_url();?>perijinan">LEMBUR BULAN <?php echo strtoupper(date('F Y')); ?></a></small>
                            </span>
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
                    <div class="row">
                        <input type="hidden" id="kode" name="kode">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input class="form-control" id="password" name="password" type="password">
                                <small class="invalid-feedback">Password wajib diisi</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tugas Hari Ini</label>
                                <textarea class="form-control" rows="3" id="keterangan" name="keterangan"></textarea>
                                <small class="invalid-feedback" id="errorketerangan">Keterangan Tugas Hari Ini wajib diisi</small>
                            </div>
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
    
<div class="modal fade" id="modal_pengumuman">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pengumuman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        $counter = 0;
                        foreach ($pengumuman->getResult() as $row) {
                            if($counter == 0){
                                ?>
                        <li data-target="#carouselExample" data-slide-to="<?php echo $counter; ?>" class="active"></li>
                                <?php
                            }else{
                                ?>
                        <li data-target="#carouselExample" data-slide-to="<?php echo $counter; ?>"></li>
                                <?php
                            }
                            $counter++;
                        }
                        ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php
                        $counter = 0;
                        foreach ($pengumuman->getResult() as $row) {
                            $img = base_url().'/images/white.png';
                            if(strlen($row->gambar) > 0){
                                if(file_exists('uploads/'.$row->gambar)){
                                    $img = base_url().'/uploads/'.$row->gambar;
                                }
                            }
                            
                            if($counter == 0){
                                ?>
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="<?php echo $img; ?>" alt="First slide">
                            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(0, 0, 0, 0.5);">
                                <h3><?php echo $row->judul; ?></h3>
                                <p><?php echo $row->isi; ?></p>
                            </div>
                        </div>
                                <?php
                            }else{
                                ?>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="<?php echo $img; ?>" alt="Second slide">
                            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(0, 0, 0, 0.5);">
                                <h3><?php echo $row->judul; ?></h3>
                                <p><?php echo $row->isi; ?></p>
                            </div>
                        </div>
                                <?php
                            }
                            $counter++;
                        }
                        ?>
                        
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

					