<script type="text/javascript">

    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>kurikulum/ajaxlevel/<?php echo $idpendkursus; ?>",
            ordering:false
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function pilih(kode){
        window.location.href = "<?php echo base_url(); ?>kurikulum/kurikulum/" + kode;
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Level Pendidikan / Kursus</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>kurikulum">Level Pendidikan (Kursus)</a></li>
            <li class="breadcrumb-item active">Level Pendidikan</li>
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
                                    <th>Level</th>
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