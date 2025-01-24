<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid flex-grow-1 container-p-y">
    <form action="<?php echo base_url() ?>calonsiswa/prosestulisupdate" method="post">
        <input type="hidden" id="idpendkursus" name="idpendkursus" value="<?php echo $head->idpendkursus; ?>">
        <input type="hidden" id="idcalon" name="idcalon" value="<?php echo $head->idcalon; ?>">

        <h4 class="font-weight-bold py-3 mb-0">Calon Siswa <?php echo $head->nama_kursus; ?></h4>
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
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>calonsiswa">Calon Siswa</a></li>
                <li class="breadcrumb-item active">Tulis Mandiri Siswa <?php echo $head->nama_kursus; ?></li>
            </ol>
        </div>

        <div class="accordion" id="formAccordion">

            <!-- Kategori: Informasi Orang Tua -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingParentInfo">
                    <button class="accordion-button collapsed font-weight-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseParentInfo" aria-expanded="true" aria-controls="collapseParentInfo">
                        Informasi Orang Tua
                    </button>
                </h2>
                <div id="collapseParentInfo" class="accordion-collapse collapse show"
                    aria-labelledby="headingParentInfo" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <div class="col mb-3">
                            <label for="parentName" class="form-label">Nama Lengkap Orang Tua (Ibu/Bapak)</label>
                            <input type="text" class="form-control" id="parentName">
                        </div>
                        <div class="col mb-3">
                            <label for="parentJob" class="form-label">Pekerjaan Orang Tua</label>
                            <input type="text" class="form-control" id="parentJob">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori: Informasi Siswa -->
            <div class="accordion-item">
                <h2 class="accordion-header " id="headingStudentInfo">
                    <button class="accordion-button collapsed font-weight-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseStudentInfo" aria-expanded="false" aria-controls="collapseStudentInfo">
                        Informasi Siswa
                    </button>
                </h2>
                <div id="collapseStudentInfo" class="accordion-collapse collapse" aria-labelledby="headingStudentInfo"
                    data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label">Nama Lengkap Anak</label>
                                <input type="text" class="form-control" id="fullName" value="<?= $formData['fullName'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nickName" class="form-label">Nama Panggilan Anak</label>
                                <input type="text" class="form-control" id="nickName" value="<?= $formData['nickName'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birthPlace" class="form-label">Tempat Lahir Siswa</label>
                                <input type="text" class="form-control" id="BirthPlace">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birthTime" class="form-label">Tanggal Dan Tahun Lahir Siswa</label>
                                <input type="date" class="form-control" id="birthTime">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" id="gender" value="<?= $formData['gender'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="schoolName" class="form-label">Nama Sekolah/Kampus</label>
                                <input type="text" class="form-control" id="schoolName" value="<?= $formData['schoolName'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="classLevel" class="form-label">Level Kelas di Sekolah</label>
                                <input type="text" class="form-control" id="classLevel" value="<?= $formData['classLevel'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="curriculum" class="form-label">Kurikulum di Sekolah</label>
                                <input type="text" class="form-control" id="curriculum" value="<?= $formData['curriculum'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="academicYear" class="form-label">Tahun Ajar Sekolah Siswa Saat Ini</label>
                                <input type="text" class="form-control" id="academicYear">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nation" class="form-label">Negara Domisili</label>
                                <input type="text" class="form-control" id="nation">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Provinsi Domisili</label>
                                <input type="text" class="form-control" id="province">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="domicile" class="form-label">Kota Domisili</label>
                                <input type="text" class="form-control" id="domicile" value="<?= $formData['domicile'] ?? ''; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subdistrict" class="form-label">Kecamatan Domisili</label>
                                <input type="text" class="form-control" id="subdistrict">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ward" class="form-label">Kelurahan Domisili</label>
                                <input type="text" class="form-control" id="ward">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Alamat Rumah Lengkap</label>
                                <input type="text" class="form-control" id="address">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori: Riwayat Belajar -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingLearningHistory">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseLearningHistory" aria-expanded="false"
                            aria-controls="collapseLearningHistory">
                            Riwayat Belajar
                        </button>
                    </h2>
                    <div id="collapseLearningHistory" class="accordion-collapse collapse"
                        aria-labelledby="headingLearningHistory" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <div class="col mb-3">
                                <label for="exp" class="form-label">Apakah Pernah Les Bahasa Inggris
                                    Sebelumnya?</label>
                                <input type="text" class="form-control" id="exp" value="<?= $formData['exp'] ?? ''; ?>">
                            </div>
                            <div class="col mb-3">
                                <label for="diagnostic" class="form-label">Apakah Ada Kesulitan Dalam Pelajaran
                                    Bahasa Inggris di Sekolah Selama Ini ?</label>
                                <input type="text" class="form-control" id="diagnostic" value="<?= $formData['diagnostic'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori: Rekomendasi -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingRecommendation">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRecommendation" aria-expanded="false"
                            aria-controls="collapseRecommendation">
                            Rekomendasi
                        </button>
                    </h2>
                    <div id="collapseRecommendation" class="accordion-collapse collapse"
                        aria-labelledby="headingRecommendation" data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <div class="col mb-3">
                                <label for="recom" class="form-label">Nama Teman/Kerabat/Sekolah/Instansi yang
                                    Merekomendasikan</label>
                                <input type="text" class="form-control" id="recom" value="<?= $formData['recom'] ?? ''; ?>">
                            </div>
                            <div class="col mb-3">
                                <label for="info" class="form-label">Mengetahui Leap English Dari Mana?</label>
                                <input type="text" class="form-control" id="info" value="<?= $formData['info'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori: Kontak -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingContact">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                            Kontak
                        </button>
                    </h2>
                    <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact"
                        data-bs-parent="#formAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone1" class="form-label">No Whatsapp Aktif</label>
                                    <input type="text" class="form-control" id="phone1" value="<?= $formData['phone1'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone2" class="form-label">No Whatsapp Anak</label>
                                    <input type="text" class="form-control" id="phone2" value="<?= $formData['phone2'] ?? ''; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Aktif</label>
                                    <input type="text" class="form-control" id="email" value="<?= $formData['email'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Program dan Kelas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProgram">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProgram" aria-expanded="false" aria-controls="collapseProgram">
                                Program dan Kelas
                            </button>
                        </h2>
                        <div id="collapseProgram" class="accordion-collapse collapse" aria-labelledby="headingProgram"
                            data-bs-parent="#formAccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="program" class="form-label">Program</label>
                                        <select class="form-select" id="program">
                                            <option>General</option>
                                            <option>English</option>
                                            <option>Both</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="class_options" class="form-label">Pilihan Kelas</label>
                                        <input type="text" class="form-control" id="class_options" value="<?= $formData['class_options'] ?? ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="purpose" class="form-label">Tujuan Mengikuti Program</label>
                                        <input type="text" class="form-control" id="purpose" value="<?= $formData['purpose'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori: Tes dan Trial -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTestTrial">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTestTrial" aria-expanded="false" aria-controls="collapseTestTrial">
                                    Tes dan Trial
                                </button>
                            </h2>
                            <div id="collapseTestTrial" class="accordion-collapse collapse" aria-labelledby="headingTestTrial"
                                data-bs-parent="#formAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="pic" class="form-label">PIC Test, Trial, Wawancara</label>
                                            <input type="text" class="form-control" id="pic">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="trialDate" class="form-label">Tanggal Trial</label>
                                            <input type="date" class="form-control" id="trialDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="testClass" class="form-label">Trial di Kelas Mana?</label>
                                            <input type="text" class="form-control" id="testClass">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="interviewDate" class="form-label">Waktu Test - Wawancara</label>
                                            <input type="date" class="form-control" id="interviewDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sitInDate" class="form-label">Waktu Test - Trial Class/Sit In</label>
                                            <input type="date" class="form-control" id="sitInDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="testType" class="form-label">Jenis Tes</label>
                                            <input type="text" class="form-control" id="testType">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="testReport" class="form-label">Laporan Hasil - Tes Dan Wawancara</label>
                                            <input type="text" class="form-control" id="testReport">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sitInReport" class="form-label">Laporan Hasil Sit In/Trial</label>
                                            <input type="text" class="form-control" id="sitInReport">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="programClass" class="form-label">Diterima di Kelas(Sesuai Jadwal Kelas yang
                                                Ada)</label>
                                            <select class="form-select" id="programClass">
                                                <option>2023</option>
                                                <option>2024</option>
                                                <option>2025</option>
                                                <option>2026</option>
                                                <option>2027</option>
                                                <option>2028</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kategori: Pendaftaran dan Administrasi -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingRegistration">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseRegistration" aria-expanded="false"
                                        aria-controls="collapseRegistration">
                                        Pendaftaran dan Administrasi
                                    </button>
                                </h2>
                                <div id="collapseRegistration" class="accordion-collapse collapse" aria-labelledby="headingRegistration"
                                    data-bs-parent="#formAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="district" class="form-label">Sby/Luar Sby</label>
                                                <select class="form-select" id="district">
                                                    <option>Surabaya</option>
                                                    <option>Sidoarjo</option>
                                                    <option>Luar Sby</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="studentStatus" class="form-label">Status Siswa</label>
                                                <select class="form-select" id="studentStatus">
                                                    <option>canceled</option>
                                                    <option>done</option>
                                                    <option>follow up another time</option>
                                                    <option>on progress</option>
                                                    <option>waiting for confirmation</option>
                                                    <option>waiting for payment</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="payment" class="form-label">Bukti Pembayaran</label>
                                                <input type="text" class="form-control" id="payment">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="invoiceNumber" class="form-label">Nomor Invoice</label>
                                                <input type="text" class="form-control" id="invoiceNumber">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="bank" class="form-label">Bank</label>
                                                <select class="form-select" id="bank">
                                                    <option>2023</option>
                                                    <option>2024</option>
                                                    <option>2025</option>
                                                    <option>2026</option>
                                                    <option>2027</option>
                                                    <option>2028</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="paymentDate" class="form-label">Tanggal Pembayaran</label>
                                                <input type="date" class="form-control" id="paymentDate">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="month" class="form-label">Bulan Masuk</label>
                                                <select class="form-select" id="month">
                                                    <option>Januari</option>
                                                    <option>Februari</option>
                                                    <option>Maret</option>
                                                    <option>April</option>
                                                    <option>Mei</option>
                                                    <option>Juni</option>
                                                    <option>Juli</option>
                                                    <option>Agustus</option>
                                                    <option>September</option>
                                                    <option>Oktober</option>
                                                    <option>November</option>
                                                    <option>Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kategori: Komunikasi dan Follow Up -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFollowUp">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFollowUp" aria-expanded="false" aria-controls="collapseFollowUp">
                                            Komunikasi dan Follow Up
                                        </button>
                                    </h2>
                                    <div id="collapseFollowUp" class="accordion-collapse collapse" aria-labelledby="headingFollowUp"
                                        data-bs-parent="#formAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="followUp1" class="form-label">Follow Up 1</label>
                                                    <input type="date" class="form-control" id="followUp1">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="followUp2" class="form-label">Follow Up 2</label>
                                                    <input type="date" class="form-control" id="followUp2">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="followUp3" class="form-label">Follow Up 3</label>
                                                    <input type="date" class="form-control" id="followUp3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="notes" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="notes" rows="3"></textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="wag" class="form-label">WAG/LV</label>
                                                    <input type="text" class="form-control" id="wag">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                </div>
                            </div>
    </form>
</div>