                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <li class="sidenav-item <?php if($menu == "home"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>home" class="sidenav-link">
                            <i class="sidenav-icon feather icon-home"></i>
                            <div>Dashboard HRD</div>
                        </a>
                    </li>
                    
                    <li class="sidenav-item <?php if($menu == "visual"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>visual" class="sidenav-link">
                            <i class="sidenav-icon feather icon-bar-chart"></i>
                            <div>Visual Data</div>
                        </a>
                    </li>

                    <li class="sidenav-item <?php if($menu == "pengumuman"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>pengumuman" class="sidenav-link">
                            <i class="sidenav-icon feather icon-bell"></i>
                            <div>Pengumuman</div>
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
                    <!-- <li class="sidenav-item <?php // if($menu == "grafikabsensi"){ echo 'active'; } ?>">
                        <a href="<?php // echo base_url(); ?>grafikabsensi" class="sidenav-link">
                            <i class="sidenav-icon feather icon-bar-chart-2"></i>
                            <div>Grafik Absensi</div>
                        </a>
                    </li> -->

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Master Kategori</li>

                    <li class="sidenav-item <?php if($menu == "sopkategori"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>sopkategori" class="sidenav-link">
                            <i class="sidenav-icon feather icon-list"></i>
                            <div>Kategori SOP</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "divisi" || $menu == "jabatan"){ echo 'open active'; } ?>">
                        <a href="javascript:" class="sidenav-link sidenav-toggle">
                            <i class="sidenav-icon feather icon-briefcase"></i>
                            <div>Organisasi</div>
                        </a>
                        <ul class="sidenav-menu">
                            <li class="sidenav-item <?php if($menu == "divisi"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>divisi" class="sidenav-link"><div>Divisi</div></a></li>
                            <li class="sidenav-item <?php if($menu == "jabatan"){ echo 'active'; } ?>"><a href="<?php echo base_url(); ?>jabatan" class="sidenav-link"><div>Jabatan</div></a></li>
                        </ul>
                    </li>
                    <!-- <li class="sidenav-item <?php //if($menu == "jamkerja"){ echo 'active'; } ?>">
                        <a href="<?php //echo base_url(); ?>jamkerja" class="sidenav-link">
                            <i class="sidenav-icon feather icon-clock"></i>
                            <div>Jam Kerja</div>
                        </a>
                    </li> -->
                    <li class="sidenav-item <?php if($menu == "form"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>form" class="sidenav-link">
                            <i class="sidenav-icon feather icon-edit-1"></i>
                            <div>Form Pemutusan</div>
                        </a>
                    </li>

                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Master Data</li>

                    <li class="sidenav-item <?php if($menu == "sop"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>sop" class="sidenav-link">
                            <i class="sidenav-icon feather icon-book"></i>
                            <div>Data SOP</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "pengguna"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>pengguna" class="sidenav-link">
                            <i class="sidenav-icon feather icon-users"></i>
                            <div>Data Karyawan</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "rekruitmen"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>rekruitmen" class="sidenav-link">
                            <i class="sidenav-icon feather icon-file-text"></i>
                            <div>Data Pelamar</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if ($menu == "calonsiswa") { echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>calonsiswa" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user-plus"></i>
                            <div>Calon Siswa</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if ($menu == "siswa") { echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>siswa" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user-check"></i>
                            <div>Siswa</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    <li class="sidenav-header small font-weight-semibold">Permintaan</li>
                    <li class="sidenav-item <?php if($menu == "persetujuan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>persetujuan" class="sidenav-link">
                            <i class="sidenav-icon feather icon-edit"></i>
                            <div>Perijinan / Lembur</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "permintaan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>permintaan" class="sidenav-link">
                            <i class="sidenav-icon feather icon-user-plus"></i>
                            <div>Permintaan Karyawan Baru</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "resign"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>resign" class="sidenav-link">
                            <i class="sidenav-icon feather icon-log-out"></i>
                            <div>Resign</div>
                        </a>
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
                                        <i class="feather icon-user text-muted"></i> &nbsp; Home Karyawan</a>
                                    <?php if($pro->isteaching == 1){?>
                                    <a href="<?php echo base_url(); ?>homepengajar" class="dropdown-item">
                                        <i class="feather icon-clipboard text-muted"></i> &nbsp; Home Pengajar</a>
                                    <?php } ?>
                                    <?php if(session()->get("pd")){?>
                                    <a href="<?php echo base_url(); ?>homependidikan" class="dropdown-item">
                                        <i class="feather icon-monitor text-muted"></i> &nbsp; Home Pendidikan</a>
                                    <?php } ?>
                                    <?php if(session()->get("it")){?>
                                    <a href="<?php echo base_url(); ?>homeit" class="dropdown-item">
                                        <i class="feather icon-cpu text-muted"></i> &nbsp; Home IT</a>
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