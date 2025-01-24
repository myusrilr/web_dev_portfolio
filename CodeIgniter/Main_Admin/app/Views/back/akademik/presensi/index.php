<script type="text/javascript">

    $(document).ready(function () {
        $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>presensikelas/ajaxlist"
        });
    });
    
    function pilih(kode){
        window.location.href = "<?php echo base_url(); ?>presensikelas/preview/" + kode;
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Jadwal Pengajaran</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan"><i class="feather icon-home"></i></a></li>
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
                                    <th>Group WA</th>
                                    <th>Sesi</th>
                                    <th>Kursus</th>
                                    <th>Periode</th>
                                    <th>Hari</th>
                                    <th>Level</th>
                                    <th>Meeting ID</th>
                                    <th style="text-align: center;">Aksi</th>
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