<!DOCTYPE html>
<html lang="en" class="default-style layout-fixed layout-navbar-fixed">

<head>
    <title>LEAP | Web Karyawan</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/smartwizard/smartwizard.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/datatables/datatables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/bootstrap-sweetalert/bootstrap-sweetalert.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/chartist/chartist.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>fullcalendar/fullcalendar.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>back/assets/libs/morris/morris.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>leaf/leaflet.css">

    <script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url(); ?>htmlcanvas/html2canvas.js"></script>


    <style>
        .modal {
            overflow-y: auto;
        }

        /* td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dee0e0;
        }

        tr:hover {
            background-color: #ddd;
        } */
    </style>

    <script type="text/javascript">
        function back() {
            window.history.back();
        }

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
            if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
                return true;
            } else if ((("0123456789").indexOf(keychar) > -1)) {
                return true;
            } else if (decimal && (keychar == ".")) {
                return true;
            } else {
                return false;
            }
        }

        function batas_angka(input) {
            if (input.value < 0) {
                input.value = 0;
            }
            if (input.value > 100) {
                input.value = 100;
            }
        }

        function trim_uang(s) {
            while (s.substr(0, 1) === '0' && s.length > 1) {
                s = s.substr(1, 9999);
            }
            while (s.substr(0, 1) === '.' && s.length > 1) {
                s = s.substr(1, 9999);
            }
            return s;
        }

        function format_uang(objek) {
            var f_nilai = objek.value;
            var b = f_nilai.replace(/[^\d]/g, "");
            var c = "";
            var panjang = b.length;
            var j = 0;
            for (var i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) === 1) && (j !== 1)) {
                    c = b.substr(i - 1, 1) + "." + c;
                } else {
                    c = b.substr(i - 1, 1) + c;
                }
            }
            objek.value = trim_uang(c);
        }
    </script>
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] Ebd -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-white logo-dark">
                <div class="app-brand">
                    <span class="app-brand-logo">
                        <img src="<?php echo base_url(); ?>back/assets/img/leap.png" alt="Brand Logo" class="img-fluid" style="width: 35px; height: 35px;">
                    </span>
                    <a href="index.html" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Leap Surabaya</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>