<!doctype html>
<html lang="en">
  <head>
    <title>LEAP | Recruitment</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>pelamar/assets/css/bootstrap.min.css">

    <!-- External Css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>pelamar/assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>pelamar/assets/css/owl.carousel.min.css" />

    <!-- Custom Css --> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>pelamar/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>pelamar/css/job-1.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  </head>
  <body>

    <div class="ugf-wrapper">
      <div class="logo">
        <img src="<?php echo base_url(); ?>back/assets/img/logo-light.png" class="img-fluid logo-white" alt="" style="width:200px; height: 190px;">
      </div>
      <div class="ugf-content-block">
        <div class="content-block">
          <h1>Rekruitmen Karyawan</h1>
          <p style="text-align: justify;">LEAP is a non-formal education institution under the Ministry of Research, Technology, and Higher Education in Indonesia. 
            <br><br>Our programs vary from English, coding, digital marketing, and digital application classes for children, teenagers, adults, and professionals. We are also open for B2B inquiries and collaboration.</p>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 offset-lg-7">
            <div class="ufg-job-application-wrapper pt80">
              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 71%;" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">5 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Informasi Tambahan</h3>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <h4 class="block-title">Akses internet yang Anda miliki saat ini <span id="errorinternet" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="internet" class="custom-control-input" id="kuota" value="Paket data internet HP (Kuota)" <?php echo ($p->internet=='Paket data internet HP (Kuota)')?'checked':''; ?>>
                      <label class="custom-control-label" for="kuota">Paket data internet HP (Kuota)</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="internet" class="custom-control-input" id="wifi" value="WiFi" <?php echo ($p->internet=='WiFi')?'checked':''; ?>>
                      <label class="custom-control-label" for="wifi">WiFi</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="kegiatan" name="kegiatan"><?php echo $p->kegiatan; ?></textarea>
                    <label for="kegiatan">Kegiatan saat ini</label>
                    <span id="errorkegiatan" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="rencana" name="rencana"><?php echo $p->rencana; ?></textarea>
                    <label for="rencana">Rencana 3 tahun ke depan</label>
                    <span id="errorrencana" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Mobilitas yang saat ini digunakan <span id="errormobilitas" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="mobilitas" class="custom-control-input" id="motor" value="Motor Pribadi" <?php echo ($p->ajar=='Ya Pernah')?'checked':''; ?>>
                      <label class="custom-control-label" for="motor">Motor Pribadi</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="mobilitas" class="custom-control-input" id="mobil" value="Mobil Pribadi" <?php echo ($p->mobilitas=='Mobil Pribadi')?'checked':''; ?>>
                      <label class="custom-control-label" for="mobil">Mobil Pribadi</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="mobilitas" class="custom-control-input" id="ojol" value="Kendaraan Umum / Ojek Online" <?php echo ($p->mobilitas=='Kendaraan Umum / Ojek Online')?'checked':''; ?>>
                      <label class="custom-control-label" for="ojol">Kendaraan Umum / Ojek Online</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="mobilitas" class="custom-control-input" id="lain" value="Lainnya" <?php echo ($p->mobilitas=='Lainnya')?'checked':''; ?>>
                      <label class="custom-control-label" for="lain">Lainnya</label>
                    </div>
                  </div>
                  <h4 class="block-title">Darimana Anda mengetahui informasi tentang lowongan ini?</h4>
                  <div class="form-group country-select">
                    <div class="select-input choose-country">
                      <span></span>
                        <select id="info" class="form-control" name="info">
                          <option value="IG Leap Surabaya" <?php echo ($p->info=='IG Leap Surabaya')?'selected':''; ?>>IG Leap Surabaya</option>
                          <option value="Website Leap Surabaya" <?php echo ($p->info=='Website Leap Surabaya')?'selected':''; ?>>Website Leap Surabaya</option>
                          <option value="Broadcast WA" <?php echo ($p->info=='Broadcast WA')?'selected':''; ?>>Broadcast WA</option>
                          <option value="Saudara atau kerabat" <?php echo ($p->info=='Saudara atau kerabat')?'selected':''; ?>>Saudara atau kerabat</option>
                          <option value="LinkedIn" <?php echo ($p->info=='LinkedIn')?'selected':''; ?>>LinkedIn</option>
                          <option value="Google" <?php echo ($p->info=='Google')?'selected':''; ?>>Google</option>
                          <option value="Lainnya" <?php echo ($p->info=='Lainnya')?'selected':''; ?>>Lainnya</option>
                        </select>
                    </div>
                    <span id="errorinfo" style="color: red;">* Wajib diisi</span>
                  </div>
                  <button class="btn float-right" onclick="save()">NEXT</button>
                  <a href="<?php echo base_url().'/lamar/form4/'.$code?>" class="back-to-prev" style="color: black; margin: 20px 0 0;"><b><i class="las la-arrow-left"></i> Back to Previous</b></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer">
        <div class="social-links">
          <a href="https://www.facebook.com/LeapSurabaya/?locale=id_ID"><i class="lab la-facebook-f"></i></a>
          <a href="https://www.linkedin.com/company/leap-english-digital-class/?originalSubdomain=id"><i class="lab la-linkedin-in"></i></a>
          <a href="https://www.instagram.com/leapsurabaya/?hl=en"><i class="lab la-instagram"></i></a>
        </div>
        <div class="copyright">
          <p>Copyright © 2023 Leap Surabaya. All Rights Reserved</p>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>pelamar/assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>pelamar/assets/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>pelamar/js/custom.js"></script>
    <script>

      $('#errorinternet').hide();
      $('#errormobilitas').hide();
      $('#errorinfo').hide();
      $('#errorrencana').hide();
      $('#errorkegiatan').hide();

      function save() {
        var kode = document.getElementById('kode').value;
        var kegiatan = document.getElementById('kegiatan').value;
        var rencana = document.getElementById('rencana').value;
        var internet = $("input[name='internet']:checked").val();
        var mobilitas = $("input[name='mobilitas']:checked").val();
        var info = document.getElementById('info').value;

        var tot = 0;
        if (kegiatan === '') {$('#errorkegiatan').show();}else{$('#errorkegiatan').hide(); tot += 1;} 
        if (rencana === '') {$('#errorrencana').show();}else{$('#errorrencana').hide(); tot += 1;} 
        if (info === '') {$('#errorinfo').show();}else{$('#errorinfo').hide(); tot += 1;} 
        if (internet === undefined) {$('#errorinternet').show();}else{$('#errorinternet').hide(); tot += 1;} 
        if (mobilitas === undefined) {$('#errormobilitas').show();}else{$('#errormobilitas').hide(); tot += 1;} 
        
        if(tot === 5){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitfive";

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('kegiatan', kegiatan);
            form_data.append('rencana', rencana);
            form_data.append('info', info);
            form_data.append('internet', internet);
            form_data.append('mobilitas', mobilitas);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if(data.status == "ok"){
                      window.location.href = '<?php echo base_url().'/lamar/form6/' ?>'+data.id;
                    }

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
    </script>
  </body>
</html>
