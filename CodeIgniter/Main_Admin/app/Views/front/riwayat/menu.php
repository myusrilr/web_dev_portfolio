<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <!-- Messages sidebox -->
        <div class="messages-sidebox col-2 mb-2">
            <li class="sidenav-header small font-weight-semibold">DATA PROFIL AKUN</li><hr>
            <!-- Mail boxes -->
            <a href="<?php echo base_url()?>riwayat" class="d-flex justify-content-between align-items-center <?php if($menu == "riwayat"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div>
                    Profil
                </div>
            </a>
            <a href="<?php echo base_url()?>gantipass" class="d-flex justify-content-between align-items-center <?php if($menu == "gantipass"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div>Ganti Password</div>
            </a>
            <hr>
            <li class="sidenav-header small font-weight-semibold">DATA RIWAYAT HIDUP</li><hr>
            <a href="<?php echo base_url()?>personal" class="d-flex justify-content-between align-items-center <?php if($menu == "personal"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div> Data Personal
                </div>
            </a>
            <a href="<?php echo base_url()?>riwayatpendidikan" class="d-flex justify-content-between align-items-center <?php if($menu == "riwayatpendidikan"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div>Pendidikan
                </div>
            </a>
            <a href="<?php echo base_url()?>riwayatkeluarga" class="d-flex justify-content-between align-items-center <?php if($menu == "riwayatkeluarga"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div>
                     Keluarga
                </div>
            </a>
            <a href="<?php echo base_url()?>riwayatpekerjaan" class="d-flex justify-content-between align-items-center <?php if($menu == "riwayatpekerjaan"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div> Riwayat Pekerjaan
                </div>
            </a>
            <a href="<?php echo base_url()?>riwayatkursus" class="d-flex justify-content-between align-items-center <?php if($menu == "riwayatkursus"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div> Kursus, Seminar, & Pelatihan
                </div>
            </a>
            <a href="<?php echo base_url()?>upload" class="d-flex justify-content-between align-items-center <?php if($menu == "upload"){ echo 'text-dark font-weight-bold'; }else{ echo 'text-muted'; } ?> py-2">
                <div> Upload
                </div>
            </a>
            <!-- / Mail boxes -->

        </div>
        <!-- / Messages sidebox -->