                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <li class="sidenav-item <?php if($menu == "homega"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>homega" class="sidenav-link">
                            <i class="sidenav-icon fas fa-home"></i>
                            <div>Dashboard GA</div>
                        </a>
                    </li>

                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-header small font-weight-semibold">Data HRD</li>
                    <li class="sidenav-item <?php if($menu == "sopkategoriga"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>sopkategoriga" class="sidenav-link">
                            <i class="sidenav-icon feather icon-list"></i>
                            <div>Kategori SOP</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "sopga"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>sopga" class="sidenav-link">
                            <i class="sidenav-icon feather icon-book"></i>
                            <div>Data SOP</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "absencega"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>absencega" class="sidenav-link">
                            <i class="sidenav-icon feather icon-clipboard"></i>
                            <div>Absensi Karyawan</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "persetujuanga"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>persetujuanga" class="sidenav-link">
                            <i class="sidenav-icon feather icon-edit"></i>
                            <div>Perijinan / Lembur</div>
                        </a>
                    </li>
                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-header small font-weight-semibold">Surat Menyurat</li>

                    <li class="sidenav-item <?php if($menu == "perijinantugas"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>perijinantugas" class="sidenav-link">
                            <i class="sidenav-icon fas fa-file-alt"></i>
                            <div>Surat Tugas</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "perijinansuratkeluar"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>perijinansuratkeluar" class="sidenav-link">
                            <i class="sidenav-icon fas fa-envelope-open"></i>
                            <div>Surat Keluar</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "persetujuanmou"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>persetujuanmou" class="sidenav-link">
                            <i class="sidenav-icon fas fa-handshake"></i>
                            <div>MoU</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-header small font-weight-semibold">Master Data</li>

                    <li class="sidenav-item <?php if($menu == "linkdrive"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>linkdrive" class="sidenav-link">
                            <i class="sidenav-icon fas fa-link"></i>
                            <div>Catatan Link Pribadi</div>
                        </a>
                    </li>

                    <li class="sidenav-divider mb-1"></li>
                    
                    <li class="sidenav-header small font-weight-semibold">Lainnya</li>

                    <li class="sidenav-item <?php if($menu == "isuinfrastruktur"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>isuinfrastruktur" class="sidenav-link">
                            <i class="sidenav-icon fas fa-toolbox"></i>
                            <div>Isu Infrastruktur</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "persetujuanpembelian"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>persetujuanpembelian" class="sidenav-link">
                            <i class="sidenav-icon fas fa-shopping-cart"></i>
                            <div>Purchase Request</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "persetujuanpinjam"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url(); ?>persetujuanpinjam" class="sidenav-link">
                            <i class="sidenav-icon fas fa-archive"></i>
                            <div>Peminjaman</div>
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
                                        <i class="feather icon-user text-muted"></i> &nbsp; Home Profil</a>
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
                                    <?php if(session()->get("hr")){?>
                                    <a href="<?php echo base_url(); ?>home" class="dropdown-item">
                                        <i class="feather icon-users text-muted"></i> &nbsp; Home HR</a>
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