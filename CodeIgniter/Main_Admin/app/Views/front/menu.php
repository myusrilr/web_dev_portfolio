<!-- [ Layout sidenav ] Start -->
<div class="sidenav bg-dark">
    <div id="layout-sidenav" class=" container layout-sidenav-horizontal sidenav-horizontal flex-grow-0 bg-dark">
        <ul class="sidenav-inner">
            <!-- Dashboards -->
            <li class="sidenav-item <?php if($menu == "homekaryawan"){ echo 'active'; } ?>">
                <a href="<?php echo base_url();?>homekaryawan" class="sidenav-link">
                    <i class="sidenav-icon feather icon-home"></i>
                    <div>Dashboard</div>
                </a>
            </li>
            <?php if($role != 'R00004'){?>
            <li class="sidenav-item <?php if($menu == "absensi"){ echo 'active'; } ?>">
                <a href="<?php echo base_url();?>absensi" class="sidenav-link">
                    <i class="sidenav-icon feather icon-user-check"></i>
                    <div>Absensi</div>
                </a>
            </li>
            <?php 
            }
            $jabatan = $model->getAllQR("select count(induk) as jml from jabatan where idjabatan = '".$pro->idjabatan."';")->jml;
            $pelamar = $model->getAllQR("select count(*) as jml from pelamar_users where idusers = '".$idusers."'")->jml;
            if($jabatan == 0 && $nm_role != 'HR' && $role != 'R00004' || $pelamar > 0){ ?>
            <li class="sidenav-item">
                <a href="<?php echo base_url();?>karyawan" class="sidenav-link sidenav-toggle <?php if($menu == "karyawan" || $menu == "pelamarkaryawan"){ echo 'active'; } ?>">
                    <i class="sidenav-icon feather icon-users"></i>
                    <div>Karyawan</div>
                </a>
                <ul class="sidenav-menu">
                    <li class="sidenav-item <?php if($menu == "karyawan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>karyawan" class="sidenav-link">
                            <div>Data Karyawan</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "pelamarkaryawan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>pelamarkaryawan" class="sidenav-link">
                            <div>Data Pelamar</div>
                        </a>
                    </li>
                </ul>
            </li>
            <?php }else{ ?>
                <li class="sidenav-item <?php if($menu == "karyawan"){ echo 'active'; } ?>">
                    <a href="<?php echo base_url();?>karyawan" class="sidenav-link">
                        <i class="sidenav-icon feather icon-users"></i>
                        <div>Karyawan</div>
                    </a>
                </li>
            <?php } 
            $mitra = $model->getAllQR("SELECT count(*) as jml FROM mitra_users  where idusers = '".$idusers."';")->jml;
            if($mitra > 0){ ?>
                <li class="sidenav-item <?php if($menu == "kemitraan"){ echo 'active'; } ?>">
                    <a href="<?php echo base_url();?>kemitraan" class="sidenav-link">
                        <i class="sidenav-icon fas fa-handshake"></i>
                        <div>Kemitraan</div>
                    </a>
                </li>
            <?php } ?>
            <li class="sidenav-item">
                <a href="javascript:" class="sidenav-link sidenav-toggle <?php if($menu == "booking" ||$menu == "perijinan" || $menu == "pengajuan" || $menu == "hakakses" || $menu == "pemutusan"|| $menu == "pinjam" || $menu == "purchase"){ echo 'active'; } ?>">
                    <i class="sidenav-icon feather icon-layers"></i>
                    <div>Formulir</div>
                </a>
                <ul class="sidenav-menu">
                    <li class="sidenav-item <?php if($menu == "booking"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>booking" class="sidenav-link">
                            <div>Booking Ruangan</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "perijinan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>perijinan" class="sidenav-link">
                            <div>Perijinan / Lembur</div>
                        </a>
                    </li>
                    <?php if($jabatan == 0 && $nm_role != 'HR'){ ?>
                    <li class="sidenav-item <?php if($menu == "perijinankaryawan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>perijinankaryawan" class="sidenav-link">
                            <div>Persetujuan Ijin/Lembur</div>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="sidenav-item <?php if($menu == "pengajuan"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>pengajuan" class="sidenav-link">
                            <div>Pengajuan Karyawan Baru</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "purchase"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>purchase" class="sidenav-link">
                            <div>Purchase Request</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "pinjam"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>pinjam" class="sidenav-link">
                            <div>Form Peminjaman</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "hakakses"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>hakakses" class="sidenav-link">
                            <div>Perubahan Hak Akses</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "pemutusan"){ echo 'active'; } ?>">
                        <a onclick="confirmation(event)" href="<?php echo base_url();?>kontrak" class="sidenav-link">
                            <div>Pemutusan Kontrak</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidenav-item">
                <a href="<?php echo base_url();?>karyawan" class="sidenav-link sidenav-toggle <?php if($menu == "listsop" || $menu == "profilleap" || $menu == "listbusdev"|| $menu == 'pembelian'|| $menu == 'linkinfrastruktur'){ echo 'active'; } ?>">
                    <i class="sidenav-icon feather icon-book"></i>
                    <div>Dokumen</div>
                </a>
                <ul class="sidenav-menu">
                    <li class="sidenav-item <?php if($menu == "profilleap"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>profilleap" class="sidenav-link">
                            <div>Leap Profil</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "listsop"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>listsop" class="sidenav-link">
                            <div>Daftar SOP</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "listbusdev"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>listbusdev" class="sidenav-link">
                            <div>Business & Development</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "linkinfrastruktur"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>linkinfrastruktur" class="sidenav-link">
                            <div>Catatan IT</div>
                        </a>
                    </li>
                    <?php if($pro->ispurchase == 1 ){ ?>
                    <li class="sidenav-item <?php if($menu == "pembelian"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>pembelian" class="sidenav-link">
                            <div>Daftar Pembelian</div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="sidenav-item">
                <a href="<?php echo base_url();?>persuratan" class="sidenav-link sidenav-toggle <?php if($menu == "surattugas" || $menu == "mou" || $menu == "suratkeluar" || $menu == "suratmasuk"){ echo 'active'; } ?>">
                    <i class="sidenav-icon feather icon-mail"></i>
                    <div>Persuratan</div>
                </a>
                <ul class="sidenav-menu">
                    <li class="sidenav-item <?php if($menu == "surattugas"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>surattugas" class="sidenav-link">
                            <div>Surat Tugas</div>
                        </a>
                    </li>
                    <li class="sidenav-item <?php if($menu == "suratkeluar"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>suratkeluar" class="sidenav-link">
                            <div>Surat Keluar</div>
                        </a>
                    </li>
                    <!-- <li class="sidenav-item <?php //if($menu == "suratmasuk"){ echo 'active'; } ?>">
                        <a href="<?php //echo base_url();?>suratmasuk" class="sidenav-link">
                            <div>Surat Masuk</div>
                        </a>&& $nm_role != 'General Affairs'
                    </li> -->
                    <?php if($jabatan == 0 ){ ?>
                    <li class="sidenav-item <?php if($menu == "mou"){ echo 'active'; } ?>">
                        <a href="<?php echo base_url();?>mou" class="sidenav-link">
                            <div>Pengajuan MoU</div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="sidenav-item <?php if($menu == "problem"){ echo 'active'; } ?>">
                <a href="<?php echo base_url();?>problem" class="sidenav-link">
                    <i class="sidenav-icon feather icon-server"></i>
                    <div>Masalah Infrastruktur</div>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- [ Layout sidenav ] end -->