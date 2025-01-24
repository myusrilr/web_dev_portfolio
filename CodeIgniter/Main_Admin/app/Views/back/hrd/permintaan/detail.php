<div class="container-fluid flex-grow-1 container-p-y">
    <div class="row">
        <div class="col">
            <!-- Info -->
            <div class="card mb-4">
                <hr class="border-light m-0">
                <h6 class="card-header"><b>Detail Data Permintaan Pengajuan Karyawan Baru</b></h6>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Diajukan Oleh</div>
                        <div class="col-md-9">
                            : <b><?php echo $pengajuan->nama;?></b>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Diajukan Tanggal </div>
                        <div class="col-md-9">
                            : <?php echo date("d M Y",strtotime($pengajuan->created_at));?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Alasan Permintaan</div>
                        <div class="col-md-9">
                            : <?php echo $pengajuan->keterangan; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Jumlah Orang yang Diminta</div>
                        <div class="col-md-9">
                            : <?php echo $pengajuan->jumlah.' Orang'; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Syarat Pelamar</div>
                        <div class="col-md-12">
                            <?php echo $pengajuan->syarat; ?>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Pertanyaan untuk Probing</div>
                        <div class="col-md-12">
                            <?php echo $pengajuan->pertanyaan; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Alur Rekruitment</div>
                        <div class="col-md-12">
                            <?php echo $pengajuan->alur; ?>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 text-muted">Detail Test</div>
                        <div class="col-md-12">
                            <?php echo $pengajuan->test; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">DAFTAR PELAMAR</h6>

                    <div class="table-responsive mt-4">
                        <table class="table mb-0" id="tb2">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- / Info --> 
            <div class="card">
                <div class="card-body">
                    <h6 class="small font-weight-semibold">HISTORI PERMINTAAN</h6>

                    <div class="table-responsive mt-4">
                        <table class="table mb-0" id="tb">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script type="text/javascript">
    var table;
    function detail(kode) {
        window.location.href = "<?php echo base_url(); ?>rekruitmen/detail/"+kode;
    }
    
    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>permintaan/listnote/"+<?php echo $pengajuan->idpengajuan; ?>,
        });

        table2 = $('#tb2').DataTable({
            ajax: "<?php echo base_url(); ?>permintaan/listpelamar/"+<?php echo $pengajuan->idpengajuan; ?>,
        });
    });
</script>