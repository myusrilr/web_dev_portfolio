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
                <div class="progress-bar" role="progressbar" style="width: 56%;" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">4 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Informasi Utama (2)</h3>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" id="toefl" name="toefl" value="<?php echo $p->toefl; ?>">
                    <label for="toefl">Berapa hasil Tes TOEFL Anda? (Jika tidak memiliki silakan isi angka 0)</label>
                    <span id="errortoefl" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Aplikasi/program digital yang telah dikuasai 
                  <span id="errorapp" style="color: red;">* Wajib diisi</span><br><small>Bisa memilih lebih dari satu..</small></h4>
                  <?php $coba = explode(';,',$p->app); //str_replace(';','',$coba[1]);?>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi1" name="app[]" value="Microsoft Office (Word, Power Point, dll)" <?php if(in_array("Microsoft Office (Word, Power Point, dll)", str_replace(';','',$coba))){ echo " checked=\"checked\""; } ?>>
                      <label class="custom-control-label" for="aplikasi1">Microsoft Office (Word, Power Point, dll)</label>
                    </div>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi2" name="app[]" value="Google Apps (Docs, Slides, dll)" <?php if(in_array("Google Apps (Docs, Slides, dll)", str_replace(';','',$coba))){ echo " checked=\"checked\""; }?>>
                      <label class="custom-control-label" for="aplikasi2">Google Apps (Docs, Slides, dll)</label>
                    </div>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi3" name="app[]" value="Aplikasi Desain (Photoshop, Canva, dll)" <?php if(in_array("Aplikasi Desain (Photoshop, Canva, dll)", str_replace(';','',$coba))){ echo " checked=\"checked\""; }?>>
                      <label class="custom-control-label" for="aplikasi3">Aplikasi Desain (Photoshop, Canva, dll)</label>
                    </div>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi4" name="app[]" value="Scratch (Aplikasi Coding)" <?php if(in_array("Scratch (Aplikasi Coding)", str_replace(';','',$coba))){ echo " checked=\"checked\""; }?>>
                      <label class="custom-control-label" for="aplikasi4">Scratch (Aplikasi Coding)</label>
                    </div>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi5" name="app[]" value="Zoom Meeting" <?php if(in_array("Zoom Meeting", str_replace(';','',$coba))){ echo " checked=\"checked\""; }?>>
                      <label class="custom-control-label" for="aplikasi5">Zoom Meeting</label>
                    </div>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="aplikasi6" onclick="var input = document.getElementById('name2'); if(this.checked){ input.disabled = false; input.focus();}else{input.disabled=true;}"
                      >
                      <label class="custom-control-label" for="aplikasi6">Others</label>&ensp;&ensp;
                      <input class="custom-control-label" for="aplikasi6" id="name2" name="name2" disabled="disabled" />
                    </div>
                  </div>
                  <h4 class="block-title">Apakah pernah mengajar secara daring? <span id="errorajar" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="ajar" class="custom-control-input" id="yap" value="Ya Pernah" <?php echo ($p->ajar=='Ya Pernah')?'checked':''; ?>>
                      <label class="custom-control-label" for="yap">Ya Pernah</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="ajar" class="custom-control-input" id="tdk" value="Tidak Pernah" <?php echo ($p->ajar=='Tidak Pernah')?'checked':''; ?>>
                      <label class="custom-control-label" for="tdk">Tidak Pernah</label>
                    </div>
                  </div>
                  <h4 class="block-title">Jika pernah mengajar secara daring, sebutkan semua aplikasi / program yang pernah digunakan untuk mengajar secara daring tersebut!
                    <span id="errorapps" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group">
                    <input type="text" class="form-control" id="apps" name="apps" value="<?php echo $p->apps; ?>">
                    <label for="wfo">(Tuliskan secara detail)</label>
                  </div>
                  <h4 class="block-title">Apakah Anda punya laptop/komputer sendiri? <span id="errorpunya" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="laptop" class="custom-control-input" id="yapunya" value="Ya, Punya" <?php echo ($p->laptop=='Ya, Punya')?'checked':''; ?>>
                      <label class="custom-control-label" for="yapunya">Ya, Punya</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="laptop" class="custom-control-input" id="tidakpunya" value="Tidak Punya" <?php echo ($p->laptop=='Tidak Punya')?'checked':''; ?>>
                      <label class="custom-control-label" for="tidakpunya">Tidak Punya</label>
                    </div>
                  </div>
                  <h4 class="block-title">Apakah Anda biasa mengoperasikan laptop/komputer sebelumnya? <br><span id="errorlaptop" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="gunalaptop" class="custom-control-input" id="yapernah" value="Ya, Pernah" <?php echo ($p->gunalaptop=='Ya, Pernah')?'checked':''; ?>>
                      <label class="custom-control-label" for="yapernah">Ya, Pernah</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="gunalaptop" class="custom-control-input" id="tidakpernah" value="Tidak Pernah" <?php echo ($p->gunalaptop=='Tidak Pernah')?'checked':''; ?>>
                      <label class="custom-control-label" for="tidakpernah">Tidak Pernah</label>
                    </div>
                  </div>
                  <button class="btn float-right" onclick="save()">NEXT</button>
                  <a href="<?php echo base_url().'/lamar/form3/'.$code?>" class="back-to-prev" style="color: black; margin: 20px 0 0;"><b><i class="las la-arrow-left"></i> Back to Previous</b></a>
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

      $('#errortoefl').hide();
      $('#errorapp').hide();
      $('#errorajar').hide();
      $('#errorlaptop').hide();
      $('#errorapps').hide();
      $('#errorpunya').hide();

      function save() {
        var kode = document.getElementById('kode').value;
        var toefl = document.getElementById('toefl').value;
        var app = $("input[name='app[]']:checked").map(function(){return $(this).val()+';';}).get();
        var ajar = $("input[name='ajar']:checked").val();
        var laptop = $("input[name='laptop']:checked").val();
        var apps = document.getElementById('apps').value;
        var gunalaptop = $("input[name='gunalaptop']:checked").val();
        
        $cek = $("input[name='app[]']:checked").length;

        var tot = 0;
        if (toefl === '') {$('#errortoefl').show();}else{$('#errortoefl').hide(); tot += 1;} 
        if (app === '') {$('#errorapp').show();}else{$('#errorapp').hide(); tot += 1;} 
        if (ajar === undefined) {$('#errorajar').show();}else{$('#errorajar').hide(); tot += 1;} 
        if (laptop === undefined) {$('#errorpunya').show();}else{$('#errorpunya').hide(); tot += 1;} 
        if (gunalaptop === undefined) {$('#errorlaptop').show();}else{$('#errorlaptop').hide(); tot += 1;} 
        if (apps === '') {$('#errorapps').show();}else{$('#errorapps').hide(); tot += 1;} 
        
        if(tot === 6){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitfour";

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('toefl', toefl);
            form_data.append('app', app);
            form_data.append('ajar', ajar);
            form_data.append('apps', apps);
            form_data.append('laptop', laptop);
            form_data.append('gunalaptop', gunalaptop);
            
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
                      window.location.href = '<?php echo base_url().'/lamar/form5/' ?>'+data.id;
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
