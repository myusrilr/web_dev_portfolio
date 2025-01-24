<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registrasi Ulang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>singlepage/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>back/assets/img/leap.png">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

    <style>
        .back {
            background: url('<?php echo base_url() ?>singlepage/images/bgcalon.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: 100% 100%;
            justify-content: center;
            /* Pusatkan secara horizontal */
            align-items: center;
            /* Pusatkan secara vertikal */
            margin: 0;
            display: flex;
        }

        /* Media query untuk layar di bawah 500px */
        @media (max-width: 600px) {
            body {
                background: url('<?php echo base_url() ?>singlepage/images/bghp.png') no-repeat center center fixed;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: blue;
            color: white;
        }

        #titleModal {
            text-transform: uppercase;
            font-size: 35px;
            font-family: "Abril_Fatface";
            text-align: center;
            color: #6d5555;
            letter-spacing: 3px;
        }

        #modalVerifikasi {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: all 1s ease;
            transform: translate(-50%, -50%) scale(1.2);
            flex-direction: column;
            align-items: center;
            opacity: 95%;
        }

        #formVerifikasi {
            border: none;
            padding-top: 30px;
        }

        #submitBtn {
            background: rgb(107, 228, 111);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        #submitBtn:hover {
            background-color: rgb(26, 143, 30);
        }

        #tutupModal {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            color: red;
            cursor: pointer;
        }

        #tutupModal:hover {
            color: rgb(136, 25, 25);
        }

        #titleEmail {
            text-align: center;
            color: black;
        }

        #email {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-color: #735d5d solid 1px;
            z-index: 1000
        }
    </style>
</head>

<body>
    <div class="wrapper back">
        <div class="inner" style="border: 1px solid #d3cccc; padding: 62px 65px 64px; ">
            <div class="form">
                <div class="logo" style="display: flex; justify-content: center; align-items: center;">
                    <img src="<?php echo base_url(); ?>images/logoreport.png" alt="Logo Leap" style="height: 50px;">
                </div>
                <h3>Registrasi Ulang</h3>
                <div class="form-group" style="margin-top: -30px;">
                    <div class="form-wrapper" style="width: 100%; margin-right:0px;">
                        <label>Nama Lengkap Siswa</label>
                        <div class="form-holder">
                            <input id="nama_lengkap" oninput="this.value = this.value.toUpperCase();" name="nama_lengkap" type="text" class="form-control" autocomplete="off">
                        </div>
                        <small class="invalid-feedback">Masukkan minimal 2 kata <br>nama depan & nama tengah atau nama tengah & nama belakang</small>
                        <br>
                        <strong><small class="invalid-feedback" id="error-message"></small></strong>
                    </div>
                </div>
                <div class="form-end">
                    <div class="checkbox"></div>
                    <div class="button-holder">
                        <button type="button" id="searchBtn" onclick="search();">Cari</button>
                    </div>
                </div>
                <div class="form-group" id="daftarsiswa" style="display: none;">
                    <div class="form-wrapper" style="width: 100%; margin-right:0px;">
                        <label>Data Siswa</label>
                        <div class="form-holder">
                            <table id="datasiswa">
                                <!-- Data siswa akan muncul di sini -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk verifikasi email -->
    <div id="modalVerifikasi">
        <!-- Tombol tutup dengan tanda silang -->
        <button onclick="tutupModal()" id="tutupModal">&times;</button>
        <h2 id="titleModal">Verifikasi Email</h2>
        <form id="formVerifikasi" style="border: none;">
            <label for="email" id="titleEmail">Masukkan e-mail yang Telah didaftarkan:</label>
            <input type="email" id="email" placeholder="Masukkan email" required>
            <button type="submit" id="submitBtn">Kirim</button>
        </form>
    </div>


</body>
<script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>

<script>
    function lengkapiekstern(id) {
        window.open("<?php echo base_url(); ?>registrasiulang/form/" + id, "_blank");
    }

    function buatbaru(nama) {
        var form_data = new FormData();
        form_data.append('nama_lengkap', nama);

        $.ajax({
            url: "<?php echo base_url(); ?>registrasiulang/new",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                if (response.status == "ok") {
                    window.location.href = '<?php echo base_url() . 'registrasiulang/form/' ?>' + response.id;
                }
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

    function search() {
        // Ambil nilai dari input nama lengkap
        var namaLengkap = document.getElementById('nama_lengkap').value.trim();

        // Split nama menjadi array kata-kata
        var namaArray = namaLengkap.split(' ');

        // Filter untuk menghapus kata-kata kosong (jika ada spasi berlebihan)
        namaArray = namaArray.filter(function(kata) {
            return kata !== '';
        });

        // Validasi jika jumlah kata minimal 2
        if (namaArray.length < 2) {
            document.getElementById('error-message').innerHTML = "Nama lengkap harus terdiri dari minimal 2 kata.";
        } else {
            document.getElementById('error-message').innerHTML = "";

            var nama_lengkap = document.getElementById('nama_lengkap').value;

            var form_data = new FormData();
            form_data.append('nama_lengkap', nama_lengkap);

            $.ajax({
                url: "<?php echo base_url(); ?>registrasiulang/cari",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function(data) {
                    document.getElementById("daftarsiswa").style.display = "block";

                    $('#datasiswa').html(data.status);
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
    }

    function bukaModal(idSiswa) {
        // Tampilkan modal
        document.getElementById('modalVerifikasi').style.display = 'block';

        // Tangani pengiriman form
        document.getElementById('formVerifikasi').onsubmit = function(e) {
            e.preventDefault();
            var email = document.getElementById('email').value;

            // Kirim data email ke server
            $.ajax({
                url: "<?php echo base_url(); ?>/registrasiulang/verifikasi_email",
                type: "POST",
                data: {
                    idsiswa: idSiswa,
                    email: email
                },
                success: function(response) {
                    // Debug respons terlebih dahulu
                    console.log("Response:", response);

                    try {
                        // Jika response sudah berupa objek, tidak perlu parse
                        // const res = typeof response === "object" ? response : JSON.parse(response);

                        if (response.status === "ok") {
                            console.log("ID ditemukan:", response.idsiswa);
                            window.location.href = '<?php echo base_url() ?>registrasiulang/register/' + response.idsiswa;
                        } else {
                            alert(response.message || "Gagal memproses data.");
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        alert("Terjadi kesalahan parsing JSON.");
                    }
                }

            });
        };
    }


    function tutupModal() {
        // Sembunyikan modal
        document.getElementById('modalVerifikasi').style.display = 'none';
    }
</script>

</html>