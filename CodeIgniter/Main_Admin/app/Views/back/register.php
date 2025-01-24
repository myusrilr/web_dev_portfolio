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
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/timepicker/timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/minicolors/minicolors.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-maxlength/bootstrap-maxlength.css">

    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/pages/authentication.css">
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Content ] Start -->
    <div class="authentication-wrapper authentication-2 ui-bg-cover ui-bg-overlay-container px-4" style="background-image: url('<?php echo base_url(); ?>back/assets/img/bg/21.jpg');">
        <div class="ui-bg-overlay bg-dark opacity-25"></div>

        <div class="authentication-inner py-5" style="max-width: 1000px;">

            <div class="card">
                <div class="p-4 p-sm-5">
                    <!-- [ Logo ] Start -->
                    <div class="d-flex justify-content-center align-items-center pb-2 mb-4">
                        <div class="ui-w-60">
                            <div class="w-100 position-relative">
                                <img src="<?php echo base_url(); ?>back/assets/img/leap.png" alt="Brand Logo" class="img-fluid">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Logo ] End -->

                    <h5 class="text-center text-muted font-weight-normal mb-4">Create an Account</h5>

                    <!-- Form -->
                    <form>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Panggilan</label>
                                <input type="text" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" id="datepicker-base">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="08__ - ____ - ____" mask="08__ - ____ - ____" placeholder="08__ - ____ - ____">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Pribadi</label>
                                <input type="text" id="email" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Kantor</label>
                                <input type="text" id="text-mask-email2" class="form-control" placeholder=" @leapsurabaya.sch.id">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Tahun Masuk Kerja</label>
                                <input type="text" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" placeholder="__.___.___._-___.___">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">BPJS Ketenagakerjaan</label>
                                <input type="text" class="form-control bootstrap-maxlength-example" onkeypress="return hanyaAngka(event,false);" maxlength="11">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">BPJS Kesehatan</label>
                                <input type="text" class="form-control bootstrap-maxlength-example" onkeypress="return hanyaAngka(event,false);" maxlength="13">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor KTP</label>
                                <input type="text" class="form-control bootstrap-maxlength-example" onkeypress="return hanyaAngka(event,false);" maxlength="16">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" class="form-control bootstrap-maxlength-example" onkeypress="return hanyaAngka(event,false);" maxlength="16">
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Domisili Sekarang</label>
                                <input type="text" class="form-control">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                       
                        <button type="button" class="btn btn-primary btn-block mt-4">Sign Up</button>
                    </div>
                    </form>
                    <!-- [ Form ] End -->

                </div>
                <div class="card-footer py-3 px-4 px-sm-5">
                    <div class="text-center text-muted">
                        Already have an account?
                        <a href="pages_authentication_login-v2.html">Sign In</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- / Content -->

    <!-- Core scripts -->
    <script src="<?php echo base_url(); ?>back/assets/js/pace.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/sidenav.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/layout-helpers.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/material-ripple.js"></script>

    <!-- Libs -->
    <script src="<?php echo base_url(); ?>back/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/moment/moment.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/timepicker/timepicker.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/libs/minicolors/minicolors.js"></script>    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <!-- Demo -->
    <script src="<?php echo base_url(); ?>back/assets/js/demo.js"></script><script src="<?php echo base_url(); ?>back/assets/js/analytics.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/pages/forms_pickers.js"></script>
    <script src="<?php echo base_url(); ?>back/assets/js/pages/forms_extras.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>back/assets/src/phonemask.min.js"></script>
    <script type="text/javascript">
        const cssPhone = 'input[name="phone"';
        (new phoneMask()).init(cssPhone);

        $("#npwp").inputmask({"mask": "99.999.999.9-999.999"});
        $("#email").inputmask("email");

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
    </script>
</body>

</html>
