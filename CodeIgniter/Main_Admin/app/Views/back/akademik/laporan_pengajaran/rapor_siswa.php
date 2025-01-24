<script type="text/javascript">
    $(document).ready(function() {
        $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporanpengajaran/ajaxraporsiswa/<?php echo $head->idjadwal; ?>"
        });

        $('#select-all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });
    });

    function preview(idjadwal, idsiswa) {
        document.getElementById('idjadwal').value = idjadwal;
        document.getElementById('idsiswa').value = idsiswa;
        $('#modal_rapor').modal('show');
        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/getValueRapor/" + idjadwal + "/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#nama_siswa').html(data.nama_siswa);
                $('#level_siswa').html(data.level_siswa);
                $('#nama_guru').html(data.nama_guru);
                $('#term').html(data.term);
                $('#total_sesi').html(data.total_kursus);
                $('#total_masuk').html(data.presensi);
                $('#logoreport').attr("src", data.logo);
                $('#tb_kanan').html(data.strFormat);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function unduhrapor() {
        html2canvas(document.getElementById("dialogbody")).then(function(canvas) {
            var nama = $('#nama_siswa').html();
            var anchorTag = document.createElement("a");
            document.body.appendChild(anchorTag);
            anchorTag.download = nama + ".jpg";
            anchorTag.href = canvas.toDataURL();
            anchorTag.target = '_blank';
            anchorTag.click();
        });
    }

    var obj = [];
    var index_kirim = 0;
    var index_final = 0;

    function kirim_email() {
        var idjadwal = document.getElementById('idjadwalAll').value;
        if (idjadwal === "") {
            iziToast.error({
                title: 'Error',
                message: "ID jadwal tidak boleh kosong",
                position: 'topRight'
            });
        } else {
            $('#btnKirimEmailSemua').html('<i class="fas feather icon-mail"></i> Loading...');
            $('#btnKirimEmailSemua').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idjadwal', idjadwal);
            $.ajax({
                url: "<?php echo base_url(); ?>laporanpengajaran/get_siswa_from_jadwal",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    obj = JSON.parse(data.status);
                    index_kirim = 0;
                    index_final = obj.length;

                    // proses kirim email by array
                    $('#status_kirim').html("Status : " + obj[index_kirim]["namasiswa"] + " [ proses ]");
                    kirim_single_email_sub_all(idjadwal);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    $('#btnKirimEmailSemua').html('<i class="fas feather icon-mail"></i> Kirim Email Rapor');
                    $('#btnKirimEmailSemua').attr('disabled', false);

                    iziToast.error({
                        title: 'Error',
                        message: "Error get data " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }
    }

    function kirim_single_email_sub_all(idjadwal) {
        $('#btnKirimEmailSemua').html('<i class="fas feather icon-mail"></i> Loading...');
        $('#btnKirimEmailSemua').attr('disabled', true);

        //$('#status_kirim').html("Status : " + obj[index_kirim]["namasiswa"] + " [ proses ]");

        var idsiswa = obj[index_kirim]["idsiswa"];
        var namasiswa = obj[index_kirim]["namasiswa"];

        var form_data = new FormData();
        form_data.append('idjadwal', idjadwal);
        form_data.append('idsiswa', idsiswa);

        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/kirim_email_single_sub",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                if (index_kirim === (index_final - 1)) {
                    $('#btnKirimEmailSemua').html('<i class="fas feather icon-mail"></i> Kirim Email Rapor');
                    $('#btnKirimEmailSemua').attr('disabled', false);
                } else {
                    $('#status_kirim').html("Status : " + obj[index_kirim]["namasiswa"] + " [ " + data.status + " ]");

                    index_kirim = index_kirim + 1;
                    kirim_single_email_sub_all(idjadwal);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btnKirimEmailSemua').html('<i class="fas feather icon-mail"></i> Kirim Email Rapor');
                $('#btnKirimEmailSemua').attr('disabled', false);

                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function kirim_single_email() {
        $('#btnKirimEmailSingle').text('Loading...');
        $('#btnKirimEmailSingle').attr('disabled', true);

        var form_data = new FormData();
        form_data.append('idjadwal', document.getElementById('idjadwal').value);
        form_data.append('idsiswa', document.getElementById('idsiswa').value);

        $.ajax({
            url: "<?php echo base_url(); ?>laporanpengajaran/kirim_email_single",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#btnKirimEmailSingle').text('Kirim Email');
                $('#btnKirimEmailSingle').attr('disabled', false);

                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btnKirimEmailSingle').text('Kirim Email');
                $('#btnKirimEmailSingle').attr('disabled', false);

                iziToast.error({
                    title: 'Error',
                    message: "Error get data " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function kirim_email_alternatif(){
        var myArray = [];
        $("input:checkbox[name=type]:checked").each(function(){
            myArray.push($(this).val());
        });
        var myJsonString = JSON.stringify(myArray);
        if(myArray.length > 0){
            window.localStorage.setItem("userscetak", JSON.stringify(myArray));
            window.location.href = "<?php echo base_url() ?>laporanpengajaran/alternatif/<?php echo $idjadwalenkrip; ?>";
        }else{
            iziToast.error({
                title: 'Stop',
                message: "Minimal 1 data terpilih",
                position: 'topRight'
            });
        }
    }

</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Rapor Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporanpengajaran">Laporan Pengajaran</a></li>
            <li class="breadcrumb-item active">Laporan Rapor Siswa</li>
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
                    <input type="hidden" id="idjadwalAll" name="idjadwalAll" value="<?php echo $head->idjadwal; ?>" readonly>
                    <button id="btnKirimEmailSemua" type="button" class="btn btn-primary btn-sm" onclick="kirim_email_alternatif();"><i class="fas feather icon-mail"></i> Kirim Email Rapor </button>
                    <label id="status_kirim"></label>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="select-all" id="select-all" /></th>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Tgl Lahir</th>
                                    <th>Nama Sekolah</th>
                                    <th>Tgl Rapor Terkirim</th>
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

<style>
    .dialogbody {
        background: url(<?php echo $background; ?>) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: 100% 100%;
        margin-top: 0cm;
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 0cm;
        height: 780px;
    }

    /* Buat dua kolom yang sama yang mengapung di samping satu sama lain */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 300px;
        /* Hanya untuk demonstrasi */
    }

    .column1 {
        float: left;
        width: 50%;
        padding: 15px;
        padding-left: 45px;
        height: 300px;
        /* Hanya untuk demonstrasi */
    }

    .column2 {
        float: left;
        width: 50%;
        padding: 15px;
        height: 300px;
        /* Hanya untuk demonstrasi */
    }

    /* Hapus floats setelah  columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="modal_rapor">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-sm btn-primary" onclick="unduhrapor()">Unduh Rapor</button>
                <button id="btnKirimEmailSingle" type="button" class="btn btn-sm btn-primary" onclick="kirim_single_email()">Kirim Email</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idjadwal" name="idjadwal">
                <input type="hidden" id="idsiswa" name="idsiswa">
                <div id="dialogbody" class="dialogbody">
                    <div class="row">
                        <div class="column1">
                            <table border="0" style="width: 90%; margin-top: 20px; margin-right: 20px; margin-left: 20px; font-size: 12px;">
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <img id="logoreport" src="<?php echo $logo_report; ?>" alt="logo" style="width: 200px; height: auto;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;">ACCREDITATION LEVEL B</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Operational Licence : 421.9 / 41 / A / IO-SP / 436.7.15 / 2022</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Nilek : 05209.1.0593 / 09</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">NPSN : K0560112</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Rungkut Asri Tengah VII / 51, Surabaya 60293</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">Phone : (031) 870 5464 - 0813 3538 1619</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">www.leapsurabaya.sch.id</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;"><u>OUR VISION</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <p style="margin-left: 30px; margin-right: 30px;">LEAP vision's is to become a sustainable and professional educational institution that prioritizes equality, quality, and ease of access to learning through the synergy of human roles, technology, and community collaboration to create a positive educational environment for educators and learners</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr style="border: 1px solid black;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 16px;"><u>STUDENT PROGRESS REPORT</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 100px;">&nbsp;&nbsp;NAME</td>
                                    <td style="text-align: left;" id="nama_siswa">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;LEVEL</td>
                                    <td style="text-align: left;" id="level_siswa">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;TEACHER</td>
                                    <td style="text-align: left;" id="nama_guru">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">&nbsp;&nbsp;TERM</td>
                                    <td style="text-align: left;" id="term">&nbsp;&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <div class="column2">
                            <table id="tb_kanan" border="0" style="width: 90%; margin-top: 60px; margin-right: 20px; font-size: 11px;">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>