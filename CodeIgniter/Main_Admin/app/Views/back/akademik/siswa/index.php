<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">
    var save_method; //for save method string
    var table, tb_jadwal, tb_alumni;

    // Select2
    $(function() {
        $('.select2-demo').select2({
            dropdownParent: $('#modal_keluar .modal-content')
        });
    });

    $(document).ready(function() {
        load_awal();
    });

    function load_awal() {
        tabel = $('#tb').DataTable({
            "processing": true,
            "responsive": false,
            "serverSide": true,
            "ordering": true,
            "retrieve": true,
            "order": [
                [0, 'asc']
            ],
            "ajax": {
                "url": "<?php echo base_url(); ?>siswa/ajaxlist",
                "type": "POST",
                "data": {
                    noinduk: document.getElementById('cari_noinduk').value,
                    nama: document.getElementById('cari_nama').value,
                    panggilan: document.getElementById('panggilan_cari').value,
                    tgl_daftar: document.getElementById('tgl_daftar_cari').value,
                    jkel: document.getElementById('jkel_cari').value,
                    asal_sekolah: document.getElementById('asal_sekolah_cari').value,
                    tmp_lahir: document.getElementById('tmp_lahir_cari').value,
                    tgl_lahir: document.getElementById('tgl_lahir_cari').value,
                    domisili: document.getElementById('domisili_cari').value,
                    nama_ortu: document.getElementById('nama_ortu_cari').value,
                    perkerjaan_ortu: document.getElementById('perkerjaan_ortu_cari').value,
                    statusdata: document.getElementById('statusdata').value,
                    kelas: document.getElementById('kelas').value,
                }
            },
            "deferRender": true,
            "columns": [{
                    "data": 'idsiswa',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "no_induk"
                },
                {
                    data: "nama_lengkap",
                    render: function(data, type, row, meta) {
                        var mitraInfo = row.kode_mitra ? "<br><b>Mitra : </b>" + row.company : "";

                        return row.nama_lengkap + " (" + row.panggilan + ")" + mitraInfo;  // Menambahkan info mitra jika ada idmitra tidak null
                    }
                },
                {
                    data: "program",
                    render: function(data, type, row, meta) {
                        // Mengembalikan string kosong sementara AJAX bekerja
                        return "<ul><li>Loading...</li></ul>";
                    }
                },
                {
                    data: "nama_ortu",
                    render: function(data, type, row, meta) {
                        return row.nama_ortu;  
                    }
                },
                {
                    data: "status",
                    render: function(data, type, row, meta) {
                        if (row.sts_pengisian === "Belum Lengkap") {
                            return '<span class="badge badge-danger">' + row.sts_pengisian + '</span>';
                        } else if (row.sts_pengisian === "Sudah Lengkap") {
                            return '<span class="badge badge-success">' + row.sts_pengisian + '</span>';
                        } 
                    }
                },
                {
                    "data": "idsiswa",
                    "render": function(data, type, row, meta) {
                        return '<div style="text-align:center; width:100%;"><div class="btn-group" role="group">' +
                            '<a type="button" target="_blank" title="Ganti" class="btn btn-sm btn-success" href="' + "<?php echo base_url(); ?>" + 'siswa/editing/' + row.idsiswa +'"><i class="fas fa-pencil-alt"></i></a>' +
                            '<button type="button" title="Hapus" class="btn btn-sm btn-danger" onclick="hapus(' + "'" + row.idsiswa + "'" + ',' + "'" + row.nama_lengkap + "'" + ')"><i class="fas fa-trash-alt"></i></button>' +
                            '<button type="button" title="Lihat Jadwal" class="btn btn-sm btn-primary" onclick="jadwal(' + "'" + row.idsiswa + "'" + ')"><i class="fas fa-calendar"></i></button>' +
                            '<button type="button" title="Histori Rapor" class="btn btn-sm btn-warning" onclick="histori(' + "'" + row.idsiswa + "'" + ')"><i class="fas fa-file"></i></button>' +
                            '<button type="button" title="Keluar" class="btn btn-sm btn-info" onclick="keluar(' + "'" + row.idsiswa + "'" + ',' + "'" + row.nama_lengkap + "'" + ')"><i class="feather icon-log-out"></i></button>' +
                            '</div></div>';
                    }
                },
                
            ],"rowCallback": function(row, data, index) {
                var idsiswa = data.idsiswa;

                // Lakukan AJAX untuk mengambil programList berdasarkan idsiswa
                $.ajax({
                    url: "<?php echo base_url(); ?>siswa/jadwalsiswa/" + idsiswa,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var programList = "<ul>";
                        response.data.forEach(function(item) {
                            programList += "<li>" + item.groupwa + "</li>";
                        });
                        programList += "</ul>";
                        
                        // Update isi kolom ke-4 (index 3) dengan programList
                        $('td:eq(3)', row).html(programList);  // Kolom ke-4, index 3
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $('td:eq(3)', row).html("<ul><li>Error loading program</li></ul>");
                    }
                });

                // Kembalikan data kosong sementara, karena AJAX bersifat asinkron
                $('td:eq(3)', row).html("<ul><li>Loading...</li></ul>");
            }
        });
    }

    function reload() {
        document.getElementById('cari_noinduk').value = "";
        document.getElementById('cari_nama').value = "";
        document.getElementById('panggilan_cari').value = "";
        document.getElementById('tgl_daftar_cari').value = "";
        document.getElementById('jkel_cari').value = "";
        document.getElementById('asal_sekolah_cari').value = "";
        document.getElementById('tmp_lahir_cari').value = "";
        document.getElementById('tgl_lahir_cari').value = "";
        document.getElementById('domisili_cari').value = "";
        document.getElementById('nama_ortu_cari').value = "";
        document.getElementById('perkerjaan_ortu_cari').value = "";
        document.getElementById('statusdata').value = "";
        document.getElementById('kelas').value = "";

        tabel.destroy();
        load_awal();
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Siswa');
        var tgldaftar = document.getElementById('tgl_daftar').value;
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/shownoinduk/" + tgldaftar,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                document.getElementById('no_induk').value = data.noinduk;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error generate no induk",
                    position: 'topRight'
                });
            }
        });
    }

    function getNoInduk() {
        var tgldaftar = document.getElementById('tgl_daftar').value;
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/shownoinduk/" + tgldaftar,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                document.getElementById('no_induk').value = data.noinduk;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error generate no induk",
                    position: 'topRight'
                });
            }
        });
    }

    function hapus(id, nama) {
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin menghapus siswa " + nama + " ?",
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>siswa/hapus/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function(data) {
                            swal("Gagal!", data.status, "error");
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                } else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
            });
    }



    // function ganti(id) {
    //     save_method = 'update';
    //     $('#form')[0].reset();
    //     $('#modal_form').modal('show');
    //     $('.modal-title').text('Ganti Siswa');
    //     $.ajax({
    //         url: "<?php //echo base_url(); ?>siswa/show/" + id,
    //         type: "POST",
    //         dataType: "JSON",
    //         success: function(data) {
    //             $('[name="kode"]').val(data.idsiswa);
    //             $('[name="tgl_daftar"]').val(data.tgl_daftar);
    //             $('[name="domisili"]').val(data.domisili);
    //             $('[name="nama_lengkap"]').val(data.nama_lengkap);
    //             $('[name="panggilan"]').val(data.panggilan);
    //             $('[name="tmplahir"]').val(data.tmp_lahir);
    //             $('[name="tgllahir"]').val(data.tgl_lahir);
    //             $('[name="sekolah"]').val(data.nama_sekolah);
    //             $('[name="lv_sekolah"]').val(data.level_sekolah);
    //             $('[name="ortu"]').val(data.nama_ortu);
    //             $('[name="pekerjaan_ortu"]').val(data.pekerjaan_ortu);
    //             $('[name="no_induk"]').val(data.no_induk);
    //             $('[name="idmitra"]').val(data.idmitra);
    //             $('[name="email"]').val(data.email);
    //             $('[name="no_hp"]').val(data.tlp);
    //             $('[name="provinsi"]').val(data.provinsi);

    //             if (data.jkel === "Laki-laki") {
    //                 document.getElementById('rbLaki').checked = true;
    //                 document.getElementById('rbPerempuan').checked = false;
    //             } else if (data.jkel === "Perempuan") {
    //                 document.getElementById('rbLaki').checked = false;
    //                 document.getElementById('rbPerempuan').checked = true;
    //             }

    //             // mencari nilai kabupaten
    //             var form_data = new FormData();
    //             form_data.append('provinsi', data.provinsi);
    //             $.ajax({
    //                 url: "<?php //echo base_url(); ?>siswa/kabupaten",
    //                 dataType: 'JSON',
    //                 cache: false,
    //                 contentType: false,
    //                 processData: false,
    //                 data: form_data,
    //                 type: 'POST',
    //                 success: function(data1) {
    //                     $('#kabupaten').html(data1.status);
    //                     $('[name="kabupaten"]').val(data.kabupaten);

    //                     // mencari nilai kecamatan
    //                     form_data = new FormData();
    //                     form_data.append('kabupaten', data.kabupaten);

    //                     $.ajax({
    //                         url: "<?php //echo base_url(); ?>siswa/kecamatan",
    //                         dataType: 'JSON',
    //                         cache: false,
    //                         contentType: false,
    //                         processData: false,
    //                         data: form_data,
    //                         type: 'POST',
    //                         success: function(data2) {
    //                             $('#kecamatan').html(data2.status);
    //                             $('[name="kecamatan"]').val(data.kecamatan);

    //                             // mencari kelurahan
    //                             form_data = new FormData();
    //                             form_data.append('kecamatan', data.kecamatan);

    //                             $.ajax({
    //                                 url: "<?php //echo base_url(); ?>siswa/kelurahan",
    //                                 dataType: 'JSON',
    //                                 cache: false,
    //                                 contentType: false,
    //                                 processData: false,
    //                                 data: form_data,
    //                                 type: 'POST',
    //                                 success: function(data3) {
    //                                     $('#kelurahan').html(data3.status);
    //                                     $('[name="kelurahan"]').val(data.kelurahan);
    //                                 },
    //                                 error: function(jqXHR, textStatus, errorThrown4) {
    //                                     iziToast.error({
    //                                         title: 'Error',
    //                                         message: "Error json " + errorThrown4,
    //                                         position: 'topRight'
    //                                     });
    //                                 }
    //                             });
    //                         },
    //                         error: function(jqXHR, textStatus, errorThrown3) {
    //                             iziToast.error({
    //                                 title: 'Error',
    //                                 message: "Error json " + errorThrown3,
    //                                 position: 'topRight'
    //                             });
    //                         }
    //                     });
    //                 },
    //                 error: function(jqXHR, textStatus, errorThrown2) {
    //                     iziToast.error({
    //                         title: 'Error',
    //                         message: "Error json " + errorThrown2,
    //                         position: 'topRight'
    //                     });
    //                 }
    //             });

    //         },
    //         error: function(jqXHR, textStatus, errorThrown1) {
    //             iziToast.error({
    //                 title: 'Error',
    //                 message: "Error json " + errorThrown1,
    //                 position: 'topRight'
    //             });
    //         }
    //     });
    // }

    function closemodal() {
        $('#modal_form').modal('hide');
    }

    function jadwal(idsiswa) {
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/enkrip/" + idsiswa,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                window.location.href = "<?php echo base_url(); ?>siswa/jadwal/" + data.status;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error generate no induk",
                    position: 'topRight'
                });
            }
        });
    }

    function openfile() {
        $('#form_file')[0].reset();
        $('#modal_file').modal('show');
    }

    function closemodalfile() {
        $('#modal_file').modal('hide');
    }

    function savefile() {
        var formData = new FormData();
        formData.append("file", $("#file")[0].files[0]);

        $.ajax({
            url: '<?php echo base_url(); ?>siswa/proses_upload_file',
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
                $('#ket_upload').html(data.status);

                if (data.status === "Data berhasil diperbarui") {
                    closemodalfile();
                }
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

    function exportdata() {
        window.location.href = "<?php echo base_url(); ?>siswa/exportdata/semua";
    }

    function histori(idsiswa) {
        window.location.href = "<?php echo base_url(); ?>siswa/histori/"+idsiswa;
    }

    function openexport() {
        $('#form_export')[0].reset();
        $('#modal_expor').modal('show');
    }

    function closemodalexpor() {
        $('#modal_expor').modal('hide');
    }

    function exportfiles() {
        var sts_data = document.getElementById('sts_data').value;
        window.location.href = "<?php echo base_url(); ?>siswa/exportdata/"+sts_data;
    }

    function keluar(id, nama) {
        $('#form_keluar')[0].reset();
        $('#modal_keluar').modal('show');
        $.ajax({
            url: "<?php echo base_url(); ?>siswa/show/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $('[name="idsiswa_pindah"]').val(data.idsiswa);
                $('[name="no_induk"]').val(data.no_induk);
                $('[name="nama_siswa_keluar"]').val(data.nama_lengkap);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error generate no induk",
                    position: 'topRight'
                });
            }
        });
    }

    function proses_keluar() {
        var idsiswa = document.getElementById('idsiswa_pindah').value;
        var alasan = document.getElementById('alasan').value;
        var tag = $('.select2-demo').val();

        if (idsiswa === '') {
            iziToast.error({
                title: 'Stop',
                message: "Tidak ditemukan siswa",
                position: 'topRight'
            });
        } else if (alasan === '') {
            iziToast.error({
                title: 'Stop',
                message: "Alasan wajib diisi",
                position: 'topRight'
            });
        } else {

            $('#btnSaveKeluar').text('Menyimpan...');
            $('#btnSaveKeluar').attr('disabled', true);

            var form_data = new FormData();
            form_data.append('idsiswa', idsiswa);
            form_data.append('alasan', alasan);
            form_data.append('tag', tag);

            $.ajax({
                url: "<?php echo base_url(); ?>siswa/keluar",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    iziToast.success({
                        title: 'Info',
                        message: data.status,
                        position: 'topRight'
                    });

                    reload();
                    closemodalkeluar();

                    $('#btnSaveKeluar').text('Proses Siswa Keluar');
                    $('#btnSaveKeluar').attr('disabled', false);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    iziToast.error({
                        title: 'Error',
                        message: "Error json " + errorThrown,
                        position: 'topRight'
                    });

                    $('#btnSaveKeluar').text('Proses Siswa Keluar');
                    $('#btnSaveKeluar').attr('disabled', false);
                }
            });
        }
    }

    function closemodalkeluar() {
        $('#modal_keluar').modal('hide');
    }

    function siswakeluar() {
        window.location.href = "<?php echo base_url(); ?>siswa/listkeluar";
    }

    function siswa_lulus() {
        $('#idjadwal_lulus').val("");
        $('#rombel_lulus').val("");
        $('#modal_lulus').modal('show');
        load_alumni("");
    }

    function load_alumni(idjadwal) {
        tb_alumni = $('#tb_alumni').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlist_alumni/" + idjadwal,
            retrieve: true
        });
        tb_alumni.destroy();
        tb_alumni = $('#tb_alumni').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajaxlist_alumni/" + idjadwal,
            retrieve: true
        });
    }

    function show_jadwal_lulus() {
        $('#modal_jadwal').modal('show');
        tb_jadwal = $('#tb_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajax_jadwal_lulus",
            retrieve: true
        });
        tb_jadwal.destroy();
        tb_jadwal = $('#tb_jadwal').DataTable({
            ajax: "<?php echo base_url(); ?>siswa/ajax_jadwal_lulus",
            retrieve: true
        });
    }

    function pilih_jadwal_lulus(idjadwal, rombel) {
        $('#idjadwal_lulus').val(idjadwal);
        $('#rombel_lulus').val(rombel);
        $('#modal_jadwal').modal('hide');

        load_alumni(idjadwal);
    }

    function cetaK_alumni() {
        window.open("<?php echo base_url(); ?>siswa/cetakalumni", "_blank");
    }

    function donwload_alumni() {

    }

    function pencarian() {
        $('#form_cari')[0].reset();
        $('#modal_cari').modal('show');
    }

    function proses_cari() {
        tabel.destroy();
        load_awal();
        $('#modal_cari').modal('hide');
    }

    function pilih_kabupaten() {
        var provinsi = document.getElementById('provinsi').value;
        var form_data = new FormData();
        form_data.append('provinsi', provinsi);

        $.ajax({
            url: "<?php echo base_url(); ?>siswa/kabupaten",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kabupaten').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function pilih_kecamatan() {
        var kabupaten = document.getElementById('kabupaten').value;
        var form_data = new FormData();
        form_data.append('kabupaten', kabupaten);

        $.ajax({
            url: "<?php echo base_url(); ?>siswa/kecamatan",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kecamatan').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }

    function pilih_kelurahan() {
        var kecamatan = document.getElementById('kecamatan').value;
        var form_data = new FormData();
        form_data.append('kecamatan', kecamatan);

        $.ajax({
            url: "<?php echo base_url(); ?>siswa/kelurahan",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(data) {
                $('#kelurahan').html(data.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                iziToast.error({
                    title: 'Error',
                    message: "Error json " + errorThrown,
                    position: 'topRight'
                });
            }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Siswa</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <?php
                if (session()->get("logged_pendidikan")) {
                    echo '<a href="' . base_url() . '/homependidikan">Beranda</a>';
                } else if (session()->get("logged_hr")) {
                    echo '<a href="' . base_url() . '/home">Beranda</a>';
                }
                ?>
            </li>
            <li class="breadcrumb-item active">Siswa</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="pencarian();"><i class="fas fa-search"></i> Pencarian </button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="add();"><i class="fas fa-plus"></i> Tambah Data </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="openfile();"><i class="ion ion-ios-attach"></i> Import Data </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="openexport();"><i class="ion ion-ios-download"></i> Export Data </button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();"><i class="feather icon-refresh-cw"></i> Reload</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="siswakeluar();">Siswa Keluar</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="siswa_lulus();">Siswa Lulus / Alumni</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="5%">#</th>
                                    <th width="5%">No Induk</th>
                                    <th width="10%">Siswa</th>
                                    <th width="30%">Program</th>
                                    <th width="10%">Nama Invoice</th>
                                    <th width="10%">Status Data</th>
                                    <th width="10%">Aksi</th>
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

<div class="modal fade" id="modal_lulus" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Siswa Lulus / Alumni</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col">
                        <label class="form-label">Rombel</label>
                        <div class="input-group">
                            <input type="hidden" id="idjadwal_lulus" name="idjadwal_lulus" readonly autocomplete="off">
                            <input type="text" id="rombel_lulus" name="rombel_lulus" class="form-control" placeholder="Rombel" readonly>
                            <span class="input-group-append">
                                <button class="btn btn-sm btn-secondary" type="button" onclick="show_jadwal_lulus();">...</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary btn-sm" onclick="cetaK_alumni();"><i class="fas fa-print"></i> Cetak </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="donwload_alumni();"><i class="fas fa-download"></i> Export Excel </button>
            </div>
            <div class="modal-body">
                <table id="tb_alumni" class="datatables-demo table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Jadwal</th>
                            <th>Siswa</th>
                            <th>Ortu</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Import Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_file">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label" style="color:red;">Pastikan menggunkan template yang tersedia</label>
                            <label class="form-label" style="color:blue; cursor:pointer;" onclick="exportdata();">Unduh Disini</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">File</label>
                            <input type="file" id="file" name="file" class="form-control" autocomplete="off">
                        </div>
                    </div>
                </form>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped" style="min-width: 0px;"> 0 % </div>
                </div>
                <label id="ket_upload"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalfile();">Tutup</button>
                <button id="btnSaveFile" type="button" class="btn btn-primary" onclick="savefile();">Import Data Siswa</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_expor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Export Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_export">
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Pilih Status Data</label>
                            <select name="sts_data" id="sts_data" class="form-control">
                                <option value="semua">Semua Data</option>
                                <option value="belumlengkap">Belum Lengkap</option>
                                <option value="sudahlengkap">Sudah Lengkap</option>
                                <option value="duplikat">Duplikat</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="progress">
                    <div class="progress-bar progress-bar-striped" style="min-width: 0px;"> 0 % </div>
                </div>
                <label id="ket_upload"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalexpor();">Tutup</button>
                <button id="btnSaveFile" type="button" class="btn btn-primary" onclick="exportfiles();">Export Data Siswa</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_keluar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Form Siswa Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_keluar">
                    <input type="hidden" id="idsiswa_pindah" name="idsiswa_pindah" autocomplete="off" readonly>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">No Induk</label>
                            <input type="text" id="no_induk" name="no_induk" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Nama</label>
                            <input type="text" id="nama_siswa_keluar" name="nama_siswa_keluar" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Alasan Keluar</label>
                            <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">Tag Alasan Keluar</label>
                            <select class="select2-demo form-control" multiple style="width: 100%" data-allow-clear="true" name="tag[]">
                                <?php foreach ($tags->getResult() as $row) { ?>
                                    <option value="<?php echo $row->idtag; ?>"><?php echo ucwords(strtolower($row->tag . ' (' . $row->keterangan . ')')); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodalkeluar();">Tutup</button>
                <button id="btnSaveKeluar" type="button" class="btn btn-primary" onclick="proses_keluar();">Proses Siswa Keluar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_jadwal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <div class="card-datatable table-responsive">
                    <table id="tb_jadwal" class="datatables-demo table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kelas</th>
                                <th>Kursus<br>Tahun Ajaran</th>
                                <th>Hari<br>Sesi</th>
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

<div class="modal fade" id="modal_cari" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Filter Pencarian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form_cari">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">No Induk</label>
                                    <input type="text" id="cari_noinduk" name="cari_noinduk" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" id="cari_nama" name="cari_nama" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Panggilan</label>
                                    <input type="text" id="panggilan_cari" name="panggilan_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select id="jkel_cari" name="jkel_cari" class="form-control">
                                        <option value="">- Pilih Jenis Kelamin -</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Asal Sekolah</label>
                                    <input type="text" id="asal_sekolah_cari" name="asal_sekolah_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" id="tmp_lahir_cari" name="tmp_lahir_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="tgl_lahir_cari" name="tgl_lahir_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Domisili</label>
                                    <input type="text" id="domisili_cari" name="domisili_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Nama Ortu</label>
                                    <input type="text" id="nama_ortu_cari" name="nama_ortu_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Pekerjaan Ortu</label>
                                    <input type="text" id="perkerjaan_ortu_cari" name="perkerjaan_ortu_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Tanggal Daftar</label>
                                    <input type="date" id="tgl_daftar_cari" name="tgl_daftar_cari" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Status Data Siswa</label>
                                    <select id="statusdata" name="statusdata" class="form-control">
                                        <option value="">- Pilih Status Data -</option>
                                        <option value="Sudah Lengkap">Sudah Lengkap</option>
                                        <option value="Belum Lengkap">Belum Lengkap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label class="form-label">Kelas</label>
                                    <select id="kelas" name="kelas" class="form-control">
                                        <option value="">- Pilih Kelas -</option>
                                        <?php
                                        foreach ($kelas->getResult() as $row) {
                                        ?>
                                            <option value="<?php echo $row->idjadwal; ?>"> <?php echo $row->groupwa; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="proses_cari();">Cari</button>
            </div>
        </div>
    </div>
</div>