<!-- [ content ] Start -->
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card">

        <!-- Status -->
        <div class="card-body">
            <strong class="mr-2">Status:</strong>
            <span class="text-big">
                <?php if($mitra->status == 'Done'){
                    echo '<span class="badge badge-success">'.strtoupper($mitra->status).'</span>';
                }else if($mitra->status == 'Canceled'){
                    echo '<span class="badge badge-danger">'.strtoupper($mitra->status).'</span>';
                }else if($mitra->status == 'follow up'){
                    echo '<span class="badge badge-info">'.strtoupper($mitra->status).'</span>';
                }else{
                    echo '<span class="badge badge-warning">'.strtoupper($mitra->status).'</span>';
                } ?>
            </span>
            <span class="text-muted small ml-1"><?php echo date('d M Y', strtotime($mitra->created_at))?></b></span>
        </div>
        <hr class="m-0">
        <!-- / Status -->

        <div class="row">
            <div class="col-xl-12 col-md-12" id="accordion2">
                <div class="card"> 
                    <div class="card-header">
                        <a class="d-flex justify-content-between text-dark" data-toggle="collapse" href="#accordion2-1">DATA INSTANSI<div class="collapse-icon"></div></a>
                    </div>

                    <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">NAMA INSTANSI</div>
                                    <b><?php echo $mitra->namasekolah; ?></b>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">LOKASI</div>
                                    <?php echo $mitra->lokasi ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">PIC INSTANSI</div>
                                    <?php echo $mitra->kepsek ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">CONTACT PERSON</div>
                                    <?php echo $mitra->cp ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">VISI dan MISI</div>
                                    <?php $t = str_replace('</p>','<br>', $mitra->visimisi);
                                echo str_replace('<p>','', $t); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">PROGRAM INSTANSI</div>
                                    <?php $t = str_replace('</p>','<br>', $mitra->program);
                                echo str_replace('<p>','', $t); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">SUMBER DAYA YANG TERSEDIA</div>
                                    <?php $t = str_replace('</p>','<br>', $mitra->sdm);
                                echo str_replace('<p>','', $t); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">KELEBIHAN DAN KELEMAHAN</div>
                                    <?php $t = str_replace('</p>','<br>', $mitra->weakness);
                                echo str_replace('<p>','', $t); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-muted small">CATATAN / REKOMENDASI</div>
                                    <?php $t = str_replace('</p>','<br>', $mitra->rekomen);
                                echo str_replace('<p>','', $t); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div class="card-body">
            <h6 class="small font-weight-semibold">CATATAN 
            <?php if($mitra->status != 'Done'){ ?>
                <div class="float-right">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>&nbsp;&nbsp;
                    <button class="btn btn-sm btn-info btn-fw " onclick="add()">Tambah Catatan</button>
                </div>
            <?php } ?>
            </h6>

            <!-- Tambah-->
            <form id="form">
                <h5 class="modal-title">Tambah Catatan</h5>
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" id="kode" name="kode" value="<?php echo $mitra->idmitra; ?>">
                        <input type="hidden" id="status" name="status" value="<?php echo $mitra->status; ?>">
                        <input type="hidden" id="idnote" name="idnote">
                        <div class="form-group">
                            <textarea class="form-control" id="note" name="note"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Assign User</label>
                            <select class="select2-demo form-control" multiple style="width: 100%;  z-index:100000;" name="staff[]">
                                <?php foreach($users->getResult() as $row){ ?>
                                <option value="<?php echo $row->idusers; ?>"><?php echo $row->nama; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <button id="btnSimpan" type="button" class="btn btn-info float-right" onclick="simpan();">Simpan</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-4">
                <table class="table mb-0" id="tb" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="20%">Pengguna</th>
                            <th width="40%">Catatan</th>
                            <th width="30%">Assign</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- / Items -->
    </div>
</div>
</div>

<link rel="stylesheet" href="<?php echo base_url() ?>back/assets/libs/select2/select2.css">
<script src="<?php echo base_url() ?>back/assets/libs/select2/select2.js"></script>
<script type="text/javascript">
    // Select2
    $(function() {
        $('.select2-demo').select2({});
    });

    tinymce.init({
        selector: "textarea#note", theme: "modern", height: 100,
    });

    var table; 
    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>kemitraan/listnote/<?php echo $mitra->idmitra; ?>",
            scrollY: 300,   
            scrollX: true,
            autoWidth: false,
        });
    });

    $('#form').hide();

    function add() {
        $('#form')[0].reset();
        $('#form').show();
    }

    function edit(id) {
        $('#form')[0].reset();
        $('#form').show();
        $.ajax({
            url: "<?php echo base_url(); ?>kemitraan/editing/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="idnote"]').val(data.idmnote);
                $('[name="status"]').val(data.status);
                if(data.note === null){
                    tinymce.get('note').setContent("");
                }else{
                    tinymce.get('note').setContent(data.note);
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
        $('#form').hide();
    }

    function simpan() {
        var kode = document.getElementById('kode').value;
        var note = tinyMCE.get('note').getContent();
        var idnote = document.getElementById('idnote').value;
        var status = document.getElementById('status').value;
        var staff = $('.select2-demo').val();

        $('#btnSimpan').text('Menyimpan...'); //change button text
        $('#btnSimpan').attr('disabled', true); //set button disable 

        var url = "";
        if(idnote === ''){
            url = "<?php echo base_url(); ?>kemitraan/submitnote";
        }else{
            url = "<?php echo base_url(); ?>kemitraan/editnote";
        }

        var form_data = new FormData();
        form_data.append('idmitra', kode);
        form_data.append('note', note);
        form_data.append('idnote', idnote);
        form_data.append('status', status);
        form_data.append('staff', staff);
        
        $.ajax({
            url: url,
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (data) {
                iziToast.info({
                    title: 'Info',
                    message: data.status,
                    position: 'topRight'
                });

                reload();

                $('#btnSimpan').text('Simpan'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert("Error json " + errorThrown);

                $('#btnSimpan').text('Simpan'); //change button text
                $('#btnSimpan').attr('disabled', false); //set button enable 
            }
        });
    }

    function hapus(id, nama) {
        swal({
            title: "Apakah anda yakin?",
            text:  "menghapus Catatan ini?",
            showCancelButton: true,
            confirmButtonClass: "btn btn-danger",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>kemitraan/hapusnote/" + id,
                        type: "POST",
                        dataType: "JSON",
                        error: function() {
                            alert('Error');
                        },
                        success: function(data) {
                            reload();
                            swal("Berhasil!", "Datamu berhasil dihapus.", "success");
                        }
                    });
                }else {
                    swal("Dibatalkan", "Data anda tetap tersimpan :)", "error");
                }
        });
    }
</script>
<!-- [ content ] End -->