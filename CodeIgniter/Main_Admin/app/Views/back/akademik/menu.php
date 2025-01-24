<!-- Links -->
<ul class="sidenav-inner py-1">

    <li class="sidenav-item <?php if ($menu == "homependidikan") { echo 'active'; } ?>">
        <a href="<?php echo base_url(); ?>homependidikan" class="sidenav-link">
            <i class="sidenav-icon feather icon-home"></i>
            <div>Dashboard</div>
        </a>
    </li>
    <li class="sidenav-item <?php if($menu == "zoom" || $menu == "libur" || $menu == "periode" || $menu == "sesi" || $menu == "jadwal"){ echo 'open active'; } ?>">
        <a href="javascript:" class="sidenav-link sidenav-toggle">
            <i class="sidenav-icon feather icon-clock"></i>
            <div>Kelas</div>
        </a>
        <ul class="sidenav-menu">
            <li class="sidenav-item <?php if($menu == "zoom"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>zoom" class="sidenav-link"><div>Link Zoom</div></a></li>
            <li class="sidenav-item <?php if($menu == "libur"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>libur" class="sidenav-link"><div>Libur</div></a></li>
            <li class="sidenav-item <?php if($menu == "periode"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>periode" class="sidenav-link"><div>Periode</div></a></li>
            <li class="sidenav-item <?php if($menu == "sesi"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>sesi" class="sidenav-link"><div>Sesi</div></a></li>
            <li class="sidenav-item <?php if($menu == "jadwal"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>jadwal" class="sidenav-link"><div>Jadwal</div></a></li>
        </ul>
    </li>
    <!--
    <li class="sidenav-divider mb-1"></li>
    <li class="sidenav-header small font-weight-semibold">Master Data</li>
    -->
    <li class="sidenav-item <?php if ($menu == "level") {
                                echo 'active';
                            } ?>">
        <a href="<?php echo base_url(); ?>level" class="sidenav-link">
            <i class="sidenav-icon feather icon-book"></i>
            <div>Kursus & Level</div>
        </a>
    </li>
    <li class="sidenav-item <?php if($menu == "calonsiswa" || $menu == "siswa" || $menu == "presensikelas" || $menu == "buktibayar"){ echo 'open active'; } ?>">
        <a href="javascript:" class="sidenav-link sidenav-toggle">
            <i class="sidenav-icon feather icon-users"></i>
            <div>Siswa</div>
        </a>
        <ul class="sidenav-menu">
            <li class="sidenav-item <?php if($menu == "calonsiswa"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>calonsiswa" class="sidenav-link"><div>Calon Siswa</div></a></li>
            <li class="sidenav-item <?php if($menu == "siswa"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>siswa" class="sidenav-link"><div>Siswa</div></a></li>
            <li class="sidenav-item <?php if($menu == "presensikelas"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>presensikelas" class="sidenav-link"><div>Presensi Kelas</div></a></li>
            <li class="sidenav-item <?php if($menu == "buktibayar"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>buktibayar" class="sidenav-link"><div>Bukti Pembayaran</div></a></li>
        </ul>
    </li>
    <li class="sidenav-item <?php if($menu == "laporanpengajaran" || $menu == "laporancatatansiswa" || $menu == "tagsiswakeluar"){ echo 'open active'; } ?>">
        <a href="javascript:" class="sidenav-link sidenav-toggle">
            <i class="sidenav-icon feather icon-file"></i>
            <div>Laporan</div>
        </a>
        <ul class="sidenav-menu">
            <li class="sidenav-item <?php if($menu == "laporanpengajaran"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>laporanpengajaran" class="sidenav-link"><div>Laporan Pengajaran</div></a></li>
            <li class="sidenav-item <?php if($menu == "laporancatatansiswa"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>laporancatatansiswa" class="sidenav-link"><div>Laporan Catatan Siswa</div></a></li>
            <li class="sidenav-item <?php if($menu == "tagsiswakeluar"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>tagsiswakeluar" class="sidenav-link"><div>Alasan Siswa Keluar</div></a></li>
        </ul>
    </li>
    <li class="sidenav-item <?php if($menu == "feather icon-tag"){ echo 'open active'; } ?>">
        <a href="javascript:" class="sidenav-link sidenav-toggle">
            <i class="sidenav-icon feather icon-tag"></i>
            <div>Materi Diskusi</div>
        </a>
        <ul class="sidenav-menu">
            <li class="sidenav-item <?php if($menu == "feather icon-tag"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>feather icon-tag" class="sidenav-link"><div>Tag Materi Diskusi</div></a></li>
        </ul>
    </li>
    <li class="sidenav-item <?php if ($menu == "ttdall") {
                                echo 'active';
                            } ?>">
        <a href="<?php echo base_url(); ?>ttdall" class="sidenav-link">
            <i class="sidenav-icon fas fa-address-card"></i>
            <div>Tanda Tangan</div>
        </a>
    </li>
