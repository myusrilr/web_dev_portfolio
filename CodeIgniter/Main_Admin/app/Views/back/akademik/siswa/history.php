<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        var idsiswa = document.getElementById('idsiswa').value;
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlist_histori/"+idsiswa
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">History Pengiriman Rapor</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>siswa">Siswa</a></li>
            <li class="breadcrumb-item active">Histori Rapor</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <input type="hidden" id="idsiswa" name="idsiswa" value="<?php echo $idsiswa; ?>">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Kelas</th>
                                    <th>Tanggal Terkirim</th>
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
