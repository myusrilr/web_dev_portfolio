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
                <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
                <span class="step-text">1 of 3 completed</span></div>
              </div>
              <div class="form-steps active">
                <h3>Tes IQ </h3>
                <span style="color: #000; font-size: 16px;">Mohon membaca prosedur pengerjaan sampai akhir!!<br>
                <input type="hidden" value="<?php echo base_url().'/lamar/testiq/'.$code ?>" id="myInput">
                <b>Copy link ini jika ingin mensubmit hasil nanti : <button onclick="copyy()">Copy text</button></b><hr></span>
                <center><b>Klik link berikut ini untuk mengerjakan Tes IQ:</b> 
                <br><a href="https://www.tes-iq.com/" target="_blank">https://www.tes-iq.com/</a>
                </center><span>
                <ol>
                  <li>Baca dan ikuti petunjuk lebih lanjut dalam link tes yang disediakan</li>
                  <li>Waktu pengerjaan cukup lama, pastikan saat mengerjakan tidak terganggu dengan aktivitas lain dan dalam kondisi tenang)</li>
                  <li>Pengerjaan cukup dilakukan satu kali dalam sekali pengerjaan (mulai tes harus langsung diselesaikan)</li>
                  <li>Simpan hasil screenshoot dan upload pada form dibawah ini.</li>
                  <li>Tuliskan hasil angka di akhir tes dan tampilkan Screenshotnya pada form dibawah ini.</li>
                </ol>
                Contoh hasil screenshot : <br>
                <img src="<?php echo base_url().'/uploads/tesiq.jpeg'?>" height="200px" style="border: 1px solid #555;"><br><hr>
                </span>
                <div class="job-application-form">
                  <input type="hidden" name="kode" id="kode" value="<?php echo $kode; ?>">
                  <div class="form-group">
                    <input type="text" class="form-control" id="hasil" name="hasil" value="<?php echo $p->hasiliq; ?>">
                    <label for="hasil">Hasil Angka</label>
                    <span id="errorhasil" style="color: red;">* Wajib diisi</span>
                  </div>
                  <h4 class="block-title">Upload Screenshoot</h4>
                  <div class="form-group">
                    <input type="file" id="file" name="file" accept="image/*">
                  </div>  
                  <button class="btn float-right" onclick="save()">NEXT</button>
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
      $('#errorhasil').hide();
      $('#errorgambar').hide();

      function save() {
        var hasil = document.getElementById('hasil').value;
        var kode = document.getElementById('kode').value;
        var gambar = $('#file').prop('files')[0];

        var tot = 0;
        if (hasil === '') {$('#errorhasil').show();}else{$('#errorhasil').hide(); tot += 1;} 
        
        if(tot === 1){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>lamar/submitiq";

            var form_data = new FormData();
            form_data.append('hasil', hasil);
            form_data.append('kode', kode);
            form_data.append('file', gambar);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    if(data.status == "ok" || data.status == "ok_tanpa"){
                      window.location.href = '<?php echo base_url().'/lamar/testminat/' ?>'+data.id;
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

      function copyy() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
        
        // Alert the copied text
        alert("Link berhasil ter-copy");
      }
    </script>
  </body>
</html>
