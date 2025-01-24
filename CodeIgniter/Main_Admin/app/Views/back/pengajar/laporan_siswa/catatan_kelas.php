<script type="text/javascript">

    $(document).ready(function () {
        $('#tb').DataTable({
            ajax : "<?php echo base_url(); ?>laporansiswapengajar/ajaxcatatankelas/<?php echo $head->idjadwal; ?>",
            ordering : false
        });
    });
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Catatan Kelas</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporansiswapengajar">Jadwal Pengajaran</a></li>
            <li class="breadcrumb-item active">laporan Catatan Kelas</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
        <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Tahun Ajar</b></div>
                            <?php echo $head->tahun_ajar; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Kursus</b></div>
                            <?php echo $head->kursus; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Rombel</b></div>
                            <?php echo $head->groupwa; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Hari</b></div>
                            <?php echo $head->hari; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Level</b></div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Mode Belajar / Tempat</b></div>
                            <?php echo $head->mode_belajar.' '.$head->tempat; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-0">
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th style="width : 40%;">Catatan</th>
                                    <th>Materi Diskusi</th>
                                    <th>Tgl Cek</th>
                                    <th style="width : 30%;">Hasil Konfirmasi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>