<script type="text/javascript">

    $(document).ready(function () {
        $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporansiswapengajar/ajaxlist"
        });
    });

    function catatansiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporansiswapengajar/catatansiswa/" + kode;
    }

    function raporsiswa(kode){
        window.location.href = "<?php echo base_url(); ?>laporansiswapengajar/raporsiswa/" + kode;
    }
    
    function catatankelas(kode){
        window.location.href = "<?php echo base_url(); ?>laporansiswapengajar/catatankelas/" + kode;
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jadwal Pengajaran</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item active">Jadwal Pengajaran</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kelas</th>
                                    <th>Waktu & Hari</th>
                                    <th>Kursus</th>
                                    <th>Tahun Ajar</th>
                                    <th>Aksi</th>
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