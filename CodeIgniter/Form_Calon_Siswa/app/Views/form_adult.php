<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Leap English Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #edf8fc;
        }

        #title {
            background-color: #114d96;
            padding: 10px;
            border-radius: 15px;
        }

        .form-select,
        .form-control,
        .form-check-input {
            background-color: #d1dee3;
            border-color: none;
        }

        #officeApp,
        #editing,
        #custom {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="text-center mb-5 text-white h1" id="title">Form Adult Class</div>
        <form action="/submit" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="form_type" value="adult">

            <!--Nama Lengkap dan Nama Panggilan -->
            <div class="row">
                <!-- Nama Lengkap Anak -->
                <div class="col-md-6 mb-2">
                    <label for="fullName" class="form-label"><b>Nama Lengkap</b><span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Nama Lengkap" value="<?= set_value('fullName') ?>" required>
                </div>
                <!-- Nama Panggilan Anak -->
                <div class="col-md-6 mb-2">
                    <label for="nickName" class="form-label"><b>Nama Panggilan</b><span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nickName" name="nickName" placeholder="Nama Panggilan" value="<?= set_value('nickName') ?>" required>
                </div>
            </div>

            <!-- Asal Kota -->
            <div class="mb-3">
                <div class="col-12">
                    <label for="domicile" class="form-label"><b>Asal Kota</b><span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="domicile" name="domicile" placeholder="Asal Kota" value="<?= set_value('domicile') ?>" required>
                </div>
            </div>

            <!--Jenis Kelamin, kurikulum di sekolah dan pengalaman les -->
            <div class="row">
                <!-- Jenis kelamin -->
                <div class="col-md-6 mb-2">
                    <label for="gender" class="form-label"><b>Jenis Kelamin</b> <span class="text-danger">*</span></label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="" <?= set_select('gender', '') ?>></option>
                        <option value="Laki-laki" <?= set_select('gender', 'Laki-laki') ?>>Laki-laki</option>
                        <option value="Perempuan" <?= set_select('gender', 'Perempuan') ?>>Perempuan</option>
                    </select>
                </div>
                <!-- Kegiatan -->
                <div class="col-md-6 mb-2">
                    <label for="activities" class="form-label"><b>Kegiatan/pekerjaan saat ini?</b> <span class="text-danger">*</span></label>
                    <select class="form-select" id="activities" name="activities" required>
                        <option value="" <?= set_select('activities', '') ?>></option>
                        <option value="Pelajar (SMP/SMA)" <?= set_select('activities', 'Pelajar (SMP/SMA)') ?>>Pelajar (SMP/SMA)</option>
                        <option value="Mahasiswa" <?= set_select('activities', 'Mahasiswa') ?>>Mahasiswa</option>
                        <option value="Belum Bekerja" <?= set_select('activities', 'Belum Bekerja') ?>>Belum Bekerja</option>
                        <option value="Ibu Rumah Tangga" <?= set_select('activities', 'Ibu Rumah Tangga') ?>>Ibu Rumah Tangga</option>
                        <option value="Swasta" <?= set_select('activities', 'Swasta') ?>>Swasta</option>
                        <option value="Wiraswasta" <?= set_select('activities', 'Wiraswasta') ?>>Wiraswasta</option>
                        <option value="PNS" <?= set_select('activities', 'PNS') ?>>PNS</option>
                        <option value="Guru" <?= set_select('activities', 'Guru') ?>>Guru</option>
                        <option value="Lainnya" <?= set_select('activities', 'Lainnya') ?>>Lainnya</option>
                    </select>
                </div>

                <!-- Keterangan kegiatan/pekerjaan lainnya -->
                <div class="mb-3">
                    <div class="col-12">
                        <label for="otherActivities" class="form-label"><b>Silahkan tuliskan kegiatan/pekerjaan lainnya</b></label>
                        <input type="text" class="form-control" id="otherActivities" name="otherActivities" placeholder="keterangan kegiatan/pekerjaan lainnya" value="<?= set_value('otherActivities') ?>">
                    </div>
                </div>

                <!--e-mail dan Nomor WA -->
                <div class="row">
                    <!-- Email Aktif -->
                    <div class="col-md-6 mb-2">
                        <label for="email" class="form-label"><b>Email Aktif</b><span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Aktif" value="<?= set_value('email') ?>" required>
                    </div>
                    <!-- Nomor Whatsapp Aktif -->
                    <div class="col-md-6 mb-2">
                        <label for="phone1" class="form-label"><b>Nomor WhatsApp Aktif</b><span class="text-danger">*</span></label>
                        <input class="form-control" id="phone1" name="phone1" type="text" placeholder="Pastikan nomor aktif dan terhubung dengan WhatsApp" value="<?= set_value('phone1') ?>" onkeypress="return hanyaAngka(event, false);">
                        <span id="errorSpan" style="color: red;"></span>
                    </div>
                </div>


                <!--Pengetahuan Leap -->
                <div class="mb-3">
                    <div class="col-12">
                        <label for="info" class="form-label"><b>Mengetahui Informasi LEAP Surabaya darimana?</b><span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="info" name="info" placeholder="Sumber Informasi LEAP Surabaya" value="<?= set_value('info') ?>" required>
                    </div>
                </div>

                <!--Pilihan Kelas -->
                <div class="mb-3">
                    <label class="form-label"><b>Jenis kelas yang dipilih</b><span class="text-danger">*</span></label>
                    <br>
                    <div class="form-check ">
                        <input type="radio" class="form-check-input" id="classOnline" name="class_options" value="online" required>
                        <label class="form-check-label" for="class_online">Online</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="classOffline" name="class_options" value="offline" required>
                        <label class="form-check-label" for="class_offline">Offline</label>
                    </div>
                </div>

                <!-- Kategori Pendaftaran -->
                <div class="mb-3">
                    <div class="col-12">
                        <label for="idpendkursus" class="form-label"><b>Kategori Kelas</b><span class="text-danger">*</span></label>
                        <select class="form-select" id="idpendkursus" name="idpendkursus" required>
                            <?php
                            foreach ($users->getResult() as $row) {
                            ?>
                                <option value="<?php echo $row->idpendkursus ?>" data-name="<?php echo $row->nama_kursus ?>">
                                    <?php echo $row->nama_kursus ?>
                                </option>
                            <?php
                            }; ?>
                        </select>
                    </div>
                </div>

                <!-- sub-kategori kelas aplikasi perkantoran -->
                <div class="mb-3" id="officeApp">
                    <div class="col-12">
                        <label for="officeApp" class="form-label"><b>Silahkan Pilih Aplikasi Perkantoran yang Dinginkan</b><span class="text-danger">*</span></label>
                        <select class="form-select" name="officeApp" required>
                            <option value="" <?= set_select('officeApp', '') ?>></option>
                            <option value="Microsoft Word Dasar (Level 1)" <?= set_select('officeApp', 'Microsoft Word Dasar (Level 1)') ?>>Microsoft Word Dasar (Level 1)</option>
                            <option value="Microsoft Word Mahir (Level 2)" <?= set_select('officeApp', 'Microsoft Word Mahir (Level 2)') ?>>Microsoft Word Mahir (Level 2)</option>
                            <option value="Microsoft Excel Dasar (Level 1)" <?= set_select('officeApp', 'Microsoft Excel Dasar (Level 1)') ?>>Microsoft Excel Dasar (Level 1)</option>
                            <option value="Microsoft Excel Mahir (Level 2)" <?= set_select('officeApp', 'Microsoft Excel Mahir (Level 2)') ?>>Microsoft Excel Mahir (Level 2)</option>
                            <option value="Microsoft Power Point" <?= set_select('officeApp', 'Microsoft Power Point') ?>>Microsoft Power Point</option>
                        </select>
                    </div>
                </div>

                <!-- sub-kategori kelas editing -->
                <div class="mb-3" id="editing">
                    <div class="col-12">
                        <label for="editing" class="form-label"><b>Silahkan Pilih Aplikasi Editing yang Diinginkan</b><span class="text-danger">*</span></label>
                        <select class="form-select" name="editing" required>
                            <option value="" <?= set_select('editing', '') ?>></option>
                            <option value="Editing Video dengan CapCut" <?= set_select('editing', 'Editing Video dengan CapCut') ?>>Editing Video dengan CapCut</option>
                            <option value="Desain Poster dengan Canva" <?= set_select('editing', 'Desain Poster dengan Canva') ?>>Desain Poster dengan Canva</option>
                        </select>
                    </div>
                </div>

                <!-- sub-kategori kelas custom -->
                <div class="mb-3" id="custom">
                    <div class="col-12">
                        <label for="custom" class="form-label"><b>Silahkan Tuliskan Kelas yang Ingin Anda Pelajari</b></label>
                        <input type="text" class="form-control" name="custom" placeholder="Pilihan Kelas yang Ingin Dipelajari" value="<?= set_value('custom') ?>">
                    </div>
                </div>

                <!-- Tujuan Mengikuti Program -->
                <div class="mb-3">
                    <div class="col-12">
                        <label for="purpose" class="form-label"><b>Tujuan Mengikuti Program</b><span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control" id="purpose" name="purpose" style="height: 100px;" required></textarea>
                    </div>
                </div>

                <!-- Rekomendasi -->
                <div class="mb-3">
                    <div class="col-12">
                        <label for="recom" class="form-label"><b>Nama Teman/Kerabat/Sekolah/Instansi yang Merekomendasikan :</b></label>
                        <input type="text" class="form-control" id="recom" name="recom" placeholder="Nama Teman/Kerabat/Sekolah/Instansi yang Merekomendasikan" value="<?= set_value('recom') ?>">
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
                <button type="submit" class="btn btn-primary col-12" id="submit-btn" disabled>Kirim</button>
        </form>
    </div>
    <!-- Tampilan pesan pop-up -->
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

        // Aktivasi Tombol Submit Hanya Jika Checkbox Dicentang
        const noteCheckbox = document.getElementById('note');
        const submitBtn = document.getElementById('submit-btn');

        noteCheckbox.addEventListener('change', function() {
            submitBtn.disabled = !noteCheckbox.checked;
        });

        const categorySelect = document.getElementById('idpendkursus');
        const officeApp = document.getElementById('officeApp');
        const editing = document.getElementById('editing');
        const custom = document.getElementById('custom');

        categorySelect.addEventListener('change', function() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const selectedName = selectedOption.getAttribute('data-name');

            // Reset all sub-categories
            officeApp.style.display = 'none';
            editing.style.display = 'none';
            custom.style.display = 'none';

            // Remove required attribute from all sub-categories
            document.querySelector('[name="officeApp"]').removeAttribute('required');
            document.querySelector('[name="editing"]').removeAttribute('required');
            document.querySelector('[name="custom"]').removeAttribute('required');

            // Show the appropriate sub-category based on selection
            if (selectedName === 'Kelas Aplikasi Perkantoran') {
                officeApp.style.display = 'block';
                document.querySelector('[name="officeApp"]').setAttribute('required', 'required');
            } else if (selectedName === 'Kelas Editing Video / Desain Poster') {
                editing.style.display = 'block';
                document.querySelector('[name="editing"]').setAttribute('required', 'required');
            } else if (selectedName === 'Lainnya') {
                custom.style.display = 'block';
                document.querySelector('[name="custom"]').setAttribute('required', 'required');
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>