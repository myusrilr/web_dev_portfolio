<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Main</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
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
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-tie f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">PARTIME</h6>
                            <h2 class="m-b-0"><?php echo $part; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <i class="fas fa-user-friends f-36 text-warning"></i>
                        </div>
                        <div class="col-auto">
                            <h6 class="text-muted m-b-10">MAGANG</h6>
                            <h2 class="m-b-0"><?php echo $magang; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger"><?php echo $pelamar; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/rekruitmen'; ?>">PELAMAR BARU <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-danger"><?php echo $pegawai; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/permintaan'; ?>">PERMINTAAN PEGAWAI BARU <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card d-flex w-100 mb-4">
                <div class="row no-gutters row-bordered row-border-light h-100">
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class="display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big mr-1 text-danger"><?php echo $perijinan; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/persetujuan'; ?>">PERIJINAN / LEMBUR <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex col-sm-6 align-items-center">
                        <div class="card-body media align-items-center text-dark">
                            <i class=" display-4 d-block text-danger"></i>
                            <span class="media-body d-block ml-3">
                                <span class="text-big"><span class="mr-1 text-danger"><?php echo $resign; ?></span>
                                <br>
                                <small class="text-muted"><a href="<?php echo base_url().'/resign'; ?>">PERMINTAAN RESIGN <?php echo strtoupper(date('F Y')) ?></a></small>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="card mb-4">
                <div class="card-header with-elements">
                    <h6 class="card-header-title mb-0">CHART PERMINTAAN PERIJINAN/LEMBUR <?php echo date("Y"); ?></h6>
                </div>
                <div class="card-body py-0">
                    <div id="chart-bar-moris" style="height:300px"></div>
                </div>
                <div class="card-footer pt-0 pb-0">
                    <div class="row row-bordered row-border-light">
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-primary" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">LEMBUR</p>
                                    <h5 class="mb-0"><?php echo $q->jmllembur; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-success" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">IJIN</p>
                                    <h5 class="mb-0"><?php echo $q->jmlijin; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-warning" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">SAKIT</p>
                                    <h5 class="mb-0"><?php echo $q->jmlsakit; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 py-3">
                            <div class="d-flex align-items-center">
                                <div class="ui-legend bg-danger" style="width:20px;height:20px"></div>
                                <div class="ml-3">
                                    <p class="text-muted small mb-1">IJIN DARURAT</p>
                                    <h5 class="mb-0"><?php echo $q->jmlizin; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
            <div class="card-header with-elements">
                <h6 class="card-header-title mb-0">CHART KEHADIRAN (<?php echo strtoupper(date("F")); ?> 2023)</h6>
            </div>
            <div class="row no-gutters row-bordered">
                <div class="col-md-5 col-lg-12 col-xl-5">
                    <div class="card-body">
                        <div class="pb-4">
                            Terlambat
                            <div class="float-right">
                                <span class="text-muted small"><?php echo $telat; ?></span>
                            </div>
                            <div class="progress mt-1" style="height:6px;">
                                <div class="progress-bar bg-danger" style="width: <?php echo ($telat/100)*100; ?>%;"></div>
                            </div>
                        </div>
                        <div class="pb-4">
                            Tepat Waktu
                            <div class="float-right">
                                <span class="text-muted small"><?php echo $tepat; ?></span>
                            </div>
                            <div class="progress mt-1" style="height:6px;">
                                <div class="progress-bar bg-success" style="width: <?php echo ($tepat/100)*100; ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-12 col-xl-7">
                    <div class="card-body">
                        <div id="chart-pie-moris" style="height:200px"></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    buildchart()
    $(window).on('resize', function() {
        buildchart();
    });
    Morris.Bar({
        element: 'chart-bar-moris',
        data: [
            <?php foreach($jmlijin->getResult() as $row){?>
            {
                y: '<?php echo $row->bln; ?>',
                a: <?php echo $row->jmlijin; ?>,
                b: <?php echo $row->jmllembur; ?>,
                c: <?php echo $row->jmlsakit; ?>,
                d: <?php echo $row->jmlizin; ?>,
            },
            <?php } ?>
        ],
        xkey: 'y',
        barSizeRatio: 0.70,
        barGap: 5,
        responsive: true,
        ykeys: ['a', 'b'],
        labels: ['Lembur', 'Ijin'],
        barColors: ['#2e76bb', '#62d493']
    });
});

function buildchart() {
    $(function() {
        //Flot Base Build Option for bottom join
        var options_bt = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 0,
                margin: {
                    top: 5,
                    left: 0,
                    bottom: 0,
                    right: 0,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

        //Flot Base Build Option for Center card
        var options_ct = {
            legend: {
                show: false
            },
            series: {
                label: "",
                shadowSize: 0,
                curvedLines: {
                    active: true,
                    nrSplinePoints: 20
                },
            },
            tooltip: {
                show: true,
                content: "x : %x | y : %y"
            },
            grid: {
                hoverable: true,
                borderWidth: 0,
                labelMargin: 0,
                axisMargin: 0,
                minBorderMargin: 5,
                margin: {
                    top: 8,
                    left: 8,
                    bottom: 8,
                    right: 8,
                }
            },
            yaxis: {
                min: 0,
                max: 30,
                color: 'transparent',
                font: {
                    size: 0,
                }
            },
            xaxis: {
                color: 'transparent',
                font: {
                    size: 0,
                }
            }
        };

    });

    $(function() {
        var graph = Morris.Donut({
            element: 'chart-pie-moris',
            data: [
                {
                    value: <?php echo $telat; ?>,
                    label: 'Terlambat'
                },
                {
                    value: <?php echo $tepat; ?>,
                    label: 'Tepat Waktu'
                }
            ],
            colors: ['#FF4961', '#f4ab55'],
            resize: true,
            formatter: function(x) {
                return x
            }
        });
        
    });
}
</script>
<!-- [ content ] End -->