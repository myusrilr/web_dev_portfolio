<script type="text/javascript">
    function profile() {
        var nama = document.getElementById('namap').value;
        var wa = document.getElementById('phone').value;
        var minat = document.getElementById('minat').value;
        var foto = $('#foto').prop('files')[0];
        
        var tot = 0;
        if (nama === '') {
            document.getElementById('namap').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('namap').classList.remove('is-invalid'); tot += 1;} 
        if (wa === '') {
            document.getElementById('phone').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('phone').classList.remove('is-invalid'); tot += 1;} 
        if (minat === '') {
            document.getElementById('minat').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('minat').classList.remove('is-invalid'); tot += 1;} 

        if(tot === 3){
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nama', nama);
            form_data.append('wa', wa);
            form_data.append('minat', minat);
            form_data.append('file', foto);

            $.ajax({
                url: "<?php echo base_url(); ?>profile/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    swal({
                        title: "Berhasil!",
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
    }

</script>
<div class="col">

    <!-- Messages list -->
    <div class="card">
        <hr class="border-light m-0">
        <h6 class="card-header"><b>PROFIL</b></h6>
        <div class="card-body">
            <!-- Form -->
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <img src="<?php echo $foto_profile; ?>" alt="image" class="img-fluid wid-100 mb-2" style="height:150px; width:150px; object-fit: cover;">
                        <h5><?php echo $idkaryawan.'<br>'.$pro->nama.'<br>'.$divisi->jabatan.' - '.$divisi->namad; ?> 
                        <br><span class="badge badge-success"><?php echo $pro->minat; ?></span></h5>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" id="namap" name="namap" class="form-control" value="<?php echo $pro->nama; ?>" placeholder="Masukkan Nama Lengkap disini">
                        <small class="invalid-feedback">Nama Lengkap wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Whatsapp</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $pro->wa; ?>" placeholder="Masukkan Nomor Whatsapp disini">
                        <small class="invalid-feedback">Nomor Whatsapp wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minat</label>
                        <input type="text" id="minat" name="minat" class="form-control" value="<?php echo $pro->minat; ?>" placeholder="Masukkan Minat disini">
                        <small class="invalid-feedback">Minat wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto</label>
                        <input type="file" id="foto" class="form-control" name="foto">
                        <small class="invalid-feedback">Foto wajib diisi</small>
                        <small><b>Gunakan ukuran foto 1 : 1 atau kotak agar tampilan foto lebih baik</b></small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $pro->email; ?>" readonly>
                        <span><i>*untuk mengubah email bisa hubungi IT</i></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Masuk Bekerja</label>
                        <input type="text" id="tglbekerja" name="tglbekerja" class="form-control" value="<?php echo $pro->thnbekerja; ?>" readonly>
                        <span><i>*untuk mengubah tanggal masuk bekerja bisa hubungi IT</i></span>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-4" onclick="profile();">Simpan</button>
        </div>
    </div>
    <!-- / Messages list -->

</div>
</div>