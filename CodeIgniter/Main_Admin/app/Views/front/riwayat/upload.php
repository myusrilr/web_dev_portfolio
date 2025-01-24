<script type="text/javascript">
    function profile() {
        var link = document.getElementById('link').value;

        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled',true);

        var form_data = new FormData();
        form_data.append('link', link);

        $.ajax({
            url: "<?php echo base_url(); ?>upload/proses",
            dataType: 'JSON',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                swal({
                    title: response.status,
                    text: "Datamu berhasil disimpan.",
                    type: "success",
                    timer: 1000
                }, function () {
                    location.reload();
                });

                
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            },error: function (response) {
                alert(response.status);
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }

</script>
<div class="col">

    <!-- Messages list -->
    <div class="card">
        <hr class="border-light m-0">
        <h6 class="card-header"><b>LINK DRIVE</b></h6>
        <div class="card-body">
            <!-- Form -->
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                    <label class="form-label">Buatlah folder baru pada gdrive dan atur akses share anyone with the link <br>
                    <br>ISI DRIVE : <br>1. Scan KTP <br>2. NPWP (Jika ada) <br>3. BPJS Kesehatan / Ketenagakerjaan (Jika ada) <br>4. SIM</label>
                    </div>
                    <?php if($k->link != null){?>
                    <div class="form-group">
                    <center><label class="form-label"><a href="<?php echo $k->link?>" target="_blank">CEK LINK DRIVE</a></label></center>
                    </div>
                    <?php }?>
                    <hr>
                    <div class="form-group">
                        <label class="form-label">URL Link Drive Anda</label>
                        <input type="text" id="link" name="link" class="form-control" value="<?php echo $k->link; ?>" placeholder="Masukkan URL Link Drive Anda disini">
                        <small class="invalid-feedback">Link Drive wajib diisi</small>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-4" onclick="profile();">Simpan</button>
        </div>
    </div>
    <!-- / Messages list -->

</div>
</div>