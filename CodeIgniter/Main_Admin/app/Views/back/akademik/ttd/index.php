<script type="text/javascript">
    function simpan_ttd() {
        var ttd = $('#ttd').prop('files')[0];
        var status = document.getElementById('status').value;

        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);

        var form_data = new FormData();
        form_data.append('file', ttd);
        form_data.append('status', status);

        $.ajax({
            url: "<?php echo base_url(); ?>ttdall/proses",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function(response) {
                iziToast.info({
                    title: 'Info',
                    message: response.status,
                    position: 'topRight'
                });

                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);

                if(response.status === "Tanda tangan terupload"){
                    window.location.href = "<?php echo base_url() ?>ttdall";
                }
            },
            error: function(response) {

                iziToast.error({
                    title: 'Error',
                    message: response.status,
                    position: 'topRight'
                });

                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
</script>
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Tanda Tangan</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>homependidikan">Beranda</a></li>
            <li class="breadcrumb-item active">Tanda Tangan</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <img src="<?php echo $ttd; ?>" alt="image" class="img-fluid wid-100 mb-2" style="height:100px; width:auto; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">File Tanda Tangan</label>
                                <input type="file" id="ttd" name="ttd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gunakan ttd ini untuk seluruh rapor? </label>
                                <select id="status" name="status" class="form-control">
                                    <option value="Ya" <?php if($status == 'Ya'){ echo 'selected';  } ?>>Ya </option>
                                    <option value="Tidak"  <?php if($status == 'Tidak'){ echo 'selected';  } ?>>Tidak </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button id="btnSave" type="button" class="btn btn-primary btn-block mt-4" onclick="simpan_ttd();">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>