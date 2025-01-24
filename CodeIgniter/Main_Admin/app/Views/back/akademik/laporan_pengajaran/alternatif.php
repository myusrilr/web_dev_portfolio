<script type="text/javascript">

    var wadah = [];
    var id = [];
    var nama = [];
    var email = [];

    $(document).ready(function () {
        loaddata();
    });

    function loaddata(){

        var userscetak = JSON.parse(window.localStorage.getItem("userscetak"));
        var str = "";
        for (let i = 0; i < userscetak.length; i++) {
            str += "'" + userscetak[i] + "',";
        }
        str = str.substring(0, str.length - 1);
        
        var form_data = new FormData();
        form_data.append('users', str);

        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/getDataSiswa/<?php echo $head->idjadwal; ?>",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                
                for (let i = 0; i < data.idsiswa.length; i++) {
                    wadah.push("wadah_rapor_" + data.idsiswa[i]);
                    id.push(data.idsiswa[i]);
                    nama.push(data.nama[i]);
                    email.push(data.email[i]);

                    $('#wadah').append('<div id="wadah_rapor_' + data.idsiswa[i] + '" class="col-md-12" style="margin-bottom:20px;">'+ data.rapor[i] +'</div>');
                }
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function unduhrapor(idjadwal){
        
        $('#btnUnduh').attr('disabled', true);

        for (let i = 0; i < id.length; i++) {

            html2canvas(document.getElementById(wadah[i])).then(function (canvas) {

                $('#txtLoading').html( (i + 1) + "/" + id.length);

                var form_data = new FormData();
                form_data.append('idjadwal', idjadwal);
                form_data.append('id', id[i]);
                form_data.append('nama', nama[i]);
                form_data.append('image', canvas.toDataURL("image/jpeg", 0.9));

                $.ajax({
                    url: "<?php echo base_url(); ?>laporanpengajaran/simpangambar",
                    dataType: 'JSON',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (data) {
                        console.log(data.status);
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        
                        iziToast.error({
                            title: 'Error',
                            message: "Error json " + errorThrown,
                            position: 'topRight'
                        });
                    }
                });
            });
        }

        $('#btnUnduh').attr('disabled', false);
    }

    function kirim_email(idjadwal){
        $('#btnKirim').attr('disabled', true);

        for (let i = 0; i < id.length; i++) {

            $('#txtLoading1').html( (i + 1) + "/" + id.length);

            var form_data = new FormData();
            form_data.append('idjadwal', idjadwal);
            form_data.append('id', id[i]);
            form_data.append('nama', nama[i]);
            form_data.append('email', email[i]);
            

            $.ajax({
                url: "<?php echo base_url(); ?>laporanpengajaran/kirimemail",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    console.log(data.status);
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                }, error: function (jqXHR, textStatus, errorThrown) {
                    
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

        $('#btnKirim').attr('disabled', false);
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Send Bulk Rapor Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporanpengajaran">Laporan Pengajaran</a></li>
            <li class="breadcrumb-item active">Send Bulk Rapor Siswa</li>
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
                            <?php echo $head->mode_belajar . ' ' . $head->tempat; ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-0">
            <div class="card">
                <div class="card-header">
                    <button id="btnUnduh" type="button" class="btn btn-primary btn-sm" onclick="unduhrapor('<?php echo $head->idjadwal; ?>');"><i class="fas feather icon-download"></i> Unduh Semua Rapor </button>
                    <label id="txtLoading">0 / 0</label>

                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button id="btnKirim" type="button" class="btn btn-primary btn-sm" onclick="kirim_email('<?php echo $head->idjadwal; ?>');"><i class="fas feather icon-mail"></i> Kirim Email Rapor </button>
                    <label id="txtLoading1">0 / 0</label>
                </div>
                <div class="card-body">
                    <div id="wadah">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
