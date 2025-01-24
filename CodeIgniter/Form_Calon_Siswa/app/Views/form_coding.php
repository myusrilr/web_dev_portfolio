<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran LEAP Coding : Learn Scratch with Science</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    body {
        background-color: #fdebd0;
        font-family: Arial, sans-serif;

        margin: 0;
    }

    .container {
        background-color: #faeedc;
    }

    #wrapper {
        margin: auto;
    }

    .title {
        background-color: #fff;
        padding: 10px;
        font-size: 24px;
        font-weight: bold;
        border: none;
        border-bottom: 2px dashed #ccc;
    }

    .title-1 {
        background-color: #fff;
    }

    .content {
        background-color: #fdebd0;
        border: 2px dashed #ccc;
        border-top: none;
        padding: 20px;
    }

    p {
        text-align: left;
    }

    .section-title {
        font-weight: bold;
    }

    .list-item {
        margin-bottom: 10px;
    }

    .icon {
        color: red;
        margin-right: 5px;
    }

    .icon-check {
        color: orange;
        margin-right: 5px;
    }

    .contact-link {
        color: blue;
        text-decoration: none;
    }

    #submit-btn {
        background-color: #ffca9e;
        color: black;
        border-color: none;
    }

    #hope {
        height: 100px;
        /* Tinggi input sesuai kebutuhan */
        text-align: left;
        /* Teks rata kiri */
        vertical-align: top;
        /* Posisi teks di atas */
        padding: 5px;
        /* Memberi sedikit jarak teks dari tepi */
        box-sizing: border-box;
        /* Pastikan padding tidak memengaruhi ukuran total */
    }
</style>
</head>

