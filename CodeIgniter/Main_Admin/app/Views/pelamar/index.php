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
                <div class="progress-bar" role="progressbar" style="width: 14%;" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">1 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Form Rekruitmen Karyawan</h3>
                <span>Untuk mengisi, klik pada bagian bawah tulisan pada field.</span>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    <label for="email">Email</label>
                    <span id="erroremail" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Divisi Tujuan (pendaftaran)</h4>
                  <div class="form-group country-select">
                    <div class="select-input choose-country">
                      <span></span>
                      <?php $cek = 'null';?>
                        <select id="jenis" class="form-control" name="jenis">
                          <?php foreach($lamar->getResult() as $row){ ?>
                          <option value="<?php echo $row->bidang; ?>" <?php if ($jenis == $row->bidang) {$cek = 'ada'; echo 'selected="selected"';} ?>><?php echo $row->bidang; ?></option>
                          <?php } ?>
                          <option value="Other" <?php if($cek == 'null' && $jenis != '') {echo 'selected="selected"';} ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: <?php if($cek == 'null' && $jenis != '') {echo 'flex';}else{ echo 'none'; } ?>" name="jenisinput" id="jenisinput">
                      <input type="text" class="form-control" name="jenisi" id="jenisi" value="<?php echo $jenis; ?>">
                      <label for="jeniss">Other</label>
                    </div>
                    <span id="errorjenis" style="color: red;">* Wajib diisi</span>
                  </div>
                  <button class="btn" onclick="save();">NEXT</button>
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
      var otherInput;
      var serviceTypeInput = $('#jenis');
      serviceTypeInput.on('change', function() {
        otherInput = $('#jenisinput');
        if (serviceTypeInput.val() == "Other") {
          otherInput.show();
        } else {
          otherInput.hide();
        }
      });

      $('#erroremail').hide();
      $('#errorjenis').hide();

      function save() {
        var email = document.getElementById('email').value;
        var jenis = document.getElementById('jenis').value;
        var kode = document.getElementById('kode').value;
        var jenisi = document.getElementById('jenisi').value;

        var tot = 0;
        if (email === '') {$('#erroremail').show();}else{$('#erroremail').hide(); tot += 1;} 
        if (jenis === '') {$('#errorjenis').show();}else{$('#errorjenis').hide(); tot += 1;} 
        
        if(tot === 2){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitone";

            var form_data = new FormData();
            form_data.append('email', email);
            form_data.append('kode', kode);
            if(jenis == 'Other'){
              form_data.append('jenis', jenisi);
            }else{
              form_data.append('jenis', jenis);
            }
            
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
                      window.location.href = '<?php echo base_url().'/lamar/form2/' ?>'+data.id;
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
