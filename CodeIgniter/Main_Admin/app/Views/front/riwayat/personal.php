
<div class="col">

    <!-- Messages list -->
    <div class="card">
        <hr class="border-light m-0">
        <h6 class="card-header"><b>DATA PERSONAL</b></h6>
        <div class="card-body">
            <div class="text-bold small font-weight-semibold mb-3">Isi Sesuai KTP</div>
            <!-- Form -->
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nomor KTP</label>
                        <input type="text" id="ktp" name="ktp" class="form-control bootstrap-maxlength-example" onkeypress="return hanyaAngka(event,false);" maxlength="16" value="<?php echo $k->ktp; ?>" placeholder="Masukkan No KTP disini">
                        <small class="invalid-feedback">Nomor KTP wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text"  id="nama" name="nama" class="form-control" value="<?php echo $k->nama; ?>" placeholder="Masukkan Nama Lengkap disini">
                        <small class="invalid-feedback">Nama Lengkap wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Panggilan</label>
                        <input type="text"  id="nickname" name="nickname" class="form-control" value="<?php echo $k->nickname; ?>" placeholder="Masukkan Panggilan disini">
                        <small class="invalid-feedback">Panggilan wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kota Lahir</label>
                        <input type="text"  id="kota" name="kota" class="form-control" value="<?php echo $k->kota; ?>">
                        <small class="invalid-feedback">Kota Lahir wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="datepicker-base" name="tgllahir" placeholder="mm/dd/yyyy" value="<?php echo $k->tgl; ?>">
                        <small class="invalid-feedback">Tanggal Lahir wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" placeholder="Pria / Wanita" id="jk" name="jk" value="<?php echo $k->jk; ?>">
                        <small class="invalid-feedback">Jenis Kelamin wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Golongan Darah</label>
                        <input type="text" class="form-control" id="goldar" name="goldar" value="<?php echo $k->goldar; ?>" placeholder="Masukkan Golongan Darah disini">
                        <small class="invalid-feedback">Golongan Darah wajib diisi</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Agama</label>
                        <input type="text" class="form-control" id="agama" name="agama" value="<?php echo $k->agama; ?>" placeholder="Masukkan Agama disini">
                        <small class="invalid-feedback">Agama wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Perkawinan</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?php echo $k->status; ?>" placeholder="Masukkan Status Perkawinan disini">
                        <small class="invalid-feedback">Status Perkawinan wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Anak (Diisi jika status kawin)</label>
                        <input type="number" class="form-control" id="anak" name="anak" value="<?php echo $k->anak; ?>" placeholder="Masukkan Jumlah Anak disini">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Sesuai KTP</label>
                        <input type="text" class="form-control" id="alamatktp" name="alamatktp" value="<?php echo $k->alamatktp; ?>" placeholder="Masukkan Alamat Sesuai KTP disini">
                        <small class="invalid-feedback">Alamat Sesuai KTP wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Tempat Tinggal</label>
                        <input type="text" class="form-control" id="domisili" name="domisili" value="<?php echo $k->domisili; ?>" placeholder="Masukkan Alamat Tempat Tinggal disini">
                        <small class="invalid-feedback">Alamat Tempat Tinggal wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kewarganegaaan</label>
                        <input type="text" class="form-control" id="warga" name="warga" value="<?php echo $k->warga; ?>" placeholder="Masukkan Kewarganegaaan disini">
                        <small class="invalid-feedback">Kewarganegaaan wajib diisi</small>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Messages list -->
        <hr class="m-0">
        <div class="card-body">
            <div class="text-bold small font-weight-semibold mb-3">Lengkap</div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Anak ke </label>
                        <input type="text" class="form-control" id="anakke" name="anakke" value="<?php echo $k->anakke; ?>" placeholder="Masukkan Anak ke disini">
                        <small class="invalid-feedback">Anak ke wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Hobi </label>
                        <input type="text" class="form-control" id="hobi" name="hobi" value="<?php echo $k->hobi; ?>" placeholder="Masukkan Hobi disini">
                        <small class="invalid-feedback">Hobi wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Pribadi</label>
                        <input type="text" id="email" class="form-control" name="emailpribadi" value="<?php echo $k->email; ?>" placeholder="Masukkan Email Pribadi disini">
                        <small class="invalid-feedback">Email Pribadi wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Kantor (Opsional)</label>
                        <input type="text" class="form-control" id="emailkantor" name="emailkantor" placeholder=" @leapsurabaya.sch.id" value="<?php echo $k->emailkantor; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Linkedin</label>
                        <input type="text" class="form-control" id="akun" name="akun" value="<?php echo $k->linkedin; ?>" placeholder="Masukkan Link Linkedin disini">
                        <small class="invalid-feedback">Link Linkedin wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Instagram</label>
                        <input type="text" class="form-control" id="ig" name="ig" value="<?php echo $k->ig; ?>" placeholder="Masukkan Link Instagram disini">
                        <small class="invalid-feedback">Instagram wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Facebook (Opsional)</label>
                        <input type="text" class="form-control" id="fb" name="fb" value="<?php echo $k->fb; ?>" placeholder="Masukkan Link Facebook disini">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telp" name="telp" placeholder="Masukkan Nomor Telepon disini" onkeypress="return hanyaAngka(event,false);" value="<?php echo $k->telp; ?>">
                        <small class="invalid-feedback">Nomor Telepon wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Riwayat Penyakit</label>
                        <input type="text" class="form-control" id="riwayat" name="riwayat" placeholder="Masukkan Riwayat Penyakit disini" value="<?php echo $k->riwayat; ?>">
                        <small class="invalid-feedback">Riwayat Penyakit wajib diisi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NPWP (Wajib, jika punya)</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" placeholder="__.___.___._-___.___" value="<?php echo $k->npwp; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">BPJS Ketenagakerjaan (Wajib, jika punya)</label>
                        <input type="text" class="form-control bootstrap-maxlength-example" placeholder="Masukkan BPJS Ketenagakerjaan disini" id="bpjskerja" name="bpjskerja" value="<?php echo $k->bpjskerja; ?>" onkeypress="return hanyaAngka(event,false);" maxlength="11">
                    </div>
                    <div class="form-group">
                        <label class="form-label">BPJS Kesehatan (Wajib, jika punya)</label>
                        <input type="text" class="form-control bootstrap-maxlength-example" placeholder="Masukkan BPJS Kesehatan disini" id="bpjssehat" name="bpjssehat" value="<?php echo $k->bpjssehat; ?>" onkeypress="return hanyaAngka(event,false);" maxlength="13">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Rekening Bank Mandiri</label>
                        <input type="text" class="form-control" id="rekening" name="rekening" placeholder="Masukkan Nomor Rekening Bank Mandiri disini" onkeypress="return hanyaAngka(event,false);" value="<?php echo $k->rekening; ?>">
                        <small class="invalid-feedback">Nomor Rekening Bank Mandiri wajib diisi</small>
                        <small><i>*Untuk bank Lain tulis kodebank lalu no rek. <br> Misal : BCA ditulis 014xxx (x artinya no rek)</i></small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Moda Mobilitas sehari-hari</label>
                        <input type="text" class="form-control" id="moda" name="moda" placeholder="ex: Motor Pribadi" value="<?php echo $k->moda; ?>">
                        <small class="invalid-feedback">Moda Mobilitas wajib diisi</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="setuju" name="setuju">
                    <span class="custom-control-label" for="setuju">Saya menyatakan bahwa semua informasi yang saya berikan dalam formulir ini benar.
                    <span id="errorsetuju" style="color: red;">*Wajib</span>
                    </span>
                </label>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-4" id="btnSave" onclick="save();">Simpan</button>
        </div>
    </div>
