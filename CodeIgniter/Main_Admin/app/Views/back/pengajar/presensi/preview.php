<script type="text/javascript">

    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            paging : false,
            searching : false
        });
    });

    function reload() {
        table.ajax.reload(null, false);
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Preview Presensi</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homepengajar"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>presensisiswa/">Jadwal Pengajaran</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>presensisiswa/detil/<?php echo $idjadwalenkrip; ?>">Detil Jadwal Pengajaran</a>
            </li>
            <li class="breadcrumb-item active">Preview Presensi</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">
                        <b><?php echo $head->groupwa . ' - ' . $head->nama_kursus; ?></b>
                    </h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Hari / Sesi</div>
                            <?php echo $head->hari . ' (' . $head->sesi . ')'; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Level</div>
                            <?php echo $head->level; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Start Kursus</div>
                            <?php echo $head->periode; ?>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Meeting Id</div>
                            <?php echo $head->meeting_id; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="idjadwal" name="idjadwal" value="<?php echo $idjadwal; ?>">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nama</th>
                                    <?php
                                    $no = 1;
                                    foreach ($tgl_head->getResult() as $row) {
                                        echo '<th style="text-align:center;">PTM '.$no.'<br>'.$row->tgl.'</th>';
                                        $no++;
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($siswa->getResult() as $rowsiswa) {
                                    ?>
                                <tr>
                                    <td><?php echo $rowsiswa->nama_lengkap; ?></td>
                                    <?php
                                    foreach ($tgl_head->getResult() as $row) {
                                        $cek = $model->getAllQR("SELECT count(*) as jml FROM 
                                            presensi_siswa where idsiswa = '".$rowsiswa->idsiswa."' and idjadwaldetil = '".$row->idjadwaldetil."';")->jml;
                                        if($cek > 0){
                                            ?>
                                    <td style="text-align:center;">&#x2714;</td>
                                            <?php
                                        }else{
                                            ?>
                                    <td></td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>