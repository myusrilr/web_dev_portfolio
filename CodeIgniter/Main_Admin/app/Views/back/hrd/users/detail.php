<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Detail Data Karyawan</h4>

    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-auto col-sm-12">
                    <img src="<?php echo $foto_karyawan ?>" alt class="d-block ui-w-100 rounded-circle mb-0">
                </div>
                <div class="col">
                    <h4 class="font-weight-bold mb-2"><?php echo $u->nama.' ('.$u->nickname.')'; ?> <span class="float-right">ID : <?php echo $u->idkaryawan; ?></span></h4>
                    <div class="text-muted mb-2">
                        <?php echo $u->hobi; ?>
                       <br><br>
                       <span class="badge badge-success"><?php echo $pu->minat; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->

    <div class="row">
        <div class="col">
            <!-- Info -->
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>ISI DATA SESUAI KTP</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">NIK </div>
                        <div class="col-md-9">
                            : <?php echo $u->ktp; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Tempat/Tgl Lahir</div>
                        <div class="col-md-9">
                            : <?php echo date("d M Y",strtotime($u->tgl)); ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Jenis Kelamin</div>
                        <div class="col-md-3">
                            : <?php echo $u->jk; ?>
                        </div>
                        <div class="col-md-3 text-muted">Gol. darah</div>
                        <div class="col-md-3">
                            : <?php echo $u->goldar; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Alamat</div>
                        <div class="col-md-9">
                            : <?php echo $u->alamatktp; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Agama</div>
                        <div class="col-md-9">
                            : <?php echo $u->agama; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Status Perkawinan</div>
                        <div class="col-md-3">
                            : <?php echo $u->status; ?>
                        </div>
                        <?php if($u->anak != ''){ ?>
                        <div class="col-md-3 text-muted">Jumlah Anak</div>
                        <div class="col-md-3">
                            : <?php echo $u->anak; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Kewarganegaaan</div>
                        <div class="col-md-9">
                            : <?php echo $u->warga; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Info -->

            <!-- Info -->
            <div class="card mb-4">
                <hr class="border-light m-0">
                <div class="card-body">
                    <h6 class="my-3">BPJS</h6>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Ketenagakerjaan</div>
                        <div class="col-md-3">
                            : <?php echo $u->bpjskerja; ?>
                        </div>
                        <div class="col-md-3 text-muted">Kesehatan</div>
                        <div class="col-md-3">
                            : <?php echo $u->bpjssehat; ?>
                        </div>
                    </div>
                    <h6 class="my-3">Nomor Lainnya</h6>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Rekening (Mandiri)</div>
                        <div class="col-md-3">
                            : <?php echo $u->rekening; ?>
                        </div>
                        <div class="col-md-3 text-muted">NPWP</div>
                        <div class="col-md-3">
                            : <?php echo $u->npwp; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Info -->

        </div>
        <div class="col-xl-4">

            <!-- Side info -->
            <div class="card mb-4">
                <div class="card-body">
                    <p class="mb-2">
                        <i class="ion ion-md-desktop ui-w-30 text-center text-lighter"></i> <?php echo $pu->jabatan.' / '.$pu->nama; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-md-calendar ui-w-30 text-center text-lighter"></i> <?php echo date("d M Y",strtotime($pu->thnbekerja)); ?></p>
                </div>
                    <hr class="border-light m-0">
                <div class="card-body">
                    <p class="mb-2">
                        <i class="ion ion-ios-navigate ui-w-30 text-center text-lighter"></i> <?php echo $u->domisili; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-ios-mail ui-w-30 text-center text-lighter"></i> <?php echo $u->email; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-ios-briefcase ui-w-30 text-center text-lighter"></i> <?php echo $u->emailkantor; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-md-phone-portrait ui-w-30 text-center text-lighter"></i><?php echo $pu->wa; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-ios-call ui-w-30 text-center text-lighter"></i><?php echo $u->telp; ?></p>
                </div>
                <hr class="border-light m-0">
                <div class="card-body">
                    <p class="mb-2">
                        <i class="ion ion-ios-car ui-w-30 text-center text-lighter"></i> <?php echo $u->moda; ?></p>
                    <p class="mb-2">
                        <i class="ion ion-ios-pulse ui-w-30 text-center text-lighter"></i> <?php echo $u->riwayat; ?></p>
                </div>
                <hr class="border-light m-0">
                <div class="card-body">
                    <a href="<?php echo $u->linkedin; ?>" target="_blank" class="d-block text-dark mb-2">
                        <i class="ion ion-logo-linkedin ui-w-30 text-center text-linkedin"></i> Linkedin
                    </a>
                    <?php if($u->fb != ''){?>
                    <a href="<?php echo $u->fb; ?>" target="_blank"  class="d-block text-dark mb-2" target="_blank">
                        <i class="ion ion-logo-facebook ui-w-30 text-center text-facebook"></i> Facebook
                    </a>
                    <?php }if($u->ig != ''){?>
                    <a href="<?php echo $u->ig; ?>" target="_blank" class="d-block text-dark mb-0">
                        <i class="ion ion-logo-instagram ui-w-30 text-center text-instagram"></i> Instagram
                    </a>
                    <?php }?>
                </div>
            </div>
            <!-- / Side info -->

        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <!-- Info -->
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>KELUARGA</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Anak ke </div>
                        <div class="col-md-9">
                            : <?php echo $u->anakke; ?>
                        </div>
                    </div>
                    <table class="table table-bordered m-0">
                        <tr>
                            <th>Hubungan</th>
                            <th>Nama Lengkap</th>
                            <th>No hp</th>
                        </tr>
                        <?php 
                        foreach($ke->getResult() as $row){
                            $str = '<tr>';
                            $str .= '<td>'.$row->hubungan.'</td>';
                            $str .= '<td>'.$row->namalengkap.'<br>'.$row->pekerjaan.'</td>';
                            $str .= '<td>'.$row->hp.'</td>';
                            $str .= '</tr>';
                            echo $str;
                        }
                        ?>
                    </table>
                </div>
            </div>
            <!-- / Info -->            
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>RIWAYAT PEKERJAAN</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?php 
                            foreach($pe->getResult() as $row){
                                $str = $row->namaperusahaan.' ('.$row->periode.')';
                                $str .= '<br>'.$row->jabatan;
                                $str .= '<br><b>Jobdesk : </b>'.$row->jobdesk;
                                $str .= '<br>';
                                echo $str;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>PENDIDIKAN</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                        <?php 
                            foreach($pen->getResult() as $row){
                                $str = $row->sekolah;
                                $str .= '<br>'.$row->jenjang;
                                $str .= '<br>'.$row->prodi;
                                $str .= '<br>'.$row->tahun;
                                $str .= '<br>'.$row->ipk;
                                $str .= '<br>'.$row->organisasi;
                                $str .= '<br>';
                                echo $str;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>KURSUS/SEMINAR/PELATIHAN</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                        <?php 
                            foreach($kursus->getResult() as $row){
                                $str = $row->nama;
                                $str .= '<br>'.date("d M Y",strtotime($row->tanggal));
                                $str .= '<br>'.$row->lokasi;
                                $str .= '<br>'.$row->nosertifikat;
                                $str .= '<br><b>Deskripsi : </b><br>'.$row->deskripsi;
                                $str .= '<br>';
                                echo $str;
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>