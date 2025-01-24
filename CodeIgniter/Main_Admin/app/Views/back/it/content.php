<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Main</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-tie f-36 text-primary"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">KARYAWAN</h6>
                            <h2 class="m-b-0"><?php echo $karyawan; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-female f-36 text-danger"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">PEREMPUAN</h6>
                            <h2 class="m-b-0"><?php echo $wanita; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-male f-36 text-success"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">LAKI-LAKI</h6>
                            <h2 class="m-b-0"><?php echo $pria; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-clock f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">FULLTIME</h6>
                            <h2 class="m-b-0"><?php echo $full; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="col-xl-6 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-danger"><?php echo $resign; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/resign'; ?>">PERIJINAN AKSES AKUN <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<script>

</script>
<!-- [ content ] End -->