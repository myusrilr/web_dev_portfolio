<script type="text/javascript">
    $(document).ready(function () {
        $('#baru, #cbaru').on('keyup', function () {
        if ($('#baru').val() == $('#cbaru').val()) {
            $('#message').html('Password sama').css('color', 'green');
        } else 
            $('#message').html('Password tidak sama').css('color', 'red');
        });
    });

    function showpass() {
        var x = document.getElementById("lama");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        var y = document.getElementById("baru");
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
        var z = document.getElementById("cbaru");
        if (z.type === "password") {
            z.type = "text";
        } else {
            z.type = "password";
        }
    }

    function proses() {
        var lama = document.getElementById('lama').value;
        var baru = document.getElementById('baru').value;
        var cbaru = document.getElementById('cbaru').value;
        var message = document.getElementById('message').textContent;
        
        var tot = 0;
        if (lama === '') {
            document.getElementById('lama').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('lama').classList.remove('is-invalid'); tot += 1;} 
        if (cbaru === '') {
            document.getElementById('cbaru').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('cbaru').classList.remove('is-invalid'); tot += 1;} 
        if (baru === '') {
            document.getElementById('baru').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('baru').classList.remove('is-invalid'); tot += 1;} 
        if(message === "Password sama"){
            tot +=1;
        }else{alert("Password Konfirmasi tidak sama");}

        if(tot === 4){
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
<div class="col">

    <!-- Messages list -->
    <div class="card">
        <hr class="border-light m-0">
        <h6 class="card-header"><b>GANTI PASSWORD</b></h6>
        <div class="card-body">
            <!-- Form -->
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Password Lama</label>
                        <input class="form-control" id="lama" name="lama" type="password">
                        <small class="invalid-feedback">Password Lama wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <input class="form-control" id="baru" name="baru" type="password">
                        <small class="invalid-feedback">Password Baru wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input class="form-control" id="cbaru" name="cbaru" type="password">
                        <span id='message'></span>
                        <small class="invalid-feedback">Konfirmasi Password Baru wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" onclick="showpass()">
                            <span class="form-check-label">Show Password</span>
                        </label>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-4" onclick="proses();">Simpan</button>
        </div>
    </div>
    <!-- / Messages list -->

</div>
</div>