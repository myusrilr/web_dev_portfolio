<!DOCTYPE html>

<html lang="en" class="default-style">

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
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/bootstrap-material.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/shreerang-material.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/css/uikit.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/datatables/datatables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-sweetalert/bootstrap-sweetalert.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/timepicker/timepicker.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/minicolors/minicolors.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>izitoast/css/iziToast.min.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-maxlength/bootstrap-maxlength.css">

    <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] Ebd -->
    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-1 layout-without-sidenav">
        <div class="layout-inner">
            <!-- [ Layout navbar ( Header ) ] Start -->
            <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white" id="layout-navbar">
                <div class="container">
                    <a href="<?php echo base_url();?>homekaryawan" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                            <img src="<?php echo base_url(); ?>back/assets/img/leap.png" alt="Brand Logo" class="img-fluid" style="height: 30px;">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">Leap Surabaya</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <!-- Divider -->
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center ml-auto">
                            <!-- Divider -->
                            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                            <div class="demo-navbar-user nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <img src="<?php echo $foto_profile; ?>" alt class="d-block ui-w-30 rounded-circle" style="height:30px; width:30px; object-fit: cover;"> 
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?php echo $nm_role; ?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if(session()->get("pd")){?>
                                    <a href="<?php echo base_url(); ?>homependidikan" class="dropdown-item">
                                        <i class="feather icon-monitor text-muted"></i> &nbsp; Home Pendidikan</a>
                                    <?php } ?>
                                    <?php if(session()->get("it")){?>
                                    <a href="<?php echo base_url(); ?>homeit" class="dropdown-item">
                                        <i class="feather icon-cpu text-muted"></i> &nbsp; Home IT</a>
                                    <?php } ?>
                                    <?php if(session()->get("hr")){?>
                                    <a href="<?php echo base_url(); ?>home" class="dropdown-item">
                                        <i class="feather icon-users text-muted"></i> &nbsp; Home HR</a>
                                    <?php } ?>
                                    <?php if(session()->get("ga")){?>
                                    <a href="<?php echo base_url(); ?>homega" class="dropdown-item">
                                        <i class="feather icon-settings text-muted"></i> &nbsp; Home GA</a>
                                    <?php } ?>
                                    <?php if(session()->get("busdev")){?>
                                    <a href="<?php echo base_url(); ?>homebusdev" class="dropdown-item">
                                        <i class="feather icon-camera text-muted"></i> &nbsp; Home Busdev</a>
                                    <?php } ?>
                                    <?php if(session()->get("bos")){?>
                                    <a href="<?php echo base_url(); ?>homepimpinan" class="dropdown-item">
                                        <i class="feather icon-briefcase text-muted"></i> &nbsp; Home Pimpinan</a>
                                    <?php } ?>
                                    <?php if($pro->isteaching == 1 || session()->get("role") == "R00005"){?>
                                    <a href="<?php echo base_url(); ?>homepengajar" class="dropdown-item">
                                        <i class="feather icon-clipboard text-muted"></i> &nbsp; Home Pengajar</a>
                                    <div class="dropdown-divider"></div>
                                    <?php } ?>
                                    <a href="<?php echo base_url(); ?>riwayat" class="dropdown-item">
                                        <i class="feather icon-user text-danger"></i> &nbsp; Data Diri</a>
                                    <a href="<?php echo base_url(); ?>gantipass" class="dropdown-item">
                                        <i class="feather icon-lock text-danger"></i> &nbsp; Ganti Password</a>
                                    <a href="<?php echo base_url(); ?>login/logout" class="dropdown-item">
                                        <i class="feather icon-power text-danger"></i> &nbsp; Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- [ Layout navbar ( Header ) ] End -->
            <div class="layout-container">
                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <!-- [ content ] Start -->