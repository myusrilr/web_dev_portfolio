<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>penggunabusdev/ajaxlist",
            scrollx: true,
            responsive: true
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function save() {
        var idbidang = document.getElementById('idbidang').value;
        var kode = document.getElementById('kode').value;

        $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>penggunabusdev/ajax_edit";
            
            var form_data = new FormData();
            form_data.append('idbidang', idbidang);
            form_data.append('kode', kode);
            
            // ajax adding data to database
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                traditional: true,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    reload();
                    $('#modal_form').modal('hide');

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
    }

    function ganti(id) {
        $('#info').hide();
        save_method = 'in';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Pilih Bidang Pengguna');
        $.ajax({
            url: "<?php echo base_url(); ?>penggunabusdev/ganti/"+id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idusers);
                $('[name="idbidang"]').val(data.idbidang);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }

    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Karyawan Busdev</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="feather icon-home"></i></li>
            <li class="breadcrumb-item active">Karyawan Busdev</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="tb" class="datatables-demo table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="5%">ID Karyawan</th>
                                    <th width="10%">Foto</th>
                                    <th>Detail</th>
                                    <th>Bidang Busdev</th>
                                    <th width="10%">Aksi</th>
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

<div class="modal fade" id="modal_form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-row">
                        <input type="hidden" id="kode" name="kode">
                        <div class="form-group col">
                            <label class="form-label">Bidang Busdev</label>
                            <select class="custom-select" id="idbidang" name="idbidang">
                                <option value="" selected>Pilih Bidang Busdev</option>
                                <?php
                                foreach($bidang->getResult() as $row) {?>
                                <option value="<?php echo $row->idbidang; ?>"><?php echo $row->namabidang ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="closemodal();">Tutup</button>
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Simpan</button>
            </div>
        </div>
    </div>
</div>