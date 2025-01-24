<script type="text/javascript">

    $(document).ready(function () {

    });

    function proses() {
        var lama = document.getElementById('lama').value;
        var baru = document.getElementById('baru').value;
        
        if(lama === ""){
            alert("Password lama tidak boleh kosong");
        }else if(baru === ""){
            alert("Password baru tidak boleh kosong");
        }else{
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('lama', lama);
            form_data.append('baru', baru);

            $.ajax({
                url: "<?php echo base_url(); ?>gantipass/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    location.reload();

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                },error: function (response) {
                    alert(response.status);
                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ganti Password
            <small>Maintenance profile</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">Ganti Password</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Ganti Password</h3>
                    </div>
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="lama" class="col-sm-2 control-label">Password Lama</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="lama" name="lama" type="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="baru" class="col-sm-2 control-label">Password Baru</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="baru" name="baru" type="password">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="button" class="btn btn-primary" onclick="proses();">Simpan</button>
                            <button type="button" class="btn btn-default">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>