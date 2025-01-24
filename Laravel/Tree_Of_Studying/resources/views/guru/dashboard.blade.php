@extends('layouts.app')

@section('title', 'Dashboard ' . ucfirst($userRole))

@section('contents')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard Guru</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

		<!-- CSS animasi -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- File Modular (Three.js) -->
    
    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('/css/custom.css') }}" rel="stylesheet"> -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #C2FFC7;">

            <!-- Main Content -->
            <div id="content" style="background-color: #C2FFC7;">

                <!-- Begin Page Content -->
                <!-- Content Row -->
                <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Rapat Pertemuan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">1/01/2025</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tugas
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Laporan Tertunda</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Content Row -->

<div class="row">

<!-- Area Chart -->


<!-- Pie Chart -->

</div>

<!-- Content Row -->
<div class="row">

<!-- Content Column -->
<div class="col-lg-12 mb-4">

    <!-- Project Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tahapan Pembuatan Rapor</h6>
        </div>
        <div class="card-body">
            <h4 class="small font-weight-bold">Biji Ide <span
                    class="float-right">100%</span></h4>
            <div class="progress mb-4">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Akar Diagnostik <span
                    class="float-right">85%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-info" role="progressbar" style="width: 85%"
                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Batang Metode <span
                    class="float-right">70%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 70%"
                    aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Hama Hambatan <span
                    class="float-right">55%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar bg-secondary" role="progressbar" style="width: 55%"
                    aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Daun Formatif <span
                    class="float-right">30%</span></h4>
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"
                    aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Bunga Prestasi<span
                    class="float-right">15%</span></h4>
            <div class="progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%"
                    aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <h4 class="small font-weight-bold">Buah Sumatif <span
                    class="float-right">0%</span></h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!-- Color System -->


</div>

<div class="col-lg-6 mb-4">

   

    <!-- Approach -->
    

</div>
</div>

</div>
<!-- /.container-fluid -->

</div>

                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>

                    <!-- Logout Modal-->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <a class="btn btn-primary" href="login.html">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bootstrap core JavaScript-->
                    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                    <!-- Core plugin JavaScript-->
                    <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
                    <!-- Custom scripts for all pages-->
                    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

</body>

</html>


@endsection