<style>
    .dialogbody {
        background-image: url('<?php echo $background_report; ?>') no-repeat center center fixed;
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
        padding: 10px;
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporanpengajaran/ajax_generate_rapor/<?php echo $head->idjadwal; ?>"
        });
    });

    function generate_file(idjadwal, idsiswa) {

        document.getElementById('idsiswa_cetak_rapor').value = idsiswa;
        document.getElementById('idjadwal_cetak_rapor').value = idjadwal;

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

                proses2();
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

    function proses2() {

        html2canvas(document.getElementById("dialogbody")).then(function(canvas) {
            var nama = $('#nama_siswa').html();
            var database64 = canvas.toDataURL("image/jpg", 1.0);
            var pesan = '';
            var idsiswa = document.getElementById('idsiswa_cetak_rapor').value;
            var idjadwal = document.getElementById('idjadwal_cetak_rapor').value;

            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('database64', database64);
            form_data.append('pesan', pesan);
            form_data.append('idsiswa', idsiswa);
            form_data.append('idjadwal', idjadwal);

            $.ajax({
                url: "<?php echo base_url(); ?>laporanpengajaran/tangkapBase64",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    iziToast.info({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });
                }
            });

        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Rapor Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporanpengajaran">Laporan Pengajaran</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporanpengajaran/raporsiswa/<?php echo $idjadwalenkrip; ?>">Laporan Rapor Siswa</a></li>
            <li class="breadcrumb-item active">Generate Rapor</li>
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

            <input type="hidden" id="idsiswa_cetak_rapor">
            <input type="hidden" id="idjadwal_cetak_rapor">
            <div id="wadah_invisible">
                <div id="dialogbody" class="dialogbody" style="background-image: url('<?php echo $background_report; ?>');">
                    <div class="row">
                        <div class="column1">
                            <table border="0" style="width: 90%; margin-top: 40px; margin-right: 20px; margin-left: 20px; font-size: 12px;">
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <img id="logoreport" src="<?php echo $logo_report; ?>" alt="logo" style="width: 220px; height: auto;" />
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
                                    <td colspan="2" style="text-align: center;">Operational Licence : 188 / 14226 / 436.7.1 / 2020</td>
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
                                        <p style="margin-left: 30px; margin-right: 30px;">Leap's vision is to become holistic provider is 2030 to create competent graduates thorough collaborate with our staheholders.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr style="border: 1px solid black;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center; font-size: 18px;"><u>STUDENT PROGRESS REPORT</u></td>
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
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" onclick="generate();"> Generate File </button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Rapor</th>
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