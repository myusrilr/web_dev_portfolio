<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Leap English Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .form-select,
        .form-control,
        .form-check-input {
            background-color: #cbe4f2;
            border-color: #312cab;
        }

        .form-label {
            color: #1c587a;
        }

        .form-check-label {
            color: #1c557a;
        }

        #placement-section {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-5">Form Pendaftaran Leap English Class</h2>
        <form action="/submit" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="form_type" value="kids">

            <!--Nama Lengkap dan Nama Panggilan -->
            <div class="row">
                <!-- Nama Lengkap Anak -->
                <div class="col-md-6 mb-2">
                    <label for="fullName" class="form-label"><b>Nama Lengkap Anak</b><span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullName" name="fullName"
                        placeholder="Nama Lengkap Anak" value="<?= set_value('fullName') ?>" required>
                </div>
                <!-- Nama Panggilan Anak -->
                <div class="col-md-6 mb-2">
                    <label for="nickName" class="form-label"><b>Nama Panggilan Anak</b><span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nickName" name="nickName"
                        placeholder="Nama Panggilan Anak" value="<?= set_value('nickName') ?>" required>
                </div>
            </div>

            <!--Nama Sekolah dan Level Kelas -->
            <div class="row">
                <!-- Nama Sekolah Anak -->
                <div class="col-md-6 mb-2">
                    <label for="schoolName" class="form-label"><b>Nama Sekolah Anak</b><span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="schoolName" name="schoolName"
                        placeholder="Nama Sekolah Anak" value="<?= set_value('schoolName') ?>" required>
                </div>
                <!-- Level Kelas di Sekolah -->
                <div class="col-md-6 mb-2">
                    <label for="classLevel" class="form-label"><b>Level Kelas di Sekolah</b><span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="classLevel" name="classLevel"
                        placeholder="(contoh: SD kelas 1/kelas 2)" value="<?= set_value('classLevel') ?>" required>
                </div>
            </div>

            <!--Jenis Kelamin, kurikulum di sekolah dan pengalaman les -->
            <div class="row">
                <!-- Jenis kelamin -->
                <div class="col-md-4 mb-2">
                    <label for="gender" class="form-label"><b>Jenis Kelamin</b> <span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" <?= set_select('gender', '') ?>></option>
                        <option value="laki-laki" <?= set_select('gender', 'laki-laki') ?>>Laki-laki</option>
                        <option value="perempuan" <?= set_select('gender', 'perempuan') ?>>Perempuan</option>
                    </select>
                </div>
                <!-- Kurikulum di Sekolah -->
                <div class="col-md-4 mb-2">
                    <label for="curriculum" class="form-label"><b>Kurikulum di Sekolah</b> <span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="curriculum" name="curriculum" required>
                        <option value="" <?= set_select('curriculum', '') ?>></option>
                        <option value="Nasional" <?= set_select('curriculum', 'Nasional') ?>>Nasional</option>
                        <option value="Cambridge" <?= set_select('curriculum', 'Cambridge') ?>>Cambridge</option>
                        <option value="Lainnya" <?= set_select('curriculum', 'Lainnya') ?>>Lainnya</option>
                    </select>
                </div>
                <!-- Pengalaman Les -->
                <div class="col-md-4 mb-2">
                    <label for="exp" class="form-label"><b>Pernah Les Bahasa Inggris Sebelumnya?</b><span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="exp" name="exp" required>
                        <option value="" <?= set_select('exp', '') ?>></option>
                        <option value="sudah pernah" <?= set_select('exp', 'sudah pernah') ?>>Sudah Pernah</option>
                        <option value="belum pernah" <?= set_select('exp', 'belum pernah') ?>>Belum Pernah</option>
                    </select>
                </div>
            </div>

            <!--Kesulitan dan Pengetahuan Leap -->
            <div class="row">
                <!-- Analisis Kesulitan tingkat kesulitan Bahasa Inggris -->
                <div class="col-md-6 mb-2">
                    <label for="diagnostic" class="form-label"><b>Apakah Ada Kesulitan dalam Pelajaran Bahasa Inggris di
                            Sekolah Selama Ini?</b><span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="diagnostic" name="diagnostic"
                        placeholder="jelaskan secara padat dan ringkas" value="<?= set_value('diagnostic') ?>" required>
                </div>
                <!-- info mengenai LEAP -->
                <div class="col-md-6 mb-2">
                    <label for="info" class="form-label"><b>Mengetahui Leap English dari mana?</b><span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="info" name="info"
                        placeholder="google/instagram/teman/lainnya" value="<?= set_value('info') ?>" required>
                </div>
            </div>

            <!--Domisili, e-mail, dan Nomor WA -->
            <div class="row">
                <!-- Domisili -->
                <div class="col-md-4 mb-2">
                    <label for="domicile" class="form-label"><b>Domisili</b><span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="domicile" name="domicile"
                        placeholder="Cukup Sebutkan Kota/Kabupaten" value="<?= set_value('domicile') ?>" required>
                </div>
                <!-- Email Aktif -->
                <div class="col-md-4 mb-2">
                    <label for="email" class="form-label"><b>Email Aktif</b><span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Aktif"
                        value="<?= set_value('email') ?>" required>
                </div>
                <!-- Nomor Whatsapp Aktif -->
                <div class="col-md-4 mb-2">
                    <label for="phone1" class="form-label"><b>Nomor WhatsApp Aktif</b><span
                            class="text-danger">*</span></label>
                    <input class="form-control" id="phone1" name="phone1" type="text"
                        pplaceholder="Pastikan nomor aktif dan terhubung dengan WhatsApp"
                        value="<?= set_value('phone1') ?>" onkeypress="return hanyaAngka(event, false);">
                    <span id="errorSpan" style="color: red;"></span>
                </div>
            </div>

            <!--Pilihan Kelas -->
            <div class="mb-3">
                <label class="form-label"><b>Pilihan Kelas</b></label>
                <br>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="online" name="class_options" value=online>
                    <label class="form-check-label" for="online">Online</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="offline" name="class_options" value=offline>
                    <label class="form-check-label" for="offline">Offline</label>
                </div>
            </div>

            <!-- Rekomendasi -->
            <div class="mb-3">
                <div class="col-12">
                    <label for="recom" class="form-label"><b>Nama Teman/Kerabat/Sekolah/Instansi yang Merekomendasikan
                            :</b></label>
                    <input type="text" class="form-control" id="recom" name="recom"
                        placeholder="Nama yang Merokemendasikan " value="<?= set_value('recom') ?>">
                </div>
            </div>

            <!-- Kategori Pendaftaran -->
            <div class="mb-3">
                <div class="col-12">
                    <label for="idpendkursus" class="form-label"><b>Kategori Pendaftaran</b><span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="idpendkursus" name="idpendkursus" required>
                        <?php
                        foreach ($users->getResult() as $row) {
                            ?>
                            <option value="<?php echo $row->idpendkursus ?>" data-name="<?php echo $row->nama_kursus ?>">
                                <?php echo $row->nama_kursus ?>
                            </option>
                            <?php
                        }
                        ; ?>
                    </select>
                </div>
            </div>

            <!-- Jadwal Placement Test-->
            <div class="mb-3" id="placement-section">
                <div class="col-12">
                    <label for="placement" class="form-label"><b>Pilih jadwal Placement Test (Maksimal H-1)</b></label>
                    <select class="form-select" id="placement" name="placement">
                        <option value="" <?= set_select('placement', '') ?>></option>
                        <option value="Hari Senin, Pukul 15:30 - 17:00 WIB" <?= set_select('placement', 'Hari Senin, Pukul 15:30 - 17:00 WIB') ?>>Hari Senin, Pukul
                            15:30 - 17:00 WIB</option>
                        <option value="Hari Selasa, Pukul 17:00 - 18:30 WIB" <?= set_select('placement', 'Hari Selasa, Pukul 17:00 - 18:30 WIB') ?>>Hari Selasa, Pukul
                            17:00 - 18:30 WIB</option>
                    </select>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div class="mb-3">
                <label for="payment" class="form-label">
                    <b>Silahkan Upload Bukti Pembayaran di sini (jika ada)</b>
                </label>
                <br>
                <input type="file" class="form-control-file" id="payment" name="payment" accept="jpg, .jpeg, .png, .pdf"
                    max-file-size="10485760">
                <div id="file" class="form-text mt-1">
                    Belum ada berkas yang terpilih
                </div>
            </div>

            <!-- Checkbox Note -->
            <div class="mb-3">
                <label class="form-label"><b>Note</b></label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="note" name="note" required>
                    <label class="form-check-label" for="note">
                        Periksa Kembali Data yang Sudah diberikan. Pastikan Data yang diberikan Sudah Benar dan Sesuai.
                    </label>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <p class="text-muted">
                    <span class="text-danger">*</span> Menandakan data wajib diisi.
                </p>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary col-12" id="submit" disabled>Kirim</button>
        </form>
    </div>

    <!-- Skrip untuk menampilkan pesan pop-up -->
    <?php if (session()->getFlashdata('message')): ?>
        <script>
            alert("<?= session()->getFlashdata('message') ?>");
        </script>
    <?php endif; ?>

    <script>
        // telepon
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
        // Bukti Pembayaran
        const payment = document.getElementById('payment');
        const fileNameDisplay = document.getElementById('file');

        payment.addEventListener('change', function () {
            const file = payment.files[0];
            if (file) {
                // Cek ukuran file maksimal 10MB
                if (file.size > 10 * 1024 * 1024) {
                    fileNameDisplay.textContent = 'Ukuran file melebihi batas 10MB';
                    file.value = ''; // Reset input file
                } else {
                    fileNameDisplay.textContent = `File terpilih: ${file.name}`;
                }
            } else {
                fileNameDisplay.textContent = 'Belum ada berkas yang terpilih';
            }
        });

        // Aktivasi Tombol Submit Hanya Jika Checkbox Dicentang
        const note = document.getElementById('note');
        const submit = document.getElementById('submit');

        note.addEventListener('change', function () {
            submit.disabled = !note.checked; // Enable tombol jika dicentang
        });

        // Ambil elemen dropdown dan jadwal placement section
        const categorySelect = document.getElementById('idpendkursus');
        const placementSection = document.getElementById('placement-section');

        // Event listener untuk mendeteksi perubahan kategori
        categorySelect.addEventListener('change', function () {
            // Ambil opsi yang dipilih
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const selectedName = selectedOption.getAttribute('data-name');

            // Tampilkan atau sembunyikan berdasarkan nama kategori
            if (selectedName === 'Kelas Bahasa Inggris Umum (General)') {
                placementSection.style.display = 'block'; // Tampilkan jadwal placement
            } else {
                placementSection.style.display = 'none'; // Sembunyikan jadwal placement
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14/dist/sweetalert2.all.min.js"></script>
</body>

</html>