<body>
    <div class="container">
        <div class="wrapper mt-3" id="wrapper">
            <div class="title text-center p-3" id="title">LEAP Coding : Learn Scratch with Science</div>
            <div class="content text-center" id="content">
                <div class="row">
                    <div class="col-md-6">
                        <p class="section-title">Lama Pelatihan :</p>
                        <p>Total 18x Sesi /Level (± 4,5 Bulan)</p>
                        <p class="section-title">Pertemuan :</p>
                        <p>1x seminggu (4 Sesi/bulan)</p>
                        <p class="section-title">Durasi :</p>
                        <p>60 menit/pertemuan</p>
                        <p class="section-title">Pilihan jadwal kelas yang saat ini tersedia :</p>
                        <p class="list-item"><i class="fas fa-check icon-check"></i>Rabu Pukul 17.00- 18.00 WIB</p>
                        <p class="list-item"><i class="fas fa-times icon"></i>Jika berhalangan hadir, siswa akan
                            mendapat rekaman zoom dan pantauan perkembangan materi tertinggal oleh guru walau tidak ada
                            kelas pengganti.</p>
                        <p class="section-title">Biaya Pendaftaran :</p>
                        <p>Rp. 150.000,-</p>
                        <p class="section-title">Total paket per semester</p>
                        <p>Rp 1.000.000,-</p>
                    </div>
                    <div class="col-md-6">
                        <p class="section-title">Device yang digunakan :</p>
                        <p>PC/Laptop</p>
                        <p class="section-title">Aplikasi yang digunakan :</p>
                        <p>Zoom, LMS, dan Scratch</p>
                        <p class="section-title">Metode Pembelajaran :</p>
                        <p class="list-item">- Kelas online via ZOOM + LMS</p>
                        <p class="list-item">- Kelas offline + LMS</p>
                        <p class="list-item">- Bimbingan presentasi Bahasa Inggris</p>
                        <p class="list-item">- Max 11 orang/kelas</p>
                        <p class="section-title">Info Tambahan :</p>
                        <p>Program coding kami akan menggunakan Online versions Scratch 3.0 (via web browser) yang dapat
                            dibuka pada minimal browser berikut ini:</p>
                        <p class="list-item">1. Chrome 63,</p>
                        <p class="list-item">2. Edge 15,</p>
                        <p class="list-item">3. Firefox 57,</p>
                        <p class="list-item">4. Safari 11</p>
                        <p class="list-item"><i class="fas fa-times icon"></i>Internet Explorer is NOT supported</p>
                        <p>Untuk Info lebih lanjut silahkan kontak <a href="https://wa.me/6281335381619"
                                class="contact-link" target="_blank">Admin</a></p>
                    </div>
                </div>

            </div>
            <h1 class="text-center display-3"><strong>Silahkan Isi Form di Bawah Ini dengan Benar dan Sesuai</strong>
            </h1>
            <div class="container mt-5 mb-5">
                <h2 class="title-1 text-center p-3 mb-3">Trial/Sit-In Leap Coding Class</h2>
                <form action="/submit" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="form_type" value="coding">
                    <input type="hidden" name="idpendkursus" value="K00002">

                    <!--e-mail LMS, nama lengkap, nama panggilan -->
                    <div class="row">
                        <!-- e-mail  -->
                        <div class="col-md-4 mb-2">
                            <label for="email" class="form-label"><b>Alamat Email Untuk Akun LMS</b><span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                value="<?= set_value('email') ?>" required>
                        </div>
                        <!-- Nama Lengkap -->
                        <div class="col-md-4 mb-2">
                            <label for="fullName" class="form-label"><b>Nama Lengkap</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullName" name="fullName"
                                placeholder="Nama Lengkap" value="<?= set_value('fullName') ?>" required>
                        </div>
                        <!-- Nama Panggilan -->
                        <div class="col-md-4 mb-2">
                            <label for="nickName" class="form-label"><b>Nama Panggilan</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nickName" name="nickName"
                                placeholder="Nama Panggilan" value="<?= set_value('nickName') ?>" required>
                        </div>
                    </div>

                    <!--Domisili dan Nama Sekolah -->
                    <div class="row">
                        <!-- Domisili -->
                        <div class="col-md-6 mb-2">
                            <label for="domicile" class="form-label"><b> Kota Domisili</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="domicile" name="domicile" placeholder="Domisili"
                                value="<?= set_value('domicile') ?>" required>
                        </div>
                        <!-- Nama Sekolah/Kampus-->
                        <div class="col-md-6 mb-2">
                            <label for="schoolName" class="form-label"><b>Nama Sekolah/Kampus</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="schoolName" name="schoolName"
                                placeholder="Nama Sekolah/Kampus" value="<?= set_value('schoolName') ?>" required>
                        </div>
                    </div>

                    <!-- kelas -->
                    <div class="mb-3">
                        <label class="form-label"><b>Kelas</b><span class="text-danger">*</span></label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classThree" name="classLevel"
                                value=III required>
                            <label class="form-check-label" for="classThree">III</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classFour" name="classLevel"
                                value="IV" required>
                            <label class="form-check-label" for="classFour">IV</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classFive" name="classLevel" value="V"
                                required>
                            <label class="form-check-label" for="classFive">V</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classSix" name="classLevel" value="VI"
                                required>
                            <label class="form-check-label" for="classSix">VI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classSeven" name="classLevel"
                                value="VII" required>
                            <label class="form-check-label" for="classSeven">VII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classEight" name="classLevel"
                                value="VIII" required>
                            <label class="form-check-label" for="classEight">VIII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classNine" name="classLevel"
                                value="IX" required>
                            <label class="form-check-label" for="oding_classNine">IX</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classTen" name="classLevel" value="X"
                                required>
                            <label class="form-check-label" for="classTen">X</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classEleven" name="classLevel"
                                value="XI" required>
                            <label class="form-check-label" for="classEleven">XI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classTwelve" name="classLevel"
                                value="XII" required>
                            <label class="form-check-label" for="classTwelve">XII</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="collegeStudent" name="classLevel"
                                value="Mahasiswa" required>
                            <label class="form-check-label" for="collegeStudent">Mahasiswa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="classOther" name="classLevel"
                                value="Lainnya" required>
                            <label class="form-check-label" for="classOther">Lainnya</label>
                        </div>
                    </div>

                    <!-- Info Detail -->
                    <div class="mb-3">
                        <div class="col-12">
                            <label for="otherDetail" class="form-label"><b>Jika pilih lainnya, silahkan tuliskan
                                    detailnya di bawah ini</b></label>
                            <input type="text" class="form-control" id="otherDetail" name="otherDetail"
                                placeholder="Detail informasi lainnya" value="<?= set_value('otherDetail') ?>">
                        </div>
                    </div>

                    <p class="text-muted"><strong>No Handphone ( akan dimasukkan dalam group WhatsApp, boleh lebih dari
                            1 nomor )</strong></p>

                    <!--Nomor WA -->
                    <div class="row">

                        <!-- Nomor Whatsapp Aktif 1 -->
                        <div class="col-md-6 mb-2">
                            <label for="phone1" class="form-label"><b>Nomor Handphone 1</b><span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="phone1" name="phone1" type="text" value="<?= set_value('phone1') ?>" placeholder="Pastikan nomor aktif dan terhubung dengan WhatsApp" onkeypress="return hanyaAngka(event, false);">
                            <span id="errorSpan" style="color: red;"></span>
                        </div>
                        <!-- Nomor Whatsapp Aktif 2 -->
                        <div class="col-md-6 mb-2">
                            <label for="phone2" class="form-label"><b>Nomor Handphone 2</b></label>
                            <input class="form-control" id="phone2" name="phone2" type="text" value="<?= set_value('phone2') ?>" placeholder="Pastikan nomor aktif dan terhubung dengan WhatsApp" onkeypress="return hanyaAngka(event, false);">
                            <span id="errorSpan" style="color: red;"></span>
                        </div>
                    </div>

                    <!-- pengalaman penggunaan komputer dan software -->
                    <div class="row">
                        <!-- pengalaman penggunaan komputer  -->
                        <div class="col-md-6 mb-2">
                            <label for="computer" class="form-label"><b>Apakah anak sudah terbiasa menggunakan
                                    laptop/komputer sebelumnya?</b><span class="text-danger">*</span></label>
                            <select class="form-select" id="computer" name="computer" required>
                                <option value="" <?= set_select('computer', '') ?>></option>
                                <option value="Ya" <?= set_select('computer', 'Ya') ?>>Ya</option>
                                <option value="Tidak" <?= set_select('computer', 'Tidak') ?>>Tidak</option>
                            </select>
                        </div>
                        <!--pengalaman penggunaan software -->
                        <div class="col-md-6 mb-2">
                            <label for="software" class="form-label"><b>Software/aplikasi apa yang sudah pernah
                                    digunakan?</b><span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="software" name="software"
                                placeholder="Nama software/aplikasi yang biasa digunakan"
                                value="<?= set_value('software') ?>" required>
                        </div>
                    </div>

                    <!-- pengalaman mengikuti kelas coding dan pengetahuan LEAP -->
                    <div class="row">
                        <!-- pengalaman mengikuti kelas coding  -->
                        <div class="col-md-6 mb-2">
                            <label for="exp" class="form-label"><b>Apakah anak sudah pernah mengikuti kelas coding
                                    sebelumnya?</b><span class="text-danger">*</span></label>
                            <select class="form-select" id="exp_coding" name="exp" required>
                                <option value="" <?= set_select('exp', '') ?>></option>
                                <option value="Ya" <?= set_select('exp', 'Ya') ?>>Ya</option>
                                <option value="Tidak" <?= set_select('exp', 'Tidak') ?>>Tidak</option>
                            </select>
                        </div>
                        <!-- pengetahuan LEAP -->
                        <div class="col-md-6 mb-2">
                            <label for="info" class="form-label"><b>Tahu informasi LEAP / kelas ini dari :</b><span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="info" name="info" required>
                                <option value="" <?= set_select('info', '') ?>></option>
                                <option value="Instagram" <?= set_select('info', 'Instagram') ?>>Instagram</option>
                                <option value="Facebook" <?= set_select('info', 'Facebook') ?>>Facebook</option>
                                <option value="Website" <?= set_select('info', 'Website') ?>>Website</option>
                                <option value="Teman/kerabat/saudara"
                                    <?= set_select('info', 'Teman/kerabat/saudara') ?>>
                                    Teman/kerabat/saudara</option>
                                <option value="Mitra Leap" <?= set_select('info', 'Mitra Leap') ?>>Mitra Leap</option>
                                <option value="Lainnya" <?= set_select('info', 'Lainnya') ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rekomendasi -->
                    <div class="mb-3">
                        <div class="col-12">
                            <label for="recom" class="form-label"><b>Nama Teman/Kerabat/Sekolah/Instansi yang
                                    Merekomendasikan :</b></label>
                            <input type="text" class="form-control" id="recom" name="recom"
                                placeholder="Nama yang Merokemendasikan " value="<?= set_value('recom') ?>">
                        </div>
                    </div>

                    <!-- Harapan dan kepemilikan gadget -->
                    <div class="row">
                        <!-- Harapan -->
                        <div class="col-md-6 mb-2">
                            <label for="hope" class="form-label"><b>Harapan mengikuti kelas coding</b><span
                                    class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" id="hope" name="hope"
                                value="<?= set_value('hope') ?>" required></textarea>
                        </div>
                        <!--kepemilikan gadget -->
                        <div class="col-md-6 mb-2">
                            <label class="form-label"><b>Gadget yang dimiliki</b></label>
                            <br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="hp" name="gadget[]"
                                    value="Handphone">
                                <label class="form-check-label" for="hp">Handphone</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="tab" name="gadget[]" value="Tablet">
                                <label class="form-check-label" for="tab">Tablet</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="laptop" name="gadget[]"
                                    value="Laptop">
                                <label class="form-check-label" for="laptop">Laptop</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="pc" name="gadget[]"
                                    value="Komputer/PC">
                                <label class="form-check-label" for="pc">Komputer/PC</label>
                            </div>
                        </div>
                    </div>


                    <!-- Tanggal -->
                    <div class="mb-3">
                        <div class="col-12">
                            <label for="date" class="form-label"><b>Pilih tanggal trial/ sit-in</b><span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="date" name="date" required>
                                <option value="" <?= set_select('date', '') ?>></option>
                                <option value="Rabu, Pukul 17.00 - 18.00 WIB"
                                    <?= set_select('date', 'Rabu, Pukul 17.00 - 18.00 WIB') ?>>Rabu, Pukul 17.00 - 18.00
                                    WIB</option>
                                <option value="Kamis, Pukul 17.00 - 18.00 WIB"
                                    <?= set_select('date', 'Kamis, Pukul 17.00 - 18.00 WIB') ?>>Kamis, Pukul 17.00 -
                                    18.00 WIB</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pilihan Kelas -->
                    <div class="mb-3">
                        <div class="col-12">
                            <label for="class_options" class="form-label"><b>Pilihan Kelas</b><span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="class_options" name="class_options" required>
                                <option value="" <?= set_select('class_options', '') ?>></option>
                                <option value="Online" <?= set_select('class_options', 'Online') ?>>Online</option>
                                <option value="Offline" <?= set_select('class_options', 'Offline') ?>>Offline</option>
                            </select>
                        </div>
                    </div>

                    <!-- Upload File -->
                    <div class="mb-3">
                        <label for="payment" class="form-label">
                            <b>Silahkan Upload Bukti Pembayaran di sini (jika ada)</b>
                        </label>
                        <input type="file" class="form-control" id="payment" name="payment"
                            accept="jpg, .jpeg, .png, .pdf" max-file-size="10485760">
                        <div id="file-name-display" class="form-text mt-1">
                            Belum ada berkas yang terpilih
                        </div>
                    </div>

                    <!-- Checkbox Note -->
                    <div class="mb-3">
                        <label class="form-label"><b>NOTE : Pastikan data yang sudah anda masukkan benar dan
                                sesuai</b><span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="note" name="note" required>
                            <label class="form-check-label" for="note">Ya, data yang sudah saya masukkan sudah benar dan
                                sesuai</label>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <p class="text-muted">
                            <span class="text-danger">*</span> Menandakan data wajib diisi.
                        </p>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn col-12" id="submit-btn" disabled><strong>Kirim</strong></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Skrip untuk menampilkan pesan pop-up -->
    <?php if (session()->getFlashdata('message')): ?>
        <script>
            alert("<?= session()->getFlashdata('message') ?>");
        </script>
    <?php endif; ?>

    <script>
        //telepon
        function hanyaAngka(e, decimal) {
            var key;
            var keychar;

            // Mendapatkan kode tombol yang ditekan
            if (window.event) {
                key = window.event.keyCode;
            } else if (e) {
                key = e.which;
            } else {
                return true;
            }

            // Mengonversi kode tombol menjadi karakter
            keychar = String.fromCharCode(key);

            // Tombol spesial yang diizinkan
            if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
                return true;
            }
            // Memeriksa jika input adalah angka 0-9 atau tanda '+'
            else if ((("0123456789").indexOf(keychar) > -1) || (keychar === "+" && e.target.value.length === 0)) {
                var inputValue = e.target.value + keychar;

                // Validasi panjang minimal 10 digit (tanpa menghitung '+')
                var numericValue = inputValue.replace("+", ""); // Hilangkan tanda '+' untuk validasi panjang
                if (numericValue.length < 10) {
                    document.getElementById('errorSpan').textContent = 'Nomor telepon minimal harus 10 digit.';
                } else {
                    document.getElementById('errorSpan').textContent = ''; // Menghapus pesan error
                }
                return true;
            }
            // Memeriksa jika desimal diizinkan
            else if (decimal && (keychar == ".")) {
                return true;
            }
            // Jika karakter tidak valid
            else {
                return false;
            }
        }

        const hope = document.getElementById('hope');
        console.log();

        // Bukti Pembayaran
        const fileInput = document.getElementById('payment');
        const fileNameDisplay = document.getElementById('file-name-display');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (file) {
                // Cek ukuran file maksimal 10MB
                if (file.size > 10 * 1024 * 1024) {
                    fileNameDisplay.textContent = 'Ukuran file melebihi batas 10MB';
                    fileInput.value = ''; // Reset input file
                } else {
                    fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                }
            } else {
                fileNameDisplay.textContent = 'Belum ada berkas yang terpilih';
            }
        });

        console.log(fileInput);
        console.log(fileNameDisplay);

        // Aktivasi Tombol Submit Hanya Jika Checkbox Dicentang
        const noteCheckbox = document.getElementById('note');
        const submitBtn = document.getElementById('submit-btn');

        noteCheckbox.addEventListener('change', function() {
            submitBtn.disabled = !noteCheckbox.checked; // Enable tombol jika dicentang
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>