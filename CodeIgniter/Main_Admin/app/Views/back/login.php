<!DOCTYPE html>

<html lang="en" class="default-style layout-fixed layout-navbar-fixed">
    <head>
        <title>LEAP | Web Karyawan</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

        <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">

        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

        <!-- Icon fonts -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/fontawesome.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/ionicons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/linearicons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/open-iconic.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/pe-icon-7-stroke.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/fonts/feather.css">

        <!-- Core stylesheets -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/bootstrap-material.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/shreerang-material.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/uikit.css">

        <!-- Libs -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
        <!-- Page -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/pages/authentication.css">
        
        <link rel="stylesheet" href="<?php echo base_url(); ?>izitoast/css/iziToast.min.css">
    </head>

    <body>

        <!-- [ Content ] Start -->
        <div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('<?php echo base_url(); ?>/pelamar/images/bg/2.png');">
            <div class="ui-bg-overlay bg-dark opacity-25"></div>

            <div class="authentication-inner py-5">

                <div class="card">
                    <div class="p-4 p-sm-5">
                        <!-- [ Logo ] Start -->
                        <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                            <div class="ui-w-60">
                                <div class="w-100 position-relative">
                                    <img src="<?php echo base_url(); ?>/back/assets/img/leap.png" alt="Brand Logo" class="img-fluid">
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- [ Logo ] End -->

                        <h5 class="text-center text-muted font-weight-normal mb-4">LOGIN</h5>

                        <!-- Form -->
                        <form>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label d-flex justify-content-between align-items-end">
                                    <span>Password</span>
                                </label>
                                <input type="password" class="form-control" id="pass"  name="pass">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" onclick="showpass()">
                                    <span class="form-check-label">Show Password</span>
                                </label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center m-0">
                                <label class="custom-control custom-checkbox m-0">
                                </label>
                                <button type="button" id="btnProses" class="btn btn-primary" onclick="proses();">MASUK</button>
                            </div>
                        </form>
                        <!-- [ Form ] End -->

                    </div>
                </div>

            </div>
        </div>
        <!-- / Content -->

        <!-- Core scripts -->
        <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/js/pace.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/libs/popper/popper.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/js/bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/js/sidenav.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/js/material-ripple.js"></script>
        <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
        <!-- Libs -->
        <script src="<?php echo base_url(); ?>back/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>

        <!-- Demo -->
        <script type="text/javascript">

            $(document).ready(function () {
                $('#email').keypress(function (e) {
                    var key = e.which;
                    if (key === 13) {
                        $('#pass').focus();
                        $('#pass').select();
                    }
                });

                $('#pass').keypress(function (e) {
                    var key = e.which;
                    if (key === 13) {
                        proses();
                    }
                });
            });

            function showpass() {
                var x = document.getElementById("pass");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

            function proses() {

                var email = document.getElementById('email').value;
                var pass = document.getElementById('pass').value;

                if (email === "") {
                    alert("Email tidak boleh kosong");
                } else if (pass === "") {
                    alert("Password lama tidak boleh kosong");
                } else {
                    $('#btnProses').text('Processing...');
                    $('#btnProses').attr('disabled', true);

                    var form_data = new FormData();
                    form_data.append('email', email);
                    form_data.append('pass', pass);

                    $.ajax({
                        url: "<?php echo base_url(); ?>login/proses",
                        dataType: 'JSON',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'POST',
                        success: function (response) {
                            $('#btnProses').text('Sign In');
                            $('#btnProses').attr('disabled', false);

                            if (response.status === "ok_hr") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_guru") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_bos") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_it") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_pendidikan") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_pengajar") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_busdev") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_ga") {
                                window.location.href = "<?php echo base_url(); ?>homekaryawan";
                            } else if (response.status === "ok_siswa") {
                                window.location.href = "<?php echo base_url(); ?>siswa";
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: response.status,
                                    position: 'topRight'
                                });
                            }

                        }, error: function (response) {
                            iziToast.error({
                                title: 'Error',
                                message: response.status,
                                position: 'topRight'
                            });
                            $('#btnProses').text('Sign In');
                            $('#btnProses').attr('disabled', false);
                        }
                    });
                }
            }

        </script>
    </body>
</html>
