<script type="text/javascript">
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>absensi/ajaxlist"
        });

    });
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">REKAP ABSENSI BULAN <?php echo strtoupper(date('F Y')); ?>
    <small style="float:right;">*Rekap akan muncul setiap akhir bulan</small></h4>
    <div class="row">
        <!-- visitors  start -->
        <div class="col-sm-3">
            <div class="card bg-primary text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $hadir->jml; ?></h2>
                    <h5 class="text-white">JUMLAH KEHADIRAN</h5>
                    <i class="feather icon-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-success text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $tepat->jml; ?></h2>
                    <h5 class="text-white">TEPAT WAKTU</h5>
                    <i class="feather icon-thumbs-up"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-danger text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $telat->jml; ?></h2>
                    <h5 class="text-white">TERLAMBAT</h5>
                    <i class="feather icon-user-minus"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-warning text-white widget-visitor-card">
                <div class="card-body text-center">
                    <h2 class="text-white"><?php echo $jam;?></h2>
                    <h5 class="text-white">TABUNGAN JAM</h5>
                    <i class="feather icon-clock"></i>
                </div>
            </div>
        </div>
        <!-- visitors  end -->
        <!-- progressbar static data start -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Histori Absensi</h5>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th>Tanggal</th>
                                    <th>Scan Masuk</th>
                                    <th>Scan Keluar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- progressbar static data end -->
    </div>