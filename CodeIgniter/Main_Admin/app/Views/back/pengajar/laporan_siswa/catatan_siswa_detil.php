<script type="text/javascript">

    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporansiswapengajar/ajaxcatatansiswapertanggal/<?php echo $head->idsiswa.'/'.$head->idjadwal; ?>",
            ordering:false
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Catatan Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporansiswapengajar">Jadwal Pengajaran</a></li>
            <li class="breadcrumb-item active">Laporan Catatan Siswa</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
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
                            <div class="text-muted small"><b>Pengajar</b></div>
                            <?php echo $nama_pengajar; ?>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="text-muted small"><b>Siswa</b></div>
                            <?php echo $head->nama_lengkap.' ('.$head->panggilan.')'; ?>
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
                                    <th>Catatan Pengajar</th>
                                    <th>Admin</th>
                                    <th>Tgl<br>Follow Up</th>
                                    <th>Kesimpulan</th>
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
    </div>
</div>