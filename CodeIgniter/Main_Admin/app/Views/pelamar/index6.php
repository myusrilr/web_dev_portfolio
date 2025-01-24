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
                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">6 of 6 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Ketersediaan</h3>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <h4 class="block-title">Jika saat ini sudah bekerja, apakah ada rencana mengundurkan diri? 
                    <span id="errorresign" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group">
                    <input type="text" class="form-control" id="resign" name="resign">
                    <label for="wfo">(Ya/Tidak, sertai dengan alasan)</label>
                  </div>
                  <h4 class="block-title">Bersedia untuk bekerja secara offline (WFO) di lokasi kantor LEAP (Rungkut Asri Tengah VII/51, Surabaya) 
                    <span id="errorwfo" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group">
                    <textarea class="form-control" id="wfo" name="wfo"></textarea>
                    <label for="wfo">(Ya/Tidak, sertai dengan alasan)</label>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" id="gaji" name="gaji">
                    <label for="gaji">Gaji yang Diharapkan</label>
                    <span id="errorgaji" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Upload CV, ijazah, transkrip, KTP, NPWP, KK, sertifikat (TOEFL dll) dalam 1 file pdf dan masukkan ke dalam google drive Anda</h4>
                  <div class="form-group">
                    <input type="text" class="form-control" id="link" name="link">
                    <label for="link">URL Link Google Drive</label>
                    <span id="errorlink" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Jika saya diterima, paling cepat saya bisa mulai bergabung/ magang di LEAP Surabaya pada tanggal : 
                    <span id="errorbergabung" style="color: red;">* Wajib diisi</span></h4>
                  <div class="form-group">
                    <input type="date" name="bergabung" class="form-control" id="bergabung">
                    <label for="inputText">Pilih tanggal</label>
                  </div>
                  <div class="form-group check-group">
                    <div class="custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="setuju" name="setuju">
                      <label class="custom-control-label" for="setuju">Saya menyatakan bahwa semua informasi yang saya berikan dalam formulir ini benar. <span id="errorsetuju" style="color: red;">*Wajib</span></label>
                    </div>
                  </div>
                  <button class="btn float-right" onclick="save()" id="btnSave">Submit</button>
                  <a href="<?php echo base_url().'/lamar/form5/'.$code?>" class="back-to-prev" style="color: black; margin: 20px 0 0;"><b><i class="las la-arrow-left"></i> Back to Previous</b></a>
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
      $('#errorresign').hide();
      $('#errorwfo').hide();
      $('#errorgaji').hide();
      $('#errorlink').hide();
      $('#errorbergabung').hide();
      $('#errorsetuju').hide();

      var rupiah = document.getElementById('gaji');
      rupiah.addEventListener('keyup', function(e){
          // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
          // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
          rupiah.value = formatRupiah(this.value, 'Rp. ');
      });
      /* Fungsi formatRupiah */
      function formatRupiah(angka, prefix){
          var number_string = angka.replace(/[^,\d]/g, '').toString(),
          split           = number_string.split(','),
          sisa             = split[0].length % 3,
          rupiah             = split[0].substr(0, sisa),
          ribuan             = split[0].substr(sisa).match(/\d{3}/gi);

          // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
          if(ribuan){
              separator = sisa ? '.' : '';
              rupiah += separator + ribuan.join('.');
          }

          rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
          return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }

      function save() {
        var kode = document.getElementById('kode').value;
        var gaji = document.getElementById('gaji').value;
        var link = document.getElementById('link').value;
        var resign = document.getElementById('resign').value;
        var wfo = document.getElementById('wfo').value;
        var bergabung = document.getElementById('bergabung').value;
        var setuju = document.getElementById('setuju').checked;

        var tot = 0;
        if (gaji === '') {$('#errorgaji').show();}else{$('#errorgaji').hide(); tot += 1;} 
        if (link === '') {$('#errorlink').show();}else{$('#errorlink').hide(); tot += 1;} 
        if (resign === '') {$('#errorresign').show();}else{$('#errorresign').hide(); tot += 1;} 
        if (wfo === '') {$('#errorwfo').show();}else{$('#errorwfo').hide(); tot += 1;} 
        if (bergabung === '') {$('#errorbergabung').show();}else{$('#errorbergabung').hide(); tot += 1;} 
        if (setuju === false) {$('#errorsetuju').show();}else{$('#errorsetuju').hide(); tot += 1;} 
        
        if(tot === 6){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitsix";

            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('gaji', gaji);
            form_data.append('link', link);
            form_data.append('resign', resign);
            form_data.append('wfo', wfo);
            form_data.append('bergabung', bergabung);
            
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
                      window.location.href = '<?php echo base_url().'/lamar/submitview/'?>'+data.id;
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
