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
                <div class="progress-bar" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">2 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Informasi Utama</h3>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $p->nama; ?>">
                    <label for="nama">Nama Lengkap</label>
                    <span id="errornama" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="panggilan" name="panggilan" value="<?php echo $p->panggilan; ?>">
                    <label for="panggilan">Nama Panggilan</label>
                    <span id="errorpanggilan" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Jenis Kelamin <span id="errorjk" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="jk" class="custom-control-input" id="lk" value="Laki-laki" <?php echo ($p->jk=='Laki-laki')?'checked':''; ?>>
                      <label class="custom-control-label" for="lk">Laki-laki</label>
                    </div>
                  </div>
                  <div class="form-group radio-group">
                    <div class="custom-radio">
                      <input type="radio" name="jk" class="custom-control-input" id="pr" value="Perempuan" <?php echo ($p->jk=='Perempuan')?'checked':''; ?>>
                      <label class="custom-control-label" for="pr">Perempuan</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="ttl" name="ttl" value="<?php echo $p->ttl; ?>">
                    <label for="ttl">Tempat & Tanggal Lahir</label>
                    <span>Contoh : Surabaya, 1 Januari 1990</span><br>
                    <span id="errorttl" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="domisili" name="domisili" value="<?php echo $p->domisili; ?>">
                    <label for="domisili">Kota domisili saat ini (tempat tinggal)</label>
                    <span id="errordomisili" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $p->alamat; ?>">
                    <label for="alamat">Alamat lengkap saat ini</label>
                    <span id="erroralamat" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="wa" name="wa" onkeypress="return hanyaAngka(event,false);" value="<?php echo $p->wa; ?>">
                    <label for="wa">No. HP (WhatsApp)</label>
                    <span>Contoh : 081234xxxx</span><br>
                    <span id="errorwa" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="fb" name="fb" value="<?php echo $p->fb; ?>">
                    <label for="fb">URL Akun Facebook (Optional)</label>
                    <span id="errorfb" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="ig" name="ig" value="<?php echo $p->ig; ?>">
                    <label for="ig">URL Akun Instagram (Optional)</label>
                    <span id="errorig" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="<?php echo $p->linkedin; ?>">
                    <label for="linkedin">URL Akun Linkedin</label>
                    <span id="errorlinkedin" style="color: red;">* Wajib diisi</span>
                  </div>
                  <button class="btn float-right" onclick="save();">NEXT</button>
                  <a href="<?php echo base_url().'/lamar/mulai/'.$code?>" class="back-to-prev" style="color: black; margin: 20px 0 0;"><b><i class="las la-arrow-left"></i> Back to Previous</b></a>
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
      function hanyaAngka(e, decimal) {
        var key;
        var keychar;
        if (window.event) {
            key = window.event.keyCode;
        } else if (e) {
            key = e.which;
        } else {
            return true;
        }
        keychar = String.fromCharCode(key);
        if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
            return true;
        } else if ((("0123456789").indexOf(keychar) > -1)) {
            return true;
        } else if (decimal && (keychar == ".")) {
            return true;
        } else {
            return false;
        }
      }

      $('#errornama').hide();$('#errorpanggilan').hide();
      $('#errorjk').hide();$('#errorttl').hide();
      $('#errordomisili').hide();$('#erroralamat').hide();
      $('#errorlinkedin').hide();$('#errorfb').hide();
      $('#errorig').hide();$('#errorwa').hide();
      

      function save() {
        var nama = document.getElementById('nama').value;
        var panggilan = document.getElementById('panggilan').value;
        var jk = $("input[name='jk']:checked").val();
        var ttl = document.getElementById('ttl').value;
        var domisili = document.getElementById('domisili').value;
        var alamat = document.getElementById('alamat').value;
        var wa = document.getElementById('wa').value;
        var ig = document.getElementById('ig').value;
        var kode = document.getElementById('kode').value;
        var fb = document.getElementById('fb').value;
        var linkedin = document.getElementById('linkedin').value;

        var tot = 0;
        if (nama === '') {$('#errornama').show();}else{$('#errornama').hide(); tot += 1;} 
        if (panggilan === '') {$('#errorpanggilan').show();}else{$('#errorpanggilan').hide(); tot += 1;} 
        if (jk === undefined) {$('#errorjk').show();}else{$('#errorjk').hide(); tot += 1;} 
        if (ttl === '') {$('#errorttl').show();}else{$('#errorttl').hide(); tot += 1;} 
        if (domisili === '') {$('#errordomisili').show();}else{$('#errordomisili').hide(); tot += 1;} 
        if (alamat === '') {$('#erroralamat').show();}else{$('#erroralamat').hide(); tot += 1;} 
        if (wa === '') {$('#errorwa').show();}else{$('#errorwa').hide(); tot += 1;} 
        // if (ig === '') {$('#errorig').show();}else{$('#errorig').hide(); tot += 1;} 
        // if (fb === '') {$('#errorfb').show();}else{$('#errorfb').hide(); tot += 1;} 
        if (linkedin === '') {$('#errorlinkedin').show();}else{$('#errorlinkedin').hide(); tot += 1;} 
        
        if(tot === 8){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submittwo";

            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('panggilan', panggilan);
            form_data.append('jk', jk);
            form_data.append('ttl', ttl);
            form_data.append('domisili', domisili);
            form_data.append('alamat', alamat);
            form_data.append('kode', kode);
            form_data.append('wa', wa);
            form_data.append('fb', fb);
            form_data.append('ig', ig);
            form_data.append('linkedin', linkedin);
            
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
                      window.location.href = '<?php echo base_url().'/lamar/form3/' ?>'+data.id;
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