</div>
<script type="text/javascript">

    var save_method; //for save method string
    $('#errorsetuju').hide();

    function save() {
        var ktp = document.getElementById('ktp').value;
        var nama = document.getElementById('nama').value;
        var nickname = document.getElementById('nickname').value;
        var kota = document.getElementById('kota').value;
        var tgl = document.getElementById('datepicker-base').value;
        var jk = document.getElementById('jk').value;
        var goldar = document.getElementById('goldar').value;

        var agama = document.getElementById('agama').value;
        var status = document.getElementById('status').value;
        var anak = document.getElementById('anak').value;
        var domisili = document.getElementById('domisili').value;
        var alamatktp = document.getElementById('alamatktp').value;
        var warga = document.getElementById('warga').value;

        var anakke = document.getElementById('anakke').value;
        var hobi = document.getElementById('hobi').value;
        var akun = document.getElementById('akun').value;
        var ig = document.getElementById('ig').value;
        var fb = document.getElementById('fb').value;
        var riwayat = document.getElementById('riwayat').value;
        var email = document.getElementById('email').value;
        var emailkantor = document.getElementById('emailkantor').value;
        var telp = document.getElementById('telp').value;

        var npwp = document.getElementById('npwp').value;
        var bpjssehat = document.getElementById('bpjssehat').value;
        var bpjskerja = document.getElementById('bpjskerja').value;
        var rekening = document.getElementById('rekening').value;
        var moda = document.getElementById('moda').value;
        var setuju = document.getElementById('setuju').checked;

        var tot = 0;
        if (ktp === '') {
            document.getElementById('ktp').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('ktp').classList.remove('is-invalid'); tot += 1;} 
        if(nama === ''){
            document.getElementById('nama').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('nama').classList.remove('is-invalid'); tot += 1;}
        if(nickname === ''){
            document.getElementById('nickname').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('nickname').classList.remove('is-invalid'); tot += 1;}
        if(kota === ''){
            document.getElementById('kota').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('kota').classList.remove('is-invalid'); tot += 1;}
        if(tgl === ''){
            document.getElementById('datepicker-base').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('datepicker-base').classList.remove('is-invalid'); tot += 1;}
        if(jk === ''){
            document.getElementById('jk').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('jk').classList.remove('is-invalid'); tot += 1;}
        if(goldar === ''){
            document.getElementById('goldar').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('goldar').classList.remove('is-invalid'); tot += 1;}

        if(agama === ''){
            document.getElementById('agama').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('agama').classList.remove('is-invalid'); tot += 1;}
        if(status === ''){
            document.getElementById('status').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('status').classList.remove('is-invalid'); tot += 1;}
        if(alamatktp === ''){
            document.getElementById('alamatktp').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('alamatktp').classList.remove('is-invalid'); tot += 1;}
        if(domisili === ''){
            document.getElementById('domisili').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('domisili').classList.remove('is-invalid'); tot += 1;}
        if(warga === ''){
            document.getElementById('warga').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('warga').classList.remove('is-invalid'); tot += 1;}

        if(anakke === ''){
            document.getElementById('anakke').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('anakke').classList.remove('is-invalid'); tot += 1;}
        if(hobi === ''){
            document.getElementById('hobi').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('hobi').classList.remove('is-invalid'); tot += 1;}

        if(akun === ''){
            document.getElementById('akun').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('akun').classList.remove('is-invalid'); tot += 1;}
        if(ig === ''){
            document.getElementById('ig').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('ig').classList.remove('is-invalid'); tot += 1;}
        if(riwayat === ''){
            document.getElementById('riwayat').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('riwayat').classList.remove('is-invalid'); tot += 1;}
        if(email === ''){
            document.getElementById('email').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('email').classList.remove('is-invalid'); tot += 1;}
        if(telp === ''){
            document.getElementById('telp').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('telp').classList.remove('is-invalid'); tot += 1;}

        if(rekening === ''){
            document.getElementById('rekening').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('rekening').classList.remove('is-invalid'); tot += 1;}
        if(moda === ''){
            document.getElementById('moda').classList.add('form-control', 'is-invalid');
        }else{document.getElementById('moda').classList.remove('is-invalid'); tot += 1;}
        if (setuju === false) {$('#errorsetuju').show();}else{$('#errorsetuju').hide(); tot += 1;} 
        
        if(tot === 22){
            $('#btnSave').text('Menyimpan...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            url = "<?php echo base_url(); ?>personal/proses";

            var form_data = new FormData();
            form_data.append('ktp', ktp);
            form_data.append('nama', nama);
            form_data.append('nickname', nickname);
            form_data.append('kota', kota);
            form_data.append('tgl', tgl);
            form_data.append('jk', jk);
            form_data.append('goldar', goldar);
            form_data.append('agama', agama);
            form_data.append('status', status);
            form_data.append('anak', anak);
            form_data.append('alamatktp', alamatktp);
            form_data.append('domisili', domisili);
            form_data.append('warga', warga);
            form_data.append('anakke', anakke);
            form_data.append('hobi', hobi);
            form_data.append('akun', akun);
            form_data.append('ig', ig);
            form_data.append('fb', fb);
            form_data.append('email', email);
            form_data.append('emailkantor', emailkantor);
            form_data.append('telp', telp);
            form_data.append('riwayat', riwayat);
            form_data.append('npwp', npwp);
            form_data.append('bpjskerja', bpjskerja);
            form_data.append('bpjssehat', bpjssehat);
            form_data.append('rekening', rekening);
            form_data.append('moda', moda);
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    swal({
                        title: "Berhasil!",
                        text: "Datamu berhasil disimpan.",
                        type: "success",
                        timer: 1000
                    }, function () {
                        location.reload();
                    });

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Simpan'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        }
    }

</script>