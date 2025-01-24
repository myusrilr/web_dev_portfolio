                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <li class="sidenav-item <?php if($menu == "homepimpinan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>homepimpinan" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-item <?php if($menu == "visual"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>visual" class="sidenav-link">
                            <i class="sidenav-icon feather icon-bar-chart"></i>
                            <div>Visual Data</div>
                        </a>
                    </li>
                    
                    <li class="sidenav-header small font-weight-semibold">Data Karyawan</li>
                    <li class="sidenav-item <?php if($menu == "absence"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>absence" class="sidenav-link">
                            <i class="sidenav-icon feather icon-clipboard"></i>
                            <div>Absensi Karyawan</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "tabungan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>tabungan" class="sidenav-link">
                            <i class="sidenav-icon feather icon-clock"></i>
                            <div>Tabungan Jam Kerja</div>
                        </a>
                    </li>
                    <!-- <li class="sidenav-item <?php //if($menu == "grafikabsensi"){ echo 'active'; } ?>">
                        <a href="<?php //echo base_url(); ?>grafikabsensi" class="sidenav-link">
                            <i class="sidenav-icon feather icon-bar-chart-2"></i>
                            <div>Grafik Absensi</div>
                        </a>
                    </li> -->
                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-header small font-weight-semibold">Menu Divisi</li>

                    <li class="sidenav-item <?php if($menu == "sop" || $menu == "pengguna" || $menu == "rekruitmen" || $menu == "persetujuan" || $menu == "resign" || $menu == "permintaan"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-users"></i>
                            <div>HRD</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "sop"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>sop" class="sidenav-link">
                                    <div>Data SOP</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "pengguna"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pengguna" class="sidenav-link">
                                    <div>Data Karyawan</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "rekruitmen"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>rekruitmen" class="sidenav-link">
                                    <div>Data Pelamar</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "persetujuan"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>persetujuan" class="sidenav-link">
                                    <div>Perijinan / Lembur</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "permintaan"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>permintaan" class="sidenav-link">
                                    <div>Permintaan Karyawan Baru</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "resign"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>resign" class="sidenav-link">
                                    <div>Resign</div>
                                </a></li>
                        </ul>
                    </li>

                    <li class="sidenav-item <?php if($menu == "daftartugas" || $menu == "daftarsuratkeluar" || $menu == "daftarmou"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon fas fa-envelope-open"></i>
                            <div>Surat Menyurat</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "daftartugas"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>daftartugas" class="sidenav-link">
                                    <div>Surat Tugas</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "daftarsuratkeluar"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>daftarsuratkeluar" class="sidenav-link">
                                    <div>Surat Keluar</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "daftarmou"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>daftarmou" class="sidenav-link">
                                    <div>MoU</div>
                                </a></li>
                        </ul>
                    </li>

                    <li class="sidenav-item <?php if($menu == "isuinfrastruktur" || $menu == "persetujuanpembelian" || $menu == "persetujuanpinjam"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon fas fa-toolbox"></i>
                            <div>General Affairs</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "isuinfrastruktur"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>isuinfrastruktur" class="sidenav-link">
                                    <div>Isu Infrastruktur</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "persetujuanpembelian"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>persetujuanpembelian" class="sidenav-link">
                                    <div>Purchase Request</div>
                                </a></li>
                            <li class="sidenav-item <?php if($menu == "persetujuanpinjam"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>persetujuanpinjam" class="sidenav-link">
                                    <div>Peminjaman</div>
                                </a></li>
                        </ul>
                    </li>

                    <li class="sidenav-item <?php if($menu == "bidanglink" || $menu == "leapprofil"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-camera"></i>
                            <div>Busdev</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "bidanglink"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>bidanglink" class="sidenav-link">
                                <div>Daftar Link Dokumen Busdev</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "leapprofil"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>leapprofil" class="sidenav-link">
                                <div>Leap Profile</div>
                            </a></li>
                        </ul>
                    </li>

                    <li class="sidenav-item <?php if($menu == "infrastruktur" || $menu == "logaktifitas" || $menu == "pindah"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-monitor"></i>
                            <div>IT</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "infrastruktur"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>infrastruktur" class="sidenav-link">
                                <div>Laporan Infrastruktur</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "logaktifitas"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>logaktifitas" class="sidenav-link">
                                <div>Log Aktifitas</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "pindah"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pindah" class="sidenav-link">
                                <div>Perubahan Hak Akses</div>
                            </a></li>
                        </ul>
                    </li>

                    <li class="sidenav-item <?php if($menu == "homependidikan" || $menu == "siswa" || $menu == "laporanpengajaran" || $menu == "laporancatatansiswa" || $menu == "presensikelas" || $menu == "jadwal"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon fas fa-user-graduate"></i>
                            <div>Pendidikan</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "homependidikan"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>homependidikan" class="sidenav-link">
                                <div>Kalendar Akademik</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "laporanpengajaran"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>laporanpengajaran" class="sidenav-link">
                                <div>Notulen Rapat per Minggu</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "laporancatatansiswa"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>laporancatatansiswa" class="sidenav-link">
                                <div>Laporan Siswa Bermasalah</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "presensikelas"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>presensikelas" class="sidenav-link">
                                <div>Absensi Siswa</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "siswa"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>siswa" class="sidenav-link">
                                <div>Data Siswa</div>
                            </a></li>
                            <li class="sidenav-item <?php if($menu == "jadwal"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>jadwal" class="sidenav-link">
                                <div>Penjadwalan Zoom</div>
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- [ Layout sidenav ] End -->
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <!-- [ Layout navbar ( Header ) ] Start -->
                <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-dark container-p-x" id="layout-navbar" style="height: 70px;">

                    <a href="<?php echo base_url(); ?>home" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
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
                                        <?php if(session()->get("pd")){?>
                                    <a href="<?php echo base_url(); ?>homependidikan" class="dropdown-item">
                                        <i class="feather icon-monitor text-muted"></i> &nbsp; Home Pendidikan</a>
                                    <?php } ?>
                                    <?php if(session()->get("it")){?>
                                    <a href="<?php echo base_url(); ?>homeit" class="dropdown-item">
                                        <i class="feather icon-cpu text-muted"></i> &nbsp; Home IT</a>
                                    <?php } ?>
                                    <?php if(session()->get("hr")){?>
                                    <a href="<?php echo base_url(); ?>home" class="dropdown-item">
                                        <i class="feather icon-users text-muted"></i> &nbsp; Home HR</a>
                                    <?php } ?>
                                    <?php if(session()->get("ga")){?>
                                    <a href="<?php echo base_url(); ?>homega" class="dropdown-item">
                                        <i class="feather icon-settings text-muted"></i> &nbsp; Home GA</a>
                                    <?php } ?>
                                    <?php if(session()->get("busdev")){?>
                                    <a href="<?php echo base_url(); ?>homebusdev" class="dropdown-item">
                                        <i class="feather icon-camera text-muted"></i> &nbsp; Home Busdev</a>
                                    <?php } ?>
                                    <?php if(session()->get("bos")){?>
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