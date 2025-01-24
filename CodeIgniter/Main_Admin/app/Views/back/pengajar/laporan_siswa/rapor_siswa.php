<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>laporansiswapengajar/ajaxsiswa/<?php echo $head->idjadwal; ?>"
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }

    function show(idjadwal, idsiswa) {
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Penilaian Rapor Siswa');
        $('#idsiswa').val(idsiswa);
        $('#idjadwal').val(idjadwal);
        $.ajax({
            url: "<?php echo base_url(); ?>laporansiswapengajar/show/" + idjadwal + "/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#wadah_parameter').html(data.status);

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

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function closemodalupdate() {
        $('#modal_update').modal('hide');
    }

    tinymce.init({
        selector: "textarea#catatan", theme: "modern", height: 250,
    });

    function tambahsesi(idjadwal, idsiswa) {
        $('#formupdate')[0].reset();
        $('#modal_update').modal('show');
        $('#idsiswaa').val(idsiswa);
        $('#idjadwall').val(idjadwal);
        $.ajax({
            url: "<?php echo base_url(); ?>laporansiswapengajar/tambahsesi/" + idjadwal + "/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#sesi').val(data.tambahan_sesi);
                tinyMCE.get('catatan').setContent(data.tambahan_ket);
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

    function saveupdate() {

        var idjadwall = document.getElementById('idjadwall').value;
        var idsiswaa = document.getElementById('idsiswaa').value;
        var sesi = document.getElementById('sesi').value;
        var catatan = tinyMCE.get('catatan').getContent();

        $('#btnSaveUpdate').text('Menyimpan...');
        $('#btnSaveUpdate').attr('disabled', true);

        var form_data = new FormData();
        form_data.append('idjadwall', idjadwall);
        form_data.append('idsiswaa', idsiswaa);
        form_data.append('catatan', catatan);
        form_data.append('sesi', sesi);

        $.ajax({
            url: "<?php echo base_url(); ?>laporansiswapengajar/prosesupdate",
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

                $('#modal_update').modal('hide');
                reload();

                $('#btnSaveUpdate').text('Simpan');
                $('#btnSaveUpdate').attr('disabled', false);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });

                $('#btnSaveUpdate').text('Simpan'); //change button text
                $('#btnSaveUpdate').attr('disabled', false); //set button enable 
            }
        });
        }

    function save() {

        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        $.ajax({
            url: "<?php echo base_url(); ?>laporansiswapengajar/proses",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {
                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });

                $('#modal_form').modal('hide');
                reload();

                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });

                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 
            }
        });
    }

    function cetak(idjadwal, idsiswa) {
        $('#modal_rapor').modal('show');
        $.ajax({
            url: "<?php echo base_url(); ?>laporansiswapengajar/getValueRapor/" + idjadwal + "/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('#idsiswa_cetak_rapor').val(idsiswa);
                $('#idjadwal_cetak_rapor').val(idjadwal);

                $('#nama_siswa').html(data.nama_siswa);
                $('#level_siswa').html(data.level_siswa);
                $('#nama_guru').html(data.nama_guru);
                $('#term').html(data.term);
                $('#total_sesi').html(data.total_kursus);
                $('#total_masuk').html(data.presensi);
                $('#logoreport').attr("src", data.logo);
                $('#tb_kanan').html(data.strFormat);

                var txt = "Selamat siang,\n\nBerikut kami kirimkan E-Rapor/E-Sertifikat " + data.nama_kursus + " untuk:\nNama : " + data.nama_siswa + "\nLevel : " + data.level_siswa + "\n\nSelamat telah menyelesaikan keseluruhan materi dan aktivitas di level ini dengan baik.\n\nTerima kasih,\nSalam LKP LEAP English & Digital Class Surabaya";
                $('#pesan').val(txt);
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

        $('#btnUnduhRapor').text('Loading...');
        $('#btnUnduhRapor').attr('disabled', true);

        html2canvas(document.getElementById("dialogbody")).then(function(canvas) {
            var nama = $('#nama_siswa').html();

            var anchorTag = document.createElement("a");
            document.body.appendChild(anchorTag);
            anchorTag.download = nama + ".jpg";
            anchorTag.href = canvas.toDataURL("image/jpg", 0.9);
            anchorTag.target = '_blank';
            anchorTag.click();

            $('#btnUnduhRapor').text('Unduh Rapor');
            $('#btnUnduhRapor').attr('disabled', false);
        });
    }

    function kirim_email() {
        $('#btnKirimEmail').text('Loading...');
        $('#btnKirimEmail').attr('disabled', true);

        var idsiswa = document.getElementById('idsiswa_cetak_rapor').value;
        var idjadwal = document.getElementById('idjadwal_cetak_rapor').value;

        if (idsiswa === "") {
            iziToast.error({
                title: 'Error',
                message: "ID siswa tidak ditemukan",
                position: 'topRight'
            });
        } else if (idjadwal === "") {
            iziToast.error({
                title: 'Error',
                message: "ID jadwal tidak ditemukan",
                position: 'topRight'
            });
        } else {
            var form_data = new FormData();
            form_data.append('idsiswa', idsiswa);
            form_data.append('idjadwal', idjadwal);

            $.ajax({
                url: "<?php echo base_url(); ?>laporansiswapengajar/kirim_rapor_email",
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

                    $('#btnKirimEmail').text('Kirim Rapor Siswa Ke Email');
                    $('#btnKirimEmail').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#btnKirimEmail').text('Kirim Rapor Siswa Ke Email');
                    $('#btnKirimEmail').attr('disabled', false);

                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });
                }
            });
        }

    }

    function excel_template() {
        window.location.href = "<?php echo base_url(); ?>laporansiswapengajar/exportdata/<?php echo $head->idjadwal; ?>";
    }

    function upload_nilai_excel() {
        $('#form_upload_rapor')[0].reset();
        $('#modal_upload_rapor').modal('show');

        $(".progress-bar").css("width", "0%").text("0%");
        $('#ket_upload').html("");
    }

    function save_rapor() {
        $('#btnSaveRapor').text('Menyimpan...');
        $('#btnSaveRapor').attr('disabled', true);

        var idjadwal_rapor = document.getElementById('idjadwal_rapor').value;
        var file = $("#file")[0].files[0];

        var formData = new FormData();
        formData.append("file", file);
        formData.append("idjadwal_rapor", idjadwal_rapor);

        $.ajax({
            url: '<?php echo base_url(); ?>laporansiswapengajar/proses_upload_file',
            type: 'POST',
            dataType: 'JSON',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                iziToast.success({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });

                reload();

                $('#btnSaveRapor').text('Simpan');
                $('#btnSaveRapor').attr('disabled', false);

                $(".progress-bar").css("width", "0%").text("0%");
                $('#ket_upload').html("");

                $('#modal_upload_rapor').modal('hide');
            },
            xhr: function() {
                var fileXhr = $.ajaxSettings.xhr();
                if (fileXhr.upload) {
                    fileXhr.upload.addEventListener("progress", function(e) {
                        if (e.lengthComputable) {
                            var prosentase = (e.loaded / e.total) * 100;
                            $(".progress-bar").css("width", prosentase + "%").text(prosentase + "%");
                            $('#ket_upload').html("Uploading " + prosentase + "%");
                        }
                    }, false);
                }
                return fileXhr;
            }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Laporan Rapor Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>laporansiswapengajar">Jadwal Pengajaran</a></li>
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
                    <button type="button" class="btn btn-primary btn-sm" onclick="excel_template();"><i class="fas fa-file"></i> Excel Template </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="upload_nilai_excel();"><i class="fas fa-upload"></i> Upload Nilai From Excel </button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Siswa</th>
                                    <th>Form Penilaian</th>
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

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="kode" name="kode" readonly>
                    <input type="hidden" id="idsiswa" name="idsiswa" readonly>
                    <input type="hidden" id="idjadwal" name="idjadwal" readonly>
                    <div id="wadah_parameter">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="formupdate">
                    <input type="hidden" id="idsiswaa" name="idsiswaa" readonly>
                    <input type="hidden" id="idjadwall" name="idjadwall" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Jumlah Sesi Tambahan</label>
                            <input type="text" id="sesi" name="sesi" class="form-control" placeholder="Jumlah sesi tambahan" autocomplete="off">
                            <span style="font-size: 12px;"><i>Note: Jika ingin membatalkan tambahan sesi hapus data secara manual lalu simpan.</i></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea id="catatan" name="catatan" class="form-control" rows="5"></textarea> 
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalupdate();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="saveupdate();">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload_rapor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Upload Excel Penilaian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idjadwal_rapor" name="idjadwal_rapor" value="<?php echo $head->idjadwal; ?>" readonly>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" style="min-width: 0px;"> 0 % </div>
                </div>
                <label id="ket_upload"></label>
                <form id="form_upload_rapor">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">File Excel</label>
                            <input type="file" id="file" name="file" class="form-control" autocomplete="off" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button id="btnSaveRapor" type="button" class="btn btn-primary" onclick="save_rapor();">Simpan</button>
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
                <button id="btnUnduhRapor" type="button" class="btn btn-sm btn-primary" onclick="unduhrapor()">Unduh Rapor</button>
                <button id="btnKirimEmail" type="button" class="btn btn-sm btn-primary" onclick="kirim_email()">Kirim Rapor Siswa Ke Email</button>
            </div>
            <div class="modal-body" style="margin-bottom: -20px;">
                <div class="form-row">
                    <div class="form-group col">
                        <textarea id="pesan" name="pesan" rows="10" class="form-control" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="dialogbody" class="dialogbody">
                    <input type="hidden" id="idsiswa_cetak_rapor" name="idsiswa_cetak_rapor" readonly>
                    <input type="hidden" id="idjadwal_cetak_rapor" name="idjadwal_cetak_rapor" readonly>
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
        </div>
    </div>
</div>