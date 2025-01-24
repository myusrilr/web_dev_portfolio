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
            justify-content: center; /* Pusatkan secara horizontal */
            align-items: center;    /* Pusatkan secara vertikal */
            margin: 0;
            display: flex;
        }

        h3{
            font-size: 26px;
        }

        /* Media query untuk layar di bawah 500px */
        @media (max-width: 600px) {
            body {
                background: url('<?php echo base_url() ?>singlepage/images/bghp.png') no-repeat center center fixed;
            }

            h3{
                font-size: 20px;
            }

        }
    </style>
</head>

<body>
    <div class="wrapper back">
        <div class="inner">
            <div class ="form">
                <div class="logo" style="display: flex; justify-content: center; align-items: center;">
                    <img src="<?php echo base_url(); ?>images/logoreport.png" alt="Logo Leap" style="height: 50px;">
                </div>
                <h3>Terima kasih telah melengkapi <br>form registrasi siswa <br> Leap English and Digital Class.</h3>
                <h4 style="font-size: 18px; text-align: center;">Jika ada pertanyaan silakan kontak langsung ke nomor 
                    <a href="https://wa.me/6285172050025" target="_blank">+62 851-7205-0025</a> <br>(Jam operasional kami Senin - Kamis Pukul 14.15 - 19.15 WIB)</h4>
            </div>
        </div>
    </div>
</body>
<script src="<?php echo base_url(); ?>back/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>izitoast/js/iziToast.min.js"></script>

<script>
    function lengkapiekstern(id) {
        window.open("<?php echo base_url(); ?>registrasiulang/form/" + id, "_blank");
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
</script>

</html>