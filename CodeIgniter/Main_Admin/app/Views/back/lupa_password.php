<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bank Soal</title>
        <link rel="icon" href="<?php echo $logo; ?>" type="image/x-icon">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-box-body">
                <div class="login-logo">
                    <img src="<?php echo $logo; ?>" style="width: 80px;">
                    <br>
                    <a href="<?php echo base_url(); ?>login">BANK<b>SOAL</b></a>
                    <p style="font-size: 14px;"><b>LEAP ENGLISH AND DIGITAL</b></p>
                </div>
                <p class="login-box-msg">Password akan dikirim melalui email anda. Masukkan alamat email yang terdaftar</p>
                <div class="form-group has-feedback">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" autocomplete="off">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">

                    </div>
                    <div class="col-xs-4">
                        <button id="btnProses" type="button" class="btn btn-primary btn-block btn-flat" onclick="proses();">Kirim</button>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>login">Sudah punya akun</a><br>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>back/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>back/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>back/plugins/iCheck/icheck.min.js"></script>
        <script type="text/javascript">

            $(document).ready(function() {

            });

            function proses(){

                var email = document.getElementById('email').value;

                if(email === ""){
                    alert("Email tidak boleh kosong");
                }else{
                    $('#btnProses').text('Prosessing...');
                    $('#btnProses').attr('disabled',true);

                    var form_data = new FormData();
                    form_data.append('email', email);

                    $.ajax({
                        url: "<?php echo base_url(); ?>lupapass/proses",
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            $('#btnProses').text('Sign In');
                            $('#btnProses').attr('disabled', false);
                            
                            alert(response.status);
                            window.location.href = "<?php echo base_url(); ?>login";

                        },error: function (response) {
                            alert(response.status);
                            $('#btnProses').text('Sign In');
                            $('#btnProses').attr('disabled', false);
                        }
                    });
                }
            }

        </script>
    </body>
</html>