</ul>
</div>
<!-- [ Layout sidenav ] End -->
<!-- [ Layout container ] Start -->
<div class="layout-container">
    <!-- [ Layout navbar ( Header ) ] Start -->
    <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x" id="layout-navbar" style="height: 70px;">
        <a href="<?php echo base_url(); ?>homependidikan" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo font-weight-normal ml-2">LEAP</span>
        </a>

        <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
            <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                <i class="ion ion-md-menu text-large align-middle"></i>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="layout-navbar-collapse">
            <!-- Divider -->
            <hr class="d-lg-none w-100 my-2">

            <div class="navbar-nav align-items-lg-center ml-auto">
                <div class="demo-navbar-user nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                            <img src="<?php echo $foto_profile; ?>" alt class="d-block ui-w-30 rounded-circle" style="height:30px; width:30px; object-fit: cover;">
                            <span class="px-1 mr-lg-2 ml-2 ml-lg-0"><?php echo $nm_role; ?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?php echo base_url(); ?>homekaryawan" class="dropdown-item">
                            <i class="feather icon-user text-muted"></i> &nbsp; Home Profil</a>
                        <?php if ($pro->isteaching == 1) { ?>
                            <a href="<?php echo base_url(); ?>homepengajar" class="dropdown-item">
                                <i class="feather icon-clipboard text-muted"></i> &nbsp; Home Pengajar</a>
                        <?php } ?>
                        <?php if (session()->get("it")) { ?>
                            <a href="<?php echo base_url(); ?>homeit" class="dropdown-item">
                                <i class="feather icon-cpu text-muted"></i> &nbsp; Home IT</a>
                        <?php } ?>
                        <?php if (session()->get("hr")) { ?>
                            <a href="<?php echo base_url(); ?>home" class="dropdown-item">
                                <i class="feather icon-users text-muted"></i> &nbsp; Home HR</a>
                        <?php } ?>
                        <?php if (session()->get("ga")) { ?>
                            <a href="<?php echo base_url(); ?>homega" class="dropdown-item">
                                <i class="feather icon-settings text-muted"></i> &nbsp; Home GA</a>
                        <?php } ?>
                        <?php if (session()->get("busdev")) { ?>
                            <a href="<?php echo base_url(); ?>homebusdev" class="dropdown-item">
                                <i class="feather icon-camera text-muted"></i> &nbsp; Home Busdev</a>
                        <?php } ?>
                        <?php if (session()->get("bos")) { ?>
                            <a href="<?php echo base_url(); ?>homepimpinan" class="dropdown-item">
                                <i class="feather icon-briefcase text-muted"></i> &nbsp; Home Pimpinan</a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url(); ?>login/logout" class="dropdown-item">
                            <i class="feather icon-power text-danger"></i> &nbsp; Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- [ Layout navbar ( Header ) ] End -->

    <!-- [ Layout content ] Start -->
    <div class="layout-content">