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

    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>pelamar/assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>pelamar/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
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
                <div class="progress-bar" role="progressbar" style="width: 43%;" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">3 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Informasi Utama (2)</h3>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" id="work" name="work" value="<?php echo $p->work; ?>">
                    <label for="work">Pekerjaan Terakhir</label>
                    <span id="errorwork" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="ppdk" name="ppdk" value="<?php echo $p->ppdk; ?>">
                    <label for="ppdk">Pendidikan Terakhir</label>
                    <span id="errorppdk" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Pengalaman Kerja <span id="errorpengalaman" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group">
                    <textarea class="form-control" id="pengalaman" name="pengalaman"><?php echo $p->pengalaman; ?></textarea>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" id="wawasan" name="wawasan"><?php echo $p->wawasan; ?></textarea>
                    <label for="wawasan">Apa yang kamu ketahui tentang LEAP?</label>
                    <span id="errorwawasan" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="sehat" name="sehat" value="<?php echo $p->sehat; ?>">
                    <label for="sehat">History Kesehatan</label>
                    <span id="errorsehat" style="color: red;">* Wajib diisi</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="statusnikah" name="statusnikah" value="<?php echo $p->statusnikah; ?>">
                    <label for="statusnikah">Status Pernikahan</label>
                    <span id="errorstatusnikah" style="color: red;">* Wajib diisi</span>
                  </div>
                  <button class="btn float-right" onclick="save()">NEXT</button>
                  <a href="<?php echo base_url().'/lamar/form2/'.$code?>" class="back-to-prev" style="color: black; margin: 20px 0 0;"><b><i class="las la-arrow-left"></i> Back to Previous</b></a>
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

    <script src="<?php echo base_url(); ?>pelamar/js/custom.js"></script>
    <script>
      tinymce.init({
          selector: "textarea#pengalaman", theme: "modern", height: 100,
      });

      $('#errorwork').hide();
      $('#errorppdk').hide();
      $('#errorpengalaman').hide();
      $('#errorwawasan').hide();
      $('#errorsehat').hide();
      $('#errorstatusnikah').hide();

      function save() {
        var kode = document.getElementById('kode').value;
        var work = document.getElementById('work').value;
        var ppdk = document.getElementById('ppdk').value;
        var pengalaman = tinyMCE.get('pengalaman').getContent();
        var wawasan = document.getElementById('wawasan').value;
        var sehat = document.getElementById('sehat').value;
        var statusnikah = document.getElementById('statusnikah').value;

        var tot = 0;
        if (work === '') {$('#errorwork').show();}else{$('#errorwork').hide(); tot += 1;} 
        if (ppdk === '') {$('#errorppdk').show();}else{$('#errorppdk').hide(); tot += 1;} 
        if (pengalaman === '') {$('#errorpengalaman').show();}else{$('#errorpengalaman').hide(); tot += 1;} 
        if (wawasan === '') {$('#errorwawasan').show();}else{$('#errorwawasan').hide(); tot += 1;} 
        if (sehat === '') {$('#errorsehat').show();}else{$('#errorsehat').hide(); tot += 1;} 
        if (statusnikah === '') {$('#errorstatusnikah').show();}else{$('#errorstatusnikah').hide(); tot += 1;} 
        
        if(tot === 6){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitthree";

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('work', work);
            form_data.append('ppdk', ppdk);
            form_data.append('pengalaman', pengalaman);
            form_data.append('wawasan', wawasan);
            form_data.append('sehat', sehat);
            form_data.append('statusnikah', statusnikah);
            
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
                      window.location.href = '<?php echo base_url().'/lamar/form4/' ?>'+data.id;
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
