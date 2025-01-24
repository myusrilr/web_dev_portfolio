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
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="feather icon-link f-36 text-primary"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><a href="<?php echo base_url();?>linkbidang">Data Link Dokumen</a></h6>
                            <h2 class="m-b-0"><?php echo $link; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="feather icon-airplay f-36 text-primary"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10"><a href="<?php echo base_url();?>leapprofil">Data Leap Profile</a></h6>
                            <h2 class="m-b-0"><?php echo $leap; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<!-- [ content ] End